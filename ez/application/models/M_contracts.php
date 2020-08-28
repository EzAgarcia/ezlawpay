<?php
class M_contracts extends CI_Model
{

    public function contracts()
    {
        $sent = "SELECT t_contracts.ID, t_contracts.Balance_Amount, t_contracts.Contract_N , t_contracts.Value,t_contracts.Montly_Amount, t_contracts.Date_Montly_P, t_contracts.Frequency_ID,  t_client.C_Name, t_contracts.Sign_Date, catt_status.Status, t_contracts.Receivable_Amount FROM t_contracts INNER JOIN t_client ON t_contracts.Client_ID = t_client.ID INNER JOIN t_users ON t_contracts.Registered_By_ID = t_users.ID INNER JOIN catt_status ON catt_status.ID=t_contracts.status_ID WHERE t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' ORDER BY t_contracts.ID DESC";
        $data = $this->db->query($sent);

        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }

    }

    public function cambiac($data)
    {

        $query = "SELECT * FROM t_contracts WHERE Contract_N LIKE '%" . $data['contrato'] . "%'";

        $id = $this->db->query($query)->result()[0]->ID;

        $query = "SELECT * FROM t_payments WHERE ID = '" . $data['id'] . "'";

        $id2 = $this->db->query($query)->result()[0]->Contract_ID;

        if (!empty($id)) {

            $query = "UPDATE t_payments SET Contract_ID='" . $id . "' WHERE ID = '" . $data['id'] . "'";
            $this->db->query($query);

            $query = "UPDATE t_invoice SET Contract_ID = '" . $id . "'  WHERE Payments_ID ='" . $data['id'] . "'";
            $this->db->query($query);

            $this->actualizaDeudapot($id);
            $this->actualizam($id);
            $this->actualizaDeudapot($id2);
            $this->actualizam($id2);

            return 1;
        } else {

            return 2;
        }

    }

    public function valiterms($id)
    {

        $cadena = "SELECT newterms FROM t_users WHERE ID ='" . $id . "'";
        $resp   = $this->db->query($cadena)->result()[0]->newterms;

        return $resp;

    }

    public function firmuser($id)
    {
        $query  = "SELECT name FROM terms WHERE ID = '" . $id . "'";
        $nombre = $this->db->query($query)->result()[0]->name;

        return $nombre;
    }

    public function acept($id)
    {

        $cadena12 = "UPDATE t_users SET newterms = 1  WHERE ID = '" . $_SESSION['ezlow']['iduser'] . "'";

        $this->db->query($cadena12);

        $cadena = "INSERT INTO terms(id_user, name) VALUES ('" . $_SESSION['ezlow']['iduser'] . "', '" . $id['firma'] . "')";

        $this->db->query($cadena);

        $cadena3 = "SELECT ID FROM terms WHERE name = '" . $id['firma'] . "'";

        $ID = $this->db->query($cadena3)->result()[0]->ID;

        require "class.phpmailer.php";
        require "class.smtp.php";

        $email        = 'josua.gg@ezlawpay.com';
        $destinatario = "info@ezlawpay.com";

        $smtpHost    = "mail.ezlawpay.com"; // Dominio alternativo brindado en el email de alta
        $smtpUsuario = "josua.gg@ezlawpay.com"; // Mi cuenta de correo
        $smtpClave   = "303Law!*"; // Mi contraseña

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port     = 587;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

// VALORES A MODIFICAR //
        $mail->Host     = $smtpHost;
        $mail->Username = $smtpUsuario;
        $mail->Password = $smtpClave;

        $mail->From     = $email; // Email desde donde envío el correo.
        $mail->FromName = 'Ezlawpay';
        $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario

        $mail->Subject = "Ezlawpay TERMS AND CONDITIONS"; // Este es el titulo del email.
        $mail->Body    = "
<html>

<body>

<p>Hi, </p>

        <p>The signed document can be found at: <a href='https://ezlawpay.com/ez/signeddocument/{$ID}'>Document {$id['firma']}</a></p>

        <br>

        <img width='300' height='80' src='https://ezlawpay.com/ez/assets/img/OriginalOnTransparent.png'>


</body>

</html>

<br />"; // Texto del email en formato HTML

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ),
        );

        $estadoEnvio = $mail->Send();

        return 1;
    }

    public function firmadosdias($inicio)
    {

        $cadena = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date BETWEEN '" . $inicio . " 00:00:00' AND '" . $inicio . " 23:00:00' AND Status_ID != 2 AND Client_ID != 0";

        $arreglo = $this->db->query($cadena)->result();

        $cadena = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date BETWEEN '" . $inicio . " 00:00:00' AND '" . $inicio . " 23:00:00' AND Status_ID = 2 AND Client_ID != 0";

        $arreglo1 = $this->db->query($cadena)->result();

        $nuevoarr[0] = $arreglo[0]->total;
        $nuevoarr[1] = $arreglo1[0]->total;

        return $nuevoarr;
    }

    public function nopayment($id)
    {
        $cadena = "SELECT * FROM t_billsg WHERE id_contrato = '" . $id . "' AND id_pago = 0";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo;
    }

    public function reasig()
    {

        $cadena = "SELECT t_contracts.ID, t_contracts.Balance_Amount, t_contracts.Sign_Date, t_client.C_Name, catt_status.Status, t_contracts.Contract_N FROM t_contracts INNER JOIN t_client ON t_client.ID = t_contracts.Client_ID INNER JOIN catt_status ON catt_status.ID = t_contracts.Status_ID WHERE t_contracts.Balance_Amount < 0";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo;

    }

    public function enviadosb($id)
    {

        $cadena = "SELECT * FROM sent_balance WHERE id_contract = '" . $id . "'";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo;

    }

    public function agregarcomouk($id)
    {

        $cadena12 = "UPDATE t_contracts SET Registered_By_ID = 34 WHERE ID = '" . $id . "'";

        $this->db->query($cadena12);
    }

    public function borrarinvoices($ID)
    {

        $ejecucion = "DELETE FROM t_billsg WHERE id_contrato = '" . $ID . "'";
        $this->db->query($ejecucion);

    }

    public function billstts($ID)
    {

        $hoy = date('Y-m-d');

        $cadena    = "SELECT Initial_Pay_Amount, Initial_Pay_Date FROM t_initial_payments WHERE Contract_ID = '" . $ID . "' AND Initial_Pay_Date <= '" . $hoy . "'";
        $pagosinic = $this->db->query($cadena)->result();

        $cadena      = "SELECT SUM(Initial_Pay_Amount) as totalpagosi FROM t_initial_payments WHERE Contract_ID = '" . $ID . "' AND Initial_Pay_Date <= '" . $hoy . "'";
        $totalpagosi = $this->db->query($cadena)->result()[0]->totalpagosi;

        foreach ($pagosinic as $keyd) {

            $query = "INSERT INTO t_billsg(fechap, monto, id_pago, id_contrato) VALUES ('" . $keyd->Initial_Pay_Date . "','" . $keyd->Initial_Pay_Amount . "',0, '" . $ID . "')";
            $this->db->query($query);
        }

        $cadena       = "SELECT Date_Montly_P, Value, Montly_Amount  FROM t_contracts WHERE ID= '" . $ID . "'";
        $informacionc = $this->db->query($cadena)->result();

        $comparacion1 = strtotime($informacionc[0]->Date_Montly_P);
        $comparacion2 = strtotime(date('Y-m-d', strtotime("+1 month", strtotime($hoy))));

        $comparacionesd = true;
        $conteo         = 0;

        // print_r(date('Y-m-d' , $comparacion1)."---->>".date('Y-m-d' , $comparacion2));
        // print_r('<br>');

        do {

            if ($comparacion1 <= $comparacion2) {

                $conteo = $conteo + 1;

                $nuevostt = $totalpagosi + ($informacionc[0]->Montly_Amount * $conteo);

                if ($nuevostt > $informacionc[0]->Value) {

                    $comparacionesd = false;

                } else {

                    $query = "INSERT INTO t_billsg(fechap, monto, id_pago, id_contrato) VALUES ('" . date('Y-m-d', $comparacion1) . "','" . $informacionc[0]->Montly_Amount . "',0, '" . $ID . "')";
                    $this->db->query($query);

                }

                $comparacion1 = strtotime("+1 month", $comparacion1);

            } else {

                $comparacionesd = false;

            }

        } while ($comparacionesd);

    }

    public function matchpagos($id)
    {

        $cadena = "SELECT * FROM t_billsg WHERE id_pago = 0 AND id_contrato = '" . $id . "'";

        $arreglo = $this->db->query($cadena)->result();

        foreach ($arreglo as $key) {

            $mensualidad = date('Y-m', strtotime($key->fechap));

            $sub = "SELECT ID FROM t_payments WHERE Date LIKE '%" . $mensualidad . "%' AND Contract_ID = '" . $key->id_contrato . "' AND Fee_ID = 0 LIMIT 1";

            $id = $this->db->query($sub)->result();

            if (!empty($id)) {

                $nuevo = "UPDATE t_billsg SET id_pago='" . $id[0]->ID . "' WHERE ID = '" . $key->ID . "'";
                $this->db->query($nuevo);
            }

        }

    }

    public function addnotad($info)
    {

        $fecha = date('Y-m-d');

        if (!empty($info['info'])) {

            $query = "INSERT INTO notas(Id_contract, nota, id_user, fecha) VALUES ('" . $info['id'] . "', '" . $info['info'] . "' , '" . $_SESSION['ezlow']['iduser'] . "' ,  '" . $fecha . "')";
            $this->db->query($query);

        }

        return true;
    }

    public function balance_link_pagos($contract_id)
    {
        $url = 'https://www.ezlawpay.com/ez/pdf_contract/';
        $this->db->select('tcl.Phone_Number as phone_number, tc.ID as contract_id, tcl.C_Name as client_name, tc.Contract_N as contract_number');
        $this->db->from('t_contracts as tc');
        $this->db->join('t_client as tcl', 'tcl.ID = tc.Client_ID');
        $this->db->where('tc.ID =', $contract_id);

        $raw_data = $this->db->get();
        $data     = $raw_data->row();

        if (empty($data->phone_number)) {
            // $response_error_message = $this->balance_message_response('', true);
            // return print($response_error_message);
        }

        $welcome   = 'Hola ' . $data->client_name;
        $message   = 'El balance de tu estado de cuenta del contrato ' . $data->contract_number . ' se encuentra disponible en el siguiente link: ';
        $link      = $url . $data->contract_id;
        $farewell  = 'Apreciamos su preferencia: Kostiv & Associates P.C';
        $signature = 'Powered by EZ Law Pay';

        $info['phone_number'] = $data->phone_number;
        $info['message']      = $welcome . ' ' . $message . ' ' . $link . '  ' . $farewell . ' ' . $signature;
        $response             = $this->text_message($info);

        if (!empty($data->phone_number)) {

            $number = intval(preg_replace('/[^0-9]+/', '', $data->phone_number), 10);
            if (strlen($number) == 10) {
                $this->guardar($contract_id);
            }

        }
        // $response_message = $this->balance_message_response($response);

        // return print($response_message);
    }

    public function guardar($id)
    {

        $fecha = date("Y-m-d H:i:s");

        $query = "INSERT INTO sent_balance(id_contract) VALUES ('" . $id . "')";

        $this->db->query($query);

    }

    public function eliminarnota($id)
    {

        $ejecucion = "DELETE FROM notas WHERE ID = '" . $id['id'] . "'";
        $this->db->query($ejecucion);

        return true;
    }

    public function notas($id)
    {

        $query  = "SELECT  notas.ID , notas.fecha, notas.nota, t_users.Name FROM notas, t_users WHERE notas.Id_contract = '" . $id . "' AND notas.id_user = t_users.ID";
        $nuevos = $this->db->query($query)->result();

        return $nuevos;

    }

    public function billstt()
    {

        $hoy      = date('Y-m-d');
        $query    = "SELECT t_contracts.ID FROM t_contracts, t_client WHERE t_contracts.Client_ID = t_client.ID AND t_contracts.Value !=0 AND t_contracts.Montly_Amount !=0";
        $billsgen = $this->db->query($query)->result();

        foreach ($billsgen as $key) {

            $cadena    = "SELECT Initial_Pay_Amount, Initial_Pay_Date FROM t_initial_payments WHERE Contract_ID = '" . $key->ID . "' AND Initial_Pay_Date <= '" . $hoy . "'";
            $pagosinic = $this->db->query($cadena)->result();

            $cadena      = "SELECT SUM(Initial_Pay_Amount) as totalpagosi FROM t_initial_payments WHERE Contract_ID = '" . $key->ID . "' AND Initial_Pay_Date <= '" . $hoy . "'";
            $totalpagosi = $this->db->query($cadena)->result()[0]->totalpagosi;

            foreach ($pagosinic as $keyd) {

                $query = "INSERT INTO t_billsg(fechap, monto, id_pago, id_contrato) VALUES ('" . $keyd->Initial_Pay_Date . "','" . $keyd->Initial_Pay_Amount . "',0, '" . $key->ID . "')";
                $this->db->query($query);
            }

            $cadena       = "SELECT Date_Montly_P, Value, Montly_Amount  FROM t_contracts WHERE ID= '" . $key->ID . "'";
            $informacionc = $this->db->query($cadena)->result();

            $comparacion1 = strtotime($informacionc[0]->Date_Montly_P);
            $comparacion2 = strtotime(date('Y-m-d', strtotime("+1 month", strtotime($hoy))));

            $comparacionesd = true;
            $conteo         = 0;

            // print_r(date('Y-m-d' , $comparacion1)."---->>".date('Y-m-d' , $comparacion2));
            // print_r('<br>');

            do {

                if ($comparacion1 <= $comparacion2) {

                    $conteo = $conteo + 1;

                    $nuevostt = $totalpagosi + ($informacionc[0]->Montly_Amount * $conteo);

                    if ($nuevostt > $informacionc[0]->Value) {

                        $comparacionesd = false;

                    } else {

                        $query = "INSERT INTO t_billsg(fechap, monto, id_pago, id_contrato) VALUES ('" . date('Y-m-d', $comparacion1) . "','" . $informacionc[0]->Montly_Amount . "',0, '" . $key->ID . "')";
                        $this->db->query($query);

                    }

                    $comparacion1 = strtotime("+1 month", $comparacion1);

                } else {

                    $comparacionesd = false;

                }

            } while ($comparacionesd);

        }

        print_r("Termino");

    }

    public function nuevbillsg()
    {

        $fechac  = date('m-d');
        $hoy     = date('Y-m-d');
        $hoycomp = strtotime(date('Y-m-d', strtotime("+1 month", strtotime($hoy))));

        $query = "SELECT * FROM t_initial_payments WHERE Initial_Pay_Date = '" . $hoy . "'";

        $pagosini = $this->db->query($query)->result();

        foreach ($pagosini as $keyd) {

            $query = "INSERT INTO t_billsg(fechap, monto, id_pago, id_contrato) VALUES ('" . $keyd->Initial_Pay_Date . "','" . $keyd->Initial_Pay_Amount . "',0, '" . $keyd->Contract_ID . "')";
            $this->db->query($query);
        }

        $queryn = "SELECT * FROM t_contracts WHERE Status_ID IN(3,4) AND Value != 0 AND Montly_Amount !=0 AND Date_Montly_P LIKE '%" . $fechac . "%'";

        $pagosm = $this->db->query($queryn)->result();

        foreach ($pagosm as $key) {

            $queryx = "SELECT SUM(monto) as total FROM t_billsg WHERE id_contrato = '" . $key->ID . "'";

            $sumainvoi = $this->db->query($queryx)->result()[0]->total;

            $res = (!empty($sumainvoi)) ? $sumainvoi : 0;

            if ($res < $key->Value) {

                $query = "INSERT INTO t_billsg(fechap, monto, id_pago, id_contrato) VALUES ('" . date('Y-m-d', $hoycomp) . "','" . $key->Montly_Amount . "',0, '" . $key->ID . "')";
                $this->db->query($query);

            }
        }

    }

    public function billgenerathor()
    {

        $deudorid = [];
        $anio     = date("Y");
        $mes      = date("m");

        $mes = $mes + 1;

        if ($mes == 13) {

            $mes  = 1;
            $anio = $anio + 1;

        }

        $fecha = $anio . "-" . $mes . "-01";

        $query = "SELECT t_contracts.ID FROM t_contracts, t_users WHERE t_contracts.Registered_By_ID = t_users.ID AND t_contracts.Status_ID IN(3,4) AND t_contracts.Value !=0 AND t_contracts.Montly_Amount !=0 LIMIT 150";

        $deudores = $this->db->query($query)->result();

        foreach ($deudores as $key) {

            // $cadena = "SELECT SUM(Initial_Pay_Amount) as suma FROM t_initial_payments WHERE Contract_ID = '".$key->ID."' AND Initial_Pay_Date < '".$fecha."' ";
            // $suma = $this->db->query($cadena)->result()[0]->suma;

            $cadena      = "SELECT Montly_Amount FROM t_contracts WHERE ID= '" . $key->ID . "'";
            $cantidadmes = $this->db->query($cadena)->result()[0]->Montly_Amount;

            $cadena = "SELECT COUNT(*) AS totalp FROM t_billsg WHERE  id_contrato= '" . $key->ID . "'";

            $montomen = $this->db->query($cadena)->result()[0]->totalp;

            $cadena  = "SELECT SUM(Pay_Amount) as pagosreal FROM t_payments WHERE ID= '" . $key->ID . "' AND Fee_ID = 0";
            $totalpp = $this->db->query($cadena)->result()[0]->pagosreal;

            $totaldtt = $cantidadmes * $montomen;

            if ($totaldtt > $totalpp) {

                $cadena = "SELECT t_contracts.ID, t_contracts.Contract_N, t_client.C_Name, t_contracts.Balance_Amount, t_contracts.Sign_Date FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";

                $contratom  = $this->db->query($cadena)->result();
                $deudorid[] = $contratom;

            } else {

            }

        }

        return $deudorid;

    }

    public function showbills($id)
    {

        $cadena = "SELECT * FROM t_billsg WHERE id_contrato = '" . $id . "'";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo;

    }

    public function totalfinanci($inicio)
    {

        $cadena = "SELECT SUM(Value) as total FROM t_contracts WHERE Sign_Date BETWEEN '" . $inicio . " 00:00:00' AND '" . $inicio . " 23:00:00'";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo[0]->total;
    }

    public function newpayment($inicio)
    {

        $cadena = "SELECT SUM(Montly_Amount) as total FROM t_contracts WHERE Sign_Date BETWEEN '" . $inicio . " 00:00:00' AND '" . $inicio . " 23:00:00'";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo[0]->total;
    }

    public function totalincomeday($inicio)
    {

        $cadena = "SELECT SUM(mount) as total FROM payment_square WHERE date LIKE '%" . $inicio . "%'";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo[0]->total;
    }

    public function contractsonhold($inicio)
    {

        $cadena = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date BETWEEN '" . $inicio . " 00:00:00' AND '" . $inicio . " 23:00:00' AND Status_ID = 2";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo[0]->total;
    }

    public function totalnewcontracts($inicio)
    {

        $cadena = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date BETWEEN '" . $inicio . " 00:00:00' AND '" . $inicio . " 23:00:00' AND Client_ID !=0";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo[0]->total;
    }

    public function semanafirm()
    {

        $query = "SELECT  COUNT(*) as total from t_contracts where YEARWEEK(t_contracts.Sign_Date, 1)=YEARWEEK(CURDATE(), 1)";

        $valor = $this->db->query($query)->result();

        return $valor[0]->total;

    }

    public function mesfirm()
    {

        $cadena = "SELECT COUNT(*) as total FROM t_contracts WHERE EXTRACT(YEAR_MONTH FROM t_contracts.Sign_Date) = EXTRACT(YEAR_MONTH FROM NOW())";
        $suma   = $this->db->query($cadena)->result();
        return $suma[0]->total;

    }

    public function informametod($inicio)
    {
        $query        = "SELECT COUNT(*) as totalcard FROM payment_square WHERE date LIKE '%" . $inicio . "%' AND type =4";
        $dcard        = $this->db->query($query)->result();
        $data['card'] = $dcard[0]->totalcard;

        $query        = "SELECT COUNT(*) as totalcash FROM payment_square WHERE date LIKE '%" . $inicio . "%' AND type =1";
        $dcash        = $this->db->query($query)->result();
        $data['cash'] = $dcash[0]->totalcash;

        $query         = "SELECT COUNT(*) as totalother FROM payment_square WHERE date LIKE '%" . $inicio . "%' AND type !=4 AND type !=1";
        $dother        = $this->db->query($query)->result();
        $data['other'] = $dother[0]->totalother;

        return $data;
    }

    public function estatuscontract($fecha)
    {

        $cadena = "SELECT catt_status.Status, COUNT(Status_ID) as total from t_contracts , catt_status WHERE t_contracts.Sign_Date >= '" . $fecha['inicio'] . "' AND t_contracts.Sign_Date <= '" . $fecha['fin'] . "' AND Client_ID != 0 AND t_contracts.Status_ID = catt_status.ID group by t_contracts.Status_ID having count(t_contracts.Status_ID)>0";

        $arreglo = $this->db->query($cadena)->result();

        return json_encode($arreglo);
    }

    public function aniofimr()
    {
        $query  = "SELECT COUNT(*) as total FROM t_contracts WHERE YEAR(Sign_Date) = YEAR(now())";
        $result = $this->db->query($query)->result();
        return $result[0]->total;
    }

    public function allclients()
    {
        $sent    = "SELECT ID, C_Name,Company_ID FROM t_client WHERE C_Name LIKE '%" . $_POST['query'] . "%' AND Active=1 AND Company_ID = '" . $_SESSION['ezlow']['lawfirm'] . "' LIMIT 30";
        $persons = $this->db->query($sent)->result();

        return $persons;
    }

    public function services()
    {
        $sent     = "SELECT * FROM catt_services";
        $services = $this->db->query($sent)->result();
        return $services;
    }

    public function obtenerarreglos($fecha)
    {

        $cadena = "SELECT type, COUNT(*) as total from daily_save_dashboard_payments where local_date BETWEEN '" . $fecha . " 00:00:00' and '" . $fecha . " 23:59:59' AND type != 'NO_SALE' GROUP BY type";

        $arreglo = $this->db->query($cadena)->result();

        return $arreglo;

    }

    public function actualizaDeudapot($id)
    {
        $cadena   = "SELECT t_contracts.ID FROM t_contracts, t_users WHERE t_contracts.Registered_By_ID = t_users.ID AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' AND t_contracts.ID = '" . $id . "'";
        $contrato = $this->db->query($cadena)->result();
        $cont     = 0;
        foreach ($contrato as $key => $value) {
            $cont = $cont + 1;

            $cadena2 = "SELECT SUM(Initial_Pay_Amount) as sumaini FROM t_initial_payments WHERE Initial_Pay_Date < CURDATE() AND Contract_ID = '" . $value->ID . "'";

            $initial = $this->db->query($cadena2)->result();

            $cadena3 = "SELECT SUM(Pay_Amount) as sumapay FROM t_payments WHERE Contract_ID = '" . $value->ID . "' AND Fee_ID =0";

            $initial2 = $this->db->query($cadena3)->result();

            $nuevo = $initial[0]->sumaini - $initial2[0]->sumapay;

            $cadenap = "UPDATE t_contracts SET Receivable_Amount = '" . $nuevo . "' WHERE ID='" . $value->ID . "'";
            $this->db->query($cadenap);

            $cadenax = "SELECT Date_Montly_P ,Value, Montly_Amount  FROM t_contracts WHERE ID='" . $value->ID . "'";
            $fecha   = $this->db->query($cadenax)->result();

            $fechainicial  = new DateTime($fecha[0]->Date_Montly_P);
            $fechafinal    = new DateTime(date("Y-m-d H:i:s"));
            $interval      = $fechafinal->diff($fechainicial);
            $intervalMeses = $interval->format("%m");
            $años         = $interval->format("%y");
            $mesesdiff     = $intervalMeses + ($años * 12) + 1;

            if ($fecha[0]->Montly_Amount != 0) {
                $mesesp = $fecha[0]->Value / $fecha[0]->Montly_Amount;
            } else {
                $mesesp = 100;
            }

            $fecha1 = strtotime($fecha[0]->Date_Montly_P);
            $fecha2 = strtotime(date("d-m-Y H:i:00", time()));

            if ($fecha2 > $fecha1) {
                $cadenaz = "SELECT Montly_Amount, Value, Receivable_Amount FROM t_contracts WHERE ID = '" . $value->ID . "'";
                $datosz  = $this->db->query($cadenaz)->result();

                $news  = $datosz[0]->Montly_Amount * $mesesdiff;
                $otron = $datosz[0]->Receivable_Amount + $news;

                if ($otron > $datosz[0]->Value and $mesesp < $mesesdiff) {

                    $cadena12 = "UPDATE t_contracts SET Receivable_Amount = Balance_Amount WHERE ID = '" . $value->ID . "'";

                    $this->db->query($cadena12);

                } else {

                    $cadena12 = "UPDATE t_contracts SET Receivable_Amount = '" . $otron . "' WHERE ID = '" . $value->ID . "'";

                    $this->db->query($cadena12);

                }

            } else {

            }

        }

    }

    public function estadisticas($info)
    {

        $query = "SELECT type, COUNT(*) as total from daily_save_dashboard_payments where date BETWEEN '" . $info['inicio'] . " 09:30:00' and '" . $info['fin'] . " 23:59:59' AND type != 'NO_SALE' GROUP BY type";

        $pagos = $this->db->query($query)->result_array();

        return json_encode($pagos);
    }

    public function editcont($info)
    {

        $texto = trim($info['servicesto']);
        $sent  = "UPDATE t_contracts SET Contract_N= '" . $info['contractnumber'] . "' , Value = '" . $info['contractvalue'] . "' , Montly_Amount='" . $info['amountplan'] . "' , Date_Montly_P = '" . $info['paymentplan'] . "', Frequency_ID='" . $info['frecuency'] . "', status_ID='" . $info['status'] . "', Sign_Date = '" . $info['contractsign'] . "' WHERE ID= '" . $info['id'] . "'";
        $data  = $this->db->query($sent);

        $sent = "SELECT * FROM t_referrals WHERE Contract_ID= '" . $info['id'] . "'";
        $add  = $this->db->query($sent)->result();

        if (!empty($add)) {

            $nuevadd = "UPDATE t_referrals SET Reference_Description = '" . $texto . "' WHERE Contract_ID= '" . $info['id'] . "'";
            $this->db->query($nuevadd);
        } else {

            // $selectid = "SELECT ID FROM t_contracts WHERE Contract_N= '".$info['contractnumber']."'";
            // $ids = $this->db->query($selectid)->result();
            $nuevadd = "INSERT INTO t_referrals(Contract_ID, Contract_N, Reference_Description) VALUES ('" . $info['id'] . "','" . $info['contractnumber'] . "', '" . $texto . "')";
            $this->db->query($nuevadd);
        }

        if (!empty($data)) {
            $this->M_contracts->actualizaDeudapot($info['id']);
            $this->M_contracts->actualizam($info['id']);
            return true;
        } else {
            return false;
        }
    }

    public function cobrarfees()
    {
        $cadena       = "SELECT * FROM t_late_fees WHERE activo = 0";
        $latefees     = $this->db->query($cadena)->result();
        $fecha_actual = strtotime(date("d-m-Y", time()));
        $feev         = 50;

        foreach ($latefees as $key) {
            $ffees = strtotime('+3 days', strtotime($key->Date));

            if ($ffees == $fecha_actual) {
                $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->Contract_ID . "'";
                $valrecei = $this->db->query($cadena1)->result();

                if ($valrecei[0]->Receivable_Amount > 0) {
                    $cadena = "UPDATE t_late_fees SET activo=1 WHERE ID='" . $key->ID . "'";
                    $this->db->query($cadena);

                    $chan = "UPDATE t_contracts SET Receivable_Amount = (Receivable_Amount + '" . $feev . "') WHERE ID = '" . $key->Contract_ID . "'";
                    $this->db->query($chan);

                } else {
                    $cadena = "UPDATE t_late_fees SET activo=2 WHERE ID='" . $key->ID . "'";
                    $this->db->query($cadena);
                }

            }
        }
    }

    public function actulizat()
    {

        $cadena = "SELECT ID, Next_Date FROM `t_contracts` WHERE `Value` != 0 AND `Montly_Amount` != 0 AND `Balance_Amount` > 0 AND `Next_Date` < '2020-04-27' ORDER BY `Sign_Date` DESC";
        $deuda  = $this->db->query($cadena)->result();

        foreach ($deuda as $key) {

            $actualc = strtotime('+1 month', strtotime($key->Next_Date));
            $addf    = date("Y-m-d", $actualc);

            $cambiasta = "UPDATE t_contracts SET Next_Date = '2020-04-30' WHERE ID ='" . $key->ID . "'";
            $this->db->query($cambiasta);
        }

        print_r("termino");

    }

    public function nuevosBills()
    {
        $hoy    = date('Y-m-d', strtotime('yesterday'));
        $nuevad = 0;

        ////// SE SELECCIONAN TODOD LOS CONTRATOS QUE TENGAN LA FECHA DE HON EN EL CAMPO DE Next_Date   //////////////

        $cadena = "SELECT t_contracts.ID FROM t_contracts, t_users WHERE t_contracts.Next_Date ='" . $hoy . "' AND t_contracts.Registered_By_ID = t_users.ID AND t_contracts.Status_ID IN(3,4) AND t_contracts.Value !=0 AND t_contracts.Montly_Amount !=0";
        $deuda  = $this->db->query($cadena)->result();

        ///////  SE RECORREN TODOS LOS CONTRATOS PARA GENERARLES UN BILL  ///////////////////////////////////////

        foreach ($deuda as $key) {

            ////   SE VALIDA SI ALGUN PAGO INICIAL CORRESPONDE AL DIA DE HOY   //////////////////

            $cadena    = "SELECT Initial_Pay_Date, Initial_Pay_Amount FROM t_initial_payments WHERE Initial_Pay_Date = '" . $hoy . "' AND Contract_ID='" . $key->ID . "' ORDER By Initial_Pay_Date ASC LIMIT 1";
            $actulizaf = $this->db->query($cadena)->result();

            if (!empty($actulizaf[0]->Initial_Pay_Date)) {

                ///////////// SE ENCONTRO PAGO INICIAL CON LA FECHA DE HOY POR LO QUE SE CREARA EL BILL CORRESPONDIENTE A LA FECHA DEL PAGO INICIAL ////////////

                $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed, Type) VALUES ('" . $actulizaf[0]->Initial_Pay_Date . "', '" . $key->ID . "',  '" . $actulizaf[0]->Initial_Pay_Amount . "', 0 , 1)";
                $this->db->query($crearbill);

                // $crearlate = "INSERT INTO t_late_fees(Contract_ID, Date, activo) VALUES ('".$key->ID."', '".$actulizaf[0]->Initial_Pay_Date."', 0)";
                // $this->db->query($crearlate);

                /////////// SE ACTUALIZA LA DEUDA AL DIA ////////////////////

                $chan = "UPDATE t_contracts SET Receivable_Amount = (Receivable_Amount + '" . $actulizaf[0]->Initial_Pay_Amount . "') WHERE ID = '" . $key->ID . "'";
                $this->db->query($chan);

                //////////// SE OBTIENE LA NUEVA CANTIDAD A LA DEUDA DEL DIA  /////////////////

                $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                $valrecei = $this->db->query($cadena1)->result();

                ////////// SE COMPRAR PARA SABER SI ESTE MONTO YA SE CUBRIO CON LOS PAGOS , SI ES 0 O MENOR A 0 NO SE ENVIARA NADA, DE LO CONTRARIO AUN DEBE UNA CANTIDAD Y SE ENVIARA EL MONTO A DEBER POR UN MENSAJE DE TEXTO   //////////////////////////////////////

                if ($valrecei[0]->Receivable_Amount <= 0) {
                    /// AL NO DEBER NADA NO SE AGREGARA NADA  //////////////
                    print_r('success');
                } else {

                    /////////// AL AUN DEBER UNA CANTIDAD, SE LE ENVIARA EL MENSAJE DE TEXTO CON LA CANTIDAD //////////////////
                    // $info = "";

                    $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                    $text = $this->db->query($info)->result();

                    // $this->testeztexting($text , $actulizaf[0]->Initial_Pay_Amount, $actulizaf[0]->Initial_Pay_Date);

                    // print_r("se envio mensaje");
                }
            } else {

                //////////// NO SE ENCONTRO UN PAGO INICIAL CORRESPONDIENTE A LA FECHA DE HOY POR LO QUE SE BUSCARA SI LA FECHA EN LA QUE INICIARA SU PAGO ES IGUAL AL DIA DE HOY ///////////

                $sing       = "SELECT Date_Montly_P, Montly_Amount FROM t_contracts WHERE ID ='" . $key->ID . "' AND  Date_Montly_P = '" . $hoy . "'";
                $resultsing = $this->db->query($sing)->result();

                if (!empty($resultsing)) {

                    ///////////// SI SE ENCONTRO LA FECHA INICIAL CON LA FECHA DE HOY POR LO QUE SE CREARA EL BILL CONRRESPONDIERTE DEL PRIMER PAGO MENSUAL /////////////////////

                    $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed, Type) VALUES ('" . $resultsing[0]->Date_Montly_P . "', '" . $key->ID . "',  '" . $resultsing[0]->Montly_Amount . "', 0 , 0)";
                    $this->db->query($crearbill);

                    // $crearlate = "INSERT INTO t_late_fees(Contract_ID, Date, activo) VALUES ('".$key->ID."', '".$resultsing[0]->Date_Montly_P."', 0)";
                    // $this->db->query($crearlate);

                    /////////// ACTUALIZA LA DEUDA AL DIA CON EL MONTO DE LA PRIMERA MENSUALIDAD //////////////

                    $chan = "UPDATE t_contracts SET Receivable_Amount = (Receivable_Amount + '" . $resultsing[0]->Montly_Amount . "') WHERE ID = '" . $key->ID . "'";
                    $this->db->query($chan);

                    //////////////// SE OBTIENE LA DEUDA AL DIA //////////////////

                    $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                    $valrecei = $this->db->query($cadena1)->result();

                    if ($valrecei[0]->Receivable_Amount <= 0) {

                        ///////// NO SE ENVIARA MENSAJE POR QUE NO TIENE UN ADEUDO //////////////////
                        print_r('success');
                    } else {

                        //////////// SE ENVIARA LA INFORMACION CON LA DEUDA A PAGAR /////////////////////

                        // $info = "";
                        $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                        $text = $this->db->query($info)->result();

                        // $this->testeztexting($text , $resultsing[0]->Montly_Amount, $resultsing[0]->Date_Montly_P);

                        // print_r("se envio mensaje");

                    }

                } else {

                    ////////// NO SE ENCONTRO UNA FECHA INICIAL RELACIONADA CON LA FECHA DE HOY , POR LO QUE EL PAGO SERA DE LA SIGUIENTE MENSUALIDAD ///////////////////////////

                    //// SE OBTIENE LA INFORMACION DEL CONTRATO PARA REALIZAR LOS CALCULOS //////////

                    $addval    = "SELECT Next_Date, Frequency_ID, Montly_Amount, Receivable_Amount, Value, Balance_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                    $resulnext = $this->db->query($addval)->result();

                    /////////// SE EVALUA SI EL BALANCE ES MEYOR AL MONTO MENSUAL PARA SABER SI ESTA PERSONA DEBE MENOS DE SU ABONO MENSUAL ///////////////

                    if ($resulnext[0]->Balance_Amount >= $resulnext[0]->Montly_Amount) {

                        /////////////// SI EL BALANCE ES MAYOR A LA DEUDA MENSUAL, ENTONCES SE LE PODRA COBRAR EL MONTO COMPLETO ///////////////////

                        if ($resulnext[0]->Value == $resulnext[0]->Receivable_Amount) {

                            print_r('expression');

                        } else {
                            ///////// SE CREA EL BILL CORRESPONDIENTE DEL PAGO /////////////////

                            $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed, Type) VALUES ('" . $resulnext[0]->Next_Date . "', '" . $key->ID . "',  '" . $resulnext[0]->Montly_Amount . "', 0 , 0)";

                            $this->db->query($crearbill);

                            // $crearlate = "INSERT INTO t_late_fees(Contract_ID, Date, activo) VALUES ('".$key->ID."', '".$resulnext[0]->Next_Date."', 0)";
                            // $this->db->query($crearlate);

                            /////////////////// SE ACTUALIZA LA DEUDA AL DIA DE CADA CONTRATO ///////////////////

                            $chan = "UPDATE t_contracts SET Receivable_Amount = (Receivable_Amount + '" . $resulnext[0]->Montly_Amount . "') WHERE ID = '" . $key->ID . "'";
                            $this->db->query($chan);

                        }

                        ////////////// SE OBTIENE LA DEUDA AL DIA PARA SABER CUANTO SE LE DEBE DE COBRAR A LA PERSONA ////////////

                        $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        /////////////// SE REALIZA LA COMPARACION PARA SABER SI SE LE DEBE DE MANDAR EL MENSAJE O NO /////////////

                        if ($valrecei[0]->Receivable_Amount <= 0) {

                            //////////// AL NO DEBER NADA, NO SE LE ENVIA MENSAJE ///////////////

                            print_r('success');
                        } else {

                            //////// AL TENER DEUDA, SE LE ENVIARA EL MENSAJE DE TEXTO CON LA DEUDA A PAGAR /////////////

                            // $info = "";
                            $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                            $text = $this->db->query($info)->result();

                            // $this->testeztexting($text , $resulnext[0]->Montly_Amount, $resulnext[0]->Next_Date);

                            // print_r("se envio mensaje");

                        }

                    } else {

                        //////////// SI EL BALANCE ES MENOR AL MONTO , SE LE COBRAR UNA CANTIDAD MENOR A LA DE LA MENSUALIDAD //////////////

                        ///////////// SE CREA EL BILL CORRESPONDIENTE A LA DEUDA, QUE EN ESTE CASO SERA EL BALANCE, YA QUE ES MENOR AL MONTO DE LA MENSUALIDAD ////////////////

                        $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed, Type) VALUES ('" . $resulnext[0]->Next_Date . "', '" . $key->ID . "',  '" . $resulnext[0]->Balance_Amount . "', 0 , 0)";

                        $this->db->query($crearbill);

                        // $crearlate = "INSERT INTO t_late_fees(Contract_ID, Date, activo) VALUES ('".$key->ID."', '".$resulnext[0]->Next_Date."', 0)";
                        // $this->db->query($crearlate);

                        //////////////////////// SE ACTUALIZA LA DEUDA AL DIA DEL CONTRATO /////////////////////////////

                        $chan = "UPDATE t_contracts SET Receivable_Amount = (Receivable_Amount + '" . $resulnext[0]->Balance_Amount . "') WHERE ID = '" . $key->ID . "'";
                        $this->db->query($chan);

                        ///////////////SE OBTIENE LA DEUDA AL DIA DEL CONTRATO PARA EVALUAR SI SE LE DEBE DE MANDAR MENSAJE O NO////////////////77

                        $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        ///////// SE EVALUAN LOS MONTOS PARA SABER SI SE LE ENVIARA EL MENSAJE O NO ////////////7

                        if ($valrecei[0]->Receivable_Amount <= 0) {

                            //////////// AL NO DEBER NO SE LE ENVIARA UN MENSAJE ///////////////

                            print_r('success');

                        } else {

                            //////////// SE ENVIARA UN MENSAJE DE TEXTO CON LA DEUDA QUE DEBE DE PAGAR /////////////

                            // $info = "";
                            $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                            $text = $this->db->query($info)->result();

                            // $this->testeztexting($text , $resulnext[0]->Balance_Amount , $resulnext[0]->Next_Date);

                            // print_r("se envio mensaje");

                        }

                    }

                }
            }
            /////////////////////////// GENERARA LAS NUEVAS FECHAS PARA LOS SIGUIENTES RECORDATORIOS //////////////////////

            ////////// SE VALIDA SI TIENE OTRO PAGO INICIAL ///////////////////////////

            $cadena    = "SELECT Initial_Pay_Date, Initial_Pay_Amount FROM t_initial_payments WHERE Initial_Pay_Date > '" . $hoy . "' AND Contract_ID='" . $key->ID . "' ORDER By Initial_Pay_Date ASC LIMIT 1";
            $actulizaf = $this->db->query($cadena)->result();

            if (!empty($actulizaf[0]->Initial_Pay_Date)) {

                ///////////// SI TIENE OTRO PAGO INICIAL, ACTUALIZA LA FECHA AL CONTRATO ///////////////////////

                $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $actulizaf[0]->Initial_Pay_Date . "' WHERE ID ='" . $key->ID . "'";
                $this->db->query($cambiasta);

            } else {

                ////////////////// EN CASO DE QUE NO EXISTA OTRO PAGO INICIAL, EVALUA SI DEBE DE DAR SU PRIMER PAGO /////////

                $addval    = "SELECT Next_Date, Frequency_ID, Montly_Amount, Receivable_Amount, Value, Balance_Amount, Date_Montly_P FROM t_contracts WHERE ID ='" . $key->ID . "' AND Date_Montly_P  > '" . $hoy . "'";
                $resulnext = $this->db->query($addval)->result();

                if (!empty($resulnext)) {

                    /////////////////// EN CASO DE QUE SU FECHA DE PRIMERA PAGO NO HAYA PASADO SE AGREGARA ESTA FECHA EN EL CONTRATO ////////////

                    $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $resulnext[0]->Date_Montly_P . "' WHERE ID ='" . $key->ID . "'";
                    $this->db->query($cambiasta);

                } else {

                    //////////////// EN CASO DE QUE SU FECHA DE PRIMER PAGO YA HAYA PASADO, SE INICIA CON LOS PAGOS MENSAULES ////////////////

                    //////////// SE OBTIENE LA FECHA DE SIGUIENTE PAGO DE SU CONTRATO //////////////

                    $addval    = "SELECT Next_Date, Frequency_ID, Montly_Amount, Receivable_Amount, Value, Balance_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                    $resulnext = $this->db->query($addval)->result();

                    /////////////// SE OBTIENE SU FRECUENCIA Y SE VALUA LA CANTIDAD DE DIAS QUE SE LE VAN A AGREGAR Y SE ACTUALIZA LA CANTIDAD EN EL CONTRATO/////////////////

                    switch ($resulnext[0]->Frequency_ID) {

                        case 2:

                            $actualc = strtotime('+1 week', strtotime($resulnext[0]->Next_Date));
                            $addf    = date("Y-m-d", $actualc);

                            if ($resulnext[0]->Balance_Amount > 0) {

                                $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $addf . "' WHERE ID ='" . $key->ID . "'";
                                $this->db->query($cambiasta);
                            }

                            //   $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$addf."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            break;
                        case 3:

                            $actualc = strtotime('+2 week', strtotime($resulnext[0]->Next_Date));
                            $addf    = date("Y-m-d", $actualc);

                            $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $addf . "' WHERE ID ='" . $key->ID . "'";
                            $this->db->query($cambiasta);

                            //    $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$addf."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            break;
                        case 4:

                            $actualc = strtotime('+1 month', strtotime($resulnext[0]->Next_Date));
                            $addf    = date("Y-m-d", $actualc);

                            $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $addf . "' WHERE ID ='" . $key->ID . "'";
                            $this->db->query($cambiasta);

                            //    $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$addf."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            break;
                        case 5:

                            $actualc = strtotime('+2 month', strtotime($resulnext[0]->Next_Date));
                            $addf    = date("Y-m-d", $actualc);

                            $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $addf . "' WHERE ID ='" . $key->ID . "'";
                            $this->db->query($cambiasta);

                            //    $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$addf."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            break;
                        case 6:

                            $actualc = strtotime('+3 month', strtotime($resulnext[0]->Next_Date));
                            $addf    = date("Y-m-d", $actualc);

                            $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $addf . "' WHERE ID ='" . $key->ID . "'";
                            $this->db->query($cambiasta);

                            //    $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$addf."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            break;
                        case 7:

                            $actualc = strtotime('+6 month', strtotime($resulnext[0]->Next_Date));
                            $addf    = date("Y-m-d", $actualc);

                            $cambiasta = "UPDATE t_contracts SET Next_Date = '" . $addf . "' WHERE ID ='" . $key->ID . "'";
                            $this->db->query($cambiasta);

                            //    $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$addf."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            break;

                    }

                }

            }

        }

        // $this->cobrarfees();
    }

    public function enviarmsj()
    {

        $cadena = "SELECT ID FROM t_contracts WHERE Next_Date = DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND t_contracts.Status_ID IN(3,4) AND t_contracts.Value != 0 AND t_contracts.Montly_Amount != 0 AND YEAR(NOW()) = YEAR(t_contracts.Sign_Date)";
        $ids    = $this->db->query($cadena)->result();

        foreach ($ids as $key) {
            $sql = "SELECT t_contracts.Contract_N, t_contracts.ID, t_contracts.Montly_Amount, t_contracts.Next_Date, t_client.C_Name, t_client.ID as cliente_id, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";

            $info = $this->db->query($sql)->result();

            $this->testeztexting($info, $info[0]->Montly_Amount, $info[0]->Next_Date);
        }
    }

    public function testeztexting($info, $monto, $fecha)
    {

        if (!empty($info[0]->Phone_Number)) {
            $numero = intval(preg_replace('/[^0-9]+/', '', $info[0]->Phone_Number), 10);

            $mes     = date("F");
            $nfecha  = date("m-d-Y", strtotime($fecha));
            $mensaje = 'Hola ' . $info[0]->C_Name . ',' . "\n" . ' Tu Estado de cuenta del mes de ' . $mes . ' del a? 2020, se encuentra disponible.' . "\n" . ' Contracto # ' . $info[0]->Contract_N . ' . ' . "\n" . ' Fecha de vencimiento del pago: ' . $nfecha . '. ' . "\n" . ' Formas de Pago: Pague por tel?ono o contactarnos si tiene dudas al n?mero 213-309-9123.' . "\n" . '  Pague en Persona: Puedes visitar nuestras oficinas ubicadas en el numero 3450 de Wilshire Blvd. Ste # 400 Los ?ngeles CA. 90010.' . "\n" . 'Apreciamos su preferencia: Kostiv & Associates P.C : Kostiv & Associates P.C ' . "\n" . ' Powered by EZ Law Pay';

            print_r($info[0]->ID . "-->" . $mensaje);

            $data = array(
                'User'          => 'kostivlaw18',
                'Password'      => 'wilshire3450',
                'PhoneNumbers'  => array($numero),
                'Subject'       => 'Kostiv & Associates',
                'Message'       => $mensaje,
                'StampToSend'   => '1305582245',
                'MessageTypeID' => 3,
            );

            $curl = curl_init('https://app.eztexting.com/sending/messages?format=json');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// If you experience SSL issues, perhaps due to an outdated SSL cert
            // on your own server, try uncommenting the line below
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
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

            $cadena = "INSERT INTO t_phone_messages(Contract_ID, Client_ID, Amount, Date_Payment, Sent) VALUES ('" . $info[0]->ID . "', '" . $info[0]->cliente_id . "', '" . $monto . "', '" . $fecha . "', 1)";
            $this->db->query($cadena);

            print_r("<br>");
        } else {
            print_r($info[0]->ID . "--->   error en numero");

            $cadena = "INSERT INTO t_phone_messages(Contract_ID, Client_ID, Amount, Date_Payment, Sent) VALUES ('" . $info[0]->ID . "', '" . $info[0]->cliente_id . "', '" . $monto . "', '" . $fecha . "', 0)";
            $this->db->query($cadena);

            print_r("<br>");
        }

    }

    public function actulizaBalance()
    {
        $cadena = "SELECT t_contracts.ID FROM t_contracts, t_users WHERE t_contracts.Registered_By_ID = t_users.ID AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' ";

        $todos = $this->db->query($cadena)->result();
        foreach ($todos as $key) {
            $cadena = "SELECT SUM(Pay_Amount) as suma FROM t_payments WHERE Contract_ID ='" . $key->ID . "' AND Fee_ID =0";

            $monto = $this->db->query($cadena)->result();

            $cadena  = "SELECT Value FROM t_contracts WHERE ID ='" . $key->ID . "'";
            $balance = $this->db->query($cadena)->result();

            $nbalance = $balance[0]->Value - $monto[0]->suma;

            $cadena = "UPDATE t_contracts SET Balance_Amount = '" . $nbalance . "'  WHERE ID ='" . $key->ID . "'";
            $this->db->query($cadena);
        }

        print_r("success");
    }

    public function actualizaDeuda()
    {
        $cadena   = "SELECT t_contracts.ID FROM t_contracts, t_users WHERE t_contracts.Registered_By_ID = t_users.ID AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "'";
        $contrato = $this->db->query($cadena)->result();
        $cont     = 0;
        foreach ($contrato as $key => $value) {
            $cont = $cont + 1;

            $cadena2 = "SELECT SUM(Initial_Pay_Amount) as sumaini FROM t_initial_payments WHERE Initial_Pay_Date < CURDATE() AND Contract_ID = '" . $value->ID . "'";

            $initial = $this->db->query($cadena2)->result();

            $cadena3 = "SELECT SUM(Pay_Amount) as sumapay FROM t_payments WHERE Contract_ID = '" . $value->ID . "' AND Fee_ID =0";

            $initial2 = $this->db->query($cadena3)->result();

            $nuevo = $initial[0]->sumaini - $initial2[0]->sumapay;

            $cadenap = "UPDATE t_contracts SET Receivable_Amount = '" . $nuevo . "' WHERE ID='" . $value->ID . "'";
            $this->db->query($cadenap);

            /// hasta aqui todo corre bien ////

            // print_r("contrato numero   ". $value->ID. "      Pagos iniciales".$initial[0]->sumaini."    Pagos realizados".$initial2[0]->sumapay."   total de la deuda".$nuevo);
            // print_r('<br>');

            $cadenax = "SELECT Date_Montly_P ,Value, Montly_Amount  FROM t_contracts WHERE ID='" . $value->ID . "'";
            $fecha   = $this->db->query($cadenax)->result();

            $fechainicial  = new DateTime($fecha[0]->Date_Montly_P);
            $fechafinal    = new DateTime(date("Y-m-d H:i:s"));
            $interval      = $fechafinal->diff($fechainicial);
            $intervalMeses = $interval->format("%m");
            $años         = $interval->format("%y");
            $mesesdiff     = $intervalMeses + ($años * 12) + 1;

            if ($fecha[0]->Montly_Amount != 0) {
                $mesesp = $fecha[0]->Value / $fecha[0]->Montly_Amount;
            } else {
                $mesesp = 100;
            }

            // print_r($fecha[0]->Date_Montly_P." ".date("Y-m-d H:i:s"));
            // print_r("el contrato numero ".$value->ID." tiene ".$mesesdiff. " ".$nuevo);
            // print_r('<br>');

            // if ($mesesdiff > 0) {

            $fecha1 = strtotime($fecha[0]->Date_Montly_P);
            $fecha2 = strtotime(date("d-m-Y H:i:00", time()));

            if ($fecha2 > $fecha1) {
                $cadenaz = "SELECT Montly_Amount, Value, Receivable_Amount FROM t_contracts WHERE ID = '" . $value->ID . "'";
                $datosz  = $this->db->query($cadenaz)->result();

                $news  = $datosz[0]->Montly_Amount * $mesesdiff;
                $otron = $datosz[0]->Receivable_Amount + $news;

                print_r("contrac: " . $value->ID . " " . $otron);
                print_r('<br>');

                // print_r("Id del contrato :".$value->ID ." Valor del contrato :  ". $datosz[0]->Value."  Meses por la cantidad mensual :".$datosz[0]->Receivable_Amount. "este es mese por el monto".$news);
                // print_r('<br>');

                if ($otron > $datosz[0]->Value and $mesesp < $mesesdiff) {

                    $cadena12 = "UPDATE t_contracts SET Receivable_Amount = Balance_Amount WHERE ID = '" . $value->ID . "'";

                    $this->db->query($cadena12);

                    // print_r("su valor sera el balance" .$value->ID);
                    // print_r('<br>');
                } else {

                    $cadena12 = "UPDATE t_contracts SET Receivable_Amount = '" . $otron . "' WHERE ID = '" . $value->ID . "'";

                    $this->db->query($cadena12);

                    // print_r("contrato :".$value->ID." la cantidad que se ingresara a este contrato : " .$otron);
                }

            } else {
                print_r($nuevo . "solo debe esto");
            }

            //     $cadenaz = "SELECT Montly_Amount, Value, Receivable_Amount FROM t_contracts WHERE ID = '".$value->ID."'";
            //     $datosz = $this->db->query($cadenaz)->result();

            // $news =  $datosz[0]->Montly_Amount * $mesesdiff;
            // $otron = $datosz[0]->Receivable_Amount + $news;

            // print_r($datosz[0]->Montly_Amount." ".$intervalMeses." ".$datosz[0]->Receivable_Amount." ".$value->ID);
            // // print_r('<br>');

            // if ($otron > $datosz[0]->Value ) {

            //     print_r("monto con la suma de lo generado por mes" .$otron. "monto del valor del contrato". $datosz[0]->Value);

            //     $nuevodatoadd = $datosz[0]->Value - $initial2[0]->sumapay;

            //     $cadena12 = "UPDATE t_contracts SET Receivable_Amount = Balance_Amount WHERE ID = '".$value->ID."'";

            //     $this->db->query($cadena12);
            // }else{

            //     print_r("esta es el monto del mes por los meses mas la cantidad de pagos que debria de hacer a la fecha" .$otron. "valor del contrato".$datosz[0]->Value);
            //     print_r('<br>');

            //     $cadena12 = "UPDATE t_contracts SET Receivable_Amount = '".$otron."' WHERE  ID = '".$value->ID."'";
            //     $this->db->query($cadena12);
            // }

            //     }

            print_r($mesesp);
        }

    }

    public function actualizam($id)
    {
        $cadena = "SELECT SUM(Pay_Amount) as suma FROM t_payments WHERE Contract_ID ='" . $id . "' AND Fee_ID =0";

        $monto = $this->db->query($cadena)->result();

        $cadena  = "SELECT Value FROM t_contracts WHERE ID ='" . $id . "'";
        $balance = $this->db->query($cadena)->result();

        $nbalance = $balance[0]->Value - $monto[0]->suma;

        $cadena = "UPDATE t_contracts SET Balance_Amount = '" . $nbalance . "'  WHERE ID ='" . $id . "'";
        $this->db->query($cadena);

        return 'SI';
    }

    public function statusc()
    {

        $cadena   = "SELECT t_contracts.ID, t_contracts.Receivable_Amount, t_contracts.Balance_Amount FROM t_contracts, t_users WHERE (t_contracts.Registered_By_ID = t_users.ID AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' AND status_ID=  3) OR (t_contracts.Registered_By_ID = t_users.ID AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' AND status_ID = 4)";
        $contrato = $this->db->query($cadena)->result();

        foreach ($contrato as $key) {
            $cadena2 = "SELECT count(*) as sumaini FROM t_initial_payments WHERE Initial_Pay_Date > CURDATE() AND Contract_ID = '" . $key->ID . "'";

            $numeroinitialp = $this->db->query($cadena2)->result();

            $cadena3 = "SELECT count(*) as sumanpa FROM t_payments WHERE  Contract_ID = '" . $key->ID . "'";
            $numerop = $this->db->query($cadena3)->result();

            // if ($numeroinitialp[0]->sumaini == 0 AND $numerop[0]->sumanpa ==0) {
            //     $sent = "UPDATE t_contracts SET status_ID=2 WHERE ID = '".$key->ID."'";
            //         $this->db->query($sent);
            // }

            if ($key->Receivable_Amount <= 0) {

                $sent = "UPDATE t_contracts SET status_ID=3 WHERE ID = '" . $key->ID . "'";
                $this->db->query($sent);
            }

            if ($key->Receivable_Amount > 0) {

                $sent = "UPDATE t_contracts SET status_ID=4 WHERE ID = '" . $key->ID . "'";
                $this->db->query($sent);
            }

            if ($numerop[0]->sumanpa > 0) {
                if ($key->Balance_Amount <= 0) {
                    $sent = "UPDATE t_contracts SET status_ID=1 WHERE ID = '" . $key->ID . "'";
                    $this->db->query($sent);
                }
            }

            // print_r($numeroinitialp[0]->sumaini." ". $numerop[0]->sumanpa );
            // print_r("<br>");

        }
    }

    public function addContrac($datos)
    {

        if (!empty($datos['checkvalor'])) {
            $userx = 34;
        } else {
            $userx = $_SESSION['ezlow']['iduser'];
        }

        $sent    = "SELECT ID FROM t_client WHERE C_Name = '" . $datos['info1'] . "'";
        $persons = $this->db->query($sent)->result();

        if (!empty($persons)) {

            $update_status = 3;

            $contract                   = "SELECT * FROM t_contracts WHERE Contract_N = '" . $datos['contractnumber'] . "'";
            $contract_duplicated_result = $this->db->query($contract)->result();

            $status = empty($datos['status']) ? $update_status : $datos['status'];
            if (empty($contract_duplicated_result)) {
                if (!empty($datos['initialfe'])) {
                    $cadena = "INSERT INTO t_contracts (Contract_N, Client_ID, Value, Sign_Date, Frequency_ID, Registered_By_ID, Reminder_ID, Date_Montly_P, Montly_Amount, status_ID, Balance_Amount, Description, Next_Date) VALUES ('" . $datos['contractnumber'] . "' , '" . $persons[0]->ID . "', '" . $datos['contractvalue'] . "' , '" . $datos['contractsign'] . "',   '" . $datos['frecuency'] . "', '" . $userx . "' , 0 , '" . $datos['paymentplan'] . "' , '" . $datos['amountplan'] . "','" . $status . "', '" . $datos['contractvalue'] . "' , '" . $datos['description'] . "', '" . $datos['initialfe'] . "')";
                } else {
                    $cadena = "INSERT INTO t_contracts (Contract_N, Client_ID, Value, Sign_Date, Frequency_ID, Registered_By_ID, Reminder_ID, Date_Montly_P, Montly_Amount, status_ID, Balance_Amount, Description, Next_Date) VALUES ('" . $datos['contractnumber'] . "' , '" . $persons[0]->ID . "', '" . $datos['contractvalue'] . "' , '" . $datos['contractsign'] . "',   '" . $datos['frecuency'] . "', '" . $userx . "' , 0 , '" . $datos['paymentplan'] . "' , '" . $datos['amountplan'] . "','" . $status . "', '" . $datos['contractvalue'] . "' , '" . $datos['description'] . "', '" . $datos['paymentplan'] . "')";
                }

                $this->db->query($cadena);

                $sent    = "SELECT ID FROM t_contracts WHERE Contract_N = '" . $datos['contractnumber'] . "'";
                $persons = $this->db->query($sent)->result();

                if (!empty($datos['initialfe'])) {

                    $cadena = "INSERT INTO t_initial_payments(Contract_ID, Contract_N, Initial_Pay_Date, Initial_Pay_Amount) VALUES ('" . $persons[0]->ID . "' , '" . $datos['contractnumber'] . "', '" . $datos['initialfe'] . "' , '" . $datos['initialp'] . "')";
                    $this->db->query($cadena);
                }

                $cadena = "INSERT INTO t_referrals(Contract_ID, Contract_N, Reference_Description) VALUES ('" . $persons[0]->ID . "' , '" . $datos['contractnumber'] . "', '" . $datos['servicesto'] . "')";
                $this->db->query($cadena);

                foreach ($datos['services'] as $key => $value) {

                    $cadena = "INSERT INTO t_services(Contract_ID, Contract_N, Services_ID) VALUES ('" . $persons[0]->ID . "' , '" . $datos['contractnumber'] . "' , '" . $value . "' )";
                    $this->db->query($cadena);
                }

                foreach ($datos['pays'] as $key => $valuex) {
                    $cadena = "INSERT INTO t_initial_payments(Contract_ID, Contract_N, Initial_Pay_Date, Initial_Pay_Amount) VALUES ('" . $persons[0]->ID . "' , '" . $datos['contractnumber'] . "', '" . $valuex . "' , '" . $datos['valp'][$key] . "')";
                    $this->db->query($cadena);
                }

                return 1;
            } else {
                return 2;
            }
        } else {

            return 3;
        }
    }

    public function cambiastadb($info)
    {

        parse_str($info['info'], $ok);

        switch ($ok['typeuser']) {
            case '1':
                $sent = "UPDATE t_contracts SET status_ID=2 WHERE ID = '" . $info['id'] . "'";
                $this->db->query($sent);
                break;

            case '2':
                $sent = "UPDATE t_contracts SET status_ID=6 WHERE ID = '" . $info['id'] . "'";
                $this->db->query($sent);
                break;
            case '3':
                $sent = "UPDATE t_contracts SET status_ID=5 WHERE ID = '" . $info['id'] . "'";
                $this->db->query($sent);
                break;

            case '4':
                $sent = "UPDATE t_contracts SET status_ID=8 WHERE ID = '" . $info['id'] . "'";
                $this->db->query($sent);
                break;
        }

        return true;
    }

    public function getiduser($datos)
    {
        $sent    = "SELECT ID FROM t_client WHERE C_Name = '" . $nombre . "'";
        $persons = $this->db->query($sent)->result();
        $cadena  = "INSERT INTO t_contracts (`Contract_Number`, `Client_ID`, `Contract_Value`, `Sign_Date`, `Frequency_ID`, `Registered_By_ID`, `Reminder_ID`, `Status`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])";
    }

    public function showContract($id)
    {
        $query = "SELECT t_contracts.*, t_client.C_Name, t_client.Phone_Number FROM t_contracts INNER JOIN t_client on t_contracts.Client_ID=t_client.ID WHERE t_contracts.ID = '" . $id . "'";

        return $this->db->query($query)->result();
    }

    public function referidos($id)
    {
        $query = "SELECT Reference_Description FROM t_referrals WHERE t_referrals.Contract_ID = '" . $id . "'";

        return $this->db->query($query)->result();
    }

    public function servicess($id)
    {
        $query = "SELECT catt_services.Service_Description FROM catt_services INNER JOIN t_services ON t_services.Services_ID = catt_services.ID WHERE t_services.Contract_ID = '" . $id . "'";

        return $this->db->query($query)->result();
    }

    public function initial($id)
    {
        $query = "SELECT Initial_Pay_Amount,Initial_Pay_Date FROM t_initial_payments WHERE Contract_ID = '" . $id . "'";

        return $this->db->query($query)->result();
    }

    public function paysdo($id)
    {
        $cadena = "SELECT Date, Pay_Description, Pay_Amount FROM t_payments WHERE Contract_ID ='" . $id . "' AND Fee_ID=0";

        return $this->db->query($cadena)->result();

    }

    public function pagosmos($id)
    {
        $cadena = "SELECT t_payments.*, catt_pay_method.Pay_Method FROM t_payments INNER JOIN catt_pay_method ON catt_pay_method.ID = t_payments.Pay_Method  WHERE t_payments.Contract_ID ='" . $id . "' AND t_payments.Fee_ID =0 ORDER BY t_payments.Date";

        return $this->db->query($cadena)->result();
    }

    public function fees($id)
    {
        $cadena = "SELECT t_payments.*, catt_pay_method.Pay_Method, catt_fees.Fee_Type FROM t_payments INNER JOIN catt_pay_method ON catt_pay_method.ID = t_payments.Pay_Method INNER JOIN catt_fees ON catt_fees.ID = t_payments.Fee_ID  WHERE t_payments.Contract_ID ='" . $id . "'";

        return $this->db->query($cadena)->result();
    }

    public function balance($id)
    {

        $sent = "SELECT SUM(t_payments.Pay_Amount) as suma FROM t_payments  WHERE t_payments.Contract_ID ='" . $id . "' AND t_payments.Fee_ID =0";
        $suma = $this->db->query($sent)->result();

        $sent  = "SELECT t_contracts.Value FROM t_contracts  WHERE t_contracts.ID ='" . $id . "'";
        $monto = $this->db->query($sent)->result();

        $balance = $monto[0]->Value - $suma[0]->suma;

        return $balance;
    }

    public function balance_data($contract_number)
    {
        $this->db->select('*, tc.ID as contract_id');
        $this->db->from('t_contracts as tc');
        $this->db->join('t_client as tcl', 'tcl.ID = tc.Client_ID');
        $this->db->where('tc.ID =', $contract_number);

        $data                 = $this->db->get();
        $contract['contract'] = $data->row();
        $contract['invoice']  = $this->invoice_and_payment_data($contract_number);

        return $contract;
    }

    private function invoice_and_payment_data($contract_id)
    {
        $no_feeed_payment = 0;
        $this->db->select('*');
        $this->db->from('t_contracts as tc');
        $this->db->join('t_payments as tp', 'tp.Contract_ID = tc.ID');
        $this->db->where('tc.ID =', $contract_id);
        $this->db->where('tp.Fee_ID =', $no_feeed_payment);
        $this->db->order_by('tp.Date', 'ASC');

        $data = $this->db->get();
        return $data->result();
    }

    public function message_balance_link($contract_id)
    {
        $url = 'https://www.ezlawpay.com/ez/pdf_contract/';
        $this->db->select('tcl.Phone_Number as phone_number, tc.ID as contract_id, tcl.C_Name as client_name, tc.Contract_N as contract_number');
        $this->db->from('t_contracts as tc');
        $this->db->join('t_client as tcl', 'tcl.ID = tc.Client_ID');
        $this->db->where('tc.ID =', $contract_id);

        $raw_data = $this->db->get();
        $data     = $raw_data->row();

        if (empty($data->phone_number)) {
            $response_error_message = $this->balance_message_response('', true);
            return print($response_error_message);
        }

        $welcome   = 'Hola ' . $data->client_name;
        $message   = 'El balance de tu estado de cuenta del contrato ' . $data->contract_number . ' se encuentra disponible en el siguiente link: ';
        $link      = $url . $data->contract_id;
        $farewell  = 'Apreciamos su preferencia: Kostiv & Associates P.C';
        $signature = 'Powered by EZ Law Pay';

        $info['phone_number'] = $data->phone_number;
        $info['message']      = $welcome . ' ' . $message . ' ' . $link . '  ' . $farewell . ' ' . $signature;
        $response             = $this->text_message($info);
        $response_message     = $this->balance_message_response($response);

        if (!empty($data->phone_number)) {

            $number = intval(preg_replace('/[^0-9]+/', '', $data->phone_number), 10);
            if (strlen($number) == 10) {
                $this->guardar($contract_id);
            }

        }

        return print($response_message);
    }

    private function balance_message_response($response, $no_phone_error = false)
    {
        $header      = '<div class="card" style=""><div class="card-body"><h5 class="card-title">';
        $title       = '<br>' . '<strong>' . 'Text Message Result' . '</strong>' . '</br>';
        $style       = '<div style="background-color: #f2f2f2; height:6rem; padding: 5% 3% 5% 3%; color: #737373; font-weight: lighter !important; font-size="6"; ">';
        $welcome     = 'The message could not be sent and had the following errors' . '</br>';
        $style_end   = '</div></div></div>';
        $phone_error = 'Unregistered customer phone number.';

        if ($no_phone_error) {
            return $header . $title . $style . $welcome . $phone_error . $style_end;
        }

        if (isset($response['errors']) && !empty(($response['errors']))) {
            $errors = $response['errors'];
            return $header . $title . $style . $welcome . $errors . $style_end;
        }

        $success = 'The message was sent successfully';
        return $header . $title . $style . $success . $style_end;
    }

    private function text_message($data)
    {
        $number = intval(preg_replace('/[^0-9]+/', '', $data['phone_number']), 10);

        $data = array(
            'User'          => 'kostivlaw18',
            'Password'      => 'wilshire3450',
            'PhoneNumbers'  => array($number),
            'Subject'       => 'Kostiv & Associates',
            'Message'       => $data['message'],
            'StampToSend'   => '1305582245',
            'MessageTypeID' => 3,
        );

        $curl = curl_init('https://app.eztexting.com/sending/messages?format=json');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // If you experience SSL issues, perhaps due to an outdated SSL cert
        // on your own server, try uncommenting the line below
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($response);
        $json = $json->Response;

        if ('Failure' == $json->Status) {
            $errors = array();

            if (!empty($json->Errors)) {
                $errors = $json->Errors;
            }

            $final_response = (array(
                'status' => $json->Status,
                'errors' => implode(', ', $errors),
            ));
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

            $final_response = (array(
                'status'                     => $json->Status,
                'message_id'                 => $json->Entry->ID,
                'subject'                    => $json->Entry->Subject,
                'message'                    => $json->Entry->Message,
                'message_type_id'            => $json->Entry->MessageTypeID,
                'total_recipients'           => $json->Entry->RecipientsCount,
                'credits_charged'            => $json->Entry->Credits,
                'time_to_send'               => $json->Entry->StampToSend,
                'phone_numbers'              => implode(', ', $phoneNumbers),
                'groups'                     => implode(', ', $groups),
                'locally_opted_out_numbers'  => implode(', ', $localOptOuts),
                'globally_opted_out_numbers' => implode(', ', $globalOptOuts),
            ));
        }

        return $final_response;
    }
}
