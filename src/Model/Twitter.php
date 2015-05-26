<?php
/**
 * FollowTheBrowns.com
 *
 * @author Joe Campo <jcampo@gmail.com>
 * @link   http://followthebrowns.com
 * @license http://opensource.org/licenses/MIT
 *
 */

namespace Campo\Browns\Model;

use \Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
    /*
     * @var TwitterOAuth object.
     */
    private $twitter;
    
    /**
     * __construct - Create our TwitterOAuth object.
     *
     * @param string $token        Twitter Access Token
     * @param string $token_secret Twitter Secret Access Token
     */
    public function __construct($token = null, $token_secret = null)
    {
        $this->twitter = new TwitterOAuth(
            CONSUMER_KEY,
            CONSUMER_SECRET,
            $token,
            $token_secret
        );
   
    }
    
    /**
     * Get the OAuth Request Token and Secret Request Token
     * and URL to redirect for Twitter authentication.
     *
     * @return string The URL to Twitter's OAuth validation.
     */
    public function authenticate()
    {
        try {
            $request = $this->twitter->oauth('oauth/request_token', array('oauth_callback' => CALLBACK));
        } catch (\Abraham\TwitterOAuth\TwitterOAuthException $ex) {
            echo $ex->getMessage();
            exit();
        }

        $url = $this->twitter->url('oauth/authorize', array('oauth_token' => $request['oauth_token']));
        $_SESSION['oauth_token_secret'] = $request['oauth_token_secret'];
        $_SESSION['oauth_token'] = $request['oauth_token'];

        return $url;
    }
    
    /**
     * Get the Twitter Access & Secret Access Tokens and set them to our session.
     *
     * @param string $oauth_verifier The oauth_verifier token passed back from auth.
     */
    public function getAccess($oauth_verifier)
    {
        try {
            $access_token = $this->twitter->oauth(
                "oauth/access_token",
                array("oauth_verifier" => $oauth_verifier)
            );
        } catch (\Abraham\TwitterOAuth\TwitterOAuthException $ex) {
            echo $ex->getMessage();
            exit();
        }

        $_SESSION['access_token'] = $access_token['oauth_token'];
        $_SESSION['access_token_secret'] = $access_token['oauth_token_secret'];
    }
    
    /**
     * Follow the supplied handles from players.json
     *
     * @param json $players
     */
    public function follow($players)
    {
        foreach ($players as $player) {
            $this->twitter->post('friendships/create', array('screen_name' => $player->handle));
        }
    }
}
