<?php 
    class OrdersController extends CI_Controller
    {

        public function __construct()
        {
                    parent::__construct();
                    $this->load->model('User_model');
                    $this->load->helper('url_helper');
                    $this->load->library('session');
                    $this->load->library('form_validation');
        }
        public function index()
        {
            // $this->load->view('welcome_message');
        }

        public function userDetails()
	    {
            if(null!==($this->input->post('feedbackId'))){
                $data = array(
                    'mode' => $this->input->post('feed_communication'),
                    'lead_type' => $this->input->post('feed_lead_type'),
                    'comments' => $this->input->post('feed_comments'),
                    'stage' => $this->input->post('feed_stage'),
                    'followup_date' => $this->input->post('feed_followup'),
                    'contact' => $this->input->post('contact_made'),
                    // 'slug' => $slug,
                    // 'text' => $this->input->post('text')
            );
                $this->User_model->update_feed($this->input->post('feedbackId'),$data);
		    }

		if(null==($this->input->post('feedbackId'))){
			$data = array(
				'mode' => $this->input->post('feed_communication'),
				'lead_type' => $this->input->post('feed_lead_type'),
				'comments' => $this->input->post('feed_comments'),
				'stage' => $this->input->post('feed_stage'),
				'followup_date' => $this->input->post('feed_followup'),
				'contact' => $this->input->post('contact_made'),
			);
				$query = $this->User_model->set_feedback($data);		

		}
		$data = $this->db->get("feedback")->result();
	
		echo json_encode($data);
	}

    public function editfeedbackupdate() 
	{
		$id = $this->input->post('id');
		$this->load->model('User_model');
		$data = $this->User_model->get_by_id($id);
		echo json_encode($data);
	}

    public function deleteRecord() {
		$id = $this->input->post('id');
		return $this->User_model->delete($id);
    }

    }

?>