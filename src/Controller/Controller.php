<?php
/**
 * FollowTheBrowns.com
 *
 * @author Joe Campo <jcampo@gmail.com>
 * @link   http://followthebrowns.com
 * @license http://opensource.org/licenses/MIT
 *
 */

namespace Campo\Browns\Controller;

use Campo\Browns\Model\Twitter;

class Controller extends \SlimController\SlimController
{

    /*
     * @var our Twitter Model
     */
    private $twitter;

    /**
     * __construct
     * @param \Slim\Slim $app
     */
    public function __construct(\Slim\Slim &$app)
    {
        parent::__construct($app);
    }

    /**
     * Our index page.
     */
    public function index()
    {
        $file = file_get_contents("../public/players.json");
        $players = json_decode($file);
        $this->render('index', array(
            'players' => $players,
            'total'   => count(get_object_vars($players))
        ));
    }

    /**
     * Start the Twitter OAuth authentication process.
     *
     * @param string $action This determines what the callback action should be: follow|unfollow
     */
    public function authenticate($action)
    {
        $action = (($action == "follow") ? "follow" : "unfollow");

        $this->twitter = new Twitter();

        $url = $this->twitter->authenticate($action);
        if (isset($_SESSION['oauth_token']) && isset($_SESSION['oauth_token_secret'])) {
            $this->app->redirect($url);
        } else {
            // We didn't get the token properly. Go back home.
            $this->app->redirect("/");
        }
    }

    /**
     * The Twitter OAuth Callback.
     *
     * @param string $action This determines what the callback action should be: follow|unfollow
     */
    public function callback($action)
    {
        if (!empty($this->app->request->get('denied'))) {
            // The user canceled the request.
            $this->app->redirect("/");
        }

        if (empty($this->app->request->get('oauth_verifier'))) {
            $this->app->redirect("/");
        }

        $action = (($action == "follow") ? "follow" : "unfollow");

        $oauth_verifier = $this->app->request->get('oauth_verifier');
        $this->twitter = new Twitter($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        $this->twitter->getAccess($oauth_verifier);
        $this->app->redirect('/' . $action);
    }
    
    /**
     * Follow all the players in players.json.
     */
    public function follow()
    {
        if (!isset($_SESSION['access_token']) || !isset($_SESSION['access_token_secret'])) {
            // We haven't authenticated yet.
            $this->app->redirect("/authenticate/follow");
        }
        
        $file = file_get_contents("../public/players.json");
        $players = json_decode($file);
        
        $this->twitter = new Twitter($_SESSION['access_token'], $_SESSION['access_token_secret']);
        $this->twitter->follow($players);
        
        $this->render('index', array(
            'players' => $players,
            'total'   => count(get_object_vars($players)),
            'message' => 'All done! You\'ve followed everyone. Go Browns!'
        ));
        
    }

    /**
     * Unfollow all of the players in waived.json
     */
    public function unfollow()
    {
        if (!isset($_SESSION['access_token']) || !isset($_SESSION['access_token_secret'])) {
            // We haven't authenticated yet.
            $this->app->redirect("/authenticate/unfollow");
        }

        $waivedfile = file_get_contents("../public/waived.json");
        $waived = json_decode($waivedfile);

        $playersfile = file_get_contents("../public/players.json");
        $players = json_decode($playersfile);

        $this->twitter = new Twitter($_SESSION['access_token'], $_SESSION['access_token_secret']);
        $this->twitter->unfollow($waived);

        $this->render('index', array(
            'players' => $players,
            'total'   => count(get_object_vars($players)),
            'message' => 'All done! You\'ve unfollowed all waived players. Go Browns!'
        ));
    }
}
