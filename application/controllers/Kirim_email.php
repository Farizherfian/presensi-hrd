<?php 

class Kirim_email extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('nr') == 'Karyawan') {
            $this->session->set_flashdata('error','Anda siapa!!');
            redirect(base_url('dashboard'));
        }
	}

	public function index()
	{
		$data['judul'] = 'Kirim Email';
		$this->load->view('template/header',$data);
		$this->load->view('email/v_kirim_email');
		$this->load->view('template/sidebar');
		$this->load->view('template/footer');
	}
	public function kirim()
	{
		$this->form_validation->set_rules('to', 'To', 'required|callback_validate_email_list');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');

		if ($this->input->post('cc')) {
		    $this->form_validation->set_rules('cc', 'CC', 'callback_validate_email_list');
		}

		if ($this->input->post('bcc')) {
		    $this->form_validation->set_rules('bcc', 'BCC', 'callback_validate_email_list');
		}

        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Kirim Email';
			$this->load->view('template/header',$data);
			$this->load->view('email/v_kirim_email');
			$this->load->view('template/sidebar');
			$this->load->view('template/footer');
        } else {
	        // $to = preg_split('/[,\s]+/', $this->input->post('to'));
	        // $to = array_filter(array_map('trim', preg_split('/[,\s]+/', $this->input->post('to')))); 
	        $to = array_map('trim', explode(',', $this->input->post('to')));
	        $cc = trim($this->input->post('cc')) ? array_map('trim', explode(',', $this->input->post('cc'))) : [];
	        $bcc = trim($this->input->post('bcc')) ? array_map('trim', explode(',', $this->input->post('bcc'))) : [];
	        $subject = trim($this->input->post('subject'));
	        $message = $this->input->post('message');

	        // var_dump($to,$cc,$bcc);
	        // die;

	        $files = $_FILES;
	        $attachments = [];

	        if (!empty($files['attachment']['name'][0])) {
	            $number_of_files = count($files['attachment']['name']);
	            // $this->load->library('upload');

	            // Loop through each file and upload
	            for ($i = 0; $i < $number_of_files; $i++) {
	                $_FILES['attachment']['name'] = $files['attachment']['name'][$i];
	                $_FILES['attachment']['type'] = $files['attachment']['type'][$i];
	                $_FILES['attachment']['tmp_name'] = $files['attachment']['tmp_name'][$i];
	                $_FILES['attachment']['error'] = $files['attachment']['error'][$i];
	                $_FILES['attachment']['size'] = $files['attachment']['size'][$i];

	            	// Tentukan tipe file
			        $file_type = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION); // Mengambil ekstensi file
			        $upload_path = './assets/uploads/attachment/' . $file_type . '/'; // Membuat path berdasarkan tipe file

			        // Buat folder jika belum ada
			        if (!is_dir($upload_path)) {
			            mkdir($upload_path, 0777, true); // Buat folder dengan permission 0777
			        }

	                // Set upload configuration
	                $config['upload_path'] = $upload_path;
	                $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
	                $config['max_size'] = 2048; // Maximum file size (2MB)
	                $this->upload->initialize($config);

	                if ($this->upload->do_upload('attachment')) {
	                    $upload_data = $this->upload->data();
	                    $attachments[] = $upload_path . $upload_data['file_name'];
	                } else {
	                	$data['error'] = $this->upload->display_errors();
	                    $data['judul'] = 'Kirim Email';
						$this->load->view('template/header',$data);
						$this->load->view('email/v_kirim_email',$data);
						$this->load->view('template/sidebar');
						$this->load->view('template/footer');
						return;
	                }
	            }
	        }


        	$options = [
			    'from_email' => $this->session->userdata('email'), // Ganti dengan email pengirim Anda
			    'from_name' => 'HRD',
			    'to' => $to,
			    'cc' => $cc,
			    'bcc' => $bcc,
			    'subject' => $subject,
			    'message' => $message,
			    'attachment' => $attachments,
			];

			// Mengirimkan email menggunakan fungsi send_email
			if (send_email($options)) {
			    $this->session->set_flashdata('berhasil', 'Email berhasil dikirim');
			} else {
			    $this->session->set_flashdata('gagal', 'Email gagal dikirim');
			}
			redirect(base_url('kirim_email'));
        }
	}
	public function validate_email_list($str) {
	    $emails = array_map('trim', explode(',', $str));
	    foreach ($emails as $email) {
	        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            $this->form_validation->set_message('validate_email_list', 'Harus berisi alamat email yang valid.');
	            return FALSE;
	        }
	    }
	    return TRUE;
	}

}



 ?>