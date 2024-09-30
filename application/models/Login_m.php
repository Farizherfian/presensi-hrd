<?php

class Login_m extends CI_Model {

    public function get_karyawan_by_nik($nik) {
        // $this->db->where('nik', $nik);
        // $this->db->where_not_in('status_kepegawaian', ['Pensiun', 'Tidak Aktif']);
        // $query = $this->db->get('karyawan');
        // return $query->row_array();
        $this->db->select('karyawan.*,departemen.nama as nd, jabatan.nama as nj,roles.nama as nr');
        $this->db->from('karyawan');
        $this->db->join('karyawan_jabatan', 'karyawan_jabatan.id_karyawan = karyawan.id', 'left');
        $this->db->join('jabatan', 'jabatan.id = karyawan_jabatan.id_jabatan', 'left');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $this->db->join('roles', 'roles.id = karyawan.id_roles', 'left');
        $this->db->where('karyawan.nik', $nik);
        return $this->db->get()->row_array();
    }

	public function ubah_password($id, $new_password) {
        $data = [
            'password' => $new_password,
            'update_by' => $this->session->userdata('id')
        ];
        $this->db->where('id', $id);
        $this->db->update('karyawan',$data);
    }
}
?>