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
    
    public function addEpisode($episode_number, $episode_topic, $download_link, $publish) {
        $data = 0;
        if ($this->checkEpisode($episode_number) === '3') {
            echo '3';
            return;
        }
        $publish = $publish ? 1 : 0;
        $this->db->set('episode_number', $episode_number);
        $this->db->set('episode_topic', $episode_topic);
        $this->db->set('download_link', $download_link);
        $this->db->set('publish', $publish);
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
    
    public function getUnpublishedEpisodes() {
        $query = $this->db->select('id,episode_number,episode_topic')
                ->from('show_info')
                ->where('publish',null)
                ->order_by('episode_number', 'DESC')
                ->get();
        $c = 0;
        foreach ($query->result() as $row) {
            $epnum = (int) $row->episode_number;
            if ($epnum >15) {
                $epnum--;
            }
            $data[$c]['id'] = $row->id;
            $data[$c]['episode_number'] = $epnum;
            $data[$c]['episode_topic'] = $row->episode_topic;
            $c++;
        }
        
        return $data;
    }
    
    public function publishTheseEpisodes($data) {
        $query = $this->db->set('publish','1')
                 ->where_in('id',$data)
                 ->update('show_info');
        $result = $query->result();
    }
    
    public function retrieveEpisodes($section) {
        $data = $section == 'add' ? "<select id='add_chooser'>" : "<select id='ed_chooser'>";
        $query = $this->db->select('episode_number,episode_topic')
                ->from('show_info')
                ->order_by('episode_number','DESC')
                ->get();
        foreach ($query->result() as $row) {
            $epnum = (int)$row->episode_number;
            if ($epnum > 15) {
                $epnum--;
            }
            $data .= "<option id='option". $row->episode_number . "'>";
            $data .= "Episode " . $epnum . " - " . $row->episode_topic; 
            $data .= "</option>";
        }
        $data .= "</select>";
        return $data;
    }
    
    public function retrieveNotes($episode_number) {
        $query = $this->db->select('id,note,description_link,priority')
                ->from('show_notes')
                ->where('episode',$episode_number)
                ->order_by('priority','ASC')
                ->get();
        $notes = array();
        $c = 0;
        foreach($query->result() as $row) {
            $notes[$c]['id'] = $row->id;
            $notes[$c]['note'] = $row->note;
            $notes[$c]['description_link'] = $row->description_link;
            $notes[$c]['priority'] = $row->priority;
            $c++;
        }
        return $notes;
    }
    
    public function killNotes($id) {
        $query = $this->db->where('id',$id)
                ->delete('show_notes');
        return $query;
    }
    
    public function changeNote($id, $note, $description_link, $priority) {
        $data = array(
            'note' => $note,
            'description_link' => $description_link,
            'priority' => $priority,
        );
        $query = $this->db->where('id',$id)
                ->update('show_notes',$data);
        return $query;
    }
}
