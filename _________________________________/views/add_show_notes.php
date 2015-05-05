<?php
    $this->load->library('session');
    $this->load->helper('form');
    echo link_tag('css/show_notes.css');
    echo "<script src='" . base_url("js/shownotesadmin.js") . "'></script>";
?>
<div id="add_show_notes_heading">
    <?php
        echo heading('Show Notes Admin');
    ?>
    <div id="add_notes_form" <?php if ($this->session->username) { ?>class="formVisible" <?php } ?>>
        <span id="add_new_show_click">ADD NEW SHOW</span> | 
        <span id="add_notes_click">ADD NOTES TO EXISTING SHOW</span> | 
        <span id="edit_existing_notes_click">EDIT EXISTING NOTES</span> | 
        <span id="log_out_click">LOG OUT</span>
    </div>
    <div id="add_notes_login" <?php if (!$this->session->username) { ?>class="formVisible" <?php } ?>>
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
