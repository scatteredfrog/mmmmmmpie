<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Latestshow extends CI_Model {

        public function getLatestShow() {
            $data['episode'] = array();
            $query = $this->db->select('episode_number,episode_topic,download_link')
                    ->from('show_info')
                    ->order_by('episode_number', 'DESC')
                    ->get();
            $result_count = 0;
            foreach ($query->result() as $row) {
                $data['episode'][$result_count]['episode_number'] = $row->episode_number;
                $data['episode'][$result_count]['episode_topic'] = $row->episode_topic;
                $data['episode'][$result_count]['download_link'] = $row->download_link;
                $data['episode'][$result_count]['notes'] = $this->getShowNotes($row->episode_number);
                $result_count++;
            }
            return $data;
        }
        
        public function getShowNotes($episode_number) {
            $notes = array();
            $snQuery = $this->db->select('note,description_link,priority')
                    ->from('show_notes')
                    ->where('episode',$episode_number)
                    ->order_by('priority', 'ASC')
                    ->get();
            $notes_count = 0;
            foreach ($snQuery->result() as $snRow) {
                $notes[$notes_count]['note'] = $snRow->note;
                $notes[$notes_count]['description_link'] = $snRow->description_link;
                $notes_count++;
            }
            return $notes;
        }
}
