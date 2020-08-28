<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_contracts extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
        $this->load->model('M_contracts');
        $this->load->model('M_table_list');
        $this->load->model('M_table_list2');
        $this->load->model('M_reports');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }

    public function contrac()
    {

        $datos['contracts'] = $this->M_contracts->contracts();
        $data['content']    = $this->load->view('contracts/Vlistcontracts', $datos, true);
        $this->load->view('template', $data);

    }

    public function newterms()
    {

        print_r($this->M_contracts->valiterms($_SESSION['ezlow']['iduser']));

    }

    public function reasignacion()
    {

        $data['contratos'] = $this->M_contracts->reasig();
        $data['content']   = $this->load->view('invoice/reasignacion', $data, true);
        $this->load->view('template', $data);
    }

    public function cambiac()
    {

        print_r($this->M_contracts->cambiac($_POST));
    }

    public function contracuk()
    {

        $datos['contracts'] = $this->M_contracts->contracts();
        $data['content']    = $this->load->view('contracts/vlistcontractsuk', $datos, true);
        $this->load->view('template', $data);

    }

    public function agregarcomouk()
    {

        $this->M_contracts->agregarcomouk($_POST['id']);

    }

    public function estatuscontract()
    {

        print_r($this->M_contracts->estatuscontract($_POST));

    }

    public function acept()
    {

        print_r($this->M_contracts->acept($_POST));

    }

    public function showContractmd()
    {

        $datos['info']      = $this->M_contracts->showContract($_POST['ok']);
        $datos['referidos'] = $this->M_contracts->referidos($_POST['ok']);
        $datos['services']  = $this->M_contracts->servicess($_POST['ok']);
        $datos['initial']   = $this->M_contracts->initial($_POST['ok']);
        $datos['pay']       = $this->M_contracts->paysdo($_POST['ok']);
        $datos['paymos']    = $this->M_contracts->pagosmos($_POST['ok']);
        $datos['fees']      = $this->M_contracts->fees($_POST['ok']);
        $datos['balance']   = $this->M_contracts->balance($_POST['ok']);
        $datos['notas']     = $this->M_contracts->notas($_POST['ok']);
        $datos['nopagados'] = $this->M_contracts->nopayment($_POST['ok']);
        $datos['id']        = $_POST['ok'];

        $this->load->view('contracts/showcontractmd', $datos);
    }

    public function eliminarota()
    {

        print_r($this->M_contracts->eliminarnota($_POST));
    }

    public function billstt()
    {

        $this->M_contracts->billstt();

    }

    public function billstts()
    {

        $this->M_contracts->borrarinvoices($_POST['id']);
        $this->M_contracts->billstts($_POST['id']);
        $this->M_contracts->matchpagos($_POST['id']);
    }

    public function pagosmatch()
    {

        $query = "SELECT * FROM t_billsg WHERE id_pago = 0";
        $data  = $this->db->query($query)->result();

        foreach ($data as $key) {
            $mensualidad = date('Y-m', strtotime($key->fechap));

            $sub = "SELECT ID FROM t_payments WHERE Date LIKE '%" . $mensualidad . "%' AND Contract_ID = '" . $key->id_contrato . "' AND Fee_ID = 0 LIMIT 1";

            $id = $this->db->query($sub)->result();

            if (!empty($id)) {

                print_r($id[0]->ID);
                print_r('<br>');
                $nuevo = "UPDATE t_billsg SET id_pago='" . $id[0]->ID . "' WHERE ID = '" . $key->ID . "'";
                $this->db->query($nuevo);
            }

        }

    }

    public function billgenerathor()
    {

        $this->M_contracts->billgenerathor();
    }

    public function paymentform()
    {

        $data['content'] = $this->load->view('statistics/paymentform', "", true);
        $this->load->view('template', $data);
    }

    public function firmadosdiass()
    {
        if (empty($_POST)) {
            $hoy         = date('Y-m-d');
            $arreglo     = [];
            $informacion = [];
            $onhold      = [];

            for ($i = 1; $i < 11; $i++) {

                $actualc        = strtotime("-" . $i . " days", strtotime($hoy));
                $addf           = date("Y-m-d", $actualc);
                $info           = $this->M_contracts->firmadosdias($addf);
                $arreglo[$addf] = $info;
            }

            // $inicio = date( "Y-m-d", $inicio);
            // // array_push($arreglo, $inicio);
            // $info = $this->M_contracts->contractsonhold($inicio);
            // $arreglo[$inicio] = $info;
            // $inicio = strtotime($inicio."+ 1 days");

            print_r(json_encode($arreglo));

        } else {

            // $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            // $fecha1 = $_POST["year"]."-".$_POST['mes']."-1";
            // $fecha2 = $_POST["year"]."-".$_POST['mes']."-".$number;

            $inicio   = strtotime($_POST['inicio']);
            $fin      = strtotime($_POST['fin']);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->firmadosdias($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }
    }

    public function onholdcontracts()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->contractsonhold($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->contractsonhold($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }

    }

    public function paymenform()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $fecha1 = $anio . "-" . $mes2;

            $informacion = $this->M_contracts->informametod($fecha1);

            print_r(json_encode($informacion));
        } else {

            $fecha1 = $_POST['year'] . "-" . $_POST['mes'];

            $informacion = $this->M_contracts->informametod($fecha1);

            print_r(json_encode($informacion));

        }

    }

    public function totalincomeajax()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->totalincomeday($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->totalincomeday($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }

    }

    public function contractsfinancial()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->totalfinanci($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->totalfinanci($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }

    }

    public function newpayment()
    {
        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->newpayment($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->newpayment($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }
    }

    public function nopayments()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->nopayments($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->nopayments($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }

    }

    public function newcontractsjax()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->totalnewcontracts($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info             = $this->M_contracts->totalnewcontracts($inicio);
                    $arreglo[$inicio] = $info;
                    $inicio           = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r(json_encode($arreglo));
        }

    }

    public function totalmes()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalincome($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalincome($_POST['year'], $_POST['mes']);

            print_r($total);

        }

    }

    public function totalonhold()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalonhold($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalonhold($_POST['year'], $_POST['mes']);

            print_r($total);

        }

    }

    public function totalfinancial()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalfinancial($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalfinancial($_POST['year'], $_POST['mes']);

            print_r($total);

        }

    }

    public function totalfinanpromedio()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalfinanpromedio($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalfinanpromedio($_POST['year'], $_POST['mes']);

            print_r($total);

        }

    }

    public function totalpaypromedio()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalpaypromedio($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalpaypromedio($_POST['year'], $_POST['mes']);

            print_r($total);

        }

    }

    public function totalmescon()
    {

        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalmescon($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalmescon($_POST['year'], $_POST['mes']);

            print_r($total);

        }

    }

    public function totalincome()
    {

        $anio = date("Y");
        $mes  = date("m");

        if ($mes == 1) {
            $mes  = 12;
            $anio = $anio - 1;
        } else {
            $mes = $mes - 1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $total = $this->M_reports->totalincome($anio, $mes2);

        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

        $data['total']   = $total;
        $data['content'] = $this->load->view('statistics/totalincome', $data, true);
        $this->load->view('template', $data);
    }

    public function newcontracts()
    {

        $anio = date("Y");
        $mes  = date("m");

        if ($mes == 1) {
            $mes  = 12;
            $anio = $anio - 1;
        } else {
            $mes = $mes - 1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $total = $this->M_reports->totalincome($anio, $mes2);

        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

        $data['total']   = $total;
        $data['content'] = $this->load->view('statistics/newcontracts', $data, true);
        $this->load->view('template', $data);
    }

    public function newcontractsf()
    {

        $anio = date("Y");
        $mes  = date("m");

        if ($mes == 1) {
            $mes  = 12;
            $anio = $anio - 1;
        } else {
            $mes = $mes - 1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $total = $this->M_reports->totalincome($anio, $mes2);

        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

        $data['total']   = $total;
        $data['content'] = $this->load->view('statistics/newcontractfinan', $data, true);
        $this->load->view('template', $data);
    }

    public function totalpaymentmensual()
    {
        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");

            if ($mes == 1) {
                $mes  = 12;
                $anio = $anio - 1;
            } else {
                $mes = $mes - 1;
            }

            $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

            $total = $this->M_reports->totalpaymentmensual($anio, $mes2);

            print_r($total);

        } else {

            $total = $this->M_reports->totalpaymentmensual($_POST['year'], $_POST['mes']);

            print_r($total);

        }
    }

    public function nopaymenttt()
    {

        $contadorm = 0;
        if (empty($_POST)) {
            $anio = date("Y");
            $mes  = date("m");
            if ($mes == 1) {

                $mes  = 12;
                $anio = $anio - 1;

            } else {

                $mes = $mes - 1;
            }

            $mes2   = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

            $fecha1 = $anio . "-" . $mes2 . "-01";
            $fecha2 = $anio . "-" . $mes2 . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info      = $this->M_contracts->nopayments($inicio);
                    $contadorm = $contadorm + $info;
                    $inicio    = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r($contadorm);

        } else {

            $number = cal_days_in_month(CAL_GREGORIAN, $_POST['mes'], $_POST["year"]);

            $fecha1 = $_POST["year"] . "-" . $_POST['mes'] . "-1";
            $fecha2 = $_POST["year"] . "-" . $_POST['mes'] . "-" . $number;

            $inicio   = strtotime($fecha1);
            $fin      = strtotime($fecha2);
            $variable = true;
            $arreglo  = [];

            do {

                if ($inicio <= $fin) {

                    $variable = true;
                    $inicio   = date("Y-m-d", $inicio);
                    // array_push($arreglo, $inicio);
                    $info      = $this->M_contracts->nopayments($inicio);
                    $contadorm = $contadorm + $info;
                    $inicio    = strtotime($inicio . "+ 1 days");

                } else {
                    $variable = false;

                }

            } while ($variable);

            print_r($contadorm);
        }
    }

    public function newpaymentsf()
    {

        $anio = date("Y");
        $mes  = date("m");

        if ($mes == 1) {
            $mes  = 12;
            $anio = $anio - 1;
        } else {
            $mes = $mes - 1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $total = $this->M_reports->totalincome($anio, $mes2);

        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

        $data['total']   = $total;
        $data['content'] = $this->load->view('statistics/newpayments', $data, true);
        $this->load->view('template', $data);
    }

    public function paymentshold()
    {

        $anio = date("Y");
        $mes  = date("m");

        if ($mes == 1) {
            $mes  = 12;
            $anio = $anio - 1;
        } else {
            $mes = $mes - 1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $total = $this->M_reports->totalincome($anio, $mes2);

        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

        $data['total']   = $total;
        $data['content'] = $this->load->view('statistics/contractsinpago', $data, true);
        $this->load->view('template', $data);
    }

    public function newcontractsonhold()
    {

        $anio = date("Y");
        $mes  = date("m");

        if ($mes == 1) {
            $mes  = 12;
            $anio = $anio - 1;
        } else {
            $mes = $mes - 1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $total = $this->M_reports->totalincome($anio, $mes2);

        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio);

        $data['total']   = $total;
        $data['content'] = $this->load->view('statistics/newcontractsonhold', $data, true);
        $this->load->view('template', $data);
    }

    public function test_global()
    {
        if (self::informe) {
            print_r("adf");
            self::informe;
            print_r(self::informe);
        } else {
            print_r(self::informe);
        }
        print_r(self::informe);
    }

    public function firmados()
    {

        $hoy         = date('Y-m-d');
        $arreglo     = [];
        $informacion = [];
        $onhold      = [];

        for ($i = 1; $i < 11; $i++) {

            $actualc     = strtotime("-" . $i . " days", strtotime($hoy));
            $addf        = date("Y-m-d", $actualc);
            $arreglo[$i] = $addf;

            $cadena          = "SELECT COUNT(*) as conteo FROM t_contracts WHERE Sign_Date = '" . $addf . "' AND Status_ID != 2";
            $infos           = $this->db->query($cadena)->result();
            $informacion[$i] = $infos[0]->conteo;

            $cadena1    = "SELECT COUNT(*) as conteo FROM t_contracts WHERE Sign_Date = '" . $addf . "' AND Status_ID = 2";
            $infos1     = $this->db->query($cadena1)->result();
            $onhold[$i] = $infos1[0]->conteo;
        }

        $data['mesfirm']     = $this->M_contracts->mesfirm();
        $data['semanafirm']  = $this->M_contracts->semanafirm();
        $data['aniofimr']    = $this->M_contracts->aniofimr();
        $data['informacion'] = $informacion;
        $data['onhold']      = $onhold;
        $data['arreglo']     = $arreglo;
        $data['content']     = $this->load->view('statistics/firmados', $data, true);
        $this->load->view('template', $data);

    }

    public function modificontract()
    {
        $end  = explode('/', $_SERVER['REQUEST_URI']);
        $nuev = end($end);

        $datos['info']     = $this->M_contracts->showContract($nuev);
        $datos['services'] = $this->M_contracts->services();

        // print_r($datos['info']);
        $datos['referidos'] = $this->M_contracts->referidos($nuev);
        $datos['servicess'] = $this->M_contracts->servicess($nuev);
        $datos['initial']   = $this->M_contracts->initial($nuev);
        // $datos['pay'] = $this->M_contracts->paysdo($nuev);
        // $datos['paymos'] = $this->M_contracts->pagosmos($nuev);
        $datos['contract_data'] = $nuev;
        $data['content']        = $this->load->view('contracts/editContrac', $datos, true);
        $this->load->view('template', $data);

    }

    public function payments()
    {

        $data['content'] = $this->load->view('statistics/payments', "", true);
        $this->load->view('template', $data);
    }

    public function services()
    {
        $raw_services     = $this->M_reports->servicios();
        $data['services'] = json_encode($raw_services);
        $data['content']  = $this->load->view('statistics/services', $data, true);
        $this->load->view('template', $data);
    }

    public function services_by_dates()
    {
        $raw_start_date = isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
        $raw_end_date   = isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';

        $start_date = (!empty($raw_start_date)) ? $raw_start_date : date('Y-m-d', strtotime('-1 month'));
        $end_date   = (!empty($raw_end_date)) ? $raw_end_date : date('Y-m-d');

        $data = $this->M_reports->servicios($start_date, $end_date);

        header('Content-type: application/json');
        $json_data = json_encode($data);
        print_r($json_data);
        return $json_data;
    }

    public function actualizaDeuda()
    {

        $this->M_contracts->actualizaDeuda();

        // SELECT SUM(Initial_Pay_Amount) FROM `t_initial_payments` WHERE `Initial_Pay_Date` < CURDATE() AND Contract_ID = 500
    }

    public function actulizaBalance()
    {
        $this->M_contracts->actulizaBalance();
    }

    public function statusc()
    {

        $this->M_contracts->statusc();
    }

    public function editcont()
    {

        print_r($this->M_contracts->editcont($_POST));
    }

    public function cambiastadb()
    {

        print_r($this->M_contracts->cambiastadb($_POST));
    }

    public function cambiaestatus()
    {

        $data['id'] = $_POST['id'];

        $this->load->view('contracts/status', $data);
    }

    public function addnota()
    {

        $data['id'] = $_POST['id'];

        $this->load->view('contracts/addnote', $data);
    }

    public function addnotad()
    {

        print_r($this->M_contracts->addnotad($_POST));
    }

    public function estadisticas()
    {
        print_r($this->M_contracts->estadisticas($_POST));
    }

    public function newcontrac()
    {
        $this->load->view('contracts/VnewContrac');

    }

    public function allclients()
    {

        $datos = $this->M_contracts->allclients($_POST);

        foreach ($datos as $key) {
            echo "</i> <a href='#' class='list-group-item list-group-item-action'><i class='fas fa-user'>" . $key->C_Name . "</a>";
        }
    }

    public function actualizarin()
    {

        $this->M_contracts->actualizaDeudapot($_POST['id']);
        print_r($this->M_contracts->actualizam($_POST['id']));
    }

    public function enviarmsj()
    {
        $this->M_contracts->enviarmsj();
        $this->pagosmatch();
        $this->M_reports->cronjob('nuevosBills');
    }

    public function newview()
    {

        $datos['services'] = $this->M_contracts->services();
        $data['content']   = $this->load->view('contracts/VnewContrac', $datos, true);
        $this->load->view('template', $data);
    }

    public function nuevosBills()
    {
        $this->M_contracts->nuevosBills();
        $this->M_contracts->nuevbillsg();
        $this->M_reports->cronjob('nuevosBills');
    }

    public function actulizat()
    {
        $this->M_contracts->actulizat();
    }

    public function informaciones()
    {

        $inicio   = strtotime($_POST['inicio']);
        $fin      = strtotime($_POST['fin']);
        $variable = true;
        $arreglo  = [];

        do {

            if ($inicio <= $fin) {

                $variable = true;
                $inicio   = date("Y-m-d", $inicio);
                // array_push($arreglo, $inicio);
                $info             = $this->M_contracts->obtenerarreglos($inicio);
                $arreglo[$inicio] = $info;
                $inicio           = strtotime($inicio . "+ 1 days");

            } else {
                $variable = false;

            }

        } while ($variable);

        print_r(json_encode($arreglo));

    }

    public function graficas()
    {

        $hoy         = date('Y-m-d');
        $arreglo     = [];
        $informacion = [];

        for ($i = 1; $i < 11; $i++) {

            $actualc     = strtotime("-" . $i . " days", strtotime($hoy));
            $addf        = date("Y-m-d", $actualc);
            $arreglo[$i] = $addf;

            $cadena          = "SELECT COUNT(*) as conteo FROM t_contracts WHERE Sign_Date = '" . $addf . "'";
            $infos           = $this->db->query($cadena)->result();
            $informacion[$i] = $infos[0]->conteo;
        }

        $data['hold']        = $this->M_reports->contracts_hold();
        $data['cancel']      = $this->M_reports->contracts_cancel();
        $data['active']      = $this->M_reports->contracts_active();
        $data['pending']     = $this->M_reports->pending_today();
        $data['paid']        = $this->M_reports->paid();
        $data['informacion'] = $informacion;
        $data['arreglo']     = $arreglo;
        $data['servicios']   = $this->M_reports->servicios();
        $data['datosinfo']   = $this->M_reports->datosx();
        $data['uptodate']    = $this->M_reports->uptodate();
        $data['overdue']     = $this->M_reports->overdue();
        $data['content']     = $this->load->view('contracts/graficas', $data, true);

        $this->load->view('template', $data);
    }

    public function addContract1()
    {

        // $nombre = $_POST['info1'];
        // $id = $this->M_contracts->getiduser($nombre);
        print_r($this->M_contracts->addContrac($_POST));

    }

    //  public function actualizaDeuda(){

    //    $this->M_contracts->actualizaDeuda();

    //     // SELECT SUM(Initial_Pay_Amount) FROM `t_initial_payments` WHERE `Initial_Pay_Date` < CURDATE() AND Contract_ID = 500
    // }

    public function showContract()
    {

        $datos['info']      = $this->M_contracts->showContract($_POST['ok']);
        $datos['referidos'] = $this->M_contracts->referidos($_POST['ok']);
        $datos['services']  = $this->M_contracts->servicess($_POST['ok']);
        $datos['initial']   = $this->M_contracts->initial($_POST['ok']);
        $datos['pay']       = $this->M_contracts->paysdo($_POST['ok']);
        $datos['paymos']    = $this->M_contracts->pagosmos($_POST['ok']);
        $datos['fees']      = $this->M_contracts->fees($_POST['ok']);
        $datos['balance']   = $this->M_contracts->balance($_POST['ok']);
        $datos['notas']     = $this->M_contracts->notas($_POST['ok']);
        $datos['nopagados'] = $this->M_contracts->nopayment($_POST['ok']);
        $datos['enviados']  = $this->M_contracts->enviadosb($_POST['ok']);
        $datos['id']        = $_POST['ok'];

        $this->load->view('contracts/showcontract', $datos);
    }

    public function showbills()
    {

        $datos['info']      = $this->M_contracts->showContract($_POST['ok']);
        $datos['referidos'] = $this->M_contracts->referidos($_POST['ok']);
        $datos['services']  = $this->M_contracts->servicess($_POST['ok']);
        $datos['initial']   = $this->M_contracts->initial($_POST['ok']);
        $datos['pay']       = $this->M_contracts->paysdo($_POST['ok']);
        $datos['paymos']    = $this->M_contracts->pagosmos($_POST['ok']);
        $datos['fees']      = $this->M_contracts->fees($_POST['ok']);
        $datos['balance']   = $this->M_contracts->balance($_POST['ok']);

        $datos['bills'] = $this->M_contracts->showbills($_POST['ok']);

        $this->load->view('contracts/showbills', $datos);
    }

    public function contract_table_list2()
    {

        if (!empty($_REQUEST['month']) and !empty($_REQUEST['year'])) {

            $obtener   = $_REQUEST['month'];
            $obteneran = $_REQUEST['year'];

        } else {

            $obtener   = date('m');
            $obteneran = date('Y');

        }

        $mes = $obteneran . "-" . str_pad($obtener, 2, "0", STR_PAD_LEFT) . "-";

        $list_data = array(
            'table'            => 't_contracts as tc',
            'column_order'     => array('tc.Contract_N', 't_client.C_Name', 'tc.Value', 'tc.Balance_Amount'),
            'column_search'    => array('tc.Contract_N', 't_client.C_Name'),
            'column_names'     => array('Contract_N', 'C_Name', 'Value', 'Balance_Amount', 'contract_id'),
            'selected_columns' => 'tc.ID as contract_id, tc.Balance_Amount as Balance_Amount, tc.Contract_N as Contract_N, tc.Value as Value, t_client.C_Name as C_Name',
            'custom_search'    => array(),
            'query_data'       => array(
                'like'         => array('t_billsg.fechap' => $mes),
                'where'        => array('tc.Status_ID IN(3,4)'),
                'where1'       => array('t_billsg.id_pago' => 0),
                'oder_by'      => '',
                'oder_by_type' => 'DESC',
                'joins'        => array(
                    array(
                        'table'      => 't_client',
                        'comparison' => 'tc.Client_ID = t_client.ID',
                        'type'       => '',
                    ), array(
                        'table'      => 't_billsg',
                        'comparison' => 'tc.ID = t_billsg.id_contrato',
                        'type'       => '',
                    )),
            ),
        );

        $table = $this->M_table_list2;
        $table->add($list_data, true);
        $list = $table->json_list();

        print_r($list);
        return json_encode($list);
    }

    public function contract_table_list()
    {
        $list_data = array(
            'table'            => 't_contracts as tc',
            'column_order'     => array('catt_status.Status', 'tc.Contract_N', 't_client.C_Name', 'tc.Sign_Date', 'tc.Value', 'tc.Balance_Amount', 'tc.Receivable_Amount'),
            'column_search'    => array('catt_status.Status', 'tc.Contract_N', 't_client.C_Name', 'tc.Sign_Date', 'tc.Value', 'tc.Balance_Amount', 'tc.Receivable_Amount'),
            'column_names'     => array('Status', 'Contract_N', 'C_Name', 'Sign_Date', 'Value', 'Balance_Amount', 'Receivable_Amount', 'contract_id'),
            'selected_columns' => 'tc.ID as contract_id, tc.Balance_Amount as Balance_Amount, tc.Contract_N as Contract_N, tc.Value as Value, t_client.C_Name as C_Name, tc.Sign_Date as Sign_Date, catt_status.Status as Status, tc.Receivable_Amount as Receivable_Amount',
            'custom_search'    => array('status' => 'Status ', 'date' => 'Sign_Date'),
            'query_data'       => array(
                // 'where'        => array('t_users.Company' => $_SESSION['ezlow']['lawfirm']),
                'oder_by'      => '',
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
        $table->add($list_data, true);
        $list = $table->json_list();

        print_r($list);
        return json_encode($list);
    }

    public function contract_table_listuk()
    {

        $list_data = array(
            'table'            => 't_contracts as tc',
            'column_order'     => array('catt_status.Status', 'tc.Contract_N', 't_client.C_Name', 'tc.Sign_Date', 'tc.Value', 'tc.Balance_Amount', 'tc.Receivable_Amount'),
            'column_search'    => array('catt_status.Status', 'tc.Contract_N', 't_client.C_Name', 'tc.Sign_Date', 'tc.Value', 'tc.Balance_Amount', 'tc.Receivable_Amount'),
            'column_names'     => array('Status', 'Contract_N', 'C_Name', 'Sign_Date', 'Value', 'Balance_Amount', 'Receivable_Amount', 'contract_id'),
            'selected_columns' => 'tc.ID as contract_id, tc.Balance_Amount as Balance_Amount, tc.Contract_N as Contract_N, tc.Value as Value, t_client.C_Name as C_Name, tc.Sign_Date as Sign_Date, catt_status.Status as Status, tc.Receivable_Amount as Receivable_Amount',
            'custom_search'    => array('status' => 'Status ', 'date' => 'Sign_Date'),
            'query_data'       => array(
                'where'        => array('t_users.Company' => $_SESSION['ezlow']['lawfirm']),
                'oder_by'      => '',
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
        $table->add($list_data, true);
        $list = $table->json_list();

        print_r($list);
        return json_encode($list);

    }

    public function pdf_contract($id)
    {
        ob_start();
        $viewdata['data'] = $this->M_contracts->balance_data($id);
        $this->load->library('pdfgenerator');
        $html     = $this->load->view('pdf_exports/contract_balance', $viewdata, true);
        $filename = 'comprobante_pago';
        $this->pdfgenerator->generate($html, $filename, true, 'Letter', 'landscape');
    }

    public function signeddocument($id)
    {
        ob_start();

        $data['name'] = $this->M_contracts->firmuser($id);
        $this->load->library('pdfgenerator');
        $html     = $this->load->view('pdf_exports/terms', $data, true);
        $filename = $data['name'];
        $this->pdfgenerator->generate($html, $filename, true);
    }

    public function message_balance_link($id)
    {
        $response = $this->M_contracts->message_balance_link($id);

        return $response;
    }
}
