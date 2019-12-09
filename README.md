# Paypal Integration in Codeigniter
Sample paypal integration using codeigniter framework.

Codeigniter is one of the best light weight and fast php mvc framework.
There is no good free codeigniter paypal library.
This library will help you get started with codeigniter and paypal.

# How to Use
-------------------
Download it and place paypal at ```application/third_parthy``` and ```paypal.php``` at ```application/libraries```

```
$config = [
	"clientID"=> "client id",
	"currency"=>"EUR", //default is USD
	"intend"=>"sale", //default is sale
	"clientSecret"=> "client secret",
	"redirectUrl"=>"http://localhost/paypal-integration-ci/index.php/welcome/success",//controller method paypal will return here after success
	"cancelUrl"=>"http://localhost/paypal-integration-ci/index.php/welcome/payment/canceled"//controller method paypal will return here after cancel
];
$this->load->library('paypal',$config);
$result = $this->paypal->pay('1.00');
redirect($result["approval_url"]);
```

