<?php
class M_invoice extends CI_Model
{
    public function lawfirm($id)
    {
        $query = "select Company from catt_company where ID='" . $id . "'";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function general_contract($id)
    {
        $query = "SELECT t_contracts.Contract_N, t_client.C_Name, t_client.Address, t_client.City,t_client.Zip_Code, t_payments.Date, t_payments.Fee_ID,t_payments.Pay_Amount,t_payments.Date as date_pay , t_payments.Pay_Description,catt_frequency.Frequency from t_invoice inner join t_contracts on t_invoice.Contract_ID=t_contracts.ID inner join t_client on t_contracts.Client_ID=t_client.ID inner join t_payments on t_invoice.Payments_ID=t_payments.ID inner join catt_frequency on t_contracts.Frequency_ID=catt_frequency.ID where t_payments.ID='" . $id . "'";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function fee_description($id)
    {
        $query = "SELECT Fee_Type from catt_fees where ID='" . $id . "'";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function update_nopayment($data)
    {
        $query = "update t_payments set Contract_ID='" . $data['contract'] . "' where ID='" . $data['square'] . "'";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return 'SI';
        } else {
            return false;
        }
    }
    public function details_payment($id)
    {
        $query = "select * from t_payments where ID='" . $id . "'";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function unapplied()
    {
        $query = "select * from payment_square where id_invoice='0' order by date DESC LIMIT 300";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function unapplied2()
    {
        $query = "select * from t_payments where Contract_ID='0' order by date asc";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function details_pay_square($id)
    {
        $query = "select * from payment_square where ID='" . $id . "'";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function fees()
    {
        $query = "select ID,Fee_Type from catt_fees";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }
    public function insert_pay($data)
    {
        $query = "INSERT INTO t_payments (Date, Contract_ID,Pay_Description, Pay_Amount, Pay_Method, Fee_ID, Pay_Reference) values ('" . $data['date'] . "', '" . $data['contract'] . "' , '" . $data['note'] . "', '" . $data['mount'] . "', '" . $data['method'] . "', '" . $data['fee'] . "' , '" . $data['id_squarex'] . "')";
        $da    = $this->db->query($query);
        if (!empty($da)) {
            return $this->db->query("SELECT ID from t_payments where date='" . $data['date'] . "' and Contract_ID='" . $data['contract'] . "' and Pay_Amount='" . $data['mount'] . "'")->result()[0]->ID;
        } else {
            return false;
        }
    }
    public function insert_invoice($data)
    {
        $query = "INSERT INTO t_invoice (Contract_ID, Payments_ID,Invoice_Date) values ('" . $data['contract'] . "', '" . $data['ID_payment'] . "', NOW())";
        $da    = $this->db->query($query);
        if (!empty($da)) {
            return true;
        } else {
            return false;
        }
    }
    public function update_pay($data)
    {
        $query = "UPDATE payment_square set id_invoice='" . $data['ID_payment'] . "' where ID='" . $data['id_square'] . "'";
        $da    = $this->db->query($query);
        if (!empty($da)) {
            return true;
        } else {
            return false;
        }
    }
    public function update_mount($data)
    {

        if ($data['receivable'] <= 0) {

            $sent = "UPDATE t_contracts SET status_ID=3 WHERE ID = '" . $data["contract"] . "'";
            $this->db->query($sent);
        }

        if ($data['receivable'] > 0) {

            $sent = "UPDATE t_contracts SET status_ID=4 WHERE ID = '" . $data["contract"] . "'";
            $this->db->query($sent);
        }

        if ($data["balance"] <= 0) {
            $sent = "UPDATE t_contracts SET status_ID=1 WHERE ID = '" . $data["contract"] . "'";
            $this->db->query($sent);
        }

        $query = "update t_contracts set Receivable_Amount='" . $data['receivable'] . "', Balance_Amount='" . $data["balance"] . "' where ID='" . $data["contract"] . "'";
        $da    = $this->db->query($query);
        if (!empty($da)) {
            return true;
        } else {
            return false;
        }
    }
}
