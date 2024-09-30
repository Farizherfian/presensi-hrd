<?php 

class Laporan extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laporan_m');
        if ($this->session->userdata('nr') == 'Karyawan') {
            $this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
        }
	}
	public function index()
    {
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');

        // Ambil data laporan dari model
        $data['laporan'] = $this->Laporan_m->get_laporan_bulanan($bulan, $tahun);
        $data['bulan'] = $bulan;
       	$data['tahun'] = $tahun;

       	// echo "<Pre>";
       	// print_r($data);
       	// die;

        // Jika ada permintaan export Excel
        if ($this->input->post('excel')) {
		    $header = array_keys($data['laporan'][0]);
		    $headers = [];

		    foreach ($header as $key => $value) {
		    	if ($value == 'nik') {
		    		$headers[] = strtoupper($value);
		    	} else {
		    		$headers[] = ucwords(strtolower(str_replace('_', ' ', $value)));
		    	}
		    }

		    $filename = 'laporan_kehadiran_' . $bulan . '_' . $tahun;
            export_excel($data['laporan'], $filename, $headers);
        }
        $data['judul'] = 'Laporan Kehadiran';
	 	$this->load->view('template/header',$data);
	 	$this->load->view('laporan/v_laporan',$data);
	 	$this->load->view('template/sidebar');
	 	$this->load->view('template/footer');    
    }
}
?>