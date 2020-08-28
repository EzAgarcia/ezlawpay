<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_invoice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_invoice');
        $this->load->model('M_contracts');
        $this->load->model('M_table_list');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }
    public function view_invoice($id)
    {
        $data['general'] = $this->M_invoice->general_contract($id);
        $this->load->view('invoice/view_invoice', $data);
    }
    public function unapplied_payments2()
    {
        $data['unapplieds'] = $this->M_invoice->unapplied2();
        $data['contracts']  = $this->M_contracts->contracts();
        $data['content']    = $this->load->view('invoice/unapplied_payments2', $data, true);
        $this->load->view('template', $data);
    }
    public function unapplied_payments()
    {

        // $this->pagos();
        $data['unapplieds'] = $this->M_invoice->unapplied();
        $data['contracts']  = $this->M_contracts->contracts();
        $data['fees']       = $this->M_invoice->fees();
        $data['content']    = $this->load->view('invoice/unapplied_payments', $data, true);
        $this->load->view('template', $data);
    }
    public function view_payment_details()
    {
        $data['details'] = $this->M_invoice->details_pay_square($_POST['square']);
        $this->load->view('invoice/details_square_pay', $data);
    }
    public function view_payment_details2()
    {
        $data['details'] = $this->M_invoice->details_payment($_POST['square']);
        $this->load->view('invoice/details_payment', $data);
    }
    public function save_pay()
    {

        $data['contract'] = $this->M_contracts->showContract($_POST['contract']);
        $fesx             = intval($_POST['type_fee']);

        if ($data['contract'][0]->Balance_Amount > 0 or $fesx != 0) {

            $data['square'] = $this->M_invoice->details_pay_square($_POST['square']);

            $pay['id_square']  = $_POST['square'];
            $pay['date']       = $data['square'][0]->date;
            $pay['contract']   = $_POST['contract'];
            $pay['note']       = $data['square'][0]->note;
            $pay['mount']      = $data['square'][0]->mount;
            $pay['fee']        = intval($_POST['type_fee']);
            $pay['id_squarex'] = $data['square'][0]->id_square;
            switch ($data['square'][0]->type) {
                case 4:
                    $method = 4;
                    break;
                case 1:
                    $method = 1;
                    break;
                case 3:
                    $method = 3;
                    break;
                case 8:
                    $method = 8;
                    break;
                case 9:
                    $method = 9;
                    break;
                default:
                    $method = 2;
                    break;
            }

            $pay['method']     = $method;
            $pay['ID_payment'] = $this->M_invoice->insert_pay($pay);
            if ($pay['fee'] == 0) {
                $pay['balance']    = $data['contract'][0]->Balance_Amount - $pay['mount'];
                $pay['receivable'] = $data['contract'][0]->Receivable_Amount - $pay['mount'];

                $query1  = "SELECT Sign_Date from t_contracts where ID ='" . $_POST['contract'] . "' ";
                $fechass = $this->db->query($query1)->result()[0]->Sign_Date;

                $anio = date('Y', strtotime($fechass));
                if ($anio >= 2020) {
                    $response = $this->M_contracts->balance_link_pagos($_POST['contract']);
                }

            } else {
                if ($pay['fee'] == 7) {
                    $pay['balance']    = $data['contract'][0]->Balance_Amount;
                    $pay['receivable'] = $data['contract'][0]->Receivable_Amount - $pay['mount'];
                } else {
                    $pay['balance']    = $data['contract'][0]->Balance_Amount;
                    $pay['receivable'] = $data['contract'][0]->Receivable_Amount;
                }

            }

            $this->M_invoice->insert_invoice($pay);
            $this->M_invoice->update_pay($pay);
            $this->M_invoice->update_mount($pay);
            print_r('SI');

        } else {

            print_r('NO');

        }
    }

    public function pagos()
    {
        $fees     = array();
        $cont     = 0;
        $countf   = 0;
        $counnf   = 0;
        $countsn  = 0;
        $type_fee = $this->db->query('select ID, Fee_Type, Evaluator from catt_fees')->result();
        foreach ($type_fee as $type) {
            $fees[$type->Fee_Type] = 0;

        }
        $query = "select * from payment_square where id_invoice='0' order by ID asc";
        $data  = $this->db->query($query);
        $data  = $data->result();
        foreach ($data as $pay) {

            // print_r($pay->ID);

            $numeros = '';
            $mount   = $pay->mount;
            $note    = $pay->note;
            $ID      = $pay->ID;
            $square  = $pay->id_square;
            foreach (str_split($pay->note) as $key) {
                // print_r($key);
                if (is_numeric($key)) {
                    $numeros = $numeros . $key;

                }

            }
            if (trim($numeros) != '') {
                if (strlen($numeros) >= 8) {
                    $cuantos = strlen($numeros) / 8;
                    $cuantos = 1;
                    for ($i = 1; $i <= $cuantos; $i++) {
                        $inicio   = 8 * ($i - 1);
                        $contrato = substr($numeros, $inicio, 2) . '-' . substr($numeros, ($inicio + 2), 2) . '-' . substr($numeros, ($inicio + 4), 4);
                        $cadena2  = "SELECT ID, Contract_N, Montly_Amount,Balance_Amount,Receivable_Amount FROM t_contracts where Contract_N='" . $contrato . "'";
                        $query    = $this->db->query($cadena2);
                        if ($query->num_rows() == 0) {

                        } else {

                            $cuar = "SELECT count(ID) as encontrado FROM payment_square where ID='" . $ID . "' and (note like '%FEE%' or note like '%fee%')";
                            if ($this->db->query($cuar)->result()[0]->encontrado > 0) {
                                //es fee
                                foreach ($type_fee as $type) {
                                    $fa = "SELECT ID from  payment_square WHERE ID='" . $ID . "' and note like '%" . $type->Evaluator . "%'";
                                    if ($this->db->query($fa)->num_rows() > 0) {

                                        switch ($pay->type) {
                                            case 4:
                                                $method = 4;
                                                break;
                                            case 1:
                                                $method = 1;
                                                break;
                                            default:
                                                $method = 2;
                                                break;
                                        }

                                        $compar = "SELECT COUNT(ID) as sumad FROM t_payments WHERE Pay_Reference = '" . $square . "'";

                                        $result = $this->db->query($compar)->result();
                                        if ($result[0]->sumad > 0) {

                                        } else {

                                            $insert = "INSERT INTO t_payments (Date, Contract_N, Contract_ID, Pay_Description, Pay_Amount, Pay_Method, Fee_ID, Pay_Reference) values ('" . $pay->date . "', '','" . $query->result()[0]->ID . "','" . $note . "', '" . $mount . "', '" . $method . "','" . $type->ID . "', '" . $square . "')";
                                            $this->db->query($insert);
                                            $bus = "SELECT ID from t_payments where Pay_Reference='" . $square . "' and Contract_ID='" . $query->result()[0]->ID . "'";
                                            $id  = $this->db->query($bus)->result()[0]->ID;
                                            $this->db->query("UPDATE payment_square SET id_invoice='" . $id . "' WHERE ID='" . $pay->ID . "'");

                                            $insert_invoice = "INSERT INTO t_invoice (Contract_ID, Payments_ID, Invoice_Date) VALUES ('" . $query->result()[0]->ID . "', '" . $id . "', NOW())";
                                            $this->db->query($insert_invoice);
                                            $countf = $countf + 1;
                                            // print_r($countf);
                                        }

                                    }
                                }

                            } else {
                                //no es fee

                                $total   = $query->result()[0]->Receivable_Amount - $mount;
                                $balance = $query->result()[0]->Balance_Amount - $mount;
                                $bus     = "UPDATE t_contracts SET Receivable_Amount='" . $total . "', Balance_Amount='" . $balance . "' WHERE ID='" . $query->result()[0]->ID . "'";
                                $this->db->query($bus);
                                switch ($pay->type) {
                                    case 4:
                                        $method = 4;
                                        break;
                                    case 1:
                                        $method = 1;
                                        break;
                                    case 3:
                                        $method = 3;
                                        break;
                                    case 8:
                                        $method = 8;
                                        break;
                                    case 9:
                                        $method = 9;
                                        break;
                                    default:
                                        $method = 2;
                                        break;
                                }
                                $insert = "INSERT INTO t_payments (Date, Contract_N, Contract_ID, Pay_Description, Pay_Amount, Pay_Method, Fee_ID, Pay_Reference) values ('" . $pay->date . "', '','" . $query->result()[0]->ID . "','" . $note . "', '" . $mount . "', '" . $method . "','0', '" . $square . "')";

                                $this->db->query($insert);
                                $bus = "SELECT ID from t_payments where Pay_Reference='" . $square . "' and Contract_ID='" . $query->result()[0]->ID . "'";
                                $id  = $this->db->query($bus)->result()[0]->ID;
                                $this->db->query("UPDATE payment_square SET id_invoice='" . $id . "' WHERE ID='" . $pay->ID . "'");

                                $insert_invoice = "INSERT INTO t_invoice (Contract_ID, Payments_ID, Invoice_Date) VALUES ('" . $query->result()[0]->ID . "', '" . $id . "', NOW())";
                                $this->db->query($insert_invoice);
                                $counnf = $counnf + 1;
                                // print_r($counnf."s");

                            }
                        }
                    }
                } else {

                    $countsn = $countsn + 1;

                }

            } else {

            }
        }

    }

    public function save_pay2()
    {
        print_r($this->M_invoice->update_nopayment($_POST));
    }
    public function upload_report()
    {
        $this->load->view('invoice/upload_file');
    }
    public function charge_file()
    {

        $dir_subida     = $_SERVER['DOCUMENT_ROOT'] . '/ez2/uploads/';
        $fichero_subido = $dir_subida . basename($_FILES['customFile']['name']);

        if (move_uploaded_file($_FILES['customFile']['tmp_name'], $fichero_subido)) {

            //cargamos el archivo
            $lineas = file($fichero_subido);

//inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
            $i = 0;

//Recorremos el bucle para leer línea por línea
            foreach ($lineas as $linea_num => $linea) {
                //abrimos bucle
                /*si es diferente a 0 significa que no se encuentra en la primera línea
                (con los títulos de las columnas) y por lo tanto puede leerla*/
                if ($i != 0) {
                    //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
                    /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá
                    leyendo hasta que encuentre un ; */
                    $datos = explode(";", $linea);

                    //Almacenamos los datos que vamos leyendo en una variable
                    //usamos la función utf8_encode para leer correctamente los caracteres especiales
                    $nombre    = utf8_encode($datos[0]);
                    $edad      = $datos[1];
                    $profesion = utf8_encode($datos[2]);

                    //guardamos en base de datos la línea leida

                }

                /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya
                entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
                $i++;
                //cerramos bucle
            }

        } else {
            echo "¡Posible ataque de subida de ficheros!\n";
        }

    }

    public function unapplied_payments_list()
    {
        $list_data = array(
            'table'            => 'payment_square',
            'column_order'     => array('ID', 'type', 'date', 'mount', 'id_invoice', 'id_square'),
            'column_search'    => array('ID', 'type', 'date', 'mount', 'id_invoice', 'id_square'),
            'selected_columns' => '*',
            'query_data'       => array(
                'where'        => array('id_invoice' => 0),
                'oder_by'      => 'date',
                'oder_by_type' => 'DESC',
            ),
        );

        $table = $this->M_table_list;
        $table->add($list_data);
        $list = $table->json_list();

        print_r($list);
        return json_encode($list);
    }

    public function unapplied_payments_contracts_list()
    {
        $list_data = array(
            'table'            => 't_contracts as tc',
            'column_order'     => array('tc.ID', 'tc.Balance_Amount', 'tc.Contract_N', 'tc.Value', 'tc.Montly_Amount', 'tc.Date_Montly_P', 'tc.Frequency_ID', 't_client.C_Name', 'tc.Sign_Date', 'catt_status.Status', 'tc.Receivable_Amount'),
            'column_search'    => array('tc.ID', 'tc.Montly_Amount', 'tc.Contract_N', 't_client.C_Name'),
            'column_names'     => array('contract_id', 'Balance_Amount', 'Contract_N', 'Value', 'Montly_Amount', 'Date_Montly_P', 'Frequency_ID', 'C_Name', 'Sign_Date', 'Status', 'Receivable_Amount'),
            'selected_columns' => 'tc.ID as contract_id, tc.Balance_Amount as Balance_Amount, tc.Contract_N as Contract_N, tc.Value as Value, tc.Montly_Amount as Montly_Amount, tc.Date_Montly_P as Date_Montly_P, tc.Frequency_ID as Frequency_ID,  t_client.C_Name as C_Name, tc.Sign_Date as Sign_Date, catt_status.Status as Status, tc.Receivable_Amount as Receivable_Amount',
            'query_data'       => array(
                'where'        => array('t_users.Company' => $_SESSION['ezlow']['lawfirm']),
                'oder_by'      => 'contract_id',
                'oder_by_type' => 'DESC',
                'joins'        => array(
                    array(
                        'table'      => 't_client',
                        'comparison' => 'tc.Client_ID = t_client.ID',
                        'type'       => '',
                    ), array(
                        'table'      => 't_users',
                        'comparison' => 'tc.Registered_By_ID = t_users.ID',
                        'type'       => '',
                    ), array(
                        'table'      => 'catt_status',
                        'comparison' => 'catt_status.ID = tc.status_ID',
                        'type'       => '',
                    )),
            ),
        );

        $table = $this->M_table_list;
        $table->add($list_data);
        $list = $table->json_list();

        print_r($list);
        return json_encode($list);
    }

    public function payment_details_list()
    {
        $data['details'] = $this->M_invoice->details_payment($_POST['square']);

        print_r($unapplied);
        return json_encode();
    }
}
