<?php 

class Jabatan extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Jabatan_m');
        if ($this->session->userdata('nr') == 'Karyawan') {
            $this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
        }
	}

	public function index()
	{
		$data = [
			'judul' => 'Data Jabatan',
			'jabatan' => $this->Jabatan_m->get_all_jabatan()
		];
		$this->load->view('template/header',$data);
		$this->load->view('jabatan/v_jabatan',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'Nama Jabatan', 'required|trim|is_unique[jabatan.nama]');
		$this->form_validation->set_rules('departemen', 'Departemen', 'required|trim');

		if ($this->form_validation->run() != FALSE) {
	    	$this->Jabatan_m->tambah();
	    	$this->session->set_flashdata('berhasil','Tambah Data Berhasil');
	    	redirect(base_url('jabatan'));
		}else{
			$data=[
	        	'judul' => 'Data jabatan',
	        	'departemen' => $this->Jabatan_m->get_departemen()
			];
			$this->load->view('template/header',$data);
			$this->load->view('jabatan/v_jabatan_tambah');
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
		}
	}
	public function edit($id) {
        $data=[
        	'judul' => 'Edit Data jabatan',
        	'departemen' => $this->Jabatan_m->get_departemen(),
        	'jabatan' => $this->Jabatan_m->get_jabatan_by_id($id)
		];
		if (!$data['jabatan']) {
            show_404();
        }
		$this->load->view('template/header',$data);
		$this->load->view('jabatan/v_jabatan_edit',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
    }
    public function update($id)
	{
		$nama = $this->Jabatan_m->get_jabatan_by_id($id);
		if ($this->input->post('nama') == $nama['nama']) {
			$this->form_validation->set_rules('nama', 'Nama Jabatan', 'required|trim');	
		}else{
			$this->form_validation->set_rules('nama', 'Nama Jabatan', 'required|trim|is_unique[jabatan.nama]');
		}	
			$this->form_validation->set_rules('departemen', 'Nama Departemen', 'required|trim');

		if ($this->form_validation->run() != FALSE) {
	    	$this->Jabatan_m->update($id);
	    	$this->session->set_flashdata('berhasil','Edit Data Berhasil');
	    	redirect(base_url('jabatan'));
		}else{
			$this->edit($id);
		}
	}
	public function hapus($id)
	{
		$this->Jabatan_m->hapus($id);
		$this->session->set_flashdata('berhasil','Hapus jabatan Berhasil');
		redirect(base_url('jabatan'));
	}

}
?>