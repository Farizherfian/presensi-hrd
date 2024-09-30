<?php 

class Jabatan_m extends CI_Model {

	public function get_all_jabatan() {
        $this->db->select('jabatan.*,departemen.nama as nd');
        $this->db->from('jabatan');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $query = $this->db->get();
        return $query->result();
    }
    public function tambah(){
        $data = [
            'nama' => trim($this->input->post('nama', true)),
            'id_departemen' => $this->input->post('departemen', true),
            'deskripsi' => trim($this->input->post('deskripsi',true)),
            'created_by' => $this->session->userdata('id')
        ];
        $this->db->insert('jabatan', $data);
    }
    public function get_jabatan_by_id($id) {
        return $this->db->get_where('jabatan',['id'=> $id])->row_array();
    }
    public function get_departemen() {
        return $this->db->get('departemen')->result();
    }
    public function update($id) {
        $data = [
            'nama' => trim($this->input->post('nama', true)),
            'id_departemen' => $this->input->post('departemen', true),
            'deskripsi' => trim($this->input->post('deskripsi',true)),
            'update_by' => $this->session->userdata('id')
        ];
        $this->db->where('id', $id);
        return $this->db->update('jabatan', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jabatan');
    }

}

 ?>