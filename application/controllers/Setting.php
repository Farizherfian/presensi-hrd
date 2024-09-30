<?php 

class Setting extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Setting_m');
        if ($this->session->userdata('nr') == 'Karyawan') {
            $this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
        }
	}
	    public function index() {
        // Ambil semua pengaturan dari database
        $data['setting'] = array(
            'nama_aplikasi' => $this->Setting_m->get_setting('app_name')->value ?? '',
            'jam_masuk' => $this->Setting_m->get_setting('jam_masuk')->value ?? '',
            'jam_pulang' => $this->Setting_m->get_setting('jam_pulang')->value ?? '',
            'latitude' => $this->Setting_m->get_setting('latitude')->value ?? '',
            'longitude' => $this->Setting_m->get_setting('longitude')->value ?? '',
            'radius' => $this->Setting_m->get_setting('radius')->value ?? '',
            'smtp_host' => $this->Setting_m->get_setting('smtp_host')->value ?? '',
            'smtp_user' => $this->Setting_m->get_setting('smtp_user')->value ?? '',
            'ssl_tsl' => $this->Setting_m->get_setting('ssl_tsl')->value ?? '',
            'smtp_port' => $this->Setting_m->get_setting('smtp_port')->value ?? ''
        );
        $data['judul'] = 'Setting';
	  	$this->load->view('template/header',$data);
	  	$this->load->view('setting/v_setting');
	  	$this->load->view('template/sidebar');
	  	$this->load->view('template/footer');
    }

    public function update() {
        // Validasi form
        $this->form_validation->set_rules('nama_aplikasi', 'Nama Aplikasi', 'required');
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required');
        $this->form_validation->set_rules('jam_pulang', 'Jam Pulang', 'required');
        $this->form_validation->set_rules('latitude', 'Latitude', 'required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');
        $this->form_validation->set_rules('radius', 'Radius', 'required');
        $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'required');
        $this->form_validation->set_rules('ssl_tsl', 'SSL/TSL', 'required');
        $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman setting
            $this->index();
        } else {
            // Ambil nilai dari input form
            $settings = array(
                'app_name' => $this->input->post('nama_aplikasi'),
                'jam_masuk' => $this->input->post('jam_masuk'),
                'jam_pulang' => $this->input->post('jam_pulang'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'radius' => $this->input->post('radius'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_user' => $this->input->post('smtp_user'),
                'ssl_tsl' => $this->input->post('ssl_tsl'),
                'smtp_port' => $this->input->post('smtp_port')
            );

            if (!empty($_FILES['logo']['name'])) {
	            $config['upload_path'] = './assets/uploads/logo/';
	            $config['allowed_types'] = 'gif|jpg|png';
	            $config['max_size'] = 2048; // 2MB
	            $config['file_name'] = 'logo_' . time(); // Nama file unik berdasarkan waktu

	            $this->load->library('upload', $config);
	            $this->upload->initialize($config);

	            if ($this->upload->do_upload('logo')) {
	                // Jika berhasil diupload, simpan nama file ke database
	                $upload_data = $this->upload->data();
	                $settings['logo'] = $upload_data['file_name'];
	            } else {
	                // Jika gagal upload, tampilkan pesan error
	                $error = $this->upload->display_errors();
	                $this->session->set_flashdata('error', $error);
	                redirect('setting');
	            }
	        }

            // Simpan semua pengaturan
            foreach ($settings as $keyword => $value) {
                $this->Setting_m->save_setting($keyword, $value, $this->session->userdata('nama_lengkap'));
            }
            redirect('setting');
        }
    }

}
?>