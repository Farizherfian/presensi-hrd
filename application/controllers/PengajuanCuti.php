<?php 

class PengajuanCuti extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PengajuanCuti_m');
	}

	public function index()
	{
		$id_karyawan = $this->session->userdata('id');
		$data = [
			'judul' => 'Pengajuan Cuti/Sakit',
			'pengajuan' => $this->PengajuanCuti_m->tampil($id_karyawan)
		];
		$this->load->view('template/header',$data);
		$this->load->view('pengajuancuti/v_pengajuancuti',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	public function tambah()
	{
		$id_karyawan = $this->session->userdata('id');
    	$cek_status = $this->db->get_where('cuti',['id_karyawan' => $id_karyawan,'status_pengajuan' => 'PENDING'])->row();
    	if ($cek_status) {
    		$this->session->set_flashdata('error', 'Pengajuan masih PENDING');
		    redirect('pengajuancuti');
    	}else{

	    	$this->form_validation->set_rules('jeniscuti', 'Jenis Cuti', 'required');
	    	$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
	    	$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');

	    	if ($this->form_validation->run() == FALSE) {
	 
	        	$data = [
					'judul' => 'Pengajuan Cuti/Sakit'
				];
				$this->load->view('template/header',$data);
				$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
	    	} else {
	    		if ($this->input->post('jeniscuti') == 'Cuti') {
	    			$id_karyawan = $this->session->userdata('id');
	    			$cuti = $this->db->get_where('karyawan',['id' => $id_karyawan])->row();

	            	$tanggal_mulai = new DateTime($this->input->post('tanggal_mulai'));
					$tanggal_selesai = new DateTime($this->input->post('tanggal_selesai'));
					$interval = $tanggal_mulai->diff($tanggal_selesai);
					$jumlah_hari = $interval->days + 1;

					$tanggal_sama = $this->PengajuanCuti_m->tanggal_sama($id_karyawan,$tanggal_selesai,$tanggal_mulai);

	    			$jumlah_hari_cuti = $this->PengajuanCuti_m->jumlah_hari_cuti($id_karyawan);
					$batas_hari = 3;
					if (($jumlah_hari_cuti->jumlah_hari + $jumlah_hari) > $cuti->batas_cuti) {
						$data['judul'] = 'Pengajuan Cuti/Sakit';
						$this->session->set_flashdata('gagal', 'Anda melewati batas cuti');
						$this->load->view('template/header',$data);
						$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
						$this->load->view('template/sidebar');
						$this->load->view('template/footer');
					}elseif ($jumlah_hari <= 0) {
						$data['judul'] = 'Pengajuan Cuti/Sakit';
						$this->session->set_flashdata('gagal', 'Masukkan Tanggal yang sesuai');
						$this->load->view('template/header',$data);
						$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
						$this->load->view('template/sidebar');
						$this->load->view('template/footer');
					}elseif ($this->input->post('tanggal_mulai') < date('Y-m-d')) {
						$data['judul'] = 'Pengajuan Cuti/Sakit';
						$this->session->set_flashdata('gagal', 'Masukkan tanggal yang sesuai');
						$this->load->view('template/header',$data);
						$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
						$this->load->view('template/sidebar');
						$this->load->view('template/footer');
					} elseif ($this->tanggalTerdapatSabtuAtauMinggu($tanggal_mulai, $tanggal_selesai)) {
			            $data['judul'] = 'Pengajuan Cuti/Sakit';
			            $this->session->set_flashdata('gagal', 'Tanggal yang Anda ajukan mencakup hari Sabtu atau Minggu.');
			            $this->load->view('template/header', $data);
			            $this->load->view('pengajuancuti/v_pengajuancuti_tambah', $data);
			            $this->load->view('template/sidebar');
			            $this->load->view('template/footer');
					}elseif (!empty($tanggal_sama)) {
		                $data['judul'] = 'Pengajuan Cuti/Sakit';
		                $this->session->set_flashdata('gagal', 'Tanggal yang anda ajukan sudah digunakan.');
		                $this->load->view('template/header', $data);
		                $this->load->view('pengajuancuti/v_pengajuancuti_tambah', $data);
		                $this->load->view('template/sidebar');
		                $this->load->view('template/footer');
					}else{
				        $nik = $this->session->userdata('nik');
				        $upload_path = './assets/uploads/pengajuancuti/' . $nik . '/';

				        if (!is_dir($upload_path)) {
				            mkdir($upload_path, 0777, true);
				        }

				        $config['upload_path'] = $upload_path;
				        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
				        $config['max_size'] = 2048;
				        $config['file_name'] = date('YmdHis');

				        $this->load->library('upload', $config);
				        $this->upload->initialize($config);

				        if (!empty($_FILES['bukti']['name'])) {
					        if ($this->upload->do_upload('bukti')) {
					            // Jika upload berhasil
					            $fileData = $this->upload->data();
					            $file_name = $fileData['file_name'];

					        } else {
					            // Tangani kesalahan upload
					           $data = [
				        	         'judul' => 'Pengajuan Cuti/Sakit',
				        	         'error' => $this->upload->display_errors()
				        	     ];
				        	     $this->load->view('template/header', $data);
				        	     $this->load->view('pengajuancuti/v_pengajuancuti_tambah', $data);
				        	     $this->load->view('template/sidebar');
				        	     $this->load->view('template/footer');
					        }
					    } else {
					        // Tidak ada file yang diunggah, lanjutkan proses lainnya
					        $file_name = '';
					    }

			            $id = $this->session->userdata('id');
			            $data = [
			                'id_karyawan' => $id,
			                'jenis_cuti' => $this->input->post('jeniscuti'),
			                'tanggal_mulai' => $this->input->post('tanggal_mulai'),
			                'tanggal_selesai' => $this->input->post('tanggal_selesai'),
			                'deskripsi' => $this->input->post('deskripsi'),
			                'bukti' => $file_name,
			                'status_pengajuan' => 'PENDING',
			                'jumlah_hari' => $jumlah_hari,
			                'created_by' => $id,
			            ];

			            $this->PengajuanCuti_m->tambah($data);
			            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
			            redirect('pengajuancuti');
			        
					}

	        	}else{

	        		$nik = $this->session->userdata('nik');
	        		$tanggal_mulai1 = new DateTime($this->input->post('tanggal_mulai'));
					$tanggal_selesai1 = new DateTime($this->input->post('tanggal_selesai'));
					$interval1 = $tanggal_mulai1->diff($tanggal_selesai1);
					$jumlah_hari1 = $interval1->days + 1;

					$tanggal_sama = $this->PengajuanCuti_m->tanggal_sama($id_karyawan,$tanggal_selesai1,$tanggal_mulai1);

					if ($jumlah_hari1 <= 0) {
						$data['judul'] = 'Pengajuan Cuti/Sakit';
						$this->session->set_flashdata('gagal', 'Masukkan Tanggal yang sesuai');
						$this->load->view('template/header',$data);
						$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
						$this->load->view('template/sidebar');
						$this->load->view('template/footer');
					} elseif ($this->tanggalTerdapatSabtuAtauMinggu($tanggal_mulai1, $tanggal_selesai1)) {
			            $data['judul'] = 'Pengajuan Cuti/Sakit';
			            $this->session->set_flashdata('gagal', 'Tanggal yang Anda ajukan mencakup hari Sabtu atau Minggu.');
			            $this->load->view('template/header', $data);
			            $this->load->view('pengajuancuti/v_pengajuancuti_tambah', $data);
			            $this->load->view('template/sidebar');
			            $this->load->view('template/footer');
					}elseif (!empty($tanggal_sama)) {
		                $data['judul'] = 'Pengajuan Cuti/Sakit';
		                $this->session->set_flashdata('gagal', 'Tanggal yang anda ajukan sudah digunakan yang sudah ada.');
		                $this->load->view('template/header', $data);
		                $this->load->view('pengajuancuti/v_pengajuancuti_tambah', $data);
		                $this->load->view('template/sidebar');
		                $this->load->view('template/footer');
					}else{
			    		$upload_path = './assets/uploads/pengajuancuti/' . $nik . '/';

			    		if (!is_dir($upload_path)) {
						    mkdir($upload_path, 0777, true);
						}

			        	$config['upload_path'] = $upload_path;
			        	$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			       	 	$config['max_size'] = 2048;
			       	 	$config['file_name'] = date('YmdHis');

			        	$this->load->library('upload', $config);
		        		$this->upload->initialize($config);		        	


			        	if (!$this->upload->do_upload('bukti')) {

			            	$data = [
								'judul' => 'Pengajuan Cuti/Sakit',
								'error' => $this->upload->display_errors()
							];
							$this->load->view('template/header',$data);
							$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
							$this->load->view('template/sidebar');
							$this->load->view('template/footer');
		    			} else {
							$id = $this->session->userdata('id');
			            	$upload_data = $this->upload->data();
			            	$data = [
			            		'id_karyawan' => $id,
			                	'jenis_cuti' => $this->input->post('jeniscuti'),
			                	'tanggal_mulai' => $this->input->post('tanggal_mulai'),
			                	'tanggal_selesai' => $this->input->post('tanggal_selesai'),
			                	'deskripsi' => $this->input->post('deskripsi'),
			                	'bukti' => $upload_data['file_name'],
			                	'status_pengajuan' => 'PENDING',
			                	'jumlah_hari' => $jumlah_hari1,
			                	'created_by' => $id,
			            	];

			            	$this->PengajuanCuti_m->tambah($data);
			            	$this->session->set_flashdata('success', 'Data berhasil disimpan.');
			            	redirect('pengajuancuti');
				        }
				    }	
	    		}
    		}
    	}
	}
	public function edit($id)
	{
		$pengajuan = $this->PengajuanCuti_m->getId_pengajuan($id);

	    if (!$pengajuan) {
	        $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan.');
	        redirect('pengajuancuti');
	    }

    	$this->form_validation->set_rules('jeniscuti', 'Jenis Cuti', 'required');
    	$this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
    	$this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');

    	if ($this->form_validation->run() == FALSE) {
 
        	$data = [
				'judul' => 'Pengajuan Cuti/Sakit',
				'pengajuan' => $pengajuan
			];
			$this->load->view('template/header',$data);
			$this->load->view('pengajuancuti/v_pengajuancuti_edit',$data);
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
    	} else {
    		if ($this->input->post('jeniscuti') == 'Cuti') {
    			$id_karyawan = $this->session->userdata('id');
    			$cuti = $this->db->get_where('karyawan',['id' => $id_karyawan])->row();
    			$jumlah_hari_cuti = $this->PengajuanCuti_m->jumlah_hari_cuti($id_karyawan);

            	$tanggal_mulai = new DateTime($this->input->post('tanggal_mulai'));
				$tanggal_selesai = new DateTime($this->input->post('tanggal_selesai'));
				$interval = $tanggal_mulai->diff($tanggal_selesai);
				$jumlah_hari = $interval->days + 1;
				$tanggal_sama = $this->PengajuanCuti_m->tanggal_sama($id_karyawan,$tanggal_selesai,$tanggal_mulai);
				if (($jumlah_hari_cuti->jumlah_hari + $jumlah_hari) > $cuti->batas_cuti) {
					$data['judul'] = 'Pengajuan Cuti/Sakit';
					$this->session->set_flashdata('gagal', 'Anda melewati batas cuti');
					$this->load->view('template/header',$data);
					$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
					$this->load->view('template/sidebar');
					$this->load->view('template/footer');
				}elseif ($jumlah_hari <= 0) {
					$data = [
						'judul' => 'Pengajuan Cuti/Sakit',
						'pengajuan' => $pengajuan
					];
					$this->session->set_flashdata('gagal', 'Masukkan Tanggal yang sesuai');
					$this->load->view('template/header',$data);
					$this->load->view('pengajuancuti/v_pengajuancuti_edit',$data);
					$this->load->view('template/sidebar');
					$this->load->view('template/footer');
				}elseif ($this->input->post('tanggal_mulai') < date('Y-m-d')) {
					$data['judul'] = 'Pengajuan Cuti/Sakit';
					$this->session->set_flashdata('gagal', 'Masukkan tanggal yang sesuai');
					$this->load->view('template/header',$data);
					$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
					$this->load->view('template/sidebar');
					$this->load->view('template/footer');
				} elseif ($this->tanggalTerdapatSabtuAtauMinggu($tanggal_mulai, $tanggal_selesai)) {
		            $data['judul'] = 'Pengajuan Cuti/Sakit';
		            $this->session->set_flashdata('gagal', 'Tanggal yang Anda ajukan mencakup hari Sabtu atau Minggu.');
		            $this->load->view('template/header', $data);
		            $this->load->view('pengajuancuti/v_pengajuancuti_edit', $data);
		            $this->load->view('template/sidebar');
		            $this->load->view('template/footer');
				}elseif (!empty($tanggal_sama)) {
	                $data['judul'] = 'Pengajuan Cuti/Sakit';
	                $this->session->set_flashdata('gagal', 'Tanggal yang anda ajukan sudah digunakan yang sudah ada.');
	                $this->load->view('template/header', $data);
	                $this->load->view('pengajuancuti/v_pengajuancuti_edit', $data);
	                $this->load->view('template/sidebar');
	                $this->load->view('template/footer');
				}else{
			        $nik = $this->session->userdata('nik');
			        $upload_path = './assets/uploads/pengajuancuti/' . $nik . '/';

			        if (!is_dir($upload_path)) {
			            mkdir($upload_path, 0777, true);
			        }

			        $config['upload_path'] = $upload_path;
			        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
			        $config['max_size'] = 2048;
			        $config['file_name'] = date('YmdHis');

			        $this->load->library('upload', $config);
				    $this->upload->initialize($config);

				    if (!empty($_FILES['bukti']['name'])) {
				        // Jika ada file baru yang diunggah
				        if ($this->upload->do_upload('bukti')) {
				            // Jika upload berhasil
				            $fileData = $this->upload->data();
				            $file_name = $fileData['file_name'];

				            // Hapus file lama jika ada
				            if ($pengajuan['bukti'] && file_exists($upload_path . $pengajuan['bukti'])) {
				                unlink($upload_path . $pengajuan['bukti']);
				            }
				        } else {
				            // Tangani kesalahan upload
				            $data = [
				                'judul' => 'Pengajuan Cuti/Sakit',
				                'pengajuan' => $pengajuan,
				                'error' => $this->upload->display_errors()
				            ];
				            $this->load->view('template/header', $data);
				            $this->load->view('pengajuancuti/v_pengajuancuti_edit', $data);
				            $this->load->view('template/sidebar');
				            $this->load->view('template/footer');
				            return;
				        }
				    } else {
				        // Tidak ada file baru yang diunggah, gunakan file lama
				        $file_name = $pengajuan['bukti'];
				    }
						$id_karyawan = $this->session->userdata('id');
					    $data = [
					        'id_karyawan' => $id_karyawan,
					        'jenis_cuti' => $this->input->post('jeniscuti'),
					        'tanggal_mulai' => $this->input->post('tanggal_mulai'),
					        'tanggal_selesai' => $this->input->post('tanggal_selesai'),
					        'deskripsi' => $this->input->post('deskripsi'),
					        'bukti' => $file_name,
					        'status_pengajuan' => 'PENDING',
					        'jumlah_hari' => $jumlah_hari,
					        'update_by' => $id_karyawan,
					    ];

		            $this->PengajuanCuti_m->edit($id,$data);
		            $this->session->set_flashdata('berhasil', 'Data berhasil diubah.');
		            redirect('pengajuancuti');  
				}

        	}else{

        		$nik = $this->session->userdata('nik');
        		$tanggal_mulai1 = new DateTime($this->input->post('tanggal_mulai'));
				$tanggal_selesai1 = new DateTime($this->input->post('tanggal_selesai'));
				$interval1 = $tanggal_mulai1->diff($tanggal_selesai1);
				$jumlah_hari1 = $interval1->days + 1;
				$tanggal_sama = $this->PengajuanCuti_m->tanggal_sama($id_karyawan,$tanggal_selesai,$tanggal_mulai);

				if ($jumlah_hari1 <= 0) {
					$data = [
						'judul' => 'Pengajuan Cuti/Sakit',
						'pengajuan' => $pengajuan
					];
					$this->session->set_flashdata('gagal', 'Masukkan Tanggal yang sesuai');
					$this->load->view('template/header',$data);
					$this->load->view('pengajuancuti/v_pengajuancuti_edit',$data);
					$this->load->view('template/sidebar');
					$this->load->view('template/footer');
				} elseif ($this->tanggalTerdapatSabtuAtauMinggu($tanggal_mulai, $tanggal_selesai)) {
		            $data['judul'] = 'Pengajuan Cuti/Sakit';
		            $this->session->set_flashdata('gagal', 'Tanggal yang Anda ajukan mencakup hari Sabtu atau Minggu.');
		            $this->load->view('template/header', $data);
		            $this->load->view('pengajuancuti/v_pengajuancuti_edit', $data);
		            $this->load->view('template/sidebar');
		            $this->load->view('template/footer');
				}elseif (!empty($tanggal_sama)) {
	                $data['judul'] = 'Pengajuan Cuti/Sakit';
	                $this->session->set_flashdata('gagal', 'Tanggal yang anda ajukan sudah digunakan.');
	                $this->load->view('template/header', $data);
	                $this->load->view('pengajuancuti/v_pengajuancuti_edit', $data);
	                $this->load->view('template/sidebar');
	                $this->load->view('template/footer');
				}else{
		    		$upload_path = './assets/uploads/pengajuancuti/' . $nik . '/';

		    		if (!is_dir($upload_path)) {
					    mkdir($upload_path, 0777, true);
					}

		        	$config['upload_path'] = $upload_path;
		        	$config['allowed_types'] = 'jpg|png|jpeg|pdf';
		       	 	$config['max_size'] = 2048;
		       	 	$config['file_name'] = date('YmdHis');

		        	$this->load->library('upload', $config);
	        		$this->upload->initialize($config);		        	


				    if (!empty($_FILES['bukti']['name'])) {
				        // Jika ada file baru yang diunggah
				        if ($this->upload->do_upload('bukti')) {
				            // Jika upload berhasil
				            $fileData = $this->upload->data();
				            $file_name = $fileData['file_name'];

				            // Hapus file lama jika ada
				            if ($pengajuan['bukti'] && file_exists($upload_path . $pengajuan['bukti'])) {
				                unlink($upload_path . $pengajuan['bukti']);
				            }
				        } else {
				            // Tangani kesalahan upload
				            $data = [
				                'judul' => 'Pengajuan Cuti/Sakit',
				                'pengajuan' => $pengajuan,
				                'error' => $this->upload->display_errors()
				            ];
				            $this->load->view('template/header', $data);
				            $this->load->view('pengajuancuti/v_pengajuancuti_edit', $data);
				            $this->load->view('template/sidebar');
				            $this->load->view('template/footer');
				            return;
				        }
				    } else {
				        // Tidak ada file baru yang diunggah, gunakan file lama
				        $file_name = $pengajuan['bukti'];
				    }
					$id_karyawan = $this->session->userdata('id');
				    $data = [
				        'id_karyawan' => $id_karyawan,
				        'jenis_cuti' => $this->input->post('jeniscuti'),
				        'tanggal_mulai' => $this->input->post('tanggal_mulai'),
				        'tanggal_selesai' => $this->input->post('tanggal_selesai'),
				        'deskripsi' => $this->input->post('deskripsi'),
				        'bukti' => $file_name,
				        'status_pengajuan' => 'PENDING',
				        'jumlah_hari' => $jumlah_hari1,
				        'update_by' => $id_karyawan,
				    ];

	            	$this->PengajuanCuti_m->edit($id,$data);
	            	$this->session->set_flashdata('success', 'Data berhasil diubah.');
	            	redirect('pengajuancuti'); 
			    }	
    		}
    	}
	}
	private function tanggalTerdapatSabtuAtauMinggu($tanggal_mulai, $tanggal_selesai)
	{
	    $current_date = $tanggal_mulai;

	    while ($current_date <= $tanggal_selesai) {
	        if ($current_date->format('N') >= 6) { // 6 untuk Sabtu, 7 untuk Minggu
	            return true;
	        }
	        $current_date->modify('+1 day');
	    }

	    return false;
	}

	public function detail($id)
	{
		$pengajuan = $this->PengajuanCuti_m->detail($id);
		if (!$pengajuan) {
	        $this->session->set_flashdata('error', 'Data pengajuan tidak ditemukan.');
	        redirect('pengajuancuti');
	    }
	    $id_karyawan= $pengajuan['id_karyawan'];
	    $hari_ini=date('Y-m-d');
	    $data = [
            'judul' => 'Pengajuan Cuti/Sakit',
            'detail' => $pengajuan,
            'cek_tanggal' => $this->PengajuanCuti_m->cek_tanggal($id_karyawan)
        ];
        $this->load->view('template/header', $data);
        $this->load->view('pengajuancuti/v_pengajuancuti_detail', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/footer');
	}

	public function hapus($id)
	{
		$pengajuan = $this->PengajuanCuti_m->getId_pengajuan($id);
		$nik = $this->session->userdata('nik');
		$upload_path = './assets/uploads/pengajuancuti/' . $nik . '/';

	    if ($pengajuan['status_pengajuan'] == 'PENDING') {

	        if ($pengajuan['bukti'] && file_exists($upload_path . $pengajuan['bukti'])) {
	            unlink($upload_path . $pengajuan['bukti']);
	        }

	        $this->PengajuanCuti_m->hapus($id);

	        $this->session->set_flashdata('berhasil', 'Pengajuan berhasil dihapus.');
	    } else {
	        $this->session->set_flashdata('error', 'Pengajuan tidak bisa dihapus.');
	    }

	    redirect('pengajuancuti');
	}

	public function setujui_pengajuan($id) {
		$this->PengajuanCuti_m->StatusSetuju($id);
		// Ambil data karyawan yang mengajukan cuti
	    $cuti = $this->db->get_where('cuti', ['id' => $id])->row();
	    $karyawan = $this->db->get_where('karyawan', ['id' => $cuti->id_karyawan])->row();

	    // Mengirim email kepada karyawan
	    $options_email = array();
	    $options_email['from_email'] = $this->session->userdata('email');
	    $options_email['from_name'] = 'HRD';
	    $options_email['to'] = $karyawan->email;
	    $options_email['subject'] = 'Pengajuan ' . $cuti->jenis_cuti . ' Disetujui';
	    $options_email['message'] = '<p>Hai ' . $karyawan->nama_lengkap . ',</p>';
	    $options_email['message'] .= '<p>Kami ingin menginformasikan bahwa Pengajuan ' . $cuti->jenis_cuti . ' Anda telah disetujui dengan rincian sebagai berikut:</p>';
	    $options_email['message'] .= '<p>Tanggal Mulai : '. $cuti->tanggal_mulai .'</p>';
	    $options_email['message'] .= '<p>Tanggal Selesai : '. $cuti->tanggal_selesai .'</p>';
	    if (!empty($cuti->deskripsi)) {
	        $options_email['message'] .= '<p>Deskripsi: ' . $cuti->deskripsi . '</p>';
	    }
	   	$options_email['message'] .= '<p>Jika ada pertanyaan lebih lanjut, silakan hubungi HRD.</p>';
	    $options_email['message'] .= '<p>Terima kasih.</p>';

	   	$upload_path = './assets/uploads/pengajuancuti/' . $karyawan->nik . '/';
	    // Cek apakah ada bukti (bisa berupa PDF atau gambar)
	    if (!empty($cuti->bukti)) {
	        $bukti_path = $upload_path . $cuti->bukti;  // Path lengkap ke file bukti
	        if (file_exists($bukti_path)) {
	            $options_email['attachment'] = $bukti_path;  // Menambahkan file bukti sebagai lampiran
	        }
	    }

	    // Menggunakan helper send_email
	    if (send_email($options_email)) {
	        $this->session->set_flashdata('berhasil', 'Pengajuan Disetujui dan email pemberitahuan telah dikirim.');
	    } else {
	        $this->session->set_flashdata('gagal', 'Pengajuan Disetujui, namun gagal mengirim email pemberitahuan.');
	    }
		redirect(base_url('pengajuancuti'));
  	}
  	public function tolak_pengajuan($id) {
    	$this->PengajuanCuti_m->StatusTolak($id);
    	// Ambil data karyawan yang mengajukan cuti
	    $cuti = $this->db->get_where('cuti', ['id' => $id])->row();
	    $karyawan = $this->db->get_where('karyawan', ['id' => $cuti->id_karyawan])->row();
	    
	    // Ambil alasan pembatalan
	    $alasan = $this->input->post('alasan');

	    $options_email = array();
	    $options_email['from_email'] = $this->session->userdata('email');
	    $options_email['from_name'] = 'HRD';
	    $options_email['to'] = $karyawan->email;
	    $options_email['subject'] = 'Pengajuan ' . $cuti->jenis_cuti . ' Ditolak';
	    $options_email['message'] = '<p>Hai ' . $karyawan->nama_lengkap . ',</p>';
	    $options_email['message'] .= '<p>Kami ingin menginformasikan bahwa Pengajuan ' . $cuti->jenis_cuti . ' Anda telah ditolak dengan rincian sebagai berikut:</p>';
	    $options_email['message'] .= '<p>Tanggal Mulai : '. $cuti->tanggal_mulai .'</p>';
	    $options_email['message'] .= '<p>Tanggal Selesai : '. $cuti->tanggal_selesai .'</p>';
	    if (!empty($cuti->deskripsi)) {
	        $options_email['message'] .= '<p>Deskripsi: ' . $cuti->deskripsi . '</p>';
	    }
	    $options_email['message'] .= '<p>Alasan: ' . $alasan . '</p>';
	   	$options_email['message'] .= '<p>Jika ada pertanyaan lebih lanjut, silakan hubungi HRD.</p>';
	    $options_email['message'] .= '<p>Terima kasih.</p>';
	    
	   	$upload_path = './assets/uploads/pengajuancuti/' . $karyawan->nik . '/';
	    // Cek apakah ada bukti (bisa berupa PDF atau gambar)
	    if (!empty($cuti->bukti)) {
	        $bukti_path = $upload_path . $cuti->bukti;  // Path lengkap ke file bukti
	        if (file_exists($bukti_path)) {
	            $options_email['attachment'] = $bukti_path;  // Menambahkan file bukti sebagai lampiran
	        }
	    }

	    // Menggunakan helper send_email
	    if (send_email($options_email)) {
	        $this->session->set_flashdata('berhasil', 'Pengajuan Ditolak dan email pemberitahuan telah dikirim.');
	    } else {
	        $this->session->set_flashdata('gagal', 'Pengajuan Ditolak, namun gagal mengirim email pemberitahuan.');
	    }
	    redirect(base_url('pengajuancuti'));
    	
  	}
  	public function batalkan_pengajuan($id)
	{
	    $this->PengajuanCuti_m->StatusDibatalkan($id);

	    // Ambil data karyawan yang mengajukan cuti
	    $cuti = $this->db->get_where('cuti', ['id' => $id])->row();
	    $karyawan = $this->db->get_where('karyawan', ['id' => $cuti->id_karyawan])->row();
	    
	    // Ambil alasan pembatalan
	    $alasan = $this->input->post('alasan');

	    // Mengirim email kepada karyawan
	    $options_email = array();
	    $options_email['from_email'] = $this->session->userdata('email');
	    $options_email['from_name'] = 'HRD';
	    $options_email['to'] = $karyawan->email;
	    $options_email['subject'] = 'Pengajuan ' . $cuti->jenis_cuti . ' Dibatalkan';
	    $options_email['message'] = '<p>Hai ' . $karyawan->nama_lengkap . ',</p>';
	    $options_email['message'] .= '<p>Kami ingin menginformasikan bahwa Pengajuan ' . $cuti->jenis_cuti . ' Anda telah dibatalkan dengan rincian sebagai berikut:</p>';
	    $options_email['message'] .= '<p>Tanggal Mulai : '. $cuti->tanggal_mulai .'</p>';
	    $options_email['message'] .= '<p>Tanggal Selesai : '. $cuti->tanggal_selesai .'</p>';
	    if (!empty($cuti->deskripsi)) {
	        $options_email['message'] .= '<p>Deskripsi: ' . $cuti->deskripsi . '</p>';
	    }
	    $options_email['message'] .= '<p>Alasan: ' . $alasan . '</p>';
	   	$options_email['message'] .= '<p>Jika ada pertanyaan lebih lanjut, silakan hubungi HRD.</p>';
	    $options_email['message'] .= '<p>Terima kasih.</p>';
	    
	   	$upload_path = './assets/uploads/pengajuancuti/' . $karyawan->nik . '/';
	    // Cek apakah ada bukti (bisa berupa PDF atau gambar)
	    if (!empty($cuti->bukti)) {
	        $bukti_path = $upload_path . $cuti->bukti;  // Path lengkap ke file bukti
	        if (file_exists($bukti_path)) {
	            $options_email['attachment'] = $bukti_path;  // Menambahkan file bukti sebagai lampiran
	        }
	    }

	    // Menggunakan helper send_email
	    if (send_email($options_email)) {
	        $this->session->set_flashdata('berhasil', 'Pengajuan Dibatalkan dan email pemberitahuan telah dikirim.');
	    } else {
	        $this->session->set_flashdata('gagal', 'Pengajuan Dibatalkan, namun gagal mengirim email pemberitahuan.');
	    }
	    redirect(base_url('pengajuancuti'));
	}

  	public function tambah_cuti()
  	{
  		$this->form_validation->set_rules('id_karyawan[]', 'Karyawan', 'required');
        $this->form_validation->set_rules('jeniscuti', 'Jenis Cuti', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = [
					'judul' => 'Pengajuan Cuti/Sakit'
				];
				$this->load->view('template/header',$data);
				$this->load->view('pengajuancuti/v_pengajuancuti_tambah_cuti',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
        } else {
    		$tanggal_mulai = new DateTime($this->input->post('tanggal_mulai'));
			$tanggal_selesai = new DateTime($this->input->post('tanggal_selesai'));
			$interval = $tanggal_mulai->diff($tanggal_selesai);
			$jumlah_hari = $interval->days + 1;
            $id_karyawan_list = $this->input->post('id_karyawan');
            foreach ($id_karyawan_list as $id_karyawan) {
            	$karyawan['id_karyawan'] = $id_karyawan;
            }
            $id_user = $this->session->userdata('id');
            $cuti = $this->db->get('karyawan')->row();
            $tanggal_sama = $this->PengajuanCuti_m->tanggal_sama($id_karyawan,$tanggal_selesai,$tanggal_mulai);
            $jumlah_hari_cuti = $this->PengajuanCuti_m->jumlah_hari_cuti($id_karyawan);
            if (($jumlah_hari_cuti->jumlah_hari + $jumlah_hari) > $cuti->batas_cuti) {
				$data['judul'] = 'Pengajuan Cuti/Sakit';
				$this->session->set_flashdata('gagal', 'Anda melewati batas cuti');
				$this->load->view('template/header',$data);
				$this->load->view('pengajuancuti/v_pengajuancuti_tambah',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
            }elseif ($jumlah_hari <= 0) {
            	$data = [
					'judul' => 'Pengajuan Cuti/Sakit'
				];
				$this->session->set_flashdata('gagal', 'Masukkan tanggal yang sesuai');
				$this->load->view('template/header',$data);
				$this->load->view('pengajuancuti/v_pengajuancuti_tambah_cuti',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
			}elseif ($this->input->post('tanggal_mulai') < date('Y-m-d')) {
				$data['judul'] = 'Pengajuan Cuti/Sakit';
				$this->session->set_flashdata('gagal', 'Masukkan tanggal yang sesuai');
				$this->load->view('template/header',$data);
				$this->load->view('pengajuancuti/v_pengajuancuti_tambah_cuti',$data);
				$this->load->view('template/sidebar');
				$this->load->view('template/footer');
			} elseif ($this->tanggalTerdapatSabtuAtauMinggu($tanggal_mulai, $tanggal_selesai)) {
	            $data['judul'] = 'Pengajuan Cuti/Sakit';
	            $this->session->set_flashdata('gagal', 'Tanggal yang Anda ajukan mencakup hari Sabtu atau Minggu.');
	            $this->load->view('template/header', $data);
	            $this->load->view('pengajuancuti/v_pengajuancuti_tambah_cuti', $data);
	            $this->load->view('template/sidebar');
	            $this->load->view('template/footer');
	        }elseif (!empty($tanggal_sama)) {
                $data['judul'] = 'Pengajuan Cuti/Sakit';
                $this->session->set_flashdata('gagal', 'Tanggal yang anda ajukan sudah digunakan yang sudah ada.');
                $this->load->view('template/header', $data);
                $this->load->view('pengajuancuti/v_pengajuancuti_tambah_cuti', $data);
                $this->load->view('template/sidebar');
                $this->load->view('template/footer');
			}else{
	            $data_cuti = [
	                'jenis_cuti' => $this->input->post('jeniscuti'),
	                'tanggal_mulai' => $this->input->post('tanggal_mulai'),
	                'tanggal_selesai' => $this->input->post('tanggal_selesai'),
	                'deskripsi' => $this->input->post('deskripsi'),
	                'status_pengajuan' => 'DISETUJUI',
	                'jumlah_hari' => $jumlah_hari,
	                'disetujui_oleh' => $id_user,
	                'created_by' => $id_user
	            ];

	            foreach ($id_karyawan_list as $id_karyawan) {
	                $data_cuti['id_karyawan'] = $id_karyawan;
	                $this->PengajuanCuti_m->tambah_cuti($data_cuti);
	            }
	            $this->session->set_flashdata('berhasil', 'Cuti Berhasil ditambahkan');
	            redirect('pengajuancuti');
	        }
        }
  	}
  	public function get_karyawan() {
        $this->load->model('Karyawan_m');
        $search = $this->input->get('q');

        $karyawan = $this->Karyawan_m->karyawan($search);

        echo json_encode($karyawan);
    }



}
?>