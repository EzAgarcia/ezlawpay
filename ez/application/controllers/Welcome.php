<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_login');
        $this->load->model('M_square');
        $this->load->model('M_reports');
        $this->load->model('M_setting');
        $this->load->model('M_tickets');
        $this->load->model('M_contracts');

        /*$this->load->model('login_model');
        $this->load->model('Empresa_model','empresas');
        $this->load->model('usuario_model','usuario');*/
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }
    public function index()
    {
        $this->load->view('index');
    }
    public function about()
    {
        $this->load->view('about');
    }
    public function login()
    {

        $this->load->view('login');

    }
    public function dashboard()
    {

        if ($_SESSION['ezlow']['lawfirm'] == 1 and $_SESSION['ezlow']['profile'] != 3) {

            $this->M_tickets->new_tickets();
            $this->M_tickets->new_balance();
            $type    = isset($this->session->ezlow['type']) ? $this->session->ezlow['type'] : 2;
            $cuantos = 1;
            if ($type == 'user') {
                $data["square"] = $this->M_square->getConfiguration();
                if ($data['square']->num_rows() > 0) {
                    $last = $this->M_reports->ultimo_square2();
                    if ($last->num_rows() >= 0) {
                        $date = $this->dashboard_payments_date($last);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL            => "https://connect.squareup.com/v2/locations/" . $data['square']->result()[0]->fcLocationID . "/transactions?begin_time=" . $date . "Z&end_time=" . date('Y') . "-" . date('m') . "-" . date('d') . "T23%3A59%3A59Z",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING       => "",
                            CURLOPT_MAXREDIRS      => 10,
                            CURLOPT_TIMEOUT        => 30,
                            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST  => "GET",
                            CURLOPT_HTTPHEADER     => array(
                                "Accept: */*",
                                "Accept-Encoding: gzip, deflate",
                                "Authorization: Bearer " . $data['square']->result()[0]->fcPersonalAccessToken,
                                "Cache-Control: no-cache",
                                "Connection: keep-alive",
                                "Host: connect.squareup.com",
                                "Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
                                "User-Agent: PostmanRuntime/7.20.1",
                                "cache-control: no-cache",
                            ),
                        ));

                        $response = curl_exec($curl);
                        $err      = curl_error($curl);
                        curl_close($curl);
                        if ($err) {
                            echo "cURL Error #:" . $err;
                        } else {
                            $array = json_decode($response, true);

                            if (isset($array['cursor'])) {
                                $cursor = $array['cursor'];
                            } else {
                                $cursor = '';
                            }
                            $cuantos = 0;
                            foreach ($array as $value) {
                                if (is_array($value)) {

                                    foreach ($value as $registrer) {
                                        $mount = substr($registrer['tenders'][0]['amount_money']['amount'], 0, -2);

                                        $note = '';
                                        if (isset($registrer['tenders'][0]['note'])) {
                                            $note = trim($registrer['tenders'][0]['note'], " \ ");
                                        } else {
                                            $note = '';
                                        }
                                        $da = array(
                                            'id_square' => $registrer['tenders'][0]['transaction_id'],
                                            'mount'     => $mount,
                                            'type'      => $registrer['tenders'][0]['type'],
                                            'date'      => $registrer['created_at'],
                                            'note'      => $note,

                                        );
                                        $this->M_reports->save_dashboard_payments($da);
                                    }
                                }

                            }

                            while ($cursor != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL            => "https://connect.squareup.com/v2/locations/" . $data['square']->result()[0]->fcLocationID . "/transactions?begin_time=" . $date . "Z&end_time=" . date('Y') . "-" . date('m') . "-" . date('d') . "T23%3A59%3A59Z&cursor=" . $cursor,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING       => "",
                                    CURLOPT_MAXREDIRS      => 10,
                                    CURLOPT_TIMEOUT        => 30,
                                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST  => "GET",
                                    CURLOPT_HTTPHEADER     => array(
                                        "Accept: */*",
                                        "Accept-Encoding: gzip, deflate",
                                        "Authorization: Bearer " . $data['square']->result()[0]->fcPersonalAccessToken,
                                        "Cache-Control: no-cache",
                                        "Connection: keep-alive",
                                        "Host: connect.squareup.com",
                                        "Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
                                        "User-Agent: PostmanRuntime/7.20.1",
                                        "cache-control: no-cache",
                                    ),
                                ));
                                $response2 = curl_exec($curl);
                                $err       = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    echo "cURL Error #:" . $err;
                                } else {
                                    $array1 = json_decode($response2, true);
                                    foreach ($array1 as $value1) {
                                        if (is_array($value1)) {
                                            foreach ($value1 as $registrer1) {
                                                $mount = substr($registrer1['tenders'][0]['amount_money']['amount'], 0, -2);
                                                $note  = '';
                                                if (isset($registrer1['tenders'][0]['note'])) {
                                                    $note = trim($registrer1['tenders'][0]['note'], " \ ");
                                                } else {
                                                    $note = '';
                                                }
                                                $da = array(
                                                    'id_square' => $registrer['tenders'][0]['transaction_id'],
                                                    'mount'     => $mount,
                                                    'type'      => $registrer['tenders'][0]['type'],
                                                    'date'      => $registrer1['created_at'],
                                                    'note'      => $note,

                                                );
                                                $this->M_reports->save_dashboard_payments($da);

                                            }
                                        }

                                    }
                                    if (isset($array1['cursor'])) {
                                        $cursor = $array1['cursor'];
                                    } else {
                                        $cursor = '';
                                    }
                                }
                            }

                        }
                    } else {

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL            => "https://connect.squareup.com/v2/locations/" . $data['square']->result()[0]->fcLocationID . "/transactions?begin_time=2016-01-01T00%3A00%3A00Z&end_time=" . date('Y') . "-" . date('m') . "-" . date('d') . "T23%3A59%3A59Z",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING       => "",
                            CURLOPT_MAXREDIRS      => 10,
                            CURLOPT_TIMEOUT        => 30,
                            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST  => "GET",
                            CURLOPT_HTTPHEADER     => array(
                                "Accept: */*",
                                "Accept-Encoding: gzip, deflate",
                                "Authorization: Bearer " . $data['square']->result()[0]->fcPersonalAccessToken,
                                "Cache-Control: no-cache",
                                "Connection: keep-alive",
                                "Host: connect.squareup.com",
                                "Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
                                "User-Agent: PostmanRuntime/7.20.1",
                                "cache-control: no-cache",
                            ),
                        ));
                        $response = curl_exec($curl);
                        $err      = curl_error($curl);
                        curl_close($curl);
                        if ($err) {
                            echo "cURL Error #:" . $err;
                        } else {
                            $array = json_decode($response, true);
                            if (isset($array['cursor'])) {
                                $cursor = $array['cursor'];
                            } else {
                                $cursor = '';
                            }
                            $cuantos = 0;
                            foreach ($array as $value) {
                                if (is_array($value)) {
                                    foreach ($value as $registrer) {

                                        $mount = substr($registrer['tenders'][0]['amount_money']['amount'], 0, -2);
                                        $note  = '';

                                        if (isset($registrer['tenders'][0]['note'])) {
                                            $note = trim($registrer['tenders'][0]['note'], " \ ");
                                        } else {
                                            $note = '';
                                        }
                                        print_r($registrer);
                                        exit();
                                        $da = array(
                                            'id_square' => $registrer['tenders'][0]['transaction_id'],
                                            'mount'     => $mount,
                                            'type'      => $registrer['tenders'][0]['type'],
                                            'date'      => $registrer['created_at'],
                                            'note'      => $note,

                                        );
                                        $this->M_reports->save_dashboard_payments($da);

                                    }
                                }

                            }

                            while ($cursor != '') {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL            => "https://connect.squareup.com/v2/locations/" . $data['square']->result()[0]->fcLocationID . "/transactions?begin_time=2016-01-01T00%3A00%3A00ZZ&end_time=" . date('Y') . "-" . date('m') . "-" . date('d') . "T23%3A59%3A59Z&cursor=" . $cursor,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING       => "",
                                    CURLOPT_MAXREDIRS      => 10,
                                    CURLOPT_TIMEOUT        => 30,
                                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST  => "GET",
                                    CURLOPT_HTTPHEADER     => array(
                                        "Accept: */*",
                                        "Accept-Encoding: gzip, deflate",
                                        "Authorization: Bearer " . $data['square']->result()[0]->fcPersonalAccessToken,
                                        "Cache-Control: no-cache",
                                        "Connection: keep-alive",
                                        "Host: connect.squareup.com",
                                        "Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
                                        "User-Agent: PostmanRuntime/7.20.1",
                                        "cache-control: no-cache",
                                    ),
                                ));
                                $response2 = curl_exec($curl);
                                $err       = curl_error($curl);
                                curl_close($curl);
                                if ($err) {
                                    echo "cURL Error #:" . $err;
                                } else {
                                    $array1 = json_decode($response2, true);
                                    foreach ($array1 as $value1) {
                                        if (is_array($value1)) {
                                            foreach ($value1 as $registrer1) {
                                                $mount = substr($registrer1['tenders'][0]['amount_money']['amount'], 0, -2);

                                                $note = '';

                                                if (isset($registrer1['tenders'][0]['note'])) {
                                                    $note = trim($registrer1['tenders'][0]['note'], " \ ");
                                                } else {
                                                    $note = '';
                                                }
                                                $da = array(
                                                    'id_square' => $registrer['tenders'][0]['transaction_id'],
                                                    'mount'     => $mount,
                                                    'type'      => $registrer['tenders'][0]['type'],
                                                    'date'      => $registrer1['created_at'],
                                                    'note'      => $note,

                                                );
                                                $this->M_reports->save_dashboard_payments($da);

                                            }
                                        }

                                    }
                                    if (isset($array1['cursor'])) {
                                        $cursor = $array1['cursor'];
                                    } else {
                                        $cursor = '';
                                    }
                                }
                            }

                        }
                    }

                }
                $this->pagos();
                $data['paymentMethod']         = $this->M_reports->paymentsmethods();
                $data['sing_today']            = $this->M_reports->count_sign_today();
                $data['hold']                  = $this->M_reports->contracts_hold();
                $data['cancel']                = $this->M_reports->contracts_cancel();
                $data['active']                = $this->M_reports->contracts_active();
                $data['pending']               = $this->M_reports->pending_today();
                $data['paid']                  = $this->M_reports->paid();
                $data['suma']                  = $this->M_reports->suma();
                $data['invoice_monthly_total'] = $this->M_reports->invoice_monthly_total();
                $data['sumadia']               = $this->M_reports->mensajesaldia();
                $data['sumames']               = $this->M_reports->mensajesmes();
                $data['invoicessumar']         = $this->M_reports->invoicessumar();
                $data['sumasemana']            = $this->M_reports->mensajessemana();
                $data['content']               = $this->load->view('dashboard', $data, true);
                $this->load->view('template', $data);
            } else {
                redirect('login');
                $data['content'] = 'We are working';
                $this->load->view('template', $data);
            }

        } else {

            if ($_SESSION['ezlow']['lawfirm'] == 2) {
                $data['content'] = $this->load->view('contracts/vlistcontractsuk', '', true);
                $this->load->view('template', $data);
            } else {

                // $datos['contracts'] = $this->M_contracts->contracts();
                $data['content'] = $this->load->view('contracts/Vlistcontracts', '', true);
                $this->load->view('template', $data);
            }
        }
    }
    public function log_out()
    {
        $this->session->sess_destroy();
        redirect('login');

    }
    public function save_profile()
    {
        print_r($this->M_setting->save_profile($_POST));
    }
    public function profile()
    {
        $data["square"]  = $this->M_square->getConfiguration();
        $data['content'] = $this->load->view('profile', $data, true);
        $this->load->view('template', $data);
    }
    public function save_square()
    {
        if ($_POST['id'] == 'new') {
            print_r($this->M_square->save_square($_POST));
        } else {
            print_r($this->M_square->update_square($_POST));
        }

    }
    public function pending()
    {
        $this->M_square->save_post($_POST);
    }
    public function testeztexting($phone)
    {
        $data = array(
            'User'          => 'kostivlaw18',
            'Password'      => 'wilshire3450',
            'PhoneNumbers'  => $phone,
/*            'Groups' => array('honey lovers'),*/
            'Subject'       => 'EZ Law Pay',
            'Message'       => 'Test from EZ Law Pay from create Client Form',
            'StampToSend'   => '1305582245',
            'MessageTypeID' => 1,
        );

        $curl = curl_init('https://app.eztexting.com/sending/messages?format=json');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($response);
        $json = $json->Response;

        if ('Failure' == $json->Status) {
            $errors = array();
            if (!empty($json->Errors)) {
                $errors = $json->Errors;
            }

            echo 'Status: ' . $json->Status . "\n" .
            'Errors: ' . implode(', ', $errors) . "\n";
        } else {
            $phoneNumbers = array();
            if (!empty($json->Entry->PhoneNumbers)) {
                $phoneNumbers = $json->Entry->PhoneNumbers;
            }

            $localOptOuts = array();
            if (!empty($json->Entry->LocalOptOuts)) {
                $localOptOuts = $json->Entry->LocalOptOuts;
            }

            $globalOptOuts = array();
            if (!empty($json->Entry->GlobalOptOuts)) {
                $globalOptOuts = $json->Entry->GlobalOptOuts;
            }

            $groups = array();
            if (!empty($json->Entry->Groups)) {
                $groups = $json->Entry->Groups;
            }

            echo 'Status: ' . $json->Status . "\n" .
            'Message ID : ' . $json->Entry->ID . "\n" .
            'Subject: ' . $json->Entry->Subject . "\n" .
            'Message: ' . $json->Entry->Message . "\n" .
            'Message Type ID: ' . $json->Entry->MessageTypeID . "\n" .
            'Total Recipients: ' . $json->Entry->RecipientsCount . "\n" .
            'Credits Charged: ' . $json->Entry->Credits . "\n" .
            'Time To Send: ' . $json->Entry->StampToSend . "\n" .
            'Phone Numbers: ' . implode(', ', $phoneNumbers) . "\n" .
            'Groups: ' . implode(', ', $groups) . "\n" .
            'Locally Opted Out Numbers: ' . implode(', ', $localOptOuts) . "\n" .
            'Globally Opted Out Numbers: ' . implode(', ', $globalOptOuts) . "\n";
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

                                if ($query->result()[0]->Balance_Amount > 0) {

                                    $total   = $query->result()[0]->Receivable_Amount - $mount;
                                    $balance = $query->result()[0]->Balance_Amount - $mount;
                                    $status  = 4;

                                    if ($total <= 0) {

                                        $status = 3;

                                    }

                                    if ($total > 0) {

                                        $status = 4;

                                    }

                                    if ($balance <= 0) {

                                        $status = 1;
                                    }

                                    $bus = "UPDATE t_contracts SET Receivable_Amount='" . $total . "', Balance_Amount='" . $balance . "' , status_ID = '" . $status . "' WHERE ID='" . $query->result()[0]->ID . "'";
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

                                    $this->message_balance_link1($query->result()[0]->ID);
                                }

                            }
                        }
                    }
                } else {

                    $countsn = $countsn + 1;
                    print_r('<br>');

                }

            } else {

            }
        }

    }

    public function prueba2()
    {
        print_r($_SERVER['DOCUMENT_ROOT']);
        //print_r(password_hash("YELahgA6", PASSWORD_DEFAULT));
    }

    public function message_balance_link1($id)
    {

        $query = "SELECT Sign_Date from t_contracts where ID ='" . $id . "' ";
        $fecha = $this->db->query($query)->result()[0]->Sign_Date;

        $anio = date('Y', strtotime($fecha));
        if ($anio >= 2020) {
            $response = $this->M_contracts->balance_link_pagos($id);
        }

    }

    public function prueba()
    {
        $query = "SELECT ID, Date_Montly_P, Sign_Date,Frequency_ID from t_contracts where ID>'6561' ";
        $array = $this->db->query($query)->result();
        foreach ($array as $key) {
            if ($key->Date_Montly_P == '') {
                $date_montly = $key->Sign_Date;
                $this->db->query("UPDATE t_contracts set Date_Montly_P='" . $date_montly . "' WHERE ID='" . $key->ID . "'");
            } elseif ($key->Date_Montly_P == '0000-00-00 00:00:00') {
                $date_montly = $key->Sign_Date;
                $this->db->query("UPDATE t_contracts set Date_Montly_P='" . $date_montly . "' WHERE ID='" . $key->ID . "'");
            } else {
                $date_montly = $key->Date_Montly_P;
            }

            if ($key->Frequency_ID == '0') {
                $this->db->query("UPDATE t_contracts set Frequency_ID='4' WHERE ID='" . $key->ID . "'");
            }

            switch ($key->Frequency_ID) {
                case '4':
                    $month = date("m", strtotime($date_montly));
                    $year  = date("Y", strtotime($date_montly));

                    $year_today  = date('Y');
                    $new_date    = $date_montly;
                    $month_today = date('m');

                    while ($year != $year_today || $month != $month_today) {
                        $new_date = date("Y-m-d", strtotime($new_date . "+ 1 month"));
                        $month    = date("m", strtotime($new_date));
                        $year     = date("Y", strtotime($new_date));

                        $year_today  = date('Y');
                        $month_today = date('m');
                    }
                    $new_date = date("Y-m-d", strtotime($new_date . "+ 1 month"));
                    //print_r($key->ID.' - '.$key->Date_Montly_P.' - '.$new_date.'<br/>');
                    print_r("UPDATE t_contracts set Next_Date='" . $new_date . "' where ID='" . $key->ID . "';" . '<br/>');
                    //$this->db->query("UPDATE t_contracts set Next_Date='".$new_date."' where ID='".$key->ID."'");

                    break;

                case '3':
                    $month = date("m", strtotime($date_montly));
                    $year  = date("Y", strtotime($date_montly));

                    $year_today  = date('Y');
                    $new_date    = $date_montly;
                    $month_today = date('m');
                    while ($year != $year_today || $month != $month_today) {

                        $new_date = date("Y-m-d", strtotime($new_date . "+ 15 days"));
                        $month    = date("m", strtotime($new_date));
                        $year     = date("Y", strtotime($new_date));

                        $year_today  = date('Y');
                        $month_today = date('m');

                    }
                    $new_date = date("Y-m-d", strtotime($new_date . "+ 15 days"));
                    print_r("UPDATE t_contracts set Next_Date='" . $new_date . "' where ID='" . $key->ID . "';" . '<br/>');
                    //$this->db->query("UPDATE t_contracts set Next_Date='".$new_date."' where ID='".$key->ID."'");
                    break;
                case '1':
                    $this->db->query("UPDATE t_contracts set Next_Date='0000-00-00' where ID='" . $key->ID . "'");
                    break;
            }

        }
    }

    private function dashboard_payments_date($last)
    {
        if ($last->num_rows() == 0) {
            $raw_date = date('2019-12-31 23:00:00');
        } else {
            $raw_date = $last->result()[0]->date;
        }

        $date = $this->adds_second_to_date($raw_date);
        $date = str_replace(' ', 'T', $date);
        $date = str_replace(':', '%3A', $date);
        return $date;
    }

    private function adds_second_to_date($raw_argument_date)
    {
        $datetime = new DateTime($raw_argument_date);
        $datetime->add(new DateInterval('PT5S'));
        $date = $datetime->format('Y-m-d H:i:s');

        return $date;
    }
}
