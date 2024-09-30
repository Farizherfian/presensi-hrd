<?php 

class Karyawan_m extends CI_Model {

	public function get_all_karyawan() {
        $this->db->select('karyawan.*,departemen.nama as nd, jabatan.nama as nj');
        $this->db->from('karyawan');
        $this->db->join('karyawan_jabatan', 'karyawan_jabatan.id_karyawan = karyawan.id', 'left');
        $this->db->join('jabatan', 'jabatan.id = karyawan_jabatan.id_jabatan', 'left');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    public function tambah($data) {
        $this->db->insert('karyawan', $data);
        return $this->db->insert_id();
    }

    public function tambah_jabatan($data) {
        $this->db->insert('karyawan_jabatan', $data);
    }
    public function get_karyawan_by_id($id) {
        return $this->db->get_where('karyawan',['id'=> $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('karyawan', $data);
    }

    public function update_jabatan($id_karyawan, $data) {
        $this->db->where('id_karyawan', $id_karyawan);
        return $this->db->update('karyawan_jabatan', $data);
    }
    public function detail($id)
    {
    	$this->db->select('karyawan.*,departemen.nama as nd, jabatan.nama as nj, roles.nama as nr');
        $this->db->from('karyawan');
        $this->db->join('karyawan_jabatan', 'karyawan_jabatan.id_karyawan = karyawan.id', 'left');
        $this->db->join('jabatan', 'jabatan.id = karyawan_jabatan.id_jabatan', 'left');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $this->db->join('roles', 'roles.id = karyawan.id_roles', 'left');
        $this->db->where('karyawan.id',$id);
        return $this->db->get()->row_array();
    }
    public function hapus($id)
    {
    	$this->db->where('id',$id);
    	return $this->db->delete('karyawan');
    }
    public function karyawan($search) {
        if (!empty($search)) {
            $this->db->like('nama_lengkap', $search);
        }
        $this->db->where('id_roles', 3);
        $this->db->where('status_kepegawaian', 'Karyawan','Kontrak');
        return $this->db->get('karyawan')->result();
    }
    public function export_excel() {
        $this->db->select('karyawan.nik,karyawan.nama_lengkap,karyawan.email,departemen.nama as departemen, jabatan.nama as jabatan,karyawan.no_telepon,karyawan.tanggal_lahir,karyawan.jenis_kelamin,karyawan.tanggal_masuk,karyawan.status_kepegawaian');
        $this->db->from('karyawan');
        $this->db->join('karyawan_jabatan', 'karyawan_jabatan.id_karyawan = karyawan.id', 'left');
        $this->db->join('jabatan', 'jabatan.id = karyawan_jabatan.id_jabatan', 'left');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }
}








 ?>