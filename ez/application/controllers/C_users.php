<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_users extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_users');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }

    public function list_user()
    {

        $datos['valor'] = $this->M_users->list_user();

        //$data['content'] = $this->load->view('users/Vlist_user', $datos, true);
        $data['content'] = $this->load->view('users/vlist_user', $datos, true);
        $this->load->view('template', $data);
    }

    public function add_user()
    {

        $datos['type'] = $this->M_users->listA();
        $this->load->view('users/Vadd_user', $datos);
    }

    public function add_userdb()
    {
        print_r($this->M_users->add_users($_POST));

    }

    public function add_userdbmod()
    {

        parse_str($_POST['info'], $infor);
        print_r($this->M_users->add_usersmod($infor, $_POST['id']));

    }

    public function reset()
    {
        $this->M_users->resetpass($_POST['id']);
    }

    public function delete()
    {
        $this->M_users->delete($_POST['id']);
    }

    public function modifyuser()
    {

        $datos['info'] = $this->M_users->infouser($_POST['id']);
        $this->load->view('users/modify_user', $datos);

    }

}
