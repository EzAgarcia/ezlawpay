<?php
class M_square extends CI_Model
{
    public function save_post($data)
    {
        $query  = "insert into push (post) values ('" . implode(",", $data) . "')";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }
    public function getConfiguration()
    {
        $query  = "select * from t_square where law_firm='" . $this->session->ezlow['lawfirm'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }
    public function save_square($data)
    {
        $query  = "INSERT INTO t_square (fcApplicationID,fcPersonalAccessToken,fcLocationID,fcSandboxApplicationID,fcSandboxAccessToken,fcSandboxLocationID, law_firm) values ('" . $data['application_id'] . "','" . $data['tocken'] . "','" . $data['location'] . "','" . $data['sandbox'] . "','" . $data['sandobox_tocken'] . "','" . $data['sandobox_location'] . "','" . $this->session->ezlow['lawfirm'] . "')";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
    public function update_square($data)
    {
        $query  = "update t_square set fcApplicationID='" . $data['application_id'] . "', fcPersonalAccessToken='" . $data['tocken'] . "', fcLocationID='" . $data['location'] . "', fcSandboxApplicationID='" . $data['sandbox'] . "', fcSandboxAccessToken='" . $data['sandobox_tocken'] . "',fcSandboxLocationID='" . $data['sandobox_location'] . "' where fnId='" . $data['id'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return 'SI';
        } else {
            return 'NO';
        }
    }

    public function validacion()
    {
        $query  = "SELECT status FROM flags WHERE execution = 'daily_dashboard'";
        $status = $this->db->query($query)->result();

        $change = "UPDATE flags SET status = 1 WHERE execution = 'daily_dashboard'";
        $this->db->query($change);

        return $status[0]->status;

    }

    public function changestatus()
    {
        $change = "UPDATE flags SET status = 0 WHERE execution = 'daily_dashboard'";
        $this->db->query($change);
    }

    public function update_paymentmethod($data)
    {
        $this->db->query("truncate pay_square");
        $keys = array_keys($data);
        $i    = 0;
        foreach ($data as $pay) {
            $query = "INSERT INTO pay_square (payment, total) VALUES ('" . $keys[$i] . "','" . $pay . "')";
            $this->db->query($query);
            $i = $i + 1;
        }
    }
    public function paymentsmethods()
    {
        $query  = 'select payment, total from pay_square';
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
}
