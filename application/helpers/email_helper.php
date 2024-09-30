<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('send_email')) {
    function send_email($options)
    {
        $CI = &get_instance();
        $CI->load->library('email');
        $CI->load->database(); // Load database untuk menyimpan log

        // Set konfigurasi email
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => $CI->config->item('smtp_host'),
            'smtp_crypto' => $CI->config->item('ssl_tsl'), 
            'smtp_port'   => $CI->config->item('smtp_port'),
            'smtp_user' => $CI->config->item('smtp_user'),
            'smtp_pass' => 'sxvx zzaq hjhi xlbv',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n"
        );

        // Initialize konfigurasi email
        $CI->email->initialize($config);

        // Set pengirim (from)
        $CI->email->from($options['from_email'], $options['from_name']);

        // Set penerima (to)
        $CI->email->to($options['to']);

        // Set CC dan BCC jika ada
        if (isset($options['cc'])) {
            $CI->email->cc($options['cc']);
        }
        if (isset($options['bcc'])) {
            $CI->email->bcc($options['bcc']);
        }

        // Set subjek dan pesan
        $CI->email->subject($options['subject']);
        $CI->email->message($options['message']);

        // Lampiran jika ada
        // if (isset($options['attachment'])) {
        //     if (is_array($options['attachment'])) {
        //         foreach ($options['attachment'] as $file) {
        //             $CI->email->attach($file);
        //         }
        //     } else {
        //         $CI->email->attach($options['attachment']);
        //     }
        // }
        if (isset($options['attachment'])) {
            if (is_array($options['attachment'])) {
                foreach ($options['attachment'] as $file) {
                    if (file_exists($file)) {  // Pastikan file ada sebelum dilampirkan
                        $CI->email->attach($file);
                    }
                }
            } else {
                if (file_exists($options['attachment'])) {  // Pastikan file ada sebelum dilampirkan
                    $CI->email->attach($options['attachment']);
                }
            }
        }

        $cc_emails = !empty($options['cc']) && is_array($options['cc']) ? implode(',',$options['cc']) : '';
            $bcc_emails = !empty($options['bcc']) && is_array($options['bcc']) ? implode(',',$options['bcc']) : '';
        if (is_array($options['to'])) {
            $to_email = implode(',',$options['to']);
        }else{
            $to_email = $options['to'];
        }

        if ($CI->email->send()) {
            // Jika berhasil, simpan log sukses ke database
            
            $log_data = array(
                'form_email'      => $options['from_email'],
                'to_email'        => $to_email,
                'cc_email'        => $cc_emails,
                'bcc_email'       => $bcc_emails,
                'subject'         => $options['subject'],
                'message'         => $options['message'],
                'status'          => 'success',
                'error_message'   => ''
            );
            $CI->db->insert('email_log', $log_data);

            return true;  // Email berhasil terkirim
        } else {
            // Jika gagal, simpan log error ke database
            $log_data = array(
                'form_email'      => $options['from_email'],
                'to_email'        => $to_email,
                'cc_email'        => $cc_emails,
                'bcc_email'       => $bcc_emails,
                'subject'         => $options['subject'],
                'message'         => $options['message'],
                'status'          => 'error',
                'error_message'   => $CI->email->print_debugger()
            );
            $CI->db->insert('email_log', $log_data);

            // Log error
            log_message('error', $CI->email->print_debugger());
            return false; // Gagal mengirim email
        }
    }
}

