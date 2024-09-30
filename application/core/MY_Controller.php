<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // $this->check_login();
        if ($this->router->class != 'login') {
            $this->check_login(); // Cek login 
        }
        $this->load_global_settings();
    }

    public function check_login() {
        if ($this->session->userdata('login') != TRUE) {
            $this->session->set_flashdata('error','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url());
        }
    }

    public function load_global_settings() {
        $this->load->model('Setting_m');
        $settings = $this->Setting_m->get_all_settings();
        
        // Buat pengaturan bisa diakses di seluruh aplikasi
        foreach ($settings as $key => $value) {
            $this->config->set_item($key, $value);
        }
    }
}


?>