<?php
set_include_path(APPPATH . './third_party/Classes/');
require_once 'PHPExcel.php';
require_once 'PHPExcel/Reader/Excel2007.php';

class M_excel_reports extends CI_Model
{
    private $creator_name      = 'EzLawPay';
    private $initial_excel_row = 'A1';
    private $extension         = '.xls';
    private $output_dir        = APPPATH . 'reports/';
    private $contracts_table   = 't_contracts as tc';
    private $contracts_columns = 'tc.ID as contract_id, tc.Balance_Amount as Balance_Amount, tc.Contract_N as Contract_N, tc.Value as Value, t_client.C_Name as C_Name, tc.Sign_Date as Sign_Date, catt_status.Status as Status, tc.Receivable_Amount as Receivable_Amount';
    private $contracts_joins   = [
        ['table' => 't_client', 'comparison' => ' tc.Client_ID = t_client.ID', 'type' => ''],
        ['table' => 't_users', 'comparison' => ' tc.Registered_By_ID = t_users.ID', 'type' => ''],
        ['table' => 'catt_status', 'comparison' => ' catt_status.ID = tc.status_ID', 'type' => ''],
    ];
    private $contract_rows = [
        'status'            => 'Status',
        'contract number'   => 'Contract_N',
        'client'            => 'C_Name',
        'date sing'         => 'Sign_Date',
        'contract amount'   => 'Value',
        'current balance'   => 'Balance_Amount',
        'receivable amount' => 'Receivable_Amount',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function graphics_report($raw_conditional = array())
    {
        $contracts_conditional = $this->change_condition($raw_conditional, 'tc.Sign_Date');
        $payments_conditional  = $this->change_condition($raw_conditional, 'date');
        $contract_totals       = $this->graphics_contract_totals_data($contracts_conditional);
        $contracts             = $this->graphics_contract_data($contracts_conditional);
        $signed_contracts      = $this->graphics_contract_signed_data($contracts_conditional);
        $by_services           = $this->graphics_contract_by_services($contracts_conditional);
        $signed_contractshold  = $this->graphics_contract_signed_dataonhold($contracts_conditional);
        $payments_by_type      = $this->graphics_payments_by_type($payments_conditional);
        $payments_by_totals    = $this->graphics_payments_totals($payments_conditional);
        $document_name         = 'contract_report';

        $data = array(
            'conotract_totals'     => $contract_totals,
            'contracts'            => $contracts,
            'signed_contracts'     => $signed_contracts,
            'signed_contractshold' => $signed_contractshold,
            'by_services'          => $by_services,
            'payments_by_type'     => $payments_by_type,
            'payments_by_totals'   => $payments_by_totals,
        );

        $document  = $this->excel_flow($data);
        $file_path = $this->create_file($document, $document_name);
        return $file_path;
    }

    public function graphics_report_by_newcontract($arreglos)
    {

        $document  = $this->excel_flownewcontract($arreglos);
        $file_path = $this->create_file($document, 'nuevo');

        return $file_path;
    }

    public function graphics_report_by_sinpay($arreglos)
    {

        $document  = $this->excel_flowsinpay($arreglos);
        $file_path = $this->create_file($document, 'nuevo');

        return $file_path;
    }

    public function graphics_report_by_financial($arreglos)
    {

        $document  = $this->excel_flowfinancial($arreglos);
        $file_path = $this->create_file($document, 'nuevo');

        return $file_path;
    }

    public function graphics_report_by_payments($arreglos)
    {

        $document  = $this->excel_flowpayments($arreglos);
        $file_path = $this->create_file($document, 'nuevo');

        return $file_path;
    }

    public function graphics_report_by_income($arreglos)
    {

        $document  = $this->excel_flowincome($arreglos);
        $file_path = $this->create_file($document, 'nuevo');

        return $file_path;
    }

    public function graphics_report_by_type($raw_conditional = array(), $type)
    {

        if ($type == 'contracts') {
            $contracts_conditional = $this->change_condition($raw_conditional, 'tc.Sign_Date');
            $contract_totals       = $this->graphics_contract_totals_data($contracts_conditional);
            $contracts             = $this->graphics_contract_data($contracts_conditional);
            $signed_contracts      = $this->graphics_contract_signed_data($contracts_conditional);
            $signed_contractshold  = $this->graphics_contract_signed_dataonhold($contracts_conditional);
            $document_name         = 'contract_report';

            $data = array(
                'conotract_totals'     => $contract_totals,
                'contracts'            => $contracts,
                'signed_contracts'     => $signed_contracts,
                'signed_contractshold' => $signed_contractshold,
            );
        }

        if ($type == 'payments') {
            $payments_conditional = $this->change_condition($raw_conditional, 'local_date');
            $payments_by_type     = $this->graphics_payments_by_type($payments_conditional);
            $payments_by_totals   = $this->graphics_payments_totals($payments_conditional);
            $document_name        = 'contract_report';

            $data = array(
                'payments_by_type'   => $payments_by_type,
                'payments_by_totals' => $payments_by_totals,
            );
        }

        if ($type == 'services') {
            $contracts_conditional = $this->change_condition($raw_conditional, 'tc.Sign_Date');
            $by_services           = $this->graphics_contract_by_services($contracts_conditional);
            $document_name         = 'contract_report';

            $data = array(
                'by_services' => $by_services,
            );
        }

        $document  = $this->excel_flow($data);
        $file_path = $this->create_file($document, $document_name);

        return $file_path;
    }

    private function change_condition($raw_conditional, $column)
    {
        $conditional = array();

        foreach ($raw_conditional as $sub_conditional) {
            $new_conditional = $column . $sub_conditional['conditional'];
            $new_array       = array('conditional' => $new_conditional, 'value' => $sub_conditional['value']);

            array_push($conditional, $new_array);
        }

        if ($column == 'local') {
            $last = array('conditional' => 'type !=', 'value' => 'NO_SALE');
            array_push($conditional, $last);
        }

        return $conditional;
    }

    private function graphics_contract_data($conditional)
    {
        $data           = $this->data($this->contracts_table, $this->contracts_columns, $conditional, $this->contracts_joins);
        $headers        = ['Status', 'Contract number', 'Client', 'Date sing', 'Contract amount', 'Current balance', 'Receivable amount'];
        $organized_data = $this->data_organizer($data, $headers, $this->contract_rows, 'Contracts');

        return $organized_data;
    }

    private function graphics_contract_totals_data($conditional)
    {
        $group_type     = 'Status_ID';
        $select         = 'Status_ID as status, SUM(Value) AS total_value, count(*) as total_records';
        $tag            = $this->types_selectors('contracts', 'status');
        $raw_data       = $this->data($this->contracts_table, $select, $conditional, $this->contracts_joins, $group_type);
        $data           = $this->add_tag_to_data($raw_data, $tag);
        $headers        = ['Status', 'Total Value', 'Total Records'];
        $rows           = array('status', 'total_value', 'total_records');
        $organized_data = $this->data_organizer($data, $headers, $rows, 'Contracts');

        // print_r($raw_data);
        // exit();

        return $organized_data;
    }

    private function add_tag_to_data($raw_data, $tag)
    {
        foreach ($raw_data as $data) {
            $old_value           = $data->{$tag['key']};
            $data->{$tag['key']} = $tag['tag_values'][$old_value];

            $processed[] = $data;
        }

        return $raw_data;
    }

    private function types_selectors($type, $key)
    {
        $conditional = array('column' => 'Status', 'from' => 'catt_status as status');

        $this->db->select('*');
        $this->db->from($conditional['from']);
        $query  = $this->db->get();
        $result = $query->result();

        $data = array();
        foreach ($result as $row) {
            $data[$row->ID] = $row->{$conditional['column']};
        }

        $complete = array('tag_values' => $data, 'key' => $key);
        return $complete;
    }

    private function graphics_contract_signed_data($info)
    {

        // print_r($info[0]['value']);
        // exit();

        // $start_limit = strtotime(date('Y-m-d').' -10 days');
        $start_date = $info[0]['value'];

        // $end_limit = strtotime(date('Y-m-d').' +1 days');
        $end_date = $info[1]['value'];

        $conditional = array(
            array('conditional' => 'Sign_Date >= ', 'value' => $start_date),
            array('conditional' => 'Sign_Date <= ', 'value' => $end_date),
            array('conditional' => 'Status_ID != ', 'value' => 2),
        );

        $data           = $this->data($this->contracts_table, $this->contracts_columns, $conditional, $this->contracts_joins);
        $headers        = ['Status', 'Contract number', 'Client', 'Date sing', 'Contract amount', 'Current balance', 'Receivable amount'];
        $subheaders     = array('Totals', count($data));
        $organized_data = $this->data_organizer($data, $headers, $this->contract_rows, 'Signed Contracts', $subheaders);

        return $organized_data;
    }

    private function graphics_contract_signed_dataonhold($info)
    {

        // print_r($info[0]['value']);
        // exit();

        // $start_limit = strtotime(date('Y-m-d').' -10 days');
        $start_date = $info[0]['value'];

        // $end_limit = strtotime(date('Y-m-d').' +1 days');
        $end_date = $info[1]['value'];

        $conditional = array(
            array('conditional' => 'Sign_Date >= ', 'value' => $start_date),
            array('conditional' => 'Sign_Date <= ', 'value' => $end_date),
            array('conditional' => 'Status_ID = ', 'value' => 2),
        );

        $data           = $this->data($this->contracts_table, $this->contracts_columns, $conditional, $this->contracts_joins);
        $headers        = ['Status', 'Contract number', 'Client', 'Date sing', 'Contract amount', 'Current balance', 'Receivable amount'];
        $subheaders     = array('Totals', count($data));
        $organized_data = $this->data_organizer($data, $headers, $this->contract_rows, 'Signed Contracts On Hold', $subheaders);

        return $organized_data;
    }

    private function graphics_contract_by_services($conditional)
    {
        $services_table   = 't_services as ts';
        $services_columns = 'cs.Service_Description AS description, count(ts.Contract_ID) AS amount';
        $services_joins   = [
            ['table' => 'catt_services as cs', 'comparison' => ' cs.ID = ts.Services_ID', 'type' => ''],
            ['table' => 't_contracts as tc', 'comparison' => ' tc.ID = ts.Contract_ID', 'type' => ''],
        ];
        $services_rows  = ['Service' => 'description', 'Amount' => 'amount'];
        $services_group = 'cs.Service_Description';

        $data           = $this->data($services_table, $services_columns, $conditional, $services_joins, $services_group);
        $headers        = ['Service', 'Amount'];
        $organized_data = $this->data_organizer($data, $headers, $services_rows, 'Total of Contracts by Service');

        return $organized_data;
    }

    private function graphics_payments_by_type($conditional)
    {
        $payments_table   = 'daily_save_dashboard_payments';
        $payments_columns = 'type AS type, mount AS amount, local_date as date';
        $payments_joins   = '';
        $payments_rows    = ['type' => 'type', 'amount' => 'amount'];
        $payments_group   = 'type';

        $data           = $this->data($payments_table, $payments_columns, $conditional, $payments_joins, $payments_group);
        $headers        = ['Service', 'Amount'];
        $organized_data = $this->data_organizer($data, $headers, $payments_rows, 'Total of Contracts by Type');

        return $organized_data;
    }

    private function graphics_payments_totals($conditional)
    {
        $payments_table   = 'daily_save_dashboard_payments';
        $payments_columns = 'type AS type, count(type) AS amount';
        $payments_joins   = '';
        $payments_rows    = ['type' => 'type', 'amount' => 'amount'];
        $payments_group   = 'type';

        $data           = $this->data($payments_table, $payments_columns, $conditional, $payments_joins, $payments_group);
        $headers        = ['Service', 'Amount'];
        $organized_data = $this->data_organizer($data, $headers, $payments_rows, 'Total Contracts Amount by Type');

        return $organized_data;
    }

    private function data_organizer($data, $headers, $rows, $title, $subheaders = '')
    {
        $base = [];
        $base = [[$title]];

        if (!empty($subheaders)) {
            $base[] = $subheaders;
        }

        $base[] = $headers;

        foreach ($data as $row) {
            $row_data = [];
            foreach ($rows as $subrow_key => $subrow_value) {
                $row_data[$subrow_key] = $row->{$subrow_value};
            }
            $base[] = $row_data;
        }

        return $base;
    }

    private function data($table, $choosed = '', $conditional = '', $joins = '', $group = '')
    {
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        if (!empty($choosed)) {
            $this->db->select($choosed);

            print_r($choosed);
            print_r('<br>');
        } else {
            $this->db->select('*');

            print_r("entro aca");
        }

        print_r($table);
        print_r('<br>');

        $this->db->from($table);

        if (!empty($joins)) {
            foreach ($joins as $integrated_join) {
                $join_table = $integrated_join['table'];
                $comparison = $integrated_join['comparison'];
                $type       = $integrated_join['type'];

                print_r('joins' . $join_table . $comparison . $type);
                print_r('<br>');
                $this->db->join($join_table, $comparison, $type);
            }
        }

        if (!empty($conditional)) {
            if (is_array($conditional)) {
                foreach ($conditional as $condition) {
                    $this->db->where($condition['conditional'], $condition['value']);
                    print_r($condition);
                    print_r('<br>');

                }
            } else {
                $this->db->where($conditional);
            }
        }

        if (!empty($group)) {

            print_r($group);
            print_r('<br>');
            $this->db->group_by($group);
        }

        $data = $this->db->get();

        return $data->result();
    }

    private function excel_flownewcontract($arreglos)
    {

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        // $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        //                ->setLastModifiedBy("Maarten Balliauw")
        //                ->setTitle("Office 2007 XLSX Test Document")
        //                ->setSubject("Office 2007 XLSX Test Document")
        //                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        //                ->setKeywords("office 2007 openxml php")
        //                ->setCategory("Test result file");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $cont = 2;

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $stylet = array('font' => array('name' => 'Arial', 'bold' => true, 'size' => '12', 'color' => array('rgb' => 'FFFFFF')), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '0A54A3')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'New Contracts per Day');
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->applyFromArray($stylet);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);

        foreach ($arreglos as $key => $value) {

            if (empty($value)) {
                $value = 0;
            }

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $cont . ':B' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $cont . ':D' . $cont);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $key);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $cont, $value);

            $cont = $cont + 1;
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('New_Contracts');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    private function excel_flowfinancial($arreglos)
    {

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        // $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        //                ->setLastModifiedBy("Maarten Balliauw")
        //                ->setTitle("Office 2007 XLSX Test Document")
        //                ->setSubject("Office 2007 XLSX Test Document")
        //                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        //                ->setKeywords("office 2007 openxml php")
        //                ->setCategory("Test result file");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $cont = 2;

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $stylet = array('font' => array('name' => 'Arial', 'bold' => true, 'size' => '12', 'color' => array('rgb' => 'FFFFFF')), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '0A54A3')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Total value of contracts per day.');
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->applyFromArray($stylet);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);

        foreach ($arreglos as $key => $value) {

            if (empty($value)) {
                $value = 0;
            }

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $cont . ':B' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $cont . ':D' . $cont);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $key);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $cont, '$' . $value);

            $cont = $cont + 1;
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('New_Contracts');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    private function excel_flowpayments($arreglos)
    {

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        // $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        //                ->setLastModifiedBy("Maarten Balliauw")
        //                ->setTitle("Office 2007 XLSX Test Document")
        //                ->setSubject("Office 2007 XLSX Test Document")
        //                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        //                ->setKeywords("office 2007 openxml php")
        //                ->setCategory("Test result file");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $cont = 2;

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $stylet = array('font' => array('name' => 'Arial', 'bold' => true, 'size' => '12', 'color' => array('rgb' => 'FFFFFF')), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '0A54A3')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Contract  Monthly Payments.');
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->applyFromArray($stylet);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);

        foreach ($arreglos as $key => $value) {

            if (empty($value)) {
                $value = 0;
            }

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $cont . ':B' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $cont . ':D' . $cont);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $key);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $cont, '$' . $value);

            $cont = $cont + 1;
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Monthly_Payments');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    private function excel_flowincome($arreglos)
    {

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        // $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        //                ->setLastModifiedBy("Maarten Balliauw")
        //                ->setTitle("Office 2007 XLSX Test Document")
        //                ->setSubject("Office 2007 XLSX Test Document")
        //                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        //                ->setKeywords("office 2007 openxml php")
        //                ->setCategory("Test result file");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $cont = 2;

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $stylet = array('font' => array('name' => 'Arial', 'bold' => true, 'size' => '12', 'color' => array('rgb' => 'FFFFFF')), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '0A54A3')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Total Income');
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->applyFromArray($stylet);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);

        foreach ($arreglos as $key => $value) {

            if (empty($value)) {
                $value = 0;
            }

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $cont . ':B' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $cont . ':D' . $cont);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $key);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $cont, $value);

            $cont = $cont + 1;
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Total_income');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    private function excel_flowsinpay($arreglos)
    {

        $objPHPExcel = new PHPExcel();

// // // Set properties
        // // // $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        // // //                ->setLastModifiedBy("Maarten Balliauw")
        // // //                ->setTitle("Office 2007 XLSX Test Document")
        // // //                ->setSubject("Office 2007 XLSX Test Document")
        // // //                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        // // //                ->setKeywords("office 2007 openxml php")
        // // //                ->setCategory("Test result file");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $cont = 3;

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $stylet = array('font' => array('name' => 'Arial', 'bold' => true, 'size' => '12', 'color' => array('rgb' => 'FFFFFF')), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '0A54A3')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Contract');
        $objPHPExcel->getActiveSheet()->getStyle("A1:L1")->applyFromArray($stylet);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:B2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:K2');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Contract Number");
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', "Client");
        $objPHPExcel->getActiveSheet()->SetCellValue('H2', "Sing Date");
        $objPHPExcel->getActiveSheet()->SetCellValue('J2', "Contract Value");
        $objPHPExcel->getActiveSheet()->SetCellValue('L2', "Balance");

        foreach ($arreglos as $key) {

            if (empty($value)) {
                $value = 0;
            }

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $cont . ':B' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $cont . ':G' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H' . $cont . ':I' . $cont);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J' . $cont . ':K' . $cont);

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $cont, $key->Contract_N);
            // $objPHPExcel->getActiveSheet()->SetCellValue('C'.$cont,$value);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $cont, $key->C_Name);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $cont, $key->Sign_Date);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $cont, '$' . $key->Balance_Amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $cont, '$' . $key->Value);
            // $objPHPExcel->getActiveSheet()->SetCellValue('E'.$cont ,$key->value);

            $cont = $cont + 1;
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('contracts');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    private function excel_flow($data)
    {

        $spreadsheet = new PHPExcel();
        $this->property_file($spreadsheet);

        $index = 0;
        foreach ($data as $sheet_name => $sheet_data) {
            $this->generate_sheet($spreadsheet, $sheet_name, $index);
            $this->pupulate_sheet($spreadsheet, $sheet_name, $sheet_data, $index);

            $index++;
        }

        $this->delete_example_sheet($spreadsheet);
        return $spreadsheet;
    }

    private function pupulate_sheet($spreadsheet, $sheet_name, $data, $index)
    {
        $spreadsheet->getSheet($index)->fromArray($data, null, $this->initial_excel_row);
        $this->set_style($sheet_name, $index, $spreadsheet);
    }

    private function set_style($sheet_name, $index, $spreadsheet)
    {
        $letters              = array();
        $default_index        = '2';
        $active_sheet         = $spreadsheet->getSheet($index);
        $letter_number        = ($sheet_name == 'payments_by_type' || $sheet_name == 'payments_by_totals' || $sheet_name == 'by_services') ? 66 : 71;
        $shett_title_range    = $this->sheet_title_range($sheet_name);
        $shett_bugtitle_range = $this->sheet_title_range($sheet_name, true);

        for ($i = 65; $i <= $letter_number; $i++) {
            array_push($letters, chr($i));
        }

        foreach ($letters as $letter) {
            $active_sheet->getRowDimension($default_index)->setRowHeight(-1);
            $active_sheet->getColumnDimension($letter)->setWidth(25);
        }

        $active_sheet->mergeCells($shett_bugtitle_range);

        $styleTitre = new PHPExcel_Style();
        $styleTitre->applyFromArray(array('font' => array('name' => 'Arial', 'bold' => true, 'size' => '12', 'color' => array('rgb' => 'FFFFFF')), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '0A54A3')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
        $active_sheet->setSharedStyle($styleTitre, $shett_title_range);
        $active_sheet->setSharedStyle($styleTitre, 'A1');
    }

    private function sheet_title_range($sheet_name, $bug_title = false)
    {
        if ($sheet_name == 'payments_by_type' || $sheet_name == 'payments_by_totals' || $sheet_name == 'by_services') {
            $range = $bug_title ? 'A1:B1' : 'A2:B2';

            return $range;
        }

        if ($sheet_name == 'signed_contracts') {
            $range = $bug_title ? 'A1:G1' : 'A3:G3';

            return $range;
        }

        if ($sheet_name == 'conotract_totals') {
            $range = $bug_title ? 'A1:C1' : 'A2:C2';

            return $range;
        }

        $range = $bug_title ? 'A1:G1' : 'A2:G2';
        return $range;
    }

    private function generate_sheet($spreadsheet, $sheet_name, $index)
    {
        $spreadsheet->createSheet($index);
        $spreadsheet->getSheet($index)->setTitle($sheet_name);
    }

    private function delete_example_sheet($delete_example_sheet)
    {
        $delete_example_sheet->setActiveSheetIndexByName('Worksheet');
        $sheetIndex = $delete_example_sheet->getActiveSheetIndex();
        $delete_example_sheet->removeSheetByIndex($sheetIndex);
    }

    private function create_file($spreadsheet, $document_name)
    {
        $path      = $this->output_dir . $document_name . $this->extension;
        $objWriter = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel5');
        $objWriter->save($path);
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return array('path' => $path, 'file_name' => $document_name . $this->extension);
    }

    private function property_file($spreadsheet)
    {
        $spreadsheet->getProperties()
            ->setCreator($this->creator_name)
            ->setLastModifiedBy($this->creator_name)
            ->setTitle($this->creator_name)
            ->setSubject($this->creator_name);
    }
}
