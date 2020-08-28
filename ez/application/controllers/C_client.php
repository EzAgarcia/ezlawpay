<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_client extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_client');
        $this->load->model('M_client_list');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }
    public function clients()
    {
        $data['clients'] = $this->M_client->list_clients();
        $data['content'] = $this->load->view('clients/v_clients', $data, true);
        $this->load->view('template', $data);
    }
    public function detail_client()
    {
        $data['countryes'] = $this->M_client->list_country();
        $data['states']    = $this->M_client->list_states();
        $data['id']        = $_POST['id'];
        $data['det']       = $this->M_client->det_client($_POST['id']);
        $this->load->view('clients/v_det_client', $data);
    }
    public function save_edit_client()
    {
        print($this->M_client->save_update($_POST));
    }
    public function new_client()
    {
        $data['countryes'] = $this->M_client->list_country();
        $data['states']    = $this->M_client->list_states();
        $this->load->view('clients/new_client', $data);
    }
    public function save_client()
    {
        $name  = $_POST['name'];
        $split = explode(' ', $name);
        $user  = strtoupper(substr($split[0], 0, 2)) . strtoupper(substr($split[1], 0, 2)) . rand(1000, 9999);
        $data  = array(
            'user'      => $user,
            'pass'      => '$2y$10$PuRH.HrPYIQwbOKUrvv.Xur5s0UEj.6PQHffMKd2DqeyxJ/dPjS8u',
            'name'      => $_POST['name'],
            'sex'       => $_POST['sex'],
            'birthdate' => $_POST['birthdate'],
            'b_country' => $_POST['b_country'],
            'language'  => $_POST['language'],
            'address'   => $_POST['address'],
            'city'      => $_POST['city'],
            'zip'       => $_POST['zip'],
            'estate'    => $_POST['estate'],
            'country'   => $_POST['country'],
            'phone'     => $_POST['phone'],
            'email'     => $_POST['email'],
        );
        print_r($this->M_client->save_client($data));
    }
    public function del_client()
    {
        print_r($this->M_client->del_client($_POST['id']));
    }
    public function client_list()
    {
        $list = $this->M_client_list->json_list();

        print_r($list);
        return $list;
    }
}
