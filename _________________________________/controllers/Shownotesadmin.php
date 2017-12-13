<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shownotesadmin extends CI_Controller
{

    public function submitNews()
    {
        $this->load->model('shownotesadmin_model');
        $data['date'] = $this->input->post('date');
        $data['headline'] = $this->input->post('headline');
        $data['article'] = $this->input->post('article');
        $success = $this->shownotesadmin_model->addNews($data);
        echo $success;
    }

    public function index()
    {
        $this->load->model('shownotesadmin_model');
        $data['new_episode'] = $this->shownotesadmin_model->getCurrentEpisode();
        $this->load->view('shownotesmain', $data);
        $this->load->view('add_show_notes');
    }

    public function getCurrentEpisode()
    {
        $this->load->model('shownotesadmin_model');
        echo $this->shownotesadmin_model->getCurrentEpisode();
    }

    public function logOut()
    {
//            $this->session->sess_destroy();
        unset($_SESSION);
    }

    public function showRatings()
    {
        $id = $this->input->post('id');
        echo json_encode($_SESSION['game_ratings'][$id]);
    }

    public function addNewRatings()
    {
        $this->load->model('shownotesadmin_model');
        $game = $this->input->post('gameTitle');
        $exists = $this->shownotesadmin_model->doesRatingExist($game);
        if ($exists !== '3') {
            $episodeNumber = $this->input->post('episodeNumber');
            if ($episodeNumber > 15) {
                $episodeNumber++;
            }
            $jim = $this->input->post('jim');
            $sean = $this->input->post('sean');
            $exists = $this->shownotesadmin_model->addRatings($episodeNumber, $game, $jim, $sean);
        }
        echo $exists;
    }

    public function submitRatingsChange()
    {
        $id = $this->input->post('id');
        $jim = $this->input->post('jim');
        $sean = $this->input->post('sean');
        $this->load->model('shownotesadmin_model');
        $success = $this->shownotesadmin_model->updateRatings($id, $jim, $sean);
        echo $success;
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->load->model('shownotesadmin_model');
        $logged_in_user = $this->shownotesadmin_model->login($username, $password);
        $_SESSION['username'] = $logged_in_user;
//            $this->session->set_userdata('username',$logged_in_user);
        echo $logged_in_user;
    }

    public function submit_episode()
    {
        $episode_topic = $this->input->post('episode_topic');
        $episode_number = $this->input->post('episode_number');
        $download_link = $this->input->post('download_link');
        $publish_this_podcast = $this->input->post('publish_this_podcast');
        $this->load->model('shownotesadmin_model');
        return $this->shownotesadmin_model->addEpisode($episode_number, $episode_topic, $download_link, $publish_this_podcast);
    }

    public function submit_notes()
    {
        $episode_number = $this->input->post('episode_number');
        $descriptions = $this->input->post('description');
        $description_links = $this->input->post('description_link');
        $is_everything = $this->input->post('is_everything');
        $priorities = $this->input->post('priority');
        $publish = $this->input->post('publish');
        $this->load->model('shownotesadmin_model');
        if ($is_everything) {
            $episode_topic = $this->input->post('episode_topic');
            $download_link = $this->input->post('download_link');
            $this->shownotesadmin_model->addNotes($episode_number, $descriptions, $description_links, $priorities, $is_everything, $episode_topic, $download_link, $publish);
        } else {
            $this->shownotesadmin_model->addNotes($episode_number, $descriptions, $description_links, $priorities);
        }
    }

    public function checkEpisode()
    {
        $this->load->model('shownotesadmin_model');
        $episode_number = $this->input->post('episode_number');
        echo $this->shownotesadmin_model->checkEpisode($episode_number);
    }

    public function azerBaijan()
    {
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            $this->load->view('azerbaijan');
        } else {
            $this->load->view('main');
        }
    }

    public function getGames()
    {
        $this->load->model('shownotesadmin_model');
        echo $this->shownotesadmin_model->retrieveGames();
    }

    public function getEpisodes()
    {
        $section = $this->input->post('section');
        $this->load->model('shownotesadmin_model');
        echo $this->shownotesadmin_model->retrieveEpisodes($section);
    }

    public function getNotes()
    {
        $ep_opt = $this->input->post('episode');
        $episode = explode(' ', $ep_opt);
        $episode[1] = (int)$episode[1];
        if ($episode[1] > 15) {
            $episode[1]++;
        } else {
            if (stristr($ep_opt, 'part 2') && $episode[1] == 15) {
                $episode[1]++;
            }
        }
        $this->load->model('shownotesadmin_model');
        echo json_encode($this->shownotesadmin_model->retrieveNotes($episode[1]));
    }

    public function deleteNote()
    {
        $id = $this->input->post('id');
        $this->load->model('shownotesadmin_model');
        echo $this->shownotesadmin_model->killNotes($id);
    }

    public function updateNote()
    {
        $id = $this->input->post('id');
        $note = $this->input->post('note');
        $description_link = $this->input->post('description_link');
        $priority = $this->input->post('priority');
        $this->load->model('shownotesadmin_model');
        echo $this->shownotesadmin_model->changeNote($id, $note, $description_link, $priority);
    }

    public function getUnpublished()
    {
        $this->load->model('shownotesadmin_model');
        $unpublishedList = $this->shownotesadmin_model->getUnpublishedEpisodes();
        $returnHTML = '<div class="formLabelRow"><div class="unpubCheck uHead">Publish?';
        $returnHTML .= '</div><div class="unpubNumber uHead">Episode topic</div>';
        $returnHTML .= '<div><button id="butt_pub" type="button" onclick="buttPub()">PUBLISH</button></div>';
        $returnHTML .= '</div>';
        foreach ($unpublishedList as $k => $v) {
            $returnHTML .= '<div class="formLabelRow"><div class="unpubCheck">';
            $returnHTML .= '<input type="checkbox" id="unpub_' . $v['id'] . '" /></div>';
            $returnHTML .= '<div class="unpubNumber">';
            $returnHTML .= 'Episode ' . $v['episode_number'] . ': ' . $v['episode_topic'];
            $returnHTML .= '</div></div>';
        }
        echo $returnHTML;
    }

    public function publishEpisodes()
    {
        $episode_ids = explode('~', $this->input->post('toPublish'));
        $this->load->model('shownotesadmin_model');
        $response = $this->shownotesadmin_model->publishTheseEpisodes($episode_ids);
        echo $response;
    }
}