<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal
{
	protected $ci;
	protected $clientID;
	protected $clientSecret;

	public function __construct(array $config = array())
	{
        $this->ci =& get_instance();
		$this->initialize($config);
		$this->_safe_mode = ( ! is_php('5.4') && ini_get('safe_mode'));
		log_message('info', 'Paypal Class Initialized');
	}
	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @return	CI_Email
	 */
	public function initialize(array $config = array())
	{
		$this->clear();

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
		$this->clientID = $value
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
		$this->clientSecret = $value
		return $this;
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

// // After Step 2
// $payer = new \PayPal\Api\Payer();
// $payer->setPaymentMethod('paypal');

// $amount = new \PayPal\Api\Amount();
// $amount->setTotal('1.00');
// $amount->setCurrency('USD');

// $transaction = new \PayPal\Api\Transaction();
// $transaction->setAmount($amount);

// $redirectUrls = new \PayPal\Api\RedirectUrls();
// $redirectUrls->setReturnUrl("http://localhost/gc/paypal.php")
//     ->setCancelUrl("http://localhost/gc/paypal.php");

// $payment = new \PayPal\Api\Payment();
// $payment->setIntent('sale')
//     ->setPayer($payer)
//     ->setTransactions(array($transaction))
//     ->setRedirectUrls($redirectUrls);

// // After Step 3
// try {
//     $payment->create($apiContext);
//     echo $payment;

//     echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
// }
// catch (\PayPal\Exception\PayPalConnectionException $ex) {
//     // This will print the detailed information on the exception.
//     //REALLY HELPFUL FOR DEBUGGING
//     echo $ex->getData();
// }