<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to Pie Factory Podcast</title>

<?php
    echo link_tag('css/pfp_main.css');

?>
    <script src=<?=base_url("js/jquery-1.9.1.min.js"); ?>></script>
</head>
<body>
    
    <!-- Facebook crap -->
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <!-- end Facebook crap -->

    <div class="containerCenter">
        <div class="headerWrapper">
            <div id="header_image">

            </div>
            <div id="header_contact">
                <div id="soc_row">
                    <div id="itunes">
                        <a href="https://itunes.apple.com/us/podcast/pie-factory-podcast/id988509945?mt=2&uo=6&at=&ct=" target="itunes_store"></a>
                    </div>
                    <div id="twit">
                        <div id="twit0"><a href="https://twitter.com/PieFactoryPFP" class="twitter-follow-button" data-show-count="false">Follow @PieFactoryPFP</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div><br />
                    </div>
                    <div id="fbok">
                        <div class="fb-like" data-href="https://www.facebook.com/PieFactoryPodcast" data-layout="button" data-action="like" data-show-faces="true"></div>
                    </div>
                </div>
                <div id="eml">
                        <div id="eml0">E-mail: </div><div id="eml1">pie</div><div id="eml2">factory@fab4it.co</div><div id="eml3">m</div><br />
                </div>
            </div>
        </div>
    </div>
