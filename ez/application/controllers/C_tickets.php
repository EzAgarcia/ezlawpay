<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_tickets extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_client');
        $this->load->model('M_tickets');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }

    public function tickets()
    {
        $info['infot']     = $this->M_tickets->tickets();
        $info['ticketst']  = $this->M_tickets->totaltick();
        $info['ticketstp'] = $this->M_tickets->totaltickp();
        $info['asignados'] = $this->M_tickets->asignados();
        $info['historial'] = $this->M_tickets->historial();
        // $info['balances']=$this->M_tickets->balancesinfo();
        $info['showbalances'] = $this->M_tickets->balancesshow();
        $data['content']      = $this->load->view('tickets/ticket', $info, true);
        $this->load->view('template', $data);
    }

    public function addtickets()
    {

        $result = $this->M_tickets->addtickets($_POST);
        $string = $_FILES['fichero_usuario']['tmp_name'];
        $type   = explode('.', $_FILES['fichero_usuario']['name']);
        $ter    = end($type);

        if (!empty($_FILES['fichero_usuario']['name'])) {
            $dir_subida     = 'assets/tickets/';
            $fichero_subido = $dir_subida . basename($result . '.' . $ter);
            move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido);
            $nombre = $result . '.' . $ter;
            $this->M_tickets->addarchivo($result, $nombre);
        }

        // $this->tickets();
        header('Location: /ez/C_tickets/tickets');

    }

    public function editar()
    {
        // $this->M_tickets->editar($_POST);
        $this->load->view('tickets/editarbalance', $_POST);

    }

    public function tomar()
    {
        $this->M_tickets->tomar($_POST);
    }

    public function cerrar()
    {

        $this->M_tickets->cerrar($_POST);
    }

    public function balance()
    {
        $this->M_tickets->balance($_POST);
    }

    public function addedit()
    {
        $this->M_tickets->addedit($_POST);
    }

    public function balance_request()
    {
        $result = $this->M_tickets->new_balance(true);

        print_r($result);
        return $result;
    }
}
