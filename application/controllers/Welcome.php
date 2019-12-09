<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function payment()
	{
		$config = [
				"clientID"=> "Aek4AInAErRU-U_NVz4aIudBLnDavQKkJ8Bf7qAcpY2vB6Pzq04eX699_9GhJmdI6zfPI9kbjMxRwvaf",
				"clientSecret"=> "EGmJSi49ktJ111COqPvmsoIDHhw-5zIXg9OtSeQ8z3t_Wy3RzIDMeKTmIRlB9gJrL5Qka7cF9-KISDiR",
				"redirectUrl"=>"http://localhost/paypal-integration-ci/index.php/welcome/success",
				"cancelUrl"=>"http://localhost/paypal-integration-ci/index.php/welcome/payment/canceled"
		];
		$this->load->library('paypal',$config);
		$result = $this->paypal->pay('1.00');
		redirect($result["approval_url"]);
	}
	public function success()
	{
		echo "<pre>";
		print_r($this->input->get());
		die;
	}
}
