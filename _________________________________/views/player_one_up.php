<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    echo "<div id='show_notes_heading'><hr />";
    echo heading("Show Notes");
    echo "</div>";    
    $episode_count = 0;
    foreach($episode as $show) {
        if ($episode_count % 2 === 0) {
            echo "<div class='episodeRow'>";
            $class_num = '0';
        } else {
            $class_num = '1';
        }
?>
    <div class="showNotes<?= $class_num?>" id="episode_<?=$episode_count?>">
        <?php
            echo heading('Episode '.$show['episode_number'] . ': '. $show['episode_topic'],3);
            echo anchor($show['download_link'],heading('Download or listen here',4));
            foreach($show['notes'] as $key=>$note) {
                echo "<div class='showNote'>" . anchor_popup($note['description_link'], $note['note']) . '</div>';
            }
        ?>
    </div>
<?php
        if ($episode_count % 2 !== 0) {
            echo "</div>";
        }
        $episode_count++;
    }
    if ($episode_count % 2 !== 0) {
        echo "</div>";
    }
?>
<script>
    $('.episodeRow').each(function() {
        var ep1 = parseInt($(this).find('.showNotes0').css('height').replace('px',''));
        var highest = ep1;
        if (typeof $(this).find('.showNotes1').html() !== 'undefined') {
            
            var ep2 = parseInt($(this).find('.showNotes1').css('height').replace('px',''));
            
            if (ep1 > ep2) {
                $(this).find('.showNotes1').css('height',ep1+'px');
            } else if (ep2 > ep1) {
                $(this).find('.showNotes0').css('height',ep2+'px');
                highest = ep2;
            }
        } else {
            $(this).find('.showNotes0').css('float','none');
            $(this).find('.showNotes0').css('margin-left','auto');
            $(this).find('.showNotes0').css('margin-right','auto');
        }
        $(this).css('height', (highest+40)+'px');
    });
</script>
</body>
</html>