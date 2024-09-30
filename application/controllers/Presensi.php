<?php 

class Presensi extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Presensi_m');
		$this->load->model('Karyawan_m');
	}

	// public function presensi_index()
	// {
	// 	if ($this->session->userdata('nr') != 'Karyawan') {

	// 		$data['judul'] = 'Data Presensi';
	// 		$data['presensi'] = $this->Presensi_m->tampil();
	// 		$this->load->view('template/header',$data);
	// 		$this->load->view('presensi/v_presensi',$data);
	// 		$this->load->view('template/sidebar');
	// 		$this->load->view('template/footer');
	// 	}else{
	// 		$id_karyawan = $this->session->userdata('id');
	// 		$hari_ini = date('Y-m-d');
	// 		$data = [
	// 			'judul' => 'Presensi',
	// 			'cek_cuti' => $this->Presensi_m->cek_cuti($id_karyawan,$hari_ini),
	// 			'cek_presensiMasuk' => $this->Presensi_m->cek_presensiMasuk($id_karyawan),
	// 			'cek_presensiKeluar' => $this->Presensi_m->cek_presensiKeluar($id_karyawan)
	// 		];
	// 		$this->load->view('template/header',$data);
	// 		$this->load->view('presensi/v_presensi',$data);
	// 		$this->load->view('template/sidebar');
	// 		$this->load->view('template/footer');
	// 	}
	// }

	public function index()
	{
		$id_user = $this->session->userdata('id');
		$data['judul'] = 'Data Presensi';
		$data['presensi'] = $this->Presensi_m->tampil($id_user);
		$this->load->view('template/header',$data);
		$this->load->view('presensi/v_presensi',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}

	public function presensiMasuk()
	{
		if ($this->session->userdata('nr') == 'Karyawan') {
			if ($this->input->method() == 'post') {
				$latitude_user = $this->input->post('latitude_user');
				$radius = $this->config->item('radius');

				$jarak = $this->hitung_jarak($latitude_user);
				// var_dump($jarak);
				// die;

				if ($jarak > $radius) {
					$this->session->set_flashdata('error','Anda Berada diluar area kantor!!');
	            	redirect(base_url('dashboard'));
				}

				$data['judul'] = 'Presensi Masuk';
				$this->load->view('template/header',$data);
				$this->load->view('presensi/v_presensi_masuk');
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
			}else{
				redirect(base_url('dashboard'));
			}
		}else{
			$this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
		}	
	}
	public function presensiMasuk_proses()
	{
		if ($this->session->userdata('nr') == 'Karyawan') {
			date_default_timezone_set('Asia/Jakarta');
			$nik = $this->session->userdata('nik');
			$foto = $this->input->post('foto');

	        if (empty($foto)) {
			    redirect(base_url('dashboard'));
			}
		    $folderPath = "./assets/uploads/presensi/". $nik . "/masuk/";

		    $image_parts = explode(";base64,", $foto);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];

		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = date('YmdHis') . '.' .$image_type;

		    $file = $folderPath . $fileName;

		    if (!is_dir($folderPath)) {
			    mkdir($folderPath, 0777, true);
			}

		    file_put_contents($file, $image_base64);

		    $data = [
		        'id_karyawan' => $this->session->userdata('id'),
		        'waktu_masuk' => date('Y-m-d H:i:s'),
		        'foto_masuk' => $fileName,
		        'created_by' => $this->session->userdata('id')
		    ];
	    
	    	$this->Presensi_m->presensi_masuk($data);

	    	echo json_encode(['status' => 'success']);
    	}else{
			$this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
		}
	}
	public function presensiKeluar()
	{
		if ($this->session->userdata('nr') == 'Karyawan') {
			if ($this->input->method() == 'post') {
				$id = $this->session->userdata('id');
				$latitude_user = $this->input->post('latitude_user');
				$radius = $this->config->item('radius');

				$jarak = $this->hitung_jarak($latitude_user);
				if ($jarak > $radius) {
					$this->session->set_flashdata('error','Anda Berada diluar area kantor!!');
	            	redirect(base_url('dashboard'));
				}
				$data = [
					'judul' => 'Presensi Keluar',
					'id_presensi' => $this->Presensi_m->get_id_presensi($id)
				];
				$this->load->view('template/header',$data);
				$this->load->view('presensi/v_presensi_keluar',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
			}else{
				redirect(base_url('dashboard'));
			}
		}else{
			$this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
		}
	}
	public function presensiKeluar_proses()
	{
		if ($this->session->userdata('nr') == 'Karyawan') {
			date_default_timezone_set('Asia/Jakarta');
			$nik = $this->session->userdata('nik');
			$foto = $this->input->post('foto');
			if (empty($foto)) {
			    redirect(base_url('dashboard'));
			}
		    $folderPath = "./assets/uploads/presensi/". $nik . "/keluar/";

		    $image_parts = explode(";base64,", $foto);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];

		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = date('YmdHis') . '.' .$image_type;

		    $file = $folderPath . $fileName;
		    if (!is_dir($folderPath)) {
			    mkdir($folderPath, 0777, true);
			}
		    file_put_contents($file, $image_base64);

		    $data = [
		        'waktu_keluar' => date('Y-m-d H:i:s'),
		        'foto_keluar' => $fileName,
		        'update_by' => $this->session->userdata('id')
		    ];
		    $id = $this->input->post('id_presensi');
	    
	    	$this->Presensi_m->presensi_keluar($id,$data);
			echo json_encode(['status' => 'success']);
		}else{
			$this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
		}
	}

	private function hitung_jarak($latitude_user)
	{
		$latitude_user = $latitude_user;
		$latitude_kantor = $this->config->item('latitude');

		$jarak = sin(deg2rad($latitude_user)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_user)) * cos(deg2rad($latitude_kantor));
		$jarak = acos($jarak);
		$jarak = rad2deg($jarak);
		$mil = $jarak * 60 * 1.1515;
		$km = $mil * 1.609344;
		$jarak_meter = floor($km * 1000);

		return $jarak_meter;
	}

}
?>