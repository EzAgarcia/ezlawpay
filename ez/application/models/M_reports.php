<?php
class M_reports extends CI_Model
{
    public function clients_sign_today()
    {
        $query  = "SELECT t_contracts.ID, t_contracts.Balance_Amount, t_contracts.Contract_N , t_contracts.Value,t_contracts.Montly_Amount, t_contracts.Date_Montly_P, t_contracts.Frequency_ID,  t_client.C_Name, t_contracts.Sign_Date, catt_status.Status, t_contracts.Receivable_Amount FROM t_contracts INNER JOIN t_client ON t_contracts.Client_ID = t_client.ID INNER JOIN t_users ON t_contracts.Registered_By_ID = t_users.ID INNER JOIN catt_status ON catt_status.ID=t_contracts.status_ID WHERE t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' AND YEARWEEK(t_contracts.Sign_Date, 1)=YEARWEEK(CURDATE(), 1) ORDER BY t_contracts.ID DESC";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function ultimo_square()
    {
        $query  = "select date from dashboard_square order by date desc limit 1";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function totalincome($anio, $mes)
    {

        $query = "SELECT SUM(mount) as total FROM payment_square WHERE date LIKE '%" . $anio . "-" . $mes . "%'";

        $result = $this->db->query($query)->result();

        return $result[0]->total;

    }

    public function paid()
    {

        $query  = "select COUNT(ID) AS total from t_contracts where Status_ID=1";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }

    }

    public function ultimo_square2()
    {
        $query  = "select date from daily_save_dashboard_payments order by date desc limit 1";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function totalpaymentmensual($anio, $mes)
    {

        $query = "SELECT SUM(Montly_Amount) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $result = $this->db->query($query)->result();

        return $result[0]->total;

    }

    public function nopaymenttt($anio, $mes)
    {

        $contador = 0;

        $query = "SELECT Contract_ID FROM t_initial_payments WHERE Initial_Pay_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $arreglo = $this->db->query($query)->result();

        foreach ($arreglo as $key) {

            $query  = "SELECT Initial_Pay_Date FROM t_initial_payments WHERE Contract_ID = '" . $key->Contract_ID . "' LIMIT 1";
            $result = $this->db->query($query)->result();

            $fecha_actual  = strtotime($inicio);
            $fecha_entrada = strtotime($result[0]->Initial_Pay_Date);

            if ($fecha_actual == $fecha_entrada) {

                $query = "SELECT ID FROM t_contracts WHERE ID = '" . $key->Contract_ID . "' AND Value = Balance_Amount";
                $nuevo = $this->db->query($query)->result();

                if (!empty($nuevo)) {
                    $contador = $contador + 1;

                }

            }

        }

        return $contador;

    }

    public function invoicessumar()
    {

        $fecha = date('Y-m');

        $query = "SELECT SUM(monto) as total FROM t_billsg WHERE fechap LIKE '%" . $fecha . "%' AND id_pago = 0";

        $result = $this->db->query($query)->result();

        return $result[0]->total;

    }

    public function totalmescon($anio, $mes)
    {

        $query = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%' AND Client_ID !=0";

        $result = $this->db->query($query)->result();

        return $result[0]->total;

    }

    public function totalonhold($anio, $mes)
    {

        $query = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%' AND Status_ID =2";

        $result = $this->db->query($query)->result();

        return $result[0]->total;

    }

    public function totalfinanpromedio($anio, $mes)
    {

        $query = "SELECT SUM(Value) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $result = $this->db->query($query)->result();

        $query = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $contract = $this->db->query($query)->result();

        $promedio = $result[0]->total / $contract[0]->total;

        return $promedio;

    }

    public function totalpaypromedio($anio, $mes)
    {

        $query = "SELECT SUM(Montly_Amount) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $result = $this->db->query($query)->result();

        $query = "SELECT COUNT(*) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $contract = $this->db->query($query)->result();

        $promedio = $result[0]->total / $contract[0]->total;

        return $promedio;
    }

    public function totalfinancial($anio, $mes)
    {

        $query = "SELECT SUM(Value) as total FROM t_contracts WHERE Sign_Date LIKE '%" . $anio . "-" . $mes . "%'";

        $result = $this->db->query($query)->result();

        return $result[0]->total;

    }

    public function servicios($start_date = '', $end_date = '')
    {
        $services = [];
        $counter  = 0;
        $tag      = [];
        $data     = [];

        $this->db->select('cs.Service_Description AS description, count(ts.Contract_ID) AS amount');
        $this->db->from('t_services as ts');
        $this->db->join('catt_services as cs', 'cs.ID = ts.Services_ID');
        $this->db->join('t_contracts as tc', 'tc.ID = ts.Contract_ID');

        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('tc.Sign_Date >= ', $start_date);
            $this->db->where('tc.Sign_Date <= ', $end_date);
        }

        $this->db->group_by('cs.Service_Description');

        $raw_data   = $this->db->get();
        $query_data = $raw_data->result();

        foreach ($query_data as $service) {
            $tag[$counter]  = $service->description;
            $data[$counter] = $service->amount;

            $services = ['tag' => $tag, 'data' => $data];
            $counter++;
        }

        return $services;
    }

    public function datosx()
    {

        $arreglo = [];
        $count   = 0;
        $cadena  = "SELECT COUNT(*) AS conteo FROM t_services GROUP BY Services_ID HAVING COUNT(*) > 1 ORDER BY Services_ID";

        $valor = $this->db->query($cadena)->result();

        foreach ($valor as $key) {
            $arreglo[$count] = $key->conteo;

            $count++;
        }

        return $arreglo;
    }

    public function count_sign_today()
    {
        $query  = "select count(t_contracts.Contract_N) as total, sum(t_contracts.Value) as mountly from t_contracts where YEARWEEK(t_contracts.Sign_Date, 1)=YEARWEEK(CURDATE(), 1)";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function paymentsmethods()
    {
        $query = "select  sum(mount) as total, type from daily_save_dashboard_payments  where date BETWEEN '" . date('Y') . "-" . date('m') . "-" . date('d') . " 09:30:00' and '" . date('Y') . "-" . date('m') . "-" . date('d') . " 23:59:59' group by type ";

        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function suma()
    {

        $hoy    = date('Y-m-d');
        $nuevad = 0;
        $suma   = 0;

        $cadena = "SELECT t_contracts.ID FROM t_contracts, t_users WHERE t_contracts.Next_Date ='" . $hoy . "' AND t_contracts.Registered_By_ID = t_users.ID AND t_contracts.Status_ID IN(3,4) AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "'";
        $deuda  = $this->db->query($cadena)->result();

        foreach ($deuda as $key) {

            $cadena    = "SELECT Initial_Pay_Date, Initial_Pay_Amount FROM t_initial_payments WHERE Initial_Pay_Date = '" . $hoy . "' AND Contract_ID='" . $key->ID . "' ORDER By Initial_Pay_Date ASC LIMIT 1";
            $actulizaf = $this->db->query($cadena)->result();

            if (!empty($actulizaf[0]->Initial_Pay_Date)) {

                $suma = $suma + ($actulizaf[0]->Initial_Pay_Amount);

                $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                $valrecei = $this->db->query($cadena1)->result();

                if ($valrecei[0]->Receivable_Amount <= 0) {

                } else {

                    $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                    $text = $this->db->query($info)->result();

                }
            } else {

                $sing       = "SELECT Date_Montly_P, Montly_Amount FROM t_contracts WHERE ID ='" . $key->ID . "' AND  Date_Montly_P = '" . $hoy . "'";
                $resultsing = $this->db->query($sing)->result();

                if (!empty($resultsing)) {

                    $suma = $suma + ($resultsing[0]->Montly_Amount);

                    $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                    $valrecei = $this->db->query($cadena1)->result();

                    if ($valrecei[0]->Receivable_Amount <= 0) {

                    } else {

                        $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                        $text = $this->db->query($info)->result();

                    }

                } else {

                    $addval    = "SELECT Next_Date, Frequency_ID, Montly_Amount, Receivable_Amount, Value, Balance_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                    $resulnext = $this->db->query($addval)->result();

                    if ($resulnext[0]->Balance_Amount >= $resulnext[0]->Montly_Amount) {

                        if ($resulnext[0]->Value == $resulnext[0]->Receivable_Amount) {

                        } else {

                            $suma = $suma + ($resulnext[0]->Montly_Amount);

                        }

                        $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        if ($valrecei[0]->Receivable_Amount <= 0) {

                        } else {

                            $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                            $text = $this->db->query($info)->result();

                        }

                    } else {

                        $suma = $suma + ($resulnext[0]->Balance_Amount);

                        $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        if ($valrecei[0]->Receivable_Amount <= 0) {

                        } else {

                            $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                            $text = $this->db->query($info)->result();

                        }

                    }

                }
            }

        }

        return $suma;

        // $this->cobrarfees();
    }

    public function mensajesaldia()
    {
        $cadena = "SELECT COUNT(*) as suma FROM t_phone_messages WHERE DATE(Created_at) = CURDATE()";
        $suma   = $this->db->query($cadena)->result();
        return $suma;

    }

    public function mensajesmes()
    {
        $cadena = "SELECT COUNT(*) as suma FROM t_phone_messages WHERE EXTRACT(YEAR_MONTH FROM Created_at) = EXTRACT(YEAR_MONTH FROM NOW())";
        $suma   = $this->db->query($cadena)->result();
        return $suma;

    }

    public function mensajessemana()
    {
        $cadena = "SELECT COUNT(*) as suma FROM t_phone_messages WHERE YEARWEEK(NOW(), 1) = YEARWEEK(Created_at, 1)";
        $suma   = $this->db->query($cadena)->result();
        return $suma;

    }

    public function aldia()
    {

        $hoy    = date('Y-m-d');
        $nuevad = 0;
        $suma   = 0;
        $data   = [];
        $cont   = 0;

        ////// SE SELECCIONAN TODOD LOS CONTRATOS QUE TENGAN LA FECHA DE HON EN EL CAMPO DE Next_Date   ////////////// SELECT t_contracts.ID, t_contracts.Contract_N FROM t_contracts, t_users WHERE t_contracts.Next_Date ='2020-02-12' AND t_contracts.Registered_By_ID = t_users.ID AND t_contracts.Status_ID IN(3,4) AND t_users.Company = 1 AND t_contracts.Value != 0 AND t_contracts.Montly_Amount != 0

        $cadena = "SELECT t_contracts.ID, t_contracts.Contract_N FROM t_contracts, t_users WHERE t_contracts.Next_Date ='" . $hoy . "' AND t_contracts.Registered_By_ID = t_users.ID AND t_contracts.Status_ID IN(3,4) AND t_users.Company = '" . $_SESSION['ezlow']['lawfirm'] . "' AND t_contracts.Value != 0 AND t_contracts.Montly_Amount != 0";
        $deuda  = $this->db->query($cadena)->result();

        ///////  SE RECORREN TODOS LOS CONTRATOS PARA GENERARLES UN BILL  ///////////////////////////////////////

        foreach ($deuda as $key) {

            ////   SE VALIDA SI ALGUN PAGO INICIAL CORRESPONDE AL DIA DE HOY   //////////////////

            $cadena    = "SELECT Initial_Pay_Date, Initial_Pay_Amount FROM t_initial_payments WHERE Initial_Pay_Date = '" . $hoy . "' AND Contract_ID='" . $key->ID . "' ORDER By Initial_Pay_Date ASC LIMIT 1";
            $actulizaf = $this->db->query($cadena)->result();

            if (!empty($actulizaf[0]->Initial_Pay_Date)) {

                $cadena1  = "SELECT t_client.C_Name FROM t_client, t_contracts WHERE t_contracts.Client_ID = t_client.ID AND t_contracts.ID ='" . $key->ID . "'";
                $valrecei = $this->db->query($cadena1)->result();

                $data[$cont] = array("Contrato" => $key->Contract_N, "Initial_Pay_Date" => $actulizaf[0]->Initial_Pay_Date, "Initial_Pay_Amount" => $actulizaf[0]->Initial_Pay_Amount, "Nombre" => $valrecei[0]->C_Name, "Tipo" => 1, "ID" => $key->ID);
                $suma        = $suma + ($actulizaf[0]->Initial_Pay_Amount);

            } else {

                $sing       = "SELECT Date_Montly_P, Montly_Amount FROM t_contracts WHERE ID ='" . $key->ID . "' AND  Date_Montly_P = '" . $hoy . "'";
                $resultsing = $this->db->query($sing)->result();

                if (!empty($resultsing)) {

                    $cadena1  = "SELECT t_client.C_Name FROM t_client, t_contracts WHERE t_contracts.Client_ID = t_client.ID AND t_contracts.ID ='" . $key->ID . "'";
                    $valrecei = $this->db->query($cadena1)->result();

                    $data[$cont] = array("Contrato" => $key->Contract_N, "Initial_Pay_Date" => $resultsing[0]->Date_Montly_P, "Initial_Pay_Amount" => $resultsing[0]->Montly_Amount, "Nombre" => $valrecei[0]->C_Name, "Tipo" => 0, "ID" => $key->ID);

                    $suma = $suma + ($resultsing[0]->Montly_Amount);

                    $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                    $valrecei = $this->db->query($cadena1)->result();

                    if ($valrecei[0]->Receivable_Amount <= 0) {

                    } else {

                        $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                        $text = $this->db->query($info)->result();

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

                            // print_r('expression'); /// Error

                        } else {
                            ///////// SE CREA EL BILL CORRESPONDIENTE DEL PAGO /////////////////

                            // $crearbill = "INSERT INTO t_bills(Bill_Date, Contract_ID, Bill_Amount, Viewed) VALUES ('".$resulnext[0]->Next_Date."', '".$key->ID."',  '".$resulnext[0]->Montly_Amount."', 0 )";

                            // $this->db->query($crearbill);

                            $cadena1  = "SELECT t_client.C_Name FROM t_client, t_contracts WHERE t_contracts.Client_ID = t_client.ID AND t_contracts.ID ='" . $key->ID . "'";
                            $valrecei = $this->db->query($cadena1)->result();

                            $data[$cont] = array("Contrato" => $key->Contract_N, "Initial_Pay_Date" => $resulnext[0]->Next_Date, "Initial_Pay_Amount" => $resulnext[0]->Montly_Amount, "Nombre" => $valrecei[0]->C_Name, "Tipo" => 0, "ID" => $key->ID);

                            $suma = $suma + ($resulnext[0]->Montly_Amount);

                            // $crearlate = "INSERT INTO t_late_fees(Contract_ID, Date, activo) VALUES ('".$key->ID."', '".$resulnext[0]->Next_Date."', 0)";
                            // $this->db->query($crearlate);

                            /////////////////// SE ACTUALIZA LA DEUDA AL DIA DE CADA CONTRATO ///////////////////

                            // $chan = "UPDATE t_contracts SET Receivable_Amount = (Receivable_Amount + '".$resulnext[0]->Montly_Amount."') WHERE ID = '".$key->ID."'";
                            // $this->db->query($chan);

                        }

                        ////////////// SE OBTIENE LA DEUDA AL DIA PARA SABER CUANTO SE LE DEBE DE COBRAR A LA PERSONA ////////////

                        $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        /////////////// SE REALIZA LA COMPARACION PARA SABER SI SE LE DEBE DE MANDAR EL MENSAJE O NO /////////////

                        if ($valrecei[0]->Receivable_Amount <= 0) {

                            //////////// AL NO DEBER NADA, NO SE LE ENVIA MENSAJE ///////////////

                            // print_r('success');
                        } else {

                            //////// AL TENER DEUDA, SE LE ENVIARA EL MENSAJE DE TEXTO CON LA DEUDA A PAGAR /////////////

                            // $info = "";
                            $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                            $text = $this->db->query($info)->result();

                        }

                    } else {

                        $cadena1  = "SELECT t_client.C_Name FROM t_client, t_contracts WHERE t_contracts.Client_ID = t_client.ID AND t_contracts.ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        $data[$cont] = array("Contrato" => $key->Contract_N, "Initial_Pay_Date" => $resulnext[0]->Next_Date, "Initial_Pay_Amount" => $resulnext[0]->Balance_Amount, "Nombre" => $valrecei[0]->C_Name, "Tipo" => 0, "ID" => $key->ID);

                        $suma = $suma + ($resulnext[0]->Balance_Amount);

                        $cadena1  = "SELECT Receivable_Amount FROM t_contracts WHERE ID ='" . $key->ID . "'";
                        $valrecei = $this->db->query($cadena1)->result();

                        if ($valrecei[0]->Receivable_Amount <= 0) {

                        } else {

                            $info = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Phone_Number FROM t_contracts, t_client WHERE t_contracts.Client_ID =t_client.ID AND t_contracts.ID = '" . $key->ID . "'";
                            $text = $this->db->query($info)->result();

                        }

                    }

                }
            }

            $cont = $cont + 1;

        }

        return $data;

    }

    public function clean_persons()
    {
        $result = $this->db->query('truncate person_square');
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    public function insert_persons_square($data)
    {
        $query  = "INSERT INTO person_square (id_square, name) VALUES ('" . $data['id'] . "', '" . $data['name'] . "')";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function save_dashboard_payments($data)
    {
        return $this->insert_last_square2($data);
    }

    public function insert_last_square2($data)
    {
        $local_date   = $this->local_date($data['date']);
        $raw_datetime = new DateTime($data['date']);
        $date         = $raw_datetime->format('Y-m-d H:i:s');

        if ($this->avoid_duplicated_payments($data)) {
            return false;
        }

        $query  = "insert into daily_save_dashboard_payments (type, date, local_date, mount ) values ('" . $data['type'] . "', '" . $date . "', '" . $local_date . "', '" . $data['mount'] . "')";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function insert_last_square($data)
    {
        $local_date   = $this->local_date($data['date']);
        $raw_datetime = new DateTime($data['date']);
        $date         = $raw_datetime->format('Y-m-d H:i:s');

        if ($this->avoid_duplicated_payments($data)) {
            return false;
        }

        $query  = "insert into daily_save_dashboard_payments (type, date, local_date, mount ) values ('" . strtoupper($data['type']) . "', '" . $date . "', '" . $local_date . "', '" . $data['mount'] . "')";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getTeamSalesToday()
    {
        $query  = "select person_square.name as Employee_Name, sum(dashboard_square.amount) as total, count(dashboard_square.employee) as sale_count from dashboard_square inner join person_square on dashboard_square.employee=person_square.id_square  where dashboard_square.date BETWEEN '" . date('Y') . "-" . date('m') . "-" . date('d') . " 00:00:00' and '" . date('Y') . "-" . date('m') . "-" . date('d') . " 23:59:59' group by Employee_Name";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }

    }
    public function getTeamSalesThisWeek()
    {
        $query  = "select person_square.name as Employee_Name, sum(dashboard_square.amount) as total, count(dashboard_square.employee) as sale_count from dashboard_square inner join person_square on dashboard_square.employee=person_square.id_square  where  YEARWEEK(dashboard_square.date, 1) = YEARWEEK(CURDATE(), 1) group by Employee_Name";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function getTeamSalesThisMonth()
    {
        $query  = "select person_square.name as Employee_Name, sum(dashboard_square.amount) as total, count(dashboard_square.employee) as sale_count from dashboard_square inner join person_square on dashboard_square.employee=person_square.id_square  where  YEAR(dashboard_square.date) = YEAR(CURDATE()) group by Employee_Name";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function getTeamSalesThisYear()
    {
        $query  = "select person_square.name as Employee_Name, sum(dashboard_square.amount) as total, count(dashboard_square.employee) as sale_count from dashboard_square inner join person_square on dashboard_square.employee=person_square.id_square  where  MONTH(dashboard_square.date) = MONTH(CURDATE()) group by Employee_Name";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function contracts_hold()
    {
        $query  = "select count(*) as total from t_contracts inner join t_users on t_contracts.Registered_By_ID=t_users.ID where t_contracts.Status_ID='2' and t_users.Company='" . $this->session->ezlow['lawfirm'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function overdue()
    {
        $query  = "select count(*) as total from t_contracts inner join t_users on t_contracts.Registered_By_ID=t_users.ID where t_contracts.Status_ID='4' and t_users.Company='" . $this->session->ezlow['lawfirm'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }

    }

    public function uptodate()
    {
        $query  = "select count(*) as total from t_contracts inner join t_users on t_contracts.Registered_By_ID=t_users.ID where t_contracts.Status_ID='3' and t_users.Company='" . $this->session->ezlow['lawfirm'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function contracts_cancel()
    {
        $query  = "select count(*) as total from t_contracts inner join t_users on t_contracts.Registered_By_ID=t_users.ID where t_contracts.Status_ID='6' and t_users.Company='" . $this->session->ezlow['lawfirm'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function contracts_active()
    {
        $query = "select count(*) as total from t_contracts inner join t_users on t_contracts.Registered_By_ID=t_users.ID where t_users.Company='" . $this->session->ezlow['lawfirm'] . "' and t_contracts.Status_ID<>'6' and t_contracts.Status_ID<>'2'";

        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function pending_today()
    {
        $query  = "select SUM(Receivable_Amount) AS TOTAL from t_contracts where Next_Date=CURDATE()";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }

    }

    public function invoice_monthly_total()
    {
        $query  = "SELECT sum(tb.Bill_Amount) AS total FROM t_contracts AS tc JOIN t_bills AS tb ON tb.Contract_ID = tc.ID WHERE LAST_DAY(tb.Bill_Date) = LAST_DAY(NOW()) AND tc.Receivable_Amount > 0";
        $result = $this->db->query($query);
        $total  = !empty($result) ? $result->result()[0]->total : 0;
        return $total;
    }

    public function monthly_bills()
    {
        $month = isset($_REQUEST['month']) && !empty($_REQUEST['month']) ? $_REQUEST['month'] : date('m');
        $year  = isset($_REQUEST['year']) && !empty($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');

        if ($month != '' || $year != '') {
            $default_day = '1';
            $time        = strtotime($year . '-' . $month . '-' . $default_day);
            $search_date = date('Y-m-d', $time);

            $query = "SELECT tc.ID, tb.Bill_Amount, tb.Bill_Date, tc.Contract_N, tcl.C_Name, tb.Type  FROM  t_bills AS tb INNER JOIN t_contracts AS tc ON  tc.ID = tb.Contract_ID INNER JOIN t_client AS tcl ON  tcl.ID = tc.Client_ID WHERE LAST_DAY(tb.Bill_Date) = LAST_DAY('" . $search_date . "')";
        } else {
            $query = "SELECT tc.ID, tb.Bill_Amount, tb.Bill_Date, tc.Contract_N, tcl.C_Name, tb.Type  FROM  t_bills AS tb INNER JOIN t_contracts AS tc ON  tc.ID = tb.Contract_ID INNER JOIN t_client AS tcl ON  tcl.ID = tc.Client_ID WHERE LAST_DAY(tb.Bill_Date) = LAST_DAY(NOW())";
        }

        $result = $this->db->query($query);
        if (empty($result)) {
            return false;
        }

        $data['month'] = $month;
        $data['year']  = $year;
        $data['info']  = $result->result();
        return $data;
    }

    public function cronjob($fn)
    {
        $data = array('function' => $fn);
        $this->db->insert('cronjob', $data);
    }

    public function daily_transactions()
    {
        $db            = 'daily_save_dashboard_payments';
        $types         = array('CARD', 'CASH', 'OTHER');
        $search_period = array('day', 'week', 'month', 'year');
        $data          = [];

        foreach ($search_period as $period) {
            $data['$period'] = [];

            foreach ($types as $type) {
                $this->db->select('sum(mount) as amount');
                $this->db->from($db);

                if ($period == 'day') {
                    $this->db->where('YEAR(local_date) = YEAR(NOW()) AND MONTH(local_date) = MONTH(NOW()) AND DAY(local_date) = DAY(NOW())');
                }

                if ($period == 'week') {
                    $week_stars = date("Y-m-d", strtotime('sunday last week'));
                    $week_ends  = date("Y-m-d", strtotime('saturday this week'));

                    $this->db->where('YEAR(local_date) = YEAR(NOW())');
                    $this->db->where('local_date >=', $week_stars);
                    $this->db->where('local_date <=', $week_ends);
                }

                if ($period == 'month') {
                    $this->db->where('YEAR(local_date) = YEAR(NOW()) AND MONTH(local_date)=MONTH(NOW())');
                }

                if ($period == 'year') {
                    $this->db->where('YEAR(local_date) = YEAR(CURDATE())');
                }

                $this->db->where('type', $type);
                $this->db->group_by("type");

                $query    = $this->db->get();
                $raw_data = $query->result();

                $data[$period][$type] = $raw_data;
            }
        }

        return $data;
    }

    private function local_date($raw_date)
    {
        $raw_datetime = new DateTime($raw_date, new DateTimeZone('UTC'));
        $datetime     = $raw_datetime->setTimezone(new DateTimeZone('America/Mexico_City'));

        return $datetime->format('Y-m-d H:i:s');
    }

    private function avoid_duplicated_payments($payment)
    {
        $datetime = new DateTime($payment['date']);
        $date     = $datetime->format('Y-m-d H:i:s');

        $conditional = array('type' => strtoupper($payment['type']), 'date' => $date, 'mount' => $payment['mount']);
        $this->db->select('type as type, DATE_FORMAT("date", "%Y-%m-%d %H:%i:%s") as date, mount as mount')->from('daily_save_dashboard_payments')->where($conditional);
        $result = $this->db->get();

        $response = $result->num_rows() > 0 ? true : false;

        return $response;
    }
}
