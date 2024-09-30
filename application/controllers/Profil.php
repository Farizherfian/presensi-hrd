<?php 

class Profil extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Karyawan_m');
		$this->load->model('Login_m');
	}

	public function index()
	{
		$id = $this->session->userdata('id');
		$data['karyawan'] = $this->Karyawan_m->detail($id);
		$data['judul'] = 'Profil';
		$this->load->view('template/header',$data);
		$this->load->view('profil/v_profil',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	public function ubahpassword()
	{
		$this->form_validation->set_rules('password', 'Password Saat ini', 'required');
        $this->form_validation->set_rules('passwordnew', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('konfirmasi', 'Konfirmasi Password Baru', 'required|matches[passwordnew]');

        if ($this->form_validation->run() == FALSE) {
            $id = $this->session->userdata('id');
			$data['karyawan'] = $this->Karyawan_m->detail($id);
            $data['judul'] = 'Profil';
			$this->load->view('template/header',$data);
			$this->load->view('profil/v_profil',$data);
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
        } else {
            $id = $this->session->userdata('id');
			$data['user'] = $this->Karyawan_m->detail($id);

            // Verifikasi password saat ini
            if (password_verify($this->input->post('password'), $data['user']['password'])) {
                // Ubah password
                $new_password = password_hash($this->input->post('passwordnew'), PASSWORD_DEFAULT);
                $this->Login_m->ubah_password($id, $new_password);

                $this->session->set_flashdata('berhasil', 'Password berhasil diubah');
                redirect(base_url('profil'));
            } else {
                $this->session->set_flashdata('gagal', 'Password saat ini tidak sesuai!');
                $id = $this->session->userdata('id');
				$data['karyawan'] = $this->Karyawan_m->detail($id);
				$data['judul'] = 'Profil';
				$this->load->view('template/header',$data);
				$this->load->view('profil/v_profil',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
            }
        }
	}

}



 ?>