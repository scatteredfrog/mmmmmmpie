<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Levelzero extends CI_Controller {

	public function index() {
            $this->load->view('main');
            $this->load->view('player_one_up');
	}
}
