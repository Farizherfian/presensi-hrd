<?php 

class Karyawan extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Karyawan_m');
        if ($this->session->userdata('nr') == 'Karyawan') {
            $this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
        }
	}

	public function index()
	{
		$data['judul'] = 'Data Karyawan';
		$data['karyawan'] = $this->Karyawan_m->get_all_karyawan();
		$this->load->view('template/header',$data);
		$this->load->view('karyawan/v_karyawan',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('departemen', 'Departemen', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');
        $this->form_validation->set_rules('status', 'Status Kepegawaian', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');


		if ($this->form_validation->run() != FALSE) {
			$config['upload_path'] = './assets/uploads/';
        	$config['allowed_types'] = 'jpg|png|jpeg';
       	 	$config['max_size'] = 2048;

        	$this->load->library('upload', $config);
        	$this->upload->initialize($config);

        	if (!$this->upload->do_upload('foto')) {
		            $foto = 'default.png';
		        } else {
		            $foto = $this->upload->data('file_name');
		        }

			    $tahun = date('y');
				$id_departemen = str_pad($this->input->post('departemen'), 2, "0", STR_PAD_LEFT);

				// $this->db->like('nik', $tahun . $id_departemen, 'after'); Mencari NIK yang dimulai dengan tahun dan ID departemen yang sesuai
				// $this->db->from('karyawan');
				// $total_karyawan = $this->db->count_all_results();
				$this->db->like('nik', $tahun . $id_departemen, 'after');
				$this->db->order_by('id', 'DESC'); // Urutkan berdasarkan ID secara menurun
				$this->db->limit(1);
				$last_nik = $this->db->get('karyawan')->row('nik');

				if ($last_nik) {
				    // Ambil bagian nomor urutan dari NIK terakhir
				    $last_urutan = (int)substr($last_nik, -4);
				    $new_urutan = str_pad($last_urutan + 1, 4, '0', STR_PAD_LEFT);
				} else {
				    // Jika belum ada NIK untuk tahun dan departemen ini, mulai dari 0001
				    $new_urutan = '0001';
				}

				// $urutan = str_pad($total_karyawan + 1, 4, '0', STR_PAD_LEFT);

				$nik = $tahun . $id_departemen . $new_urutan;

				$data = [
	                'id_roles' => $this->input->post('role'),
	                'nama_lengkap' => ucwords(preg_replace('/\s+/', ' ', strtolower(trim($this->input->post('nama', true))))),
	                'nik' => $nik,
	                'password' => password_hash($nik, PASSWORD_DEFAULT),
	                'alamat' => $this->input->post('alamat'),
	                'no_telepon' => $this->input->post('no_hp'),
	                'email' => $this->input->post('email'),
	                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
	                'jenis_kelamin' => $this->input->post('kelamin'),
	                'tanggal_masuk' => $this->input->post('tanggal_masuk'),
	                'status_kepegawaian' => $this->input->post('status'),
	                'foto' => $foto,
	                'batas_cuti' => 12,
	                'created_by' => $this->session->userdata('id')
	            ];
	            
	            $id_karyawan = $this->Karyawan_m->tambah($data);

	            
	            $data_jabatan = [
	                'id_karyawan' => $id_karyawan,
	                'id_jabatan' => $this->input->post('jabatan'),
	                'created_by' => $this->session->userdata('id')
	            ];

	            $this->Karyawan_m->tambah_jabatan($data_jabatan);
				$options = [
				    'from_email' => $this->session->userdata('email'), // Ganti dengan email pengirim Anda
				    'from_name' => 'HRD',
				    'to' => $this->input->post('email'), // Email karyawan yang baru ditambahkan
				    'subject' => 'Selamat Bergabung, ' . $this->input->post('nama'),
				    'message' => 'Halo ' . ucwords($this->input->post('nama')) . ',<br><br>' .
				                 'Selamat datang di perusahaan kami. Berikut informasi akun Anda:<br>' .
				                 'NIK: ' . $nik . '<br>' .
				                 'Password: ' . $nik . '<br><br>' .
				                 'Silakan login menggunakan NIK Anda.<br><br>' .
				                 'Salam,<br>HRD',
				];

				// Mengirimkan email menggunakan fungsi send_email
				if (send_email($options)) {
				    $this->session->set_flashdata('berhasil', 'Tambah Pegawai Berhasil dan Email terkirim');
				} else {
				    $this->session->set_flashdata('error', 'Tambah Pegawai Berhasil tetapi gagal mengirim email');
				}
				redirect(base_url('karyawan'));
			
		}else{
			$data=[
				'judul' => 'Data Karyawan',
				'role' => $this->db->get('roles')->result(),
				'departemen' => $this->db->get('departemen')->result(),
				'jabatan' => $this->db->get('jabatan')->result()
			];
			$this->load->view('template/header',$data);
			$this->load->view('karyawan/v_karyawan_tambah');
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
		}
	}

	public function edit($id) {
        $data=[
        	'judul' => 'Edit Data Pegawai',
        	'karyawan' => $this->Karyawan_m->get_karyawan_by_id($id),
			'role' => $this->db->get('roles')->result(),
			'departemen' => $this->db->get('departemen')->result(),
			'jabatan' => $this->db->get('jabatan')->result()
		];
		if (!$data['karyawan']) {
            show_404();
        }
		$this->load->view('template/header',$data);
		$this->load->view('karyawan/v_karyawan_edit',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
    }
    public function update($id)
	{
		$data['karyawan'] = $this->db->get_where('karyawan', ['id' => $id])->row_array();
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('departemen', 'Departemen', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');
        $this->form_validation->set_rules('status', 'Status Kepegawaian', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');


		if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $config['upload_path'] = './assets/uploads/';
	        $config['allowed_types'] = 'jpg|png';
	        $config['max_size'] = 2048;

	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);

	        if (!$this->upload->do_upload('foto')) {
	            // Jika tidak ada foto yang diunggah, gunakan foto lama
	            $foto = $data['karyawan']['foto'];
	        } else {
	            // Hapus foto lama jika ada
	            if ($data['karyawan']['foto'] != 'default.jpg') {
	                unlink('./assets/uploads/' . $data['karyawan']['foto']);
	            }
	            // Gunakan foto baru
	            $foto = $this->upload->data('file_name');
	        }

	        // Data yang akan diupdate ke dalam database
	        $data = [
	            'nama_lengkap' => ucwords(preg_replace('/\s+/', ' ', strtolower(trim($this->input->post('nama', true))))),
	            'email' => $this->input->post('email'),
	            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
	            'jenis_kelamin' => $this->input->post('kelamin'),
	            'no_telepon' => $this->input->post('no_hp'),
	            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
	            'status_kepegawaian' => $this->input->post('status'),
	            'id_roles' => $this->input->post('role'),
	            'alamat' => $this->input->post('alamat'),
	            'foto' => $foto,
	            'update_by' => $this->session->userdata('id')
        	];

            $this->Karyawan_m->update($id, $data);

            $jabatan_data = [
                'id_jabatan' => $this->input->post('jabatan'),
                'update_by' => $this->session->userdata('id')
            ];
            $this->Karyawan_m->update_jabatan($id, $jabatan_data);

            $this->session->set_flashdata('berhasil', 'Edit Data Berhasil');
            redirect('karyawan');
        }
	}

	public function detail($id)
	{
			$data['judul'] = 'Detail Karayawan';
			$data['karyawan'] = $this->Karyawan_m->detail($id);
			$this->load->view('template/header',$data);
			$this->load->view('karyawan/v_karyawan_detail',$data);
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
	}
	public function hapus($id)
	{

	    $karyawan = $this->db->get_where('karyawan', ['id' => $id])->row_array();

	    if ($karyawan['foto'] != 'default.png') {
	        
	        if (file_exists('./assets/uploads/' . $karyawan['foto'])) {
	            unlink('./assets/uploads/' . $karyawan['foto']);
	        }
	    }

        $this->Karyawan_m->hapus($id);
        $this->session->set_flashdata('berhasil', 'Hapus Data Berhasil');
	    redirect('karyawan');
	}
	public function excel()
	{
		$data = $this->Karyawan_m->export_excel();
		$header = array_keys($data[0]);
		    $headers = [];

		    foreach ($header as $key => $value) {
		    	if ($value == 'nik') {
		    		$headers[] = strtoupper($value);
		    	} else {
		    		$headers[] = ucwords(strtolower(str_replace('_', ' ', $value)));
		    	}
		    }
		$filename = 'Data Karyawan_' . date('Y');
        export_excel($data, $filename, $headers);
	}
	// public function hapus($id)
	// {

	//     $this->db->where('id', $id);
	//     $this->db->update('karyawan', [
	//         'is_deleted' => 1,
	//         'delete_by' => $this->session->userdata('id')
	//     ]);

	//     $this->session->set_flashdata('berhasil', 'Hapus Data Berhasil');
	//  	redirect('karyawan');
	// }

}
?>