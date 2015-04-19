<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shownotesadmin_model extends CI_Model {

    public function login($username,$password) {
        $confirmed_user = "flirzelkwerp";
        $password = md5($password);
        $query = $this->db->select('username')
                ->from('pfUsers')
                ->where('username',$username)
                ->where('password',$password)
                ->get();
        foreach ($query->result() as $row) {
            $confirmed_user = $row->username;
        }
        return $confirmed_user;
    }

    public function getCurrentEpisode() {
        $new_episode = "flirzelkwerp";
        $this->db->select_max('episode_number');
        $query = $this->db->get('show_info');
        foreach ($query->result() as $row) {
            $new_episode = $row->episode_number;
            if ($new_episode == '') {
                $new_episode = '0';
            } else {
                $new_episode++;
            }
        }
        return $new_episode;
    }
    
    public function checkEpisode($episode_number) {
        $query = $this->db->select('episode_number')
                ->from('show_info')
                ->where('episode_number', $episode_number)
                ->get();
        foreach($query->result() as $row) {
            return '3';
        }
        return '1';
    }
    
    public function addEpisode($episode_number, $episode_topic, $download_link) {
        $data = 0;
        if ($this->checkEpisode($episode_number) === '3') {
            echo '3';
            return;
        }        
        $this->db->set('episode_number', $episode_number);
        $this->db->set('episode_topic', $episode_topic);
        $this->db->set('download_link', $download_link);
        if ($this->db->insert('show_info')) {
            $data = 1;
        }
        echo $data;
    }
    
    public function addNotes($episode_number,$descriptions,$description_links,$priorities,$is_everything,$episode_topic,$download_link) {
        $notes_count = count($descriptions);
        for ($x = 0; $x < $notes_count; $x++) {
            $this->db->set('episode', $episode_number);
            $this->db->set('note', $descriptions[$x]);
            $this->db->set('description_link', $description_links[$x]);
            $this->db->set('priority', $priorities[$x]);
            if ($this->db->insert('show_notes')) {
                if ($is_everything) {
                    if ($this->addEpisode($episode_number, $episode_topic, $download_link)) {
                        echo '1';
                        return;
                    }
                }
            } else {
                echo '2';
                return;
            }
        }        
    }
}