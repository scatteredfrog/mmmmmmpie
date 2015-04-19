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
    <div class="containerCenter">
        <div class="headerWrapper">
            <div id="header_image">

            </div>
            <div id="header_contact">
                <div id="twit">
                    <div id="twit0">Twitter: </div><div id="twit1">@PieFactory</div><div id="twit2">PFP</div><br />
                </div>
                <div id="eml">
                    <div id="eml0">E-mail: </div><div id="eml1">pie</div><div id="eml2">factory@fab4it.co</div><div id="eml3">m</div><br />
                </div>
                <div id="fbk">
                    <div id="fbk0">Facebook: </div><div id="fbk1"><a href="http://www.facebook.com/PieFactoryPodcast" target="_blank">http://www.facebook.com/PieFactoryPodcast</a></div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            var width = $("#fbk").css('width');
            width = parseInt(width.substring(0,width.length-2));
            width = (787-width) / 2;
            $('#fbk').css('left',width);
        });
    </script>