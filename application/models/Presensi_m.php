<?php 


/**
 * 
 */
class Presensi_m extends CI_Model
{
	public function tampil($id_user)
	{
		$this->db->select('presensi.*,karyawan.*');
        $this->db->from('presensi');
        $this->db->join('karyawan', 'karyawan.id = presensi.id_karyawan', 'left');
        if ($this->session->userdata('nr') == 'Karyawan') { 
        	$this->db->where('karyawan.id', $id_user);
        }
        $this->db->order_by('presensi.id', 'DESC');
        return $this->db->get()->result();
	}
	public function presensi_masuk($data)
	{
		$this->db->insert('presensi',$data);
	}
	public function cek_presensiMasuk($id)
	{ 
		$this->db->where('id_karyawan', $id);
		$this->db->where('DATE(waktu_masuk)', date('Y-m-d'));
		return $this->db->get('presensi')->num_rows();
	}
	public function get_id_presensi($id)
	{
		$this->db->where('id_karyawan', $id);
		$this->db->where('DATE(waktu_masuk)', date('Y-m-d'));
		return $this->db->get('presensi')->row_array();
	}
	public function presensi_keluar($id,$data)
	{
		$this->db->where('id', $id);
        return $this->db->update('presensi', $data);
	}
	public function cek_presensiKeluar($id)
	{
		$this->db->where('id_karyawan', $id);
		$this->db->where('DATE(waktu_masuk)', date('Y-m-d'));
		$this->db->where('DATE(waktu_keluar) !=', '0000-00-00');
		return $this->db->get('presensi')->num_rows();
	}
	public function cek_cuti($id_karyawan, $hari_ini) {

        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('status_pengajuan', 'DISETUJUI');
        $this->db->where("('$hari_ini' BETWEEN tanggal_mulai AND tanggal_selesai)");
        return $this->db->get('cuti')->num_rows();
  	}
}



 ?>