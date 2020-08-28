<?php
class M_client extends CI_Model
{
    public function det_client($id)
    {
        $query  = "select * from t_client where ID='" . $id . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function list_clients()
    {
        $query  = "select C_Name, Phone_number, ID, Email, City from t_client where Active='1' and Company_ID='" . $this->session->ezlow['lawfirm'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function list_country()
    {
        $query  = "select ID, Country_Name from catt_country";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function list_states()
    {
        $query  = "select ID, State_Name from catt_state";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result->result();
        } else {
            return false;
        }
    }
    public function save_update($data)
    {
        $query  = "update t_client set C_Name='" . $data['name'] . "', Sex='" . $data['sex'] . "', Birth_Date='" . $data['birthdate'] . "', Birth_Country_ID='" . $data["b_country"] . "', Mother_Language='" . $data['language'] . "', Address='" . $data['address'] . "', City='" . $data['city'] . "',Zip_Code='" . $data['Zip_Code'] . "' ,State_ID='" . $data['estate'] . "', Country='" . $data['country'] . "',Phone_Number='" . $data['phone'] . "',Email='" . $data['email'] . "' where ID='" . $data['id'] . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
    public function save_client($data)
    {
        $query  = "INSERT INTO t_client(C_User,C_Password,C_Name,Sex,Birth_Date,Birth_Country_ID,Mother_Language,Address,City,Zip_Code,State_ID,Country,Phone_Number,Email,Register_Date,Registered_By_ID,Active, Company_ID)VALUES('" . $data['user'] . "','" . $data['pass'] . "','" . $data['name'] . "','" . $data['sex'] . "','" . $data['birthdate'] . "','" . $data['b_country'] . "','" . $data['language'] . "','" . $data['address'] . "','" . $data['city'] . "','" . $data['zip'] . "','" . $data['estate'] . "','" . $data['country'] . "','" . $data['phone'] . "','" . $data['email'] . "',NOW(),'" . $this->session->ezlow['iduser'] . "','1','" . $this->session->ezlow['lawfirm'] . "')";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
    public function del_client($id)
    {
        $query  = "update t_client set Active='0' where ID='" . $id . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
}
