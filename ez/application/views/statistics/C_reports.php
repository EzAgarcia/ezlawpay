<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_reports extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_square');
        $this->load->model('M_reports');
        $this->load->model('M_contracts');
	$this->load->model('M_phone_message');
	$this->load->model('M_excel_reports');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }

    public function clients_sign_today(){
    	$data['today']=$this->M_reports->clients_sign_today();
    	$data['content']=$this->load->view('reports/clients_sign_today', $data, true);
    	$this->load->view('template',$data);
    }
    public function transactions(){
    	$data['content']=$this->load->view('reports/transactions',null, true);
    	$this->load->view('template',$data);
    }
    public function by_users(){

    	$check = $this->M_square->validacion();

    	if ($check == 0) {
    		    	
    	
    	$data["square"] = $this->M_square->getConfiguration();
  		$this->M_reports->clean_persons();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://connect.squareup.com/v2/employees",

			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Accept: */*",
				"Accept-Encoding: gzip, deflate",
				"Authorization: Bearer ".$data['square']->result()[0]->fcPersonalAccessToken,
				"Cache-Control: no-cache",
				"Connection: keep-alive",
				"Host: connect.squareup.com",
				"Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
				"User-Agent: PostmanRuntime/7.20.1",
				"cache-control: no-cache"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$array=json_decode($response,true);
			foreach ($array as $persons) {
				foreach ($persons as $person) {
					$id=$person['id'];
					$name=$person['first_name'].' '.$person['last_name'];
					$insert=array(
						'id'=>$id,
						'name'=>$name
					);
					$this->M_reports->insert_persons_square($insert);
				}		
			}
		}

		$last=$this->M_reports->ultimo_square();

		
	
		if ($last->num_rows()>0) {
			$raw_date=$last->result()[0]->date;
			$date = $this->dashboard_payments_date($raw_date);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://connect.squareup.com/v2/payments?begin_time=".$date,

				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Accept: */*",
					"Accept-Encoding: gzip, deflate",
					"Authorization: Bearer ".$data['square']->result()[0]->fcPersonalAccessToken,
					"Cache-Control: no-cache",
					"Connection: keep-alive",
					"Host: connect.squareup.com",
					"Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
					"User-Agent: PostmanRuntime/7.20.1",
					"cache-control: no-cache"
				),
			));
			$otro=0;

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				$array=json_decode($response,true);

				
				if (isset($array['cursor'])){
					$cursor=$array['cursor'];
				}else{
					$cursor='';
				}
				

				foreach ($array as $value) {
					if (is_array($value)){
						foreach ($value as $registrer) {
							
							if ($registrer['status']=='COMPLETED'){

							
								$mount=substr($registrer['amount_money']['amount'],0,-2);
								$da=array(
									'id'=>$registrer['employee_id'],
									'mount'=>$mount,
									'type'=>'card',
									'date'=>$registrer['created_at']

								);
								
								$this->M_reports->insert_last_square($da);
							}
								
						}
					}
						
				}
				while ($cursor!='') {
				   	$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://connect.squareup.com/v2/payments?begin_time=".$date."&cursor=".$cursor,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "GET",
						CURLOPT_HTTPHEADER => array(
							"Accept: */*",
							"Accept-Encoding: gzip, deflate",
							"Authorization: Bearer ".$data['square']->result()[0]->fcPersonalAccessToken,
							"Cache-Control: no-cache",
							"Connection: keep-alive",
							"Host: connect.squareup.com",
							"Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
							"User-Agent: PostmanRuntime/7.20.1",
							"cache-control: no-cache"
						),
					));
					$response2 = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					if ($err) {
						echo "cURL Error #:" . $err;
					} else {
						$array1=json_decode($response2,true);
						foreach ($array1 as $value1) {
							if (is_array($value1)){
								foreach ($value1 as $registrer1) {
									if (!isset($registrer1['employee_id'])){
										$otro=$otro+substr($registrer1['amount_money']['amount'],0,-2);
									}else{
										if ($registrer['status']=='COMPLETED'){

											$employed=$registrer1['employee_id'];
											$mount=substr($registrer1['amount_money']['amount'],0,-2);
											$da=array(
												'id'=>$employed,
												'mount'=>$mount,
												'type'=>'card',
												'date'=>$registrer['created_at']
											);
											
											$this->M_reports->insert_last_square($da);
										}
									}
										
								}
							}
								
						}
						if (isset($array1['cursor'])){
							$cursor=$array1['cursor'];
						}else{
							$cursor='';
						}
					}
				}
			}
		}else{
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://connect.squareup.com/v2/payments?begin_time=".date('Y')."-01-01T00:00:00&end_time=".date('Y')."-12-31T23:59",

				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Accept: */*",
					"Accept-Encoding: gzip, deflate",
					"Authorization: Bearer ".$data['square']->result()[0]->fcPersonalAccessToken,
					"Cache-Control: no-cache",
					"Connection: keep-alive",
					"Host: connect.squareup.com",
					"Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
					"User-Agent: PostmanRuntime/7.20.1",
					"cache-control: no-cache"
				),
			));
			$otro=0;

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				$array=json_decode($response,true);

				
				if (isset($array['cursor'])){
					$cursor=$array['cursor'];
				}else{
					$cursor='';
				}
				

				foreach ($array as $value) {
					if (is_array($value)){
						foreach ($value as $registrer) {
							
							if ($registrer['status']=='COMPLETED'){

							
								$mount=substr($registrer['amount_money']['amount'],0,-2);
								$da=array(
									'id'=>$registrer['employee_id'],
									'mount'=>$mount,
									'type'=>'card',
									'date'=>$registrer['created_at']

								);
								
								$this->M_reports->insert_last_square($da);
							}
								
						}
					}
						
				}
				while ($cursor!='') {
				   	$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://connect.squareup.com/v2/payments?begin_time=".date('Y')."-01-01T00:00:00&end_time=".date('Y')."-12-31T23:59&cursor=".$cursor,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "GET",
						CURLOPT_HTTPHEADER => array(
							"Accept: */*",
							"Accept-Encoding: gzip, deflate",
							"Authorization: Bearer ".$data['square']->result()[0]->fcPersonalAccessToken,
							"Cache-Control: no-cache",
							"Connection: keep-alive",
							"Host: connect.squareup.com",
							"Postman-Token: 4644179e-faa2-4200-ba19-c475fb0d5a03,ab4e6a57-5cd7-431f-a4ff-081c0640eae4",
							"User-Agent: PostmanRuntime/7.20.1",
							"cache-control: no-cache"
						),
					));
					$response2 = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					if ($err) {
						echo "cURL Error #:" . $err;
					} else {
						$array1=json_decode($response2,true);
						foreach ($array1 as $value1) {
							if (is_array($value1)){
								foreach ($value1 as $registrer1) {
									if (!isset($registrer1['employee_id'])){
										$otro=$otro+substr($registrer1['amount_money']['amount'],0,-2);
									}else{
										if ($registrer['status']=='COMPLETED'){

											$employed=$registrer1['employee_id'];
											$mount=substr($registrer1['amount_money']['amount'],0,-2);
											$da=array(
												'id'=>$employed,
												'mount'=>$mount,
												'type'=>'card',
												'date'=>$registrer['created_at']
											);
											
											$this->M_reports->insert_last_square($da);
										}
									}
										
								}
							}
								
						}
						if (isset($array1['cursor'])){
							$cursor=$array1['cursor'];
						}else{
							$cursor='';
						}
					}
				}
			}
		}

		$this->M_square->changestatus();


	}


			

		// $data['teamSalesToday'] = $this->M_reports->getTeamSalesToday();
		// $data['teamSalesThisweek'] = $this->M_reports->getTeamSalesThisWeek();
		// $data['teamSalesThisMonth'] = $this->M_reports->getTeamSalesThisMonth();
		// $data['teamSalesThisYear'] = $this->M_reports->getTeamSalesThisYear();
		
		$data['transactions'] = $this->M_reports->daily_transactions();
		$data['content'] = $this->load->view('reports/users', $data, true);
		$this->load->view('template', $data);
		
    }

	public function monthly_bills(){
		$data['monthly']=$this->M_reports->monthly_bills();
		$data['content']=$this->load->view('reports/monthly_bills', $data, true);

		$this->load->view('template',$data);
	}

	public function aldia(){

    	$data['registros'] = $this->M_reports->aldia();
    	$data['content'] = $this->load->view('reports/aldia' , $data, true);
    	$this->load->view('template',$data);
    }

	public function phone_messages(){
		$data = array();
		$data['content']=$this->load->view('reports/phone_messages',$data, true);
		$this->load->view('template',$data);
	}

	public function message_list(){
		$list = $this->M_phone_message->json_list();

		print_r($list);
		return  $list;
	}

	public function mobil_message(){
		$message = $this->M_phone_message->message();

		return  $message;
	}

	public function download_excel(){
		ob_start();
		$this->create_file();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}

	public function download_excelpayments(){
		ob_start();
		$this->create_filepayments();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}


	public function download_excelincome(){
		ob_start();

		$this->create_fileincome();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}

	

	public function download_excelsinpay(){

		ob_start();

		$this->create_filesinpay();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}

	public function download_financial(){

		ob_start();

		$this->create_filefinancial();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}



	public function download_newhold(){

		ob_start();

		$this->create_fileonhold();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}

	public function download_excelnewcontract(){
		ob_start();

		$this->create_filecontracts();
		$fileurl    = APPPATH.'/reports/contract_report.xls';
		$file_name  = 'contract_report_'.date('Y-m-d').'.xls';

		$data = file_get_contents($fileurl);
		force_download($file_name, $data);
	}

	

	private function create_filesinpay() {


			$arregloc = array();

		



			if ($_REQUEST["year"] == '0' AND $_REQUEST['mes'] == '0') {
             $anio = date("Y");
        $mes = date("m");
        if ($mes == 1) {

            $mes  = 12;
            $anio = $anio-1;

        }else{

            $mes = $mes-1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio); 

        $fecha1 = $anio."-".$mes2."-01";
        $fecha2 = $anio."-".$mes2."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];


        


              
                $info = $this->M_contracts->contractnopay($anio , $mes2);
                


       

        }else{


        
        $number = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['mes'], $_REQUEST["year"]); 

        $fecha1 = $_REQUEST["year"]."-".$_REQUEST['mes']."-1";
        $fecha2 = $_REQUEST["year"]."-".$_REQUEST['mes']."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];
       
        

                  $info = $this->M_contracts->contractnopay($anio , $mes2);
                
              

           


        
        }

        

        	
			$this->M_excel_reports->graphics_report_by_sinpay($info);

			return '';
		
	}

	private function create_filepayments() {

			$arregloc = array();

		



			if ($_REQUEST["year"] == '0' AND $_REQUEST['mes'] == '0') {
             $anio = date("Y");
        $mes = date("m");
        if ($mes == 1) {

            $mes  = 12;
            $anio = $anio-1;

        }else{

            $mes = $mes-1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio); 

        $fecha1 = $anio."-".$mes2."-01";
        $fecha2 = $anio."-".$mes2."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];

        do {

            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->newpayment($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


       

        }else{


        
        $number = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['mes'], $_REQUEST["year"]); 

        $fecha1 = $_REQUEST["year"]."-".$_REQUEST['mes']."-1";
        $fecha2 = $_REQUEST["year"]."-".$_REQUEST['mes']."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];
       
        


        do {


            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->newpayment($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


        
        }

			$this->M_excel_reports->graphics_report_by_payments($arreglo);

			return '';
		
	}

	private function create_filecontracts() {

			$arregloc = array();

		



			if ($_REQUEST["year"] == '0' AND $_REQUEST['mes'] == '0') {
             $anio = date("Y");
        $mes = date("m");
        if ($mes == 1) {

            $mes  = 12;
            $anio = $anio-1;

        }else{

            $mes = $mes-1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio); 

        $fecha1 = $anio."-".$mes2."-01";
        $fecha2 = $anio."-".$mes2."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];

        do {

            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->totalnewcontracts($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


       

        }else{


        
        $number = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['mes'], $_REQUEST["year"]); 

        $fecha1 = $_REQUEST["year"]."-".$_REQUEST['mes']."-1";
        $fecha2 = $_REQUEST["year"]."-".$_REQUEST['mes']."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];
       
        


        do {


            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->totalnewcontracts($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


        
        }

			$this->M_excel_reports->graphics_report_by_newcontract($arreglo);

			return '';
		
	}

	private function create_filefinancial() {

			$arregloc = array();

		



			if ($_REQUEST["year"] == '0' AND $_REQUEST['mes'] == '0') {
             $anio = date("Y");
        $mes = date("m");
        if ($mes == 1) {

            $mes  = 12;
            $anio = $anio-1;

        }else{

            $mes = $mes-1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio); 

        $fecha1 = $anio."-".$mes2."-01";
        $fecha2 = $anio."-".$mes2."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];

        do {

            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->totalfinanci($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


       

        }else{


        
        $number = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['mes'], $_REQUEST["year"]); 

        $fecha1 = $_REQUEST["year"]."-".$_REQUEST['mes']."-1";
        $fecha2 = $_REQUEST["year"]."-".$_REQUEST['mes']."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];
       
        


        do {


            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->totalfinanci($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


        
        }

			$this->M_excel_reports->graphics_report_by_financial($arreglo);

			return '';
		
	}


	private function create_fileincome() {

			$arregloc = array();

		



			if ($_REQUEST["year"] == '0' AND $_REQUEST['mes'] == '0') {
             $anio = date("Y");
        $mes = date("m");
        if ($mes == 1) {

            $mes  = 12;
            $anio = $anio-1;

        }else{

            $mes = $mes-1;
        }

        $mes2 = str_pad($mes, 2, "0", STR_PAD_LEFT);
        $number = cal_days_in_month(CAL_GREGORIAN, $mes2, $anio); 

        $fecha1 = $anio."-".$mes2."-01";
        $fecha2 = $anio."-".$mes2."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];

        do {

            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->totalincomeday($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


       

        }else{


        
        $number = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['mes'], $_REQUEST["year"]); 

        $fecha1 = $_REQUEST["year"]."-".$_REQUEST['mes']."-1";
        $fecha2 = $_REQUEST["year"]."-".$_REQUEST['mes']."-".$number;


        $inicio = strtotime($fecha1);
        $fin = strtotime($fecha2);
        $variable = true;
        $arreglo = [];
       
        


        do {


            if ($inicio <= $fin) {


               
                $variable = true;
                $inicio = date( "Y-m-d", $inicio); 
                // array_push($arreglo, $inicio); 
                $info = $this->M_contracts->totalincomeday($inicio);
                $arreglo[$inicio] = $info; 
                $inicio = strtotime($inicio."+ 1 days"); 

            }else{
                $variable = false;

            }

        } while ($variable);


        
        }

			$this->M_excel_reports->graphics_report_by_income($arreglo);

			return '';
		
	}



	private function create_file() {


		$type = isset($_REQUEST['type']) && !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
		$conditional = $this->excel_conditional();


		if(!empty($type)){
			$this->M_excel_reports->graphics_report_by_type($conditional, $type);

			return '';
		}

		$this->M_excel_reports->graphics_report($conditional);

		return '';
	}

	private function excel_conditional() {
		$start_report_date = '2016-01-01';
		$raw_start_date = isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
		$raw_end_date   = isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';

		$start_date = (!empty($raw_start_date)) ? $raw_start_date : $start_report_date;
		$end_date   = (!empty($raw_end_date)) ? $raw_end_date : date('Y-m-d');	

		if(empty($start_date) && empty($end_date)) {
			return array();
		}

		if(!empty($start_date) && empty($end_date)) {
			return array('conditional' => ' >=', 'value' => $start_date);
		}

		if(!empty($start_date) && empty($end_date)) {
			return array('conditional' => ' >=', 'value' => $start_date);
		}

		if(empty($start_date) && !empty($end_date)) {
			return array('conditional' => ' <=', 'value' =>  $end_date);
		}

		if(!empty($start_date) && !empty($end_date)) {
			return array(array('conditional' => ' >=','value' => $start_date), array('conditional' => ' <=', 'value' => $end_date));
		}
	}

	private function dashboard_payments_date($raw_date) {
		$date = $this->adds_second_to_date($raw_date);
		$date = str_replace(' ', 'T',$date);
		$date = str_replace(':', '%3A', $date);
		return $date;
	}

	private function adds_second_to_date($raw_argument_date) {
		$datetime = new DateTime($raw_argument_date);
		$datetime->add(new DateInterval('PT5S'));
		$date = $datetime->format('Y-m-d H:i:s');

		return $date;
	}
}
?>