<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Levelzero extends CI_Controller {

    public function index() {
        $this->load->model('latestshow');
        $show_info = $this->latestshow->getLatestShow();
        $latest_show = $this->latestshow->getLatestShow(1);
        $latest_show['class_num'] = $latest_show['episode'][0]['class_num'];
        $this->load->view('main',$latest_show);
//        $this->load->view('home');
    }

    public function home() {
        $this->load->view('home');
    }
    
    public function show_notes() {
        $this->load->view('show_notes');
    }
    
    public function get_show_notes() {
        $this->load->model('latestshow');
        $show_info = $this->latestshow->getLatestShow();
        $this->output->set_content_type('application/json')->set_output(json_encode($show_info));
    }
    
    public function get_news() {
        $this->load->model('shownotesadmin_model');
        $news = $this->shownotesadmin_model->retrieveNews();
        $this->output->set_content_type('application/json')->set_output(json_encode($news));
    }
    
    public function get_ratings() {
        $this->load->model('latestshow');
        $ratings = $this->latestshow->retrieveRatings();
        $this->output->set_content_type('application/json')->set_output(json_encode($ratings));
    }
    
    public function news() {
        $this->load->view('news');
    }
}
