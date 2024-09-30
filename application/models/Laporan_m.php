<?php 

class Laporan_m extends CI_Model {

    public function get_laporan_bulanan($bulan, $tahun, $id_user = null) {
        // Mengambil data karyawan
        $this->db->select('karyawan.id, karyawan.nik, karyawan.nama_lengkap, 
                           departemen.nama as departemen, jabatan.nama as jabatan');
        $this->db->from('karyawan');
        $this->db->join('karyawan_jabatan', 'karyawan_jabatan.id_karyawan = karyawan.id', 'left');
        $this->db->join('jabatan', 'jabatan.id = karyawan_jabatan.id_jabatan', 'left');
        $this->db->join('departemen', 'departemen.id = jabatan.id_departemen', 'left');
        $this->db->where('karyawan.id_roles', 3);
        $this->db->where_not_in('karyawan.status_kepegawaian', ['Pensiun', 'Tidak Aktif']);
        if ($id_user) {
            $this->db->where('karyawan.id', $id_user);
        }
        $karyawan = $this->db->get()->result_array();

        // Inisialisasi array laporan
        $laporan = [];

        foreach ($karyawan as $k) {
            // Menghitung jumlah kehadiran pada bulan dan tahun tertentu
            $this->db->select('COUNT(*) as hadir');
            $this->db->from('presensi');
            $this->db->where('id_karyawan', $k['id']);
            $this->db->where('MONTH(waktu_masuk)', $bulan);
            $this->db->where('YEAR(waktu_masuk)', $tahun);
            $this->db->where('DAYOFWEEK(waktu_masuk) NOT IN (1, 7)'); // Tidak menghitung Sabtu (7) dan Minggu (1)
            $hadir = $this->db->get()->row()->hadir;

            // Menghitung jumlah hari cuti yang disetujui (berdasarkan rentang tanggal)
            $this->db->select('tanggal_mulai, tanggal_selesai');
            $this->db->from('cuti');
            $this->db->where('id_karyawan', $k['id']);
            $this->db->where('MONTH(tanggal_mulai)', $bulan);
            $this->db->where('YEAR(tanggal_mulai)', $tahun);
            $this->db->where('status_pengajuan', 'DISETUJUI');
            $this->db->where('jenis_cuti', 'Cuti');
            $cuti_data = $this->db->get()->result_array();

            $cuti = 0;
            foreach ($cuti_data as $cd) {
                $cuti += $this->hitung_hari_cuti($cd['tanggal_mulai'], $cd['tanggal_selesai']);
            }

            // Menghitung jumlah hari sakit yang disetujui (berdasarkan rentang tanggal)
            $this->db->select('tanggal_mulai, tanggal_selesai');
            $this->db->from('cuti');
            $this->db->where('id_karyawan', $k['id']);
            $this->db->where('MONTH(tanggal_mulai)', $bulan);
            $this->db->where('YEAR(tanggal_mulai)', $tahun);
            $this->db->where('status_pengajuan', 'DISETUJUI');
            $this->db->where('jenis_cuti', 'Sakit');
            $sakit_data = $this->db->get()->result_array();

            $sakit = 0;
            foreach ($sakit_data as $sd) {
                $sakit += $this->hitung_hari_cuti($sd['tanggal_mulai'], $sd['tanggal_selesai']);
            }

            // Menghitung jumlah hari dalam bulan (tanpa Sabtu dan Minggu)
            $total_hari = $this->hitung_hari_kerja($bulan, $tahun);

            // Menghitung alpha (tidak hadir tanpa keterangan)
            $alpha = $total_hari - ($hadir + $cuti + $sakit);

            // Masukkan data ke dalam array laporan
            $laporan[] = [
                'nik' => $k['nik'],
                'nama_lengkap' => $k['nama_lengkap'],
                'departemen' => $k['departemen'],
                'jabatan' => $k['jabatan'],
                'hadir' => $hadir,
                'cuti' => $cuti,
                'sakit' => $sakit,
                'alpha' => max($alpha, 0) // Jika alpha negatif, set ke 0
            ];
        }

        return $laporan;
    }

    // Fungsi untuk menghitung jumlah hari cuti/sakit (berdasarkan rentang tanggal)
    private function hitung_hari_cuti($tanggal_mulai, $tanggal_selesai) {
        $start = new DateTime($tanggal_mulai);
        $end = new DateTime($tanggal_selesai);
        $end->modify('+1 day'); // Tambahkan satu hari agar tanggal akhir ikut dihitung
        $interval = $start->diff($end);

        return $interval->days;
    }

    // Fungsi untuk menghitung hari kerja (tidak termasuk Sabtu dan Minggu) dalam bulan tertentu
    private function hitung_hari_kerja($bulan, $tahun) {
        $total_hari = 0;
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        for ($i = 1; $i <= $jumlah_hari; $i++) {
            $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
            $hari = date('N', strtotime($tanggal)); // 1 = Senin, 7 = Minggu
            if ($hari < 6) { // Menghitung hanya hari kerja (Senin-Jumat)
                $total_hari++;
            }
        }

        return $total_hari;
    }

}

 ?>