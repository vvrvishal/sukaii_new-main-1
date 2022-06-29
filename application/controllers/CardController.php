<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CardModel CardModel
 */
class CardController extends CI_Controller
{

	public function index()
	{
		// $this->load->view('welcome_message');
	}

	public function previousPayment()
	{

		$this->load->model('CardModel');
		$patientId = $this->session->user_session->id;
		$allCard = $this->CardModel->getAllCards($patientId);
		$card = '';
		foreach ($allCard->data as $cardRow)
		{
			$card .='<div class="col-6 px-1 rounded">
				<div class="border px-4 py-3 rounded" style="background: #f1f1f1;">
					<div class="align-items-center d-flex justify-content-between mb-3">
						<img src="'.base_url().'assets/mimages/visa_CARD.png" alt="" style="height: 42px; width: 81px;" class="rounded">
						<span><i class="fa-solid fa-circle-chevron-right"></i></span>
					</div>
					<div class="">
						<p class="mb-0 small">BANK</p>
						<p class="mb-0 small">'.$cardRow->card_number.'</p>

					</div>
				</div>
			</div>';
		}
		$data["card"] = $card;
		$this->load->view('order/previousPaymentPage',$data);
	}

	public function addCardForm()
	{
		$this->load->view('order/addCardForm');
	}

	public function addCardDetails()
	{
		$this->load->model('CardModel');
		$patientId = $this->session->user_session->id;
		$cardDataArr = array(
			"card_number" => $this->input->post("cardNumber"),
			"card_holder_name" => $this->input->post("cardHolderName"),
			"card_expiry" => $this->input->post("cardExpiry"),
			"card_type" => $this->input->post("cardType"),
			"status" => 1,
			"created_on" => date('Y-m-d H:i:s'),
			"created_by" => $patientId,
			"user_id" =>$patientId,
		);
		$checkCardExists = $this->CardModel->checkCardExists($this->input->post("cardNumber"));
//		var_dump($checkCardExists->toa);
//		exit;
		if ($checkCardExists->totalCount < 1) {
			$addCard = $this->CardModel->addCard($cardDataArr);
			if ($addCard) {
				$response["status"] = 200;
				$response["body"] = "Card Added";
			} else {
				$response["status"] = 201;
				$response["body"] = "Card already Exists";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Card already Exists";
		}
		echo json_encode($response);
	}
}
