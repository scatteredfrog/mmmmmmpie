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
        $this->load->view('footer');
    }

    public function home() {
        $this->load->view('home');
        $this->load->view('footer');
    }
    
    public function show_notes() {
        $this->load->view('show_notes');
        $this->load->view('footer');
    }
    
    public function aboutus() {
        $this->load->view('about_us');
        $this->output->delete_cache();
        $this->load->view('footer');
    }
    
    public function cactus() {
        $this->load->view('contact_us');
        $this->load->view('footer');
    }
    
    public function submitContact() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $tellus = $this->input->post('tellus');
        
        // e-mail stuff
        $this->load->library('email');
        $config['charset'] = 'iso-8859-1';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('webmaster@fab4it.com', 'piefactorypodcast.com');
        $this->email->to('piefactory@fab4it.com');
        $this->email->reply_to($email);
        $this->email->subject('PFP web site Contact Us');
        $message = 'Name: ' . $name . '<br />';
        $message .= 'E-mail address: ' . $email . '<br />&nbsp;<br />';
        $message .= 'Message: ' . $tellus;
        $ClearText = preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($tellus))) );
        $this->email->message($ClearText);
        $this->email->send();
        
        return;
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
        $this->load->view('footer');
    }
}
