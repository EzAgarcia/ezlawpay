<?php
class M_setting extends CI_Model
{
    public function save_profile($data)
    {
        $nuew_pass = password_hash($data['pass1'], PASSWORD_DEFAULT);
        $query     = "UPDATE t_users SET Password='" . $nuew_pass . "' WHERE ID='" . $this->session->ezlow['iduser'] . "'";
        $result    = $this->db->query($query);
        if (!empty($result)) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
}
