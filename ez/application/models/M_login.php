<?php
class M_login extends CI_Model
{

    public function login($user)
    {
        $query  = "SELECT * from t_users where UserName='" . $user . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function startLogin($iduser)
    {
        date_default_timezone_set('America/Chicago');
        $this->db->set('FdLastLogin', date("Y-m-d h:i:s a"))
            ->where('fnId', $iduser)
            ->update('tusers');
    }
    public function login_client($user)
    {
        $query  = "SELECT * FROM t_client where C_User='" . $user . "'";
        $result = $this->db->query($query);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function resetpass($user)
    {
        $query  = "SELECT ID from t_users where UserName='" . $user . "'";
        $result = $this->db->query($query)->result()[0]->ID;
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

}
