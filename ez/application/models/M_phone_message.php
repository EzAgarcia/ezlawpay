<?php
class M_phone_message extends CI_Model
{
    private $table            = 't_phone_messages';
    private $active_status    = 1;
    private $column_order     = array('C_Name', 'Contract_N', 'Amount', 'Date_Payment', 'Sent', 'Created_at');
    private $column_search    = array('C_Name', 'Contract_N', 'Amount', 'Date_Payment', 'Sent', 'Created_at');
    private $selected_columns = '*';

    public function __construct()
    {
        parent::__construct();
    }

    public function message()
    {
        $contract_id = isset($_POST['id']) ? $_POST['id'] : '';

        if (empty($contract_id)) {
            return print("we didn't find the message");
        }

        $this->db->select('tcl.C_Name, pm.Date_Payment, pm.Sent, pm.Created_at, tc.Contract_N');
        $this->db->from('t_phone_messages as pm');
        $this->db->join('t_client as tcl', 'tcl.ID = pm.Client_ID');
        $this->db->join('t_contracts as tc', 'tc.ID = pm.Contract_ID');
        $this->db->where('tc.ID = ' . $contract_id);
        $raw_info = $this->db->get()->result();

        if (empty($raw_info)) {
            return print("we didn't find the message");
        }

        $info = $raw_info[0];
        setlocale(LC_TIME, 'es_ES');
        $month = $this->month_name((int) date("m", strtotime($info->Date_Payment)));

        header('Content-Type: text/html; charset=ISO-8859-1');
        $header      = '<div class="card"><div class="card-body"><h5 class="card-title">';
        $title       = '<br>' . '<strong>' . 'Text Message' . '</strong>' . '</br>';
        $style       = '<div style="background-color: #f2f2f2; height:19rem; padding: 5% 3% 5% 3%; color: #737373; font-weight: lighter !important; font-size="6"; ">';
        $greeting    = 'Hola ' . $info->C_Name . ',';
        $debt        = ' Tu Estado de cuenta del mes de ' . $month . ' del a o 2020, se encuentra disponible.' . '</br>';
        $contract    = 'Contracto # ' . $info->Contract_N . ' . ' . '</br>';
        $pay_date    = 'Fecha de vencimiento del pago: ' . $info->Date_Payment . '. ' . '</br>';
        $ways_to_pay = 'Formas de pago: paga por tel fono o puedes contactarnos con preguntas al n mero 213-309-9123.' . '</br>';
        $farewell    = 'Paga en persona: puedes visitar nuestras oficinas ubicadas en el numero 3450 de Wilshire Blvd. Ste # 400 Los  ngeles CA. 90010.' . '</br>';
        $farewell_m  = 'Apreciamos tu preferencia: Kostiv & Associates P.C ' . "\n" . ' Powered by EZ Law Pay' . '</br>';
        $style_end   = '</div></div></div>';

        return print($header . $title . $style . $greeting . $debt . $contract . $pay_date . $ways_to_pay . $farewell . $farewell_m . $style_end);
    }

    public function json_list()
    {
        $data = $this->list();

        $output = array(
            'draw'            => $data['draw'],
            'recordsTotal'    => $data['count_rows'],
            'recordsFiltered' => $data['count_all_results'],
            'data'            => $data['data'],
        );

        return json_encode($output);
    }

    function list() {
        $raw_data = $this->raw_data();
        $rows     = $raw_data['rows'];
        $draw     = !empty($_POST['draw']) ? $_POST['draw'] : 1;

        $data_list['draw']              = $draw;
        $data_list['count_all_results'] = $raw_data['all_counts'];
        $data_list['count_rows']        = $raw_data['count'];
        $data_list['data']              = $this->order_data($rows);

        return $data_list;
    }

    private function order_data($rows)
    {
        $data = array();

        foreach ($rows as $data_row) {
            $row   = array();
            $row[] = $data_row->C_Name;
            $row[] = $data_row->Contract_N;
            $row[] = $data_row->Date_Payment;
            $row[] = $data_row->Sent;
            $row[] = $data_row->Created_at;
            $row[] = $data_row->Contract_ID;

            $data[] = $row;
        }

        return $data;
    }

    private function raw_data()
    {

        $this->client_list_query();

        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query              = $this->db->get();
        $data['rows']       = $query->result();
        $data['count']      = $query->num_rows();
        $data['all_counts'] = $this->raw_data_count();

        return $data;
    }

    private function raw_data_count()
    {
        $this->client_list_query();

        $query = $this->db->get();
        $data  = $query->num_rows();

        return $data;
    }

    private function client_list_query()
    {
        $this->db->select($this->selected_columns);
        $this->db->from($this->table . ' as pm');
        $this->db->join('t_client as tcl', 'tcl.ID = pm.client_ID');
        $this->db->join('t_contracts as tc', 'tc.ID = pm.Contract_ID');
        $searchable_date = $this->search_dates();
        $searchable_type = $this->search_type();

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->search_present($_POST)) // if datatable send POST for search
            {
                if ($i === 0) {
                    if (!empty($searchable_date)) {
                        $date_for_search = $searchable_date['start_date'];
                        $type            = (!empty($searchable_type)) ? $searchable_type : 'pm.Date_Payment';

                        if ($searchable_date['type'] == 'day') {
                            $this->db->where("DAY({$type})", date('d', strtotime($date_for_search)));
                            // $this->db->where('DAY(pm.Date_Payment) <=', $date_for_search);
                        }

                        if ($searchable_date['type'] == 'dm') {
                            $this->db->where("DAY({$type})", date('d', strtotime($date_for_search)));
                            $this->db->where("MONTH({$type})", date('m', strtotime($date_for_search)));
                        }

                        if ($searchable_date['type'] == 'dy') {
                            $this->db->where("DAY({$type})", date('d', strtotime($date_for_search)));
                            $this->db->where("YEAR({$type})", date('Y', strtotime($date_for_search)));
                        }

                        if ($searchable_date['type'] == 'month') {
                            $this->db->where("MONTH({$type})", date('m', strtotime($date_for_search)));
                        }

                        if ($searchable_date['type'] == 'year') {
                            $this->db->where("YEAR({$type})", date('Y', strtotime($date_for_search)));
                        }

                        if ($searchable_date['type'] == 'both') {
                            $this->db->where("{$type} >= ", $searchable_date['start_date']);
                            $this->db->where("{$type} <= ", $searchable_date['end_date']);
                        }

                        if ($searchable_date['type'] == 'all') {
                            if ($type == 'pm.Created_at') {
                                $this->db->where("{$type} >= ", $date_for_search . " 00:00:00");
                                $this->db->where("{$type} <= ", $date_for_search . " 23:59:59");
                            } else {
                                $this->db->where($type, $date_for_search);
                            }
                        }
                    }

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if (isset($_POST['order'])) {
                // here order processing
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
        }
    }

    private function search_present($data)
    {
        return isset($data['search']) && isset($data['search']['value']);
    }

    private function search_type()
    {
        $type  = (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : '';
        $table = 'pm.';

        return $table . $type;
    }

    private function search_dates()
    {
        $day   = isset($_REQUEST['day']) && !empty($_REQUEST['day']) ? $_REQUEST['day'] : '1';
        $month = isset($_REQUEST['month']) && !empty($_REQUEST['month']) ? $_REQUEST['month'] : date('m');
        $year  = isset($_REQUEST['year']) && !empty($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');

        $default_day               = $day;
        $time                      = strtotime($year . '-' . $month . '-' . $default_day);
        $search_date               = [];
        $search_date['type']       = $this->date_type();
        $search_date['start_date'] = date('Y-m-d', $time);
        $search_date['end_date']   = date('Y-m-t', $time);

        return $search_date;
    }

    private function date_type()
    {
        $day   = isset($_REQUEST['day']) && !empty($_REQUEST['day']) ? $_REQUEST['day'] : '';
        $month = isset($_REQUEST['month']) && !empty($_REQUEST['month']) ? $_REQUEST['month'] : '';
        $year  = isset($_REQUEST['year']) && !empty($_REQUEST['year']) ? $_REQUEST['year'] : '';

        if (!empty($day) && empty($month) && empty($year)) {
            return 'day';
        }

        if (!empty($day) && !empty($month) && empty($year)) {
            return 'dm';
        }

        if (!empty($day) && empty($month) && !empty($year)) {
            return 'dy';
        }

        if (empty($day) && empty($month) && !empty($year)) {
            return 'year';
        }

        if (empty($day) && !empty($month) && empty($year)) {
            return 'month';
        }

        if (empty($day) && !empty($month) && !empty($year)) {
            return 'both';
        }

        if (!empty($day) && !empty($month) && !empty($year)) {
            return 'all';
        }
    }

    private function month_name($english_month)
    {
        $spanish_months = array(
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Setiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        );

        return $spanish_months[$english_month];
    }
}
