<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('MainModel');
    }

    public function do_login()
	{
		$email = $_POST['email'];
		$pass = $_POST['pass'];

		$where = array(
			'email_member' => $email,
			'password_member' => $pass
		);

		if ($login = $this->mymodel->GetMember($where)) {
			$_SESSION['id_member'] = $login['id_member'];
			$_SESSION['email_member'] = $login['email_member'];
			$_SESSION['nama_member'] = $login['nama_member'];
			$_SESSION['status'] = "login";
			$this->load->view('hal_home_cust');
		}else{
			echo "Login Gagal";
		}
	}

    // function aksi_login() {
    //     $username = $this->input->post('username');
    //     $password = $this->input->post('password');
    //     $where = array(
    //         'username'=> $username,
    //         'password'=> $password
    //     );
    //     $data = $this->model_login->cek_login('admin',$where);
    //     $cek = $data->num_rows();
    //     if ($cek==1) {
    //         $level = $data->result_array()[0]['level'];
    //         $data_session = array(
    //             'nama'=>$username,
    //             'status'=>"login",
    //             'level' => $level
    //         );
    //         $this->session->set_userdata($data_session);
    //         redirect(base_url("index.php/mahasiswa"));
            
    //     } else {
    //         redirect(base_url("index.php"));
    //     }
    // }
    // function logout() {
    //     $this->session->session_destroy;
    //     redirect(base_url("index.php/login"));
    // }
}

?>