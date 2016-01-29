<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to Pie Factory Podcast</title>

<?php
    $rt = $_SERVER['DOCUMENT_ROOT'];
    $hs = $_SERVER['HTTP_HOST'];
    if (stristr($rt, 'Volumes') && substr($hs,0,5) === 'local') {
        $poddie = '/images/gpa65.png';
        $imgSrc = '/images/wordpress_pf_logo.png';
    } else {
        $poddie = '/piefactory/images/gpa65.png';
        $imgSrc = '/piefactory/images/wordpress_pf_logo.png';
    }
    echo link_tag('css/pfp_main.css');

?>
    <script src=<?=base_url("js/jquery-1.9.1.min.js"); ?>></script>
    <script src=<?=base_url('js/angular.min.js'); ?>></script>
    <script src=<?=base_url('js/pfp_app.js'); ?>></script>
</head>
<body ng-app="pfp" ng-controller="showNotes">
    
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
                <div id="gpa">
                    <a href="http://ccg.podomatic.com/entry/2016-01-28T20_53_28-08_00" style="text-decoration: none!important;" target="_blank">
                        <img src="<?= $poddie ?>" alt="Winner of the 2015 Golden Poddie Award!"/>
                    </a>
                </div>
                            </div>
            <div id="latest_show">
                <?php
                    echo heading('LATEST EPISODE:',2);
                    echo '<div id="latest_deets">Episode '.$episode[0]['episode_number'] . ': '. $episode[0]['episode_topic'] . '<br />';
                    echo anchor($episode[0]['download_link'],'Click here to download or listen');
                    echo '</div>';
                ?>
                <div id="itunes">
                    <a href="https://itunes.apple.com/us/podcast/pie-factory-podcast/id988509945?mt=2&uo=6&at=&ct=" target="itunes_store"></a>
                </div>
                <div id="twit">
                    <div id="twit0"><a href="https://twitter.com/PieFactoryPFP" class="twitter-follow-button" data-show-count="false">Follow @PieFactoryPFP</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div><br />
                </div>
                <div id="fbok">
                    <div class="fb-like" data-href="https://www.facebook.com/PieFactoryPodcast" data-layout="button" data-action="like" data-show-faces="true"></div>
                </div>
                <div id="wrdpr">
                    <a href="http://piefactorypodcast.wordpress.com" target="_new">
                        <img src="<?= $imgSrc ?>" /></a>
                </div>
                <div id="email_row">
                    <div id="eml0">E-mail: </div><div id="eml1">pie</div><div id="eml2">factory@fab4it.co</div><div id="eml3">m</div><br />
                </div>
            </div>
        </div>
    </div>
