<?php 

class Dashboard_m extends CI_Model {

    public function get_karyawan_terbaik_terburuk($bulan, $tahun) {
        $total_hari_kerja = $this->get_total_hari_kerja($bulan, $tahun);

        // Query data karyawan dengan performa terbaik (hadir terbanyak)
        $this->db->select('karyawan.nik, karyawan.nama_lengkap,karyawan.foto, 
                           COUNT(DISTINCT IF(MONTH(presensi.waktu_masuk) = ' . $bulan . ' AND YEAR(presensi.waktu_masuk) = ' . $tahun . ', presensi.waktu_masuk, NULL)) AS hadir,
                           SUM(IF(cuti.jenis_cuti = "Cuti" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                               DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0)) AS total_cuti,
                           SUM(IF(cuti.jenis_cuti = "Sakit" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                               DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0)) AS total_sakit,
                           (' . $total_hari_kerja . ' - 
                            COUNT(DISTINCT IF(MONTH(presensi.waktu_masuk) = ' . $bulan . ' AND YEAR(presensi.waktu_masuk) = ' . $tahun . ', presensi.waktu_masuk, NULL)) - 
                            SUM(IF(cuti.jenis_cuti = "Cuti" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                                DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0)) - 
                            SUM(IF(cuti.jenis_cuti = "Sakit" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                                DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0))) AS alpha');
        $this->db->from('karyawan');
        $this->db->join('presensi', 'karyawan.id = presensi.id_karyawan', 'left');
        $this->db->join('cuti', 'karyawan.id = cuti.id_karyawan AND cuti.status_pengajuan = "DISETUJUI"', 'left');
        $this->db->where('karyawan.id_roles', 3);
        $this->db->where('karyawan.status_kepegawaian', 'Karyawan','Kontrak');
        $this->db->group_by('karyawan.id');
        
        // Ambil data untuk karyawan terbaik (berdasarkan kehadiran)
        $this->db->order_by('hadir', 'DESC');
        $this->db->limit(3);
        $terbaik = $this->db->get()->result_array();
        
        // Reset query builder
        $this->db->reset_query();

        // Ambil data untuk karyawan terburuk (berdasarkan alpha)
        $this->db->select('karyawan.nik, karyawan.nama_lengkap,karyawan.foto,
                           COUNT(DISTINCT IF(MONTH(presensi.waktu_masuk) = ' . $bulan . ' AND YEAR(presensi.waktu_masuk) = ' . $tahun . ', presensi.waktu_masuk, NULL)) AS hadir,
                           SUM(IF(cuti.jenis_cuti = "Cuti" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                               DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0)) AS total_cuti,
                           SUM(IF(cuti.jenis_cuti = "Sakit" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                               DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0)) AS total_sakit,
                           (' . $total_hari_kerja . ' - 
                            COUNT(DISTINCT IF(MONTH(presensi.waktu_masuk) = ' . $bulan . ' AND YEAR(presensi.waktu_masuk) = ' . $tahun . ', presensi.waktu_masuk, NULL)) - 
                            SUM(IF(cuti.jenis_cuti = "Cuti" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                                DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0)) - 
                            SUM(IF(cuti.jenis_cuti = "Sakit" AND MONTH(cuti.tanggal_mulai) = ' . $bulan . ' AND YEAR(cuti.tanggal_mulai) = ' . $tahun . ', 
                                DATEDIFF(cuti.tanggal_selesai, cuti.tanggal_mulai) + 1, 0))) AS alpha');
        $this->db->from('karyawan');
        $this->db->join('presensi', 'karyawan.id = presensi.id_karyawan', 'left');
        $this->db->join('cuti', 'karyawan.id = cuti.id_karyawan AND cuti.status_pengajuan = "DISETUJUI"', 'left');
        $this->db->where('karyawan.id_roles', 3);
        $this->db->where('karyawan.status_kepegawaian', 'Karyawan','Kontrak');
        $this->db->group_by('karyawan.id');
        $this->db->order_by('alpha', 'DESC');
        $this->db->limit(3);
        $terburuk = $this->db->get()->result_array();

        return [
            'terbaik' => $terbaik,
            'terburuk' => $terburuk
        ];
    }


    private function get_total_hari_kerja($bulan, $tahun) {
        $start_date = new DateTime("$tahun-$bulan-01");
        $end_date = new DateTime($start_date->format('Y-m-t')); // Akhir bulan

        $total_hari_kerja = 0;
        while ($start_date <= $end_date) {
            $day_of_week = $start_date->format('N'); // 1 = Senin, 7 = Minggu
            if ($day_of_week < 6) { // Hanya menghitung hari Senin sampai Jumat
                $total_hari_kerja++;
            }
            $start_date->modify('+1 day');
        }

        return $total_hari_kerja;
    }
    public function get_tidak_hadir_hari_ini() {
        // Dapatkan tanggal hari ini
        $tanggal_hari_ini = date('Y-m-d');

        // Query untuk menghitung karyawan yang tidak hadir dan tidak sedang cuti
        $this->db->select('COUNT(karyawan.id) as tidak_hadir');
        $this->db->from('karyawan');
        $this->db->join('presensi', 'presensi.id_karyawan = karyawan.id AND DATE(presensi.waktu_masuk) = "'.$tanggal_hari_ini.'"', 'left');
        $this->db->join('cuti', 'cuti.id_karyawan = karyawan.id AND "'.$tanggal_hari_ini.'" BETWEEN cuti.tanggal_mulai AND cuti.tanggal_selesai AND cuti.status_pengajuan = "DISETUJUI"', 'left');
        $this->db->where('presensi.id_karyawan IS NULL'); // Karyawan yang tidak presensi
        $this->db->where('cuti.id_karyawan IS NULL'); // Tidak sedang cuti
        $this->db->where('karyawan.id_roles', 3); // Role untuk karyawan biasa
        $this->db->where_not_in('karyawan.status_kepegawaian', ['Pensiun', 'Tidak Aktif']); // Filter hanya karyawan aktif

        $result = $this->db->get()->row();
        return $result ? $result->tidak_hadir : 0;
    }
    public function get_sakit_hari_ini() {
        // Dapatkan tanggal hari ini
        $tanggal_hari_ini = date('Y-m-d');

        // Query untuk menghitung karyawan yang sedang sakit hari ini
        $this->db->select('COUNT(cuti.id_karyawan) as jumlah_sakit');
        $this->db->from('cuti');
        $this->db->where('"'.$tanggal_hari_ini.'" BETWEEN cuti.tanggal_mulai AND cuti.tanggal_selesai');
        $this->db->where('cuti.status_pengajuan', 'DISETUJUI');
        $this->db->where('cuti.jenis_cuti', 'Sakit');

        $result = $this->db->get()->row();
        return $result ? $result->jumlah_sakit : 0;
    }
    public function get_cuti_hari_ini() {
        // Dapatkan tanggal hari ini
        $tanggal_hari_ini = date('Y-m-d');

        // Query untuk menghitung karyawan yang sedang sakit hari ini
        $this->db->select('COUNT(cuti.id_karyawan) as jumlah_cuti');
        $this->db->from('cuti');
        $this->db->where('"'.$tanggal_hari_ini.'" BETWEEN cuti.tanggal_mulai AND cuti.tanggal_selesai');
        $this->db->where('cuti.status_pengajuan', 'DISETUJUI');
        $this->db->where('cuti.jenis_cuti', 'CUTI');

        $result = $this->db->get()->row();
        return $result ? $result->jumlah_cuti : 0;
    }


}

 ?>