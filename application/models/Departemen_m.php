<?php 

class Departemen_m extends CI_Model {

	public function get_all_departemen() {
        return $this->db->get('departemen')->result();
    }
    public function tambah(){
        $data = [
            'nama' => trim($this->input->post('nama', true)),
            'deskripsi' => trim($this->input->post('deskripsi',true)),
            'created_by' => $this->session->userdata('id')
        ];
        $this->db->insert('departemen', $data);
    }
    public function get_departemen_by_id($id) {
        return $this->db->get_where('departemen',['id'=> $id])->row_array();
    }
    public function update($id) {
        $data = [
            'nama' => trim($this->input->post('nama', true)),
            'deskripsi' => trim($this->input->post('deskripsi',true)),
            'update_by' => $this->session->userdata('id')
        ];
        $this->db->where('id', $id);
        return $this->db->update('departemen', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('departemen');
    }

}

 ?>