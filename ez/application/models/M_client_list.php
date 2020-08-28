<?php

class M_client_list extends CI_Model
{

    private $table = 't_client';

    private $active_status = 1;

    private $column_order = array('C_Name', 'Phone_Number', 'Email', 'City', null);

    private $column_search = array('ID', 'C_Name', 'Phone_Number', 'Email', 'City');

    private $selected_columns = 'ID, C_Name, Phone_Number, Email, City';

    public function __construct()
    {

        parent::__construct();

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

        foreach ($rows as $clients) {

            $row = array();

            $row[] = $clients->C_Name;

            $row[] = $clients->Phone_Number;

            $row[] = $clients->Email;

            $row[] = $clients->City;

            $row[] = $clients->ID;

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

        $query = $this->db->get();

        $data['rows'] = $query->result();

        $data['count'] = $query->num_rows();

        $data['all_counts'] = $this->raw_data_count();

        return $data;

    }

    private function raw_data_count()
    {

        $this->client_list_query();

        $query = $this->db->get();

        $data = $query->num_rows();

        return $data;

    }

    private function client_list_query()
    {

        $this->db->select($this->selected_columns);

        $this->db->from($this->table);

        $this->db->where('Active', $this->active_status);

        $i = 0;

        foreach ($this->column_search as $item) // loop column

        {

            if ($this->search_present($_POST)) // if datatable send POST for search

            {

                if ($i === 0) {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

                if (count($this->column_search) - 1 == $i) {
                    //last loop

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

}
