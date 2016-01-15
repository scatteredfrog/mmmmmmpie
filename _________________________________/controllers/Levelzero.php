<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Levelzero extends CI_Controller {

    public function index() {
        $this->load->model('latestshow');
        $show_info = $this->latestshow->getLatestShow();
        $latest_show = $this->latestshow->getLatestShow(1);
        $latest_show['class_num'] = $latest_show['episode'][0]['class_num'];
        $this->load->view('main',$latest_show);
        $this->load->view('player_one_up',$show_info);
    }
}
