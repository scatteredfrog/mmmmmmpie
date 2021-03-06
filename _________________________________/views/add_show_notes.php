<?php
//    $this->load->library('session');
    $this->load->helper('form');
    echo link_tag('css/show_notes.css');
    echo "<script src='" . base_url("js/shownotesadmin.js") . "'></script>";
?>
<div id="add_show_notes_heading">
    <?php
        echo heading('Show Notes Admin');
    ?>
    <div id="add_notes_form" <?php if (isset($_SESSION['username'])) { ?>class="formVisible" <?php } ?>>
        <span id="add_new_show_click" class="clickMenuOption">ADD NEW SHOW</span> | 
        <span id="add_notes_click" class="clickMenuOption">ADD NOTES TO EXISTING SHOW</span> | 
        <span id="edit_existing_notes_click" class="clickMenuOption">EDIT EXISTING NOTES</span> | 
        <span id="unpublished_episodes_click" class="clickMenuOption">UNPUBLISHED EPISODES</span> | 
        <span id="game_ratings_click" class="clickMenuOption">GAME RATINGS</span> | 
        <span id="add_news_click" class="clickMenuOption">ADD NEWS</span> | 
        <span id="log_out_click" class="clickMenuOption">LOG OUT</span>
    </div>
    <div id="add_notes_login" <?php if (!isset($_SESSION['username'])) { ?>class="formVisible" <?php } ?>>
        <?php
            echo form_open('',array('id' => 'add_notes_login_form'));
            echo "<div class='formLabelRow'><div class='labelDiv'>E-mail address:</div>";
            echo form_input(array(
                'name' => 'user_name',
                'id' => 'user_name',
                'size' => 45,
            ));
            echo "</div><div class='formLabelRow'>";
            echo "<div class='labelDiv'>Password:</div>";
            echo form_password(array(
                'name' => 'password',
                'id' => 'password',
                'size' => 45,
            ));
            echo "</div><div class='formLabelRow'>";
            echo "<div class='labelDiv'>&nbsp;</div>";
            echo "</div><div class='formLabelRow'>";
            echo form_button('add_notes_button','Log in',"id='add_notes_button'");
            echo "</div>";
            echo form_close();
        ?>
    </div>
</div>
