<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_login extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_users');
        $this->load->model('M_login');
        $this->load->helper(array('download', 'file', 'url', 'html'));
    }

    public function login()
    {
        $user_data = $this->M_login->login($_POST['user']);
        if ($user_data->num_rows() > 0) {
            if (password_verify($_POST['password'], $user_data->result()[0]->Password)) {
                if ($user_data->result()[0]->Active == 0) {
                    print_r('NO');
                } else {
                    $session_data = array(
                        'name'     => $user_data->result()[0]->UserName,
                        'iduser'   => $user_data->result()[0]->ID,
                        'profile'  => $user_data->result()[0]->Profile_ID,
                        'squareid' => $user_data->result()[0]->Square_ID,
                        'lawfirm'  => $user_data->result()[0]->Company,
                        'type'     => 'user',
                    );
                    $this->session->set_userdata('ezlow', $session_data);
                    print_r('SI');
                }

            } else {
                print_r('NO');
            }
        } else {
            $user_data2 = $this->M_login->login_client($_POST['user']);
            if (password_verify($_POST['password'], $user_data2->result()[0]->C_Password)) {
                $session_data = array(
                    'name'     => $user_data2->result()[0]->C_Name,
                    'iduser'   => $user_data2->result()[0]->ID,
                    'profile'  => '',
                    'squareid' => '',
                    'lawfirm'  => '',
                    'type'     => 'client',
                );
                $this->session->set_userdata('ezlow', $session_data);
                print_r('SI');
            } else {
                print_r('NO');
            }
        }
    }

    public function clienteinfo()
    {
        require "class.phpmailer.php";
        require "class.smtp.php";

        $nombre   = $_POST["nombre"];
        $email1   = $_POST["email"];
        $telefono = $_POST["telefono"];
        $apellido = $_POST["apellido"];
        $ciudad   = $_POST["ciudad"];

        $nombre = $nombre;

        $email        = 'info@ezlawpay.com';
        $destinatario = "josua.gg@ezlawpay.com";

        $smtpHost    = "mail.ezlawpay.com";
        $smtpUsuario = "";
        $smtpClave   = "";

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port     = 587;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        $mail->Host     = $smtpHost;
        $mail->Username = $smtpUsuario;
        $mail->Password = $smtpClave;

        $mail->From     = $email;
        $mail->FromName = 'Ezlawpay';
        $mail->AddAddress($email1);

        $mail->Subject = "Ezlawpay account";
        $mail->Body    = "
<html>

<body>

<p>Hi, </p>

<p>We are in the process of setting up your account. You will receive a separate email from one of our representatives with more details about our platform. </p>
<p> In the meantime, please feel free to contact us at (747)205-3022 if you have any questions. </p>
<p>We hope your experience with Ez Law Pay exceeds your expectations. </p>

    <p>Regards.</p>

    <img width='300' height='80' src='https://ezlawpay.com/ez/assets/img/OriginalOnTransparent.png'>

</body>

</html>

<br />";

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ),
        );

        $estadoEnvio = $mail->Send();
        if ($estadoEnvio) {

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Port     = 587;
            $mail->IsHTML(true);
            $mail->CharSet = "utf-8";

            $mail->Host     = $smtpHost;
            $mail->Username = $smtpUsuario;
            $mail->Password = $smtpClave;

            $mail->From     = $email;
            $mail->FromName = 'Ezlawpay';
            $mail->AddAddress($email);

            $mail->Subject = "Ezlawpay account";

            $mail->Body = "
<html>

<body>

<p>Informacion enviada por el usuario de la web:</p>

<p>Nombre: {$nombre}</p>
<p>Apellido: {$apellido}</p>
<p>Email: {$email1}</p>
<p>Telefono: {$telefono}</p>



</body>

</html>

<br />";

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ),
            );

            $estadoEnvio = $mail->Send();
            if ($estadoEnvio) {

            } else {

            }

        } else {

        }

        print_r(1);
    }

    public function resetpass()
    {
        $user_data = $this->M_login->resetpass($_POST['username']);
        if (!empty($user_data)) {

            $this->M_users->resetpass($user_data);

            require "class.phpmailer.php";
            require "class.smtp.php";

            $email        = 'info@ezlawpay.com';
            $destinatario = $_POST['email'];

            $smtpHost    = "mail.ezlawpay.com";
            $smtpUsuario = "";
            $smtpClave   = "";

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Port     = 587;
            $mail->IsHTML(true);
            $mail->CharSet = "utf-8";

            $mail->Host     = $smtpHost;
            $mail->Username = $smtpUsuario;
            $mail->Password = $smtpClave;

            $mail->From     = $email;
            $mail->FromName = 'Ezlawpay';
            $mail->AddAddress($destinatario);

            $mail->Subject = "Ezlawpay account";
            $mail->Body    = "
<html>

<body>

<p>Hi, </p>

<p></p>
<p>Your new password is: 123456 </p>


    <img width='300' height='80' src='https://ezlawpay.com/ez/assets/img/OriginalOnTransparent.png'>

</body>

</html>

<br />";

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ),
            );

            $estadoEnvio = $mail->Send();

            print_r(1);
        }
    }
}
