<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Latestshow extends CI_Model {

        public function getLatestShow($limit = null) {
            $data['episode'] = array();
            $query = $this->db->select('episode_number,episode_topic,download_link')
                    ->from('show_info')
                    ->where('publish','1')
                    ->order_by('episode_number', 'DESC')
                    ->limit($limit)
                    ->get();
            $result_count = 0;
            foreach ($query->result() as $row) {
                $ep_number = $row->episode_number;
                if ($row->episode_number > 15) {
                    $data['episode'][$result_count]['upper'] = true;
                    $ep_number--;
                }
                $data['episode'][$result_count]['episode_number'] = $ep_number;
                $data['episode'][$result_count]['episode_topic'] = $row->episode_topic;
                $data['episode'][$result_count]['download_link'] = $row->download_link;
                $data['episode'][$result_count]['notes'] = $this->getShowNotes($row->episode_number);
                $data['episode'][$result_count]['class_num'] = $result_count % 2 === 0 ? 0 : 1;
                $result_count++;
            }
            $latest_show = $data['episode'][0];
            if ($limit != 1) {
                // copy ratings to session
                $gquery = $this->db->select('id,gameTitle,jimRating,seanRating,episodeNumber')
                        ->from('pfGameRatings')
                        ->get();
                foreach($gquery->result() as $row) {
                    $ep_number = $row->episodeNumber > 15 ? $row->episodeNumber - 1 : $row->episodeNumber;
                    $_SESSION['ratings'][$ep_number][$row->id]['game'] = $row->gameTitle;
                    $_SESSION['ratings'][$ep_number][$row->id]['jimRating'] = $row->jimRating;
                    $_SESSION['ratings'][$ep_number][$row->id]['seanRating'] = $row->seanRating;
                }
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
        
        public function retrieveRatings() {
            $ratings = array();
            $gquery = $this->db->select('id,gameTitle,jimRating,seanRating,episodeNumber')
                    ->from('pfGameRatings')
                    ->get();
            foreach($gquery->result() as $row) {
                $ep_number = $row->episodeNumber > 15 ? $row->episodeNumber - 1 : $row->episodeNumber;
                $ratings[$ep_number][$row->id]['game'] = $row->gameTitle;
                $ratings[$ep_number][$row->id]['jimRating'] = $row->jimRating;
                $ratings[$ep_number][$row->id]['seanRating'] = $row->seanRating;
            }
            return $ratings;
        }
}
