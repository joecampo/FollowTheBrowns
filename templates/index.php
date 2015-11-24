<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Cleveland Browns Player Twitter Directory">
        <meta name="author" content="@joecampo">

        <title>FollowTheBrowns.com</title>
        <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://followthebrowns.com/assets/app.css" rel="stylesheet">
    </head>

    <body>
        <div class="follow">
            <div class="hero">Follow The Browns <i class="fa fa-twitter"></i></div>
            <p class="lead">This is a directory of the Twitter accounts for the current Cleveland Browns Roster maintained by <a href="https://twitter.com/joecampo/">@joecampo</a></p>     
            <?php if (isset($message)) { ?>
                <p class="lead"><?= $message; ?></p>
            <?php } else { ?>
            <p><a class="btn btn-lg btn-browns" href="/follow" role="button"><i class="fa fa-twitter"></i> Follow Everyone (<?= $total; ?>)</a></p>
            <p><a class="btn btn-md btn-default" href="/unfollow"><i class="fa fa-twitter"></i> Unfollow Cut/Waived</a></p>
            <?php } ?>
            <p><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://followthebrowns.com" data-text="Follow the entire Browns roster @">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </p>
             <p><a href="https://docs.google.com/spreadsheets/d/1ip4-jQB1rxPhE6uD-zqOnDVzhawxT0xMptv9e940Jb0/edit?pli=1">Sheets</a> | <a href="http://followthebrowns.com/players.json">Players JSON</a> | <a href="http://followthebrowns.com/waived.json">Waived/Cut JSON</a> | <a href="https://github.com/joecampo/FollowTheBrowns"><i class="fa fa-github fa-1x"></i> Github</a></p>
        </div>
        
        <div class="container">
            <div class="row">
            <?php foreach($players as $number => $player) { ?>
                <div class="col-md-4">
                    <div class="avatar">
                        <a href="https://twitter.com/<?= $player->handle; ?>">
                            <img src="http://avatars.io/twitter/<?= $player->handle; ?>/medium" alt="" />
                        </a>
                        <div class="content">
                            <p><strong><?= $player->name; ?></strong> <span class="number">#<?= $number; ?></span></p>
                            <p class="position"><?= $player->position; ?></p>
                            <a href="https://twitter.com/<?= $player->handle; ?>" class="twitter-follow-button" data-show-count="false">Follow @<?= $player->handle; ?></a>
                            <script>!function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = p + '://platform.twitter.com/widgets.js';
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }
                                }(document, 'script', 'twitter-wjs');</script>
                        </div>
                    </div>
                </div>
            <?php } ?>

            </div> 
            <div id="disqus_thread"></div>
            <script type="text/javascript">
                var disqus_shortname = 'followthebrowns';
                (function() {
                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
        </div>

        <div class="footer">
            <p><a href="https://twitter.com/joecampo/">@joecampo</a> - 2015 - Built in CLE with <span class="number">&hearts;</span></p>
        </div>
    </body>
</html>
