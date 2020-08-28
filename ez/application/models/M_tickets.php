<?php
class M_tickets extends CI_Model
{

    public function tickets()
    {
        $query = "SELECT * FROM tickets WHERE Usuario = '" . $_SESSION['ezlow']['iduser'] . "' ORDER BY ID DESC";
        $data  = $this->db->query($query);
        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function totaltick()
    {
        $query = "SELECT tickets.*, t_users.Name FROM tickets, t_users WHERE t_users.ID = tickets.Usuario AND Status =1 ORDER BY ID DESC";
        $data  = $this->db->query($query);

        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }

    }

    public function addedit($info)
    {
        $query = "UPDATE t_balance SET Id_contract='" . $info['nuevo'] . "' WHERE Id_ticket = '" . $info['id'] . "'";
        $this->db->query($query);
    }

    public function balancesshow()
    {
        $query = "SELECT t_contracts.Contract_N, t_users.Name, tickets.fecha, t_contracts.ID, t_client.C_Name FROM t_balance INNER JOIN t_contracts ON t_contracts.ID = t_balance.Id_contract INNER JOIN tickets ON t_balance.Id_ticket = tickets.ID INNER JOIN t_users ON tickets.Usuario = t_users.ID INNER JOIN t_client ON t_contracts.Client_ID=t_client.ID WHERE tickets.Status = 3";

        $informacion = $this->db->query($query)->result();

        return $informacion;

    }

    public function totaltickp()
    {
        $query = "SELECT tickets.*, t_users.Name FROM tickets, t_users WHERE t_users.ID = tickets.Usuario AND Status =2 AND tomar = '" . $_SESSION['ezlow']['iduser'] . "' ORDER BY ID DESC";
        $data  = $this->db->query($query);

        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }

    }

    public function historial()
    {
        $query = "SELECT tickets.fecha, tickets.Descripcion, tickets.Archivo, tickets.observaciones, tv.Name as creeo, tm.Name as realiza FROM tickets INNER JOIN t_users as tv ON tv.ID = tickets.Usuario INNER JOIN t_users as tm ON tm.ID = tickets.tomar WHERE tickets.Status = 3 ORDER BY tickets.ID DESC";
        $data  = $this->db->query($query);

        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function asignados()
    {
        $query = "SELECT tickets.*, t_users.Name FROM tickets, t_users WHERE tickets.Status = 2 AND tickets.tomar = t_users.ID ORDER BY ID DESC";
        $data  = $this->db->query($query);

        if (!empty($data)) {
            return $data->result();
        } else {
            return false;
        }
    }

    public function addtickets($info)
    {

        $cadena = "INSERT INTO tickets( Type, Descripcion, Status, Usuario) VALUES ('" . $info['types'] . "', '" . $info['descrip'] . "', 1, '" . $_SESSION['ezlow']['iduser'] . "')";
        $this->db->query($cadena);

        $cadena = "SELECT MAX(ID) AS id FROM tickets";
        $id     = $this->db->query($cadena)->result();
        $this->new_tickets();

        return $id[0]->id;

    }

    public function addarchivo($id, $ter)
    {

        $cadena = "UPDATE tickets SET Archivo = '" . $ter . "' WHERE ID = '" . $id . "'";

        $this->db->query($cadena);
        $this->new_tickets();
    }

    public function tomar($id)
    {

        $cadena = "UPDATE tickets SET tomar = '" . $_SESSION['ezlow']['iduser'] . "' , Status = 2  WHERE ID = '" . $id['id'] . "'";

        $this->db->query($cadena);
        $this->new_tickets();
    }

    public function cerrar($id)
    {

        $cadena = "UPDATE tickets SET Status = 3, observaciones = '" . $id['observaciones'] . "' WHERE ID = '" . $id['id'] . "'";

        $this->db->query($cadena);
        $this->new_tickets();
    }

    public function obtener($info)
    {

        $query  = "SELECT Id_contract FROM t_balance WHERE Id_ticket = '" . $info . "' LIMIT 1";
        $result = $this->db->query($query)->result();

        if (!empty($result[0]->Id_contract)) {

            return $result[0]->Id_contract;
        }

    }

    public function new_tickets()
    {
        $query  = "SELECT count(*) as sum FROM tickets where status = 1";
        $result = $this->db->query($query)->result()[0]->sum;

        $_SESSION['ezlow']['ntickets'] = $result;
    }

    public function balance($info)
    {

        $query   = "SELECT * FROM t_balance WHERE Id_contract = '" . $info['id'] . "'";
        $obtener = $this->db->query($query)->result();

        if (empty($obtener)) {
            $query = "INSERT INTO t_balance(Id_contract, Id_ticket) VALUES ('" . $info['id'] . "' , '" . $info['id_tickets'] . "')";
            $this->db->query($query);
        } else {

            $query = "UPDATE t_balance SET Id_ticket='" . $info['id_tickets'] . "' WHERE Id_contract = '" . $info['id'] . "'";
            $this->db->query($query);
        }

    }

    public function new_balance($ajax_call = false)
    {
        $new_balance = 1;
        $in_process  = 2;
        $processed   = 3;
        $counter     = $this->balance_ticket_data(array($new_balance, $in_process, $processed), true);

        if ($counter = 0) {
            return;
        }

        $new_balance_request = $this->balance_ticket_data($new_balance, true, false, true);
        $balance_processed   = $this->balance_ticket_data($processed, false, true, false);

        $message_type              = array();
        $message_type['waiting']   = !empty($new_balance_request) ? $new_balance_request : $new_balance_request;
        $message_type['processed'] = !empty($balance_processed) ? true : false;

        if ($ajax_call) {
            return $message_type['waiting'];
        }

        $_SESSION['ezlow']['nbalance'] = $message_type;
    }

    private function balance_ticket_data($status, $counter = false, $date_control = false, $new_balance = false)
    {
        $balance_ticket = 6;
        $yesterday      = date('d.m.Y', strtotime("-1 days"));

        if ($new_balance) {
            $this->db->select('Status');
            $this->db->from('tickets as t');
            $this->db->where('t.Type', $balance_ticket);
        } else {
            $this->db->select('Status');
            $this->db->from('t_balance as tb');
            $this->db->join('tickets as t', 't.ID = tb.id_ticket');
            $this->db->where('t.Type', $balance_ticket);
        }

        if (is_array($status)) {
            foreach ($status as $state) {
                $this->db->where('t.Status =', $state);
            }
        } else {
            $this->db->where('t.Status =', $status);
        }

        if ($date_control) {
            $this->db->where('t.fecha >', $yesterday);
        }

        $query = $this->db->get();

        if ($counter) {
            return $query->num_rows();
        }

        return $query->last_row();
    }
}
