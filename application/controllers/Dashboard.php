<?php 

class Dashboard extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_m');
		$this->load->model('Laporan_m');
		$this->load->model('Presensi_m');
		$this->load->model('PengajuanCuti_m');
	}

	public function index()
	{
    	$id_user = $this->session->userdata('id');
    	$id_karyawan = $this->session->userdata('id');
		$hari_ini = date('Y-m-d');
		$bulan_lalu = date('m', strtotime('-1 month'));
    	$tahun = date('Y');

	    $data = [];
	    if ($this->session->userdata('nr') == 'Karyawan') {
	    	for ($bulan = 1; $bulan <= 12; $bulan++) {
        		$laporan_bulanan = $this->Laporan_m->get_laporan_bulanan($bulan, date('Y'), $id_user);

        	// Jika data ditemukan, proses data untuk grafik
	        	if (!empty($laporan_bulanan)) {
		            $data['hadir_per_bulan'][] = (int) $laporan_bulanan[0]['hadir'];
		            $data['sakit_per_bulan'][] = (int) $laporan_bulanan[0]['sakit'];
		            $data['cuti_per_bulan'][] = (int) $laporan_bulanan[0]['cuti'];
	        	} else {
	            	$data['hadir_per_bulan'][] = 0;
	            	$data['sakit_per_bulan'][] = 0;
	            	$data['cuti_per_bulan'][] = 0;
	        	}
	    	}
	    }else{
		    for ($bulan = 1; $bulan <= 12; $bulan++) {
		        $laporan_bulanan = $this->Laporan_m->get_laporan_bulanan($bulan, $tahun); // Ambil laporan per bulan
		        $total_hadir = 0;
		        $total_sakit = 0;
		        $total_cuti = 0;
		        foreach ($laporan_bulanan as $laporan) {
		            $total_hadir += $laporan['hadir']; // Hitung jumlah alpha
		            $total_sakit += $laporan['sakit']; // Hitung jumlah sakit
		            $total_cuti += $laporan['cuti']; // Hitung jumlah cuti
		        }
		        $data['hadir_per_bulan'][] = $total_hadir;
		        $data['sakit_per_bulan'][] = $total_sakit;
		        $data['cuti_per_bulan'][] = $total_cuti;
		    }
		}
		$data['jumlah_tidak_hadir'] = $this->Dashboard_m->get_tidak_hadir_hari_ini();
		$data['sisa_cuti'] = $this->db->get_where('karyawan', ['id' => $id_karyawan])->row();
		$data['jumlah_karyawan'] = $this->db->get_where('karyawan', ['status_kepegawaian' => 'Karyawan','Kontrak'])->num_rows();
		$data['karyawan_pensiun'] = $this->db->get_where('karyawan', ['id_roles' => 3,'status_kepegawaian' => 'Pensiun'])->num_rows();
		$data['pending'] = $this->db->get_where('cuti', ['id' => $id_karyawan,'status_pengajuan' => 'PENDING'])->num_rows();
		$data['pengajuan_pending'] = $this->db->get_where('cuti', ['status_pengajuan' => 'PENDING'])->num_rows();
		$data['cek_cuti'] = $this->Presensi_m->cek_cuti($id_karyawan,$hari_ini);
		$data['cek_presensiMasuk'] = $this->Presensi_m->cek_presensiMasuk($id_karyawan);
		$data['cek_presensiKeluar'] = $this->Presensi_m->cek_presensiKeluar($id_karyawan);
    	$data['karyawan_terbaik_terburuk'] = $this->Dashboard_m->get_karyawan_terbaik_terburuk($bulan_lalu, $tahun);
    	$data['karyawan_terbaik'] = $data['karyawan_terbaik_terburuk']['terbaik'];
    	$data['karyawan_terburuk'] = $data['karyawan_terbaik_terburuk']['terburuk'];
    	$data['cuti_hari_ini'] = $this->Dashboard_m->get_cuti_hari_ini();
    	$data['sakit_hari_ini'] = $this->Dashboard_m->get_sakit_hari_ini();
    $hari_cuti = $this->PengajuanCuti_m->jumlah_hari_cuti($id_karyawan);
    $batas_cuti = $this->db->get_where('karyawan', ['id' => $id_karyawan])->row_array();
    $data['sisa_cuti2'] = $batas_cuti['batas_cuti'] - $hari_cuti->jumlah_hari;

		$data['judul'] = 'Dashboard';
		$this->load->view('template/header',$data);
		$this->load->view('dashboard/v_dashboard',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}


}
?>