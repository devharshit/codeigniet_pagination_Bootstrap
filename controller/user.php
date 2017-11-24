<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
// Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('usermodel');
        $this->load->library("session");
        $username = $this->session->userdata('username');
        if (empty($username)) {
            redirect($this->config->base_url() . 'login');
        }
        $this->load->library("pagination");
    }

    public function index() {
        redirect($this->config->base_url() . 'user/view');
    }

//sarching
    public function searchterm_handler($searchterm) {
        if ($searchterm) {
            $this->session->set_userdata('searchterm ', $searchterm);
            return $searchterm;
        } elseif ($this->session->userdata('searchterm')) {
//print_r ($_SESSION['searchterm']);exit;
            $searchterm = $this->session->userdata('searchterm');
            return $searchterm;
        } else {
            $searchterm = "";
            return $searchterm;
        }
    }

    public function searh() {
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
//pagination//
        $searchterm = $this->searchterm_handler($_POST, TRUE);
        $config = array();
        $config["base_url"] = $this->config->base_url() . "user/searh";
        $config["total_rows"] = $this->
            ->count_search($searchterm);
        $config["per_page"] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
//config for bootstrap pagination class integration
        $config['full_tag_open'] = '

        ';
        $config['full_tag_close'] = '
        ';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '

        ';
        $config['first_tag_close'] = '
        ';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '

        ';
        $config['prev_tag_close'] = '
        ';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '

        ';
        $config['next_tag_close'] = '
        ';
        $config['last_tag_open'] = '

        ';
        $config['last_tag_close'] = '
        ';
        $config['cur_tag_open'] = '

        ';
        $config['cur_tag_close'] = '
        ';
        $config['num_tag_open'] = '

        ';
        $config['num_tag_close'] = '
        ';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
//searching… //
        $data['result'] = $this->usermodel->get_search($searchterm, $page, $config["per_page"]);
//end searching…//
        $data["link"] = $this->pagination->create_links();
        $data['hms'] = $page;
        $this->load->view('user/userview ', $data);
        $this->load->view('layout/footer');
    }

}

?>
