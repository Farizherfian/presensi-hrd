<?php 

class PengajuanCuti_m extends CI_Model {

	// public function tampil($id)
	// {
	// 	$this->db->select('cuti.*,karyawan.nama_lengkap,karyawan.nik');
 //        $this->db->from('cuti');
 //        $this->db->join('karyawan', 'karyawan.id = cuti.id_karyawan', 'left');
 //        return $this->db->get()->result();
	// }
	public function tampil($id_karyawan)
	{
		$this->db->select('cuti.*,karyawan.nama_lengkap,karyawan.nik');
        $this->db->from('cuti');
        $this->db->join('karyawan', 'karyawan.id = cuti.id_karyawan', 'left');
        if ($this->session->userdata('nr') == 'Karyawan') { 
        	$this->db->where('karyawan.id', $id_karyawan);
        }
        $this->db->order_by('cuti.id', 'DESC');

        return $this->db->get()->result();
	}
	public function tambah($data)
	{
		$this->db->insert('cuti',$data);
	}
	public function getId_pengajuan($id)
	{
		return $this->db->get_where('cuti',['id'=> $id])->row_array();
	}
	public function edit($id,$data) {
        $this->db->where('id',$id);
        return $this->db->update('cuti', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('cuti');
    }
    public function detail($id)
	{
		$this->db->select('cuti.*,karyawan.id as id_karyawan,karyawan.nik,karyawan.nama_lengkap,karyawan.email,karyawan.tanggal_lahir,karyawan.jenis_kelamin,karyawan.no_telepon,karyawan.tanggal_masuk,karyawan.alamat,karyawan.foto,karyawan.batas_cuti,karyawan.status_kepegawaian,departemen.nama as nd, jabatan.nama as nj');
        $this->db->from('cuti');
        $this->db->join('karyawan', 'karyawan.id = cuti.id_karyawan', 'left');
        $this->db->join('karyawan_jabatan', 'karyawan_jabatan.id_karyawan = karyawan.id', 'left');
        $this->db->join('jabatan', 'jabatan.id = karyawan_jabatan.id_jabatan', 'left');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $this->db->where('cuti.id', $id);
        return $this->db->get()->row_array();
	}
	public function jumlah_hari_cuti($id_karyawan)
	{
		$this->db->select_sum('jumlah_hari');
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('jenis_cuti', 'Cuti');
        $this->db->where('YEAR(tanggal_mulai)', date('Y'));
        $this->db->where('YEAR(tanggal_selesai)', date('Y'));
        $this->db->where('status_pengajuan', 'DISETUJUI');
        return $this->db->get('cuti')->row();
	}
	public function StatusSetuju($id)
	{
		$id_user = $this->session->userdata('id');

	    // Update status pengajuan menjadi DISETUJUI
	    $data = [
	        'status_pengajuan' => 'DISETUJUI',
	        'disetujui_oleh' => $id_user
	    ];
	    $this->db->where('id', $id);
	    return $this->db->update('cuti', $data);
	}
	public function StatusTolak($id)
	{
		$id_user = $this->session->userdata('id');
		$data = array(
    		'status_pengajuan' => 'DITOLAK',
    		'alasan_tolak' => $this->input->post('alasan'),
    		'ditolak_oleh' => $id_user
    	);
		$this->db->where('id', $id);
		return $this->db->update('cuti', $data);
	}
	public function StatusDibatalkan($id)
	{
		$id_user = $this->session->userdata('id');

	    $data = [
	        'status_pengajuan' => 'DIBATALKAN',
	        'alasan_dibatalkan' => $this->input->post('alasan'),
	        'dibatalkan_oleh' => $id_user
	    ];
	    $this->db->where('id', $id);
	    return $this->db->update('cuti', $data);
	}
	public function cek_tanggal($id_karyawan) {

        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('status_pengajuan', 'DISETUJUI');
        return $this->db->get('cuti')->row_array();
  	}
  	public function tanggal_sama($id_karyawan,$tanggal_selesai,$tanggal_mulai)
  	{
  		$this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('(tanggal_mulai <= ' . $this->db->escape($tanggal_selesai->format('Y-m-d')) . ' AND tanggal_selesai >= ' . $this->db->escape($tanggal_mulai->format('Y-m-d')) . ')');
        $this->db->where('status_pengajuan', 'DISETUJUI');
        return $this->db->get('cuti')->result();
  	}
  	public function tambah_cuti($data_cuti)
	{
		$this->db->insert('cuti',$data_cuti);
	}
}


 ?>