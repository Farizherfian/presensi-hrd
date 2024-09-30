<?php
class Setting_m extends CI_Model {

    // Mendapatkan setting berdasarkan keyword
    public function get_setting($keyword) {
        $this->db->where('keyword', $keyword);
        $query = $this->db->get('setting');
        return $query->row();  // Mengambil satu record berdasarkan keyword
    }

    // Menambahkan atau meng-update setting berdasarkan keyword
    public function save_setting($keyword, $value, $updated_by) {
        $setting = $this->get_setting($keyword);

        if ($setting) {
            // Jika setting sudah ada, lakukan update
            $this->db->where('keyword', $keyword);
            $this->db->update('setting', array(
                'value' => $value,
                'updated_by' => $updated_by,
            ));
        } else {
            // Jika belum ada, lakukan insert
            $this->db->insert('setting', array(
                'keyword' => $keyword,
                'value' => $value,
                'created_by' => $updated_by,
            ));
        }

        return $this->db->affected_rows();
    }
    public function get_all_settings() {
        $query = $this->db->get('setting'); // Ganti 'settings' dengan nama tabel pengaturan Anda
        $settings = [];
        foreach ($query->result() as $row) {
            $settings[$row->keyword] = $row->value;
        }
        return $settings;
    }
}
