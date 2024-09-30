<?php 

class Departemen extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Departemen_m');
        if ($this->session->userdata('nr') == 'Karyawan') {
            $this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
        }
	}

	public function index()
	{
		$data = [
			'judul' => 'Data Departemen',
			'departemen' => $this->Departemen_m->get_all_departemen()
		];
		$this->load->view('template/header',$data);
		$this->load->view('departemen/v_departemen',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	public function tambah()
	{
		$this->form_validation->set_rules('nama', 'Nama Departemen', 'required|trim');


		if ($this->form_validation->run() != FALSE) {
	    	$this->Departemen_m->tambah();
	    	$this->session->set_flashdata('berhasil','Tambah Data Berhasil');
	    	redirect(base_url('departemen'));
		}else{
			$data['judul'] = 'Tambah Data Departemen';
			$this->load->view('template/header',$data);
			$this->load->view('departemen/v_departemen_tambah');
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
		}
	}
	public function edit($id) {
        $data=[
        	'judul' => 'Edit Data Departemen',
        	'departemen' => $this->Departemen_m->get_departemen_by_id($id)
		];
		if (!$data['departemen']) {
            show_404();
        }
		$this->load->view('template/header',$data);
		$this->load->view('departemen/v_departemen_edit',$data);
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
    }
    public function update($id)
	{
		$this->form_validation->set_rules('nama', 'Nama Departemen', 'required|trim');

		if ($this->form_validation->run() != FALSE) {
	    	$this->Departemen_m->update($id);
	    	$this->session->set_flashdata('berhasil','Edit Data Berhasil');
	    	redirect(base_url('departemen'));
		}else{
			$this->edit($id);
		}
	}
	public function hapus($id)
	{
		$this->Departemen_m->hapus($id);
		$this->session->set_flashdata('berhasil','Hapus Departemen Berhasil');
		redirect(base_url('departemen'));
	}

}
?>