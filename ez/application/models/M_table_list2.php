<?php

class M_table_list2 extends CI_Model
{

    protected $params;

    public function __construct()
    {

        parent::__construct();

    }

    public function add($data, $finished_balances = false)
    {

        $this->params = array(

            'table'             => $data['table'],

            'column_order'      => $data['column_order'],

            'column_search'     => $data['column_search'],

            'selected_columns'  => $data['selected_columns'],

            'column_names'      => isset($data['column_names']) ? $data['column_names'] : array(),

            'query_data'        => $data['query_data'],

            'custom_search'     => isset($data['custom_search']) ? $data['custom_search'] : array(),

            'finished_balances' => $finished_balances,
        );

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

        $rows = $raw_data['rows'];

        $draw = !empty($_POST['draw']) ? $_POST['draw'] : 1;

        $data_list['draw'] = $draw;

        $data_list['count_all_results'] = $raw_data['all_counts'];

        $data_list['count_rows'] = $raw_data['count'];

        $data_list['data'] = $this->order_data($rows);

        return $data_list;

    }

    private function order_data($rows)
    {
        $data = array();

        foreach ($rows as $data_row) {
            if ($this->params['finished_balances']) {
                $raw_row = $this->data_to_array(array(), $data_row);
                $row     = $this->balance_status($raw_row);

                $data[] = $row;
            } else {
                $row    = $this->data_to_array(array(), $data_row);
                $data[] = $row;
            }
        }

        return $data;
    }

    private function balance_status($row)
    {

        $contract_id = $row[4];
        $status      = $this->finished_balances($contract_id);
        array_push($row, $status);
        return $row;
    }

    public function finished_balances($contract_id)
    {
        $this->db->select('*');
        $this->db->from('t_balance as tb');
        $this->db->where('tb.id_contract =', $contract_id);

        $raw_data = $this->db->get();
        $data     = $raw_data->num_rows();

        return $data;
    }

    private function data_to_array($row, $data)
    {

        $columns = (!empty($this->params['column_names'])) ? $this->params['column_names'] : $this->params['column_search'];

        foreach ($columns as $column) {

            $row[] = $data->$column;

        }

        return $row;

    }

    private function raw_data()
    {

        $this->list_query();

        if (isset($_POST['length']) && $_POST['length'] != -1) {

            $this->db->limit($_POST['length'], $_POST['start']);

        }

        $query = $this->db->get();

        $data['rows'] = $query->result();

        $data['count'] = $query->num_rows();

        $data['all_counts'] = $this->raw_data_count();

        return $data;

    }

    private function raw_data_count()
    {

        $this->list_query();

        $query = $this->db->get();

        $data = $query->num_rows();

        return $data;

    }

    private function list_query()
    {

        $custom_search = $this->custom_search();

        $custom_date_search = $this->custom_date_search();

        $query_data = $this->params['query_data'];

        $this->db->select($this->params['selected_columns']);

        $this->db->from($this->params['table']);

        if (isset($query_data['joins']) && !empty($query_data['joins'])) {

            foreach ($query_data['joins'] as $integrated_join) {

                $table = $integrated_join['table'];

                $comparison = $integrated_join['comparison'];

                $type = $integrated_join['type'];

                $this->db->join($table, $comparison);

            }

        }

        if (isset($query_data['where']) && !empty($query_data['where'])) {

            $this->db->like($query_data['like']);
            $this->db->where($query_data['where']);
            $this->db->where($query_data['where1']);

        }

        if (isset($this->params['custom_search']) && isset($this->params['custom_search']['date']) && !empty($custom_date_search)) {
            $column_date_for_search = $this->params['custom_search']['date'];
            $date_for_search        = $custom_date_search['date'];

            if ($custom_date_search['type'] == 'month') {
                $this->db->where('MONTH(tc.Sign_Date)', date('m', strtotime($date_for_search)));
            }

            if ($custom_date_search['type'] == 'year') {
                $this->db->where('YEAR(tc.Sign_Date)', date('Y', strtotime($date_for_search)));
            }

            if ($custom_date_search['type'] == 'both') {
                $last_day_for_search = date("Y-m-t", strtotime($date_for_search));

                $this->db->where('tc.Sign_Date >= ', $date_for_search);
                $this->db->where('tc.Sign_Date <= ', $last_day_for_search);
            }
        }

        if (isset($custom_search) && !empty($custom_search)) {

            $this->db->where($custom_search);
        }

        if (isset($query_data['oder_by']) && !empty($query_data['oder_by'])) {

            $oder_by_type = (isset($query_data['oder_by_type']) && !empty($query_data['oder_by_type'])) ? $query_data['oder_by_type'] : 'DESC';

            $this->db->order_by($query_data['oder_by'], $oder_by_type);

        }

        $i = 0;

        foreach ($this->params['column_search'] as $item) // loop column

        {

            if ($this->search_present($_POST)) // if datatable send POST for search

            {

                if ($i === 0) {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

                if (count($this->params['column_search']) - 1 == $i) {
                    //last loop

                    $this->db->group_end(); //close bracket

                }

                $i++;

            }

            if (isset($_POST['order'])) {
                // here order processing

                $this->db->order_by($this->params['column_order'][$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

            }

        }

    }

    private function search_present($data)
    {
        return isset($data['search']) && isset($data['search']['value']);
    }

    private function custom_search()
    {
        $where_search_params = array();
        $custom_data         = $this->params['custom_search'];

        if (empty($custom_data)) {
            return array();
        }

        foreach (array_keys($custom_data) as $search_param) {
            if ($search_param == 'date') {
                continue;
            }

            $data = isset($_REQUEST[$search_param]) && !empty($_REQUEST[$search_param]) ? $_REQUEST[$search_param] : '';

            if (empty($data)) {
                continue;
            }

            $where_search_params[$custom_data[$search_param]] = $data;
        }

        return $where_search_params;
    }

    private function custom_date_search()
    {
        $raw_month = isset($_REQUEST['month']) && !empty($_REQUEST['month']) ? $_REQUEST['month'] : '';
        $raw_year  = isset($_REQUEST['year']) && !empty($_REQUEST['year']) ? $_REQUEST['year'] : '';

        $custom_date = array();

        if (!empty($raw_month) || !empty($raw_year)) {
            $month       = !empty($raw_month) ? $raw_month : date('m');
            $year        = !empty($raw_year) ? $raw_year : date('Y');
            $default_day = '1';
            $time        = strtotime($year . '-' . $month . '-' . $default_day);
            $search_date = date('Y-m-d', $time);

            $custom_date['date'] = $search_date;
        }

        if (empty($raw_month) && !empty($raw_year)) {$custom_date['type'] = 'year';}
        if (!empty($raw_month) && empty($raw_year)) {$custom_date['type'] = 'month';}
        if (!empty($raw_month) && !empty($raw_year)) {$custom_date['type'] = 'both';}

        if (!empty($raw_month) || !empty($raw_year)) {return $custom_date;}
        return '';
    }
}
