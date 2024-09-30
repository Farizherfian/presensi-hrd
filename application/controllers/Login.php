<?php 

/**
 * 
 */
class Login extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_m');
	}

	public function index() 
	{
     	$this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

	    if ($this->form_validation->run() == FALSE) {
	        $data['judul'] = $this->config->item('app_name');;
			$this->load->view('login/v_login',$data);
		} else {
			$bukan_karyawan = ['Pensiun', 'Tidak Aktif'];
	        $nik = $this->input->post('nik');
	        $password = $this->input->post('password');
			
			$user = $this->Login_m->get_karyawan_by_nik($nik);

			// if (!$user) {

			// }

			if (in_array($user['status_kepegawaian'], $bukan_karyawan)) {
				$this->session->set_flashdata('error', 'Anda Sudah Pensiun atau Tidak Aktif');
	            redirect(base_url());
			}else{
				if ($user && (password_verify($password, $user['password']))) {
					$user['login'] = true;
					$this->session->set_userdata(
						$user
						// [
		    //                 'id_karyawan' => $user->id,
		    //                 'nama' => $user->nama_lengkap,
		    //                 'id_roles' => $user->id_roles,
		    //                 'login' => TRUE
		    //             ]
		            );
		            $this->session->set_flashdata('berhasil', 'Selamat Datang');
		            redirect('dashboard');
		        } else {
		            $this->session->set_flashdata('error', 'NIK atau Password salah!');
		            redirect(base_url());
		        }
		    }
		}
    }

    public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}


}



 ?>