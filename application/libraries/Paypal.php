<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal
{
	protected $ci;
	private $clientID;
	private $clientSecret;
	protected $redirectUrl;
	protected $cancelUrl;
	protected $paymentMethod = "paypal";
	protected $currency = "USD";
	//intention of the payment
	protected $intent = "sale";

	public function __construct(array $config = array())
	{
		require_once APPPATH.'third_party/paypal/autoload.php';
		$this->ci =& get_instance();
		$this->initialize($config);
		$this->_safe_mode = ( ! is_php('5.4') && ini_get('safe_mode'));
		log_message('info', 'Paypal Class Initialized');
	}
	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @return	this
	 */
	public function initialize(array $config = array())
	{
		// $this->clear();
		echo "<pre>";
		print_r($config);
		die;
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$method = 'set_'.$key;

				if (method_exists($this, $method))
				{
					$this->$method($val);
				}
				else
				{
					$this->$key = $val;
				}
			}
		}
		return $this;
	}
	public function clear()
	{
		$this->clientSecret		= '';
		$this->clientID		= '';

		return $this;
	}
	/**
	 * Set ID
	 *
	 * @param	string
	 * @return	PAYPAL
	 */
	public function set_clientID($value)
	{
		$this->clientID = $value;
		return $this;
	}
	/**
	 * Set clientSecret
	 *
	 * @param	string
	 * @return	PAYPAL
	 */
	public function set_clientSecret($value)
	{
		$this->clientSecret = $value;
		return $this;
	}
	public function set_redirectUrl($value)
	{
		$this->redirectUrl = $value;
		return $this;
	}
	public function set_cancelUrl($value)
	{
		$this->cancelUrl = $value;
		return $this;
	}
	/**
	 * pay
	 *
	 * @param	string amount to pay
	 * @return	array payment details and approval link
	 */
	public function pay($payment)
	{
		die($this->redirectUrl);
		$result = array("error"=>"","payment"=>"","approval_url"=>"");
		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				$this->clientID,
				$this->clientSecret
			)
		);
		// After Step 2
		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod($this->paymentMethod);

		$amount = new \PayPal\Api\Amount();
		$amount->setTotal($payment);
		$amount->setCurrency($this->currency);

		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount);

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl($this->redirectUrl)
		->setCancelUrl($this->cancelUrl);

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent($this->intent)
		->setPayer($payer)
		->setTransactions(array($transaction))
		->setRedirectUrls($redirectUrls);

		// After Step 3
		try {
			$payment->create($apiContext);
			$result["payment"] = $payment;
			$result["approval_url"] = $payment->getApprovalLink();
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			$result["error"] = $ex->getData();
		}
		return $result;
	}

}

/* End of file Paypal.php */
/* Location: ./application/libraries/Paypal.php */
// <?php
// if($_POST){
// echo "<pre>"; 
//     print_r($_POST);
//  die;
// }
// // 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// // Used for composer based installation
// require __DIR__  . '/vendor/autoload.php';
// // Use below for direct download installation
// // require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
// // After Step 1
// $apiContext = new \PayPal\Rest\ApiContext(
//     new \PayPal\Auth\OAuthTokenCredential(
//         'Aek4AInAErRU-U_NVz4aIudBLnDavQKkJ8Bf7qAcpY2vB6Pzq04eX699_9GhJmdI6zfPI9kbjMxRwvaf',     // ClientID
//         'EGmJSi49ktJ111COqPvmsoIDHhw-5zIXg9OtSeQ8z3t_Wy3RzIDMeKTmIRlB9gJrL5Qka7cF9-KISDiR'      // ClientSecret
//     )
// );

