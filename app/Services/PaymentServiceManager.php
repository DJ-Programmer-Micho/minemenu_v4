<?php
namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use App\Models\Gateaway\Payment;
use Illuminate\Support\Facades\Log;

class PaymentServiceManager {

private $user;
private $amount;
private $serviceType = 'books';
private $order_id;
private $language = 'en';
private $auto_renew = false;
private $transaction_id;
private $ip_address;
private $payment_method;
private $currency;



private static $instance = false;

public static function getInstance() {
  if (!self::$instance) {
    self::$instance = new PaymentServiceManager();
  }
  return self::$instance;
}

public function setAmount($amount){
    $this->amount = $amount;
    return $this;
}

public function getAmount(){
    return $this->amount;
}

public function setCurrency($c){
    $this->currency = $c;
    return $this;
}

public function getCurrency(){
    return $this->currency;
}

public function setPaymentMethod($method){
    $this->payment_method = $method;
    return $this;
}

public function getPaymentMethod(){
    return $this->payment_method;
}

public function setUser(User $user){
    $this->user = $user;
    return $this;
}

public function getUser(){
    return $this->user;
}

public function setIpAddress($ip){
    $this->ip_address = $ip;
    return $this;
}

public function getIpAddress(){
    return $this->ip_address;
}

public function setLanguage($lang){
    $this->language = $lang;
    return $this;
}

public function getLanguage(){
    return $this->language;
}

public function setOrderId($order_id){
    $this->order_id = $order_id;
    return $this;
}

public function getOrderId(){
    return $this->order_id;
}

public function setAutoRenew($bool){
    $this->auto_renew = $bool;
    return $this;
}

public function getAutoRenew(){
    return $this->auto_renew;
}


public function setServiceType($serviceType){
    $this->serviceType = $serviceType;
    return $this;
}

public function getServiceType(){
    return $this->serviceType;
}

public function setTransactionId($id){
    $this->transaction_id = $id;
    return $this;
}

public function getTransactionId(){
    return $this->transaction_id;
}


public function send(){
    
    switch (self::getPaymentMethod()) {
        case Payment::AREEBA_PAYMENT:
           return  self::areebaPayment();
            break;

        case Payment::ZAINCASH_PAYMENT:
            return self::zainCashPayment();
            break;
        
        default:
            return false;
            break;
    }

}


public function zainCashPayment(){
    //building data
    $data = [
    'amount'  => self::getAmount(),        
    'serviceType'  => self::getServiceType(),          
    'msisdn'  =>    env('ZIANCASH_SECRET_MSISDN'),
    'orderId'  => self::getOrderId(),
    'redirectUrl'  => env('ZIANCASH_REDIRECT_URL'),
    'iat'  => time(),
    'exp'  => time()+60*60*4
    ];
    //Encoding Token
    $newtoken = JWT::encode(
        $data,      //Data to be encoded in the JWT
        env('ZIANCASH_SECRET_KEY'),
        'HS256'
    );
    //Check if test or production mode
    // $tUrl = 'https://test.zaincash.iq/transaction/init';
    // $rUrl = 'https://test.zaincash.iq/transaction/pay?id=';
    // if(env('ZIANCASH_PRODUCTION_CRED',false)){
        $tUrl = 'https://api.zaincash.iq/transaction/init';
        $rUrl = 'https://api.zaincash.iq/transaction/pay?id=';
    // }else{
    //     $tUrl = 'https://test.zaincash.iq/transaction/init';
    //     $rUrl = 'https://test.zaincash.iq/transaction/pay?id=';
    // }
    //POSTing data to ZainCash API
    $data_to_post = array();
    $data_to_post['token'] = urlencode($newtoken);
    $data_to_post['merchantId'] = env('ZIANCASH_MERCHANT_ID');
    $data_to_post['lang'] = self::getLanguage();
    $options = array(
    'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query($data_to_post),
    ),
    );
    $context  = stream_context_create($options);
    $response= file_get_contents($tUrl, false, $context);
    // dd($response);
    // Log::info($response);
    //Parsing response
    $array = json_decode($response, true);
    // dd($array,self::getAmount());
    $transaction_id = $array['id'];
    $newurl=$rUrl.$transaction_id;
    // dd($newurl);
    return $newurl;
}

public function areebaPayment(){
    $user = self::getUser();
    $apiKey = env('AREEBA_API_KEY');
    $url = "https://gateway.areebapayment.com/api/v3/transaction/$apiKey/debit";    
    $data = [
        "merchantTransactionId" => self::getTransactionId(),
        "amount" => self::getAmount(),
        "currency" => self::getCurrency(),
        "successUrl" => url('/payment/success'),
        "cancelUrl" =>  url('/payment/cancel'),
        "errorUrl" => url('/payment/error'),
        "callbackUrl" => url('/areeba/callback'),
        // "callbackUrl" => url('https://webhook.site/50fe705f-8e4a-4ab8-9152-f5d96695f533'),
        "customer" => [
            "firstName" => $user->profile->fullname,
            "lastName" => 'N/A',
            "company" => $user->name,
            "ipAddress" => self::getIpAddress(),
        ],
        "language" => self::getLanguage(), 
    ];

    if(self::getAutoRenew()){
        ////// Auto Renew
        $data['withRegister'] = true;
        $data["transactionIndicator"] = "RECURRING";
        $data["schedule"] = [
            "amount" => self::getAmount(),
            "currency" => "USD",
            "periodLength" => 30,
            "periodUnit" => 'DAY',
            "startDateTime" => now()->toIso8601String(),
        ];
    }
    $content = json_encode($data);
    

    $username = env('AREEBA_USERNAME');
    $password = env('AREEBA_PASSWORD');
    $credentials = base64_encode("$username:$password");

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json","Authorization: Basic $credentials"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    
    $json_response = curl_exec($curl);
    
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if ($status != 200) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);    
    $response = json_decode($json_response, true);
    $url = $response['success'] ?  $response['redirectUrl'] : '/payment/error';

    return $url;
}
}


// ############# Zain Cash Payment
// ZIANCASH_MERCHANT_ID=5ffacf6612b5777c6d44266f
// ZIANCASH_SECRET_KEY=$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS
// ZIANCASH_SECRET_MSISDN=9647835077893
// ZIANCASH_PRODUCTION_CRED=false


// ############# Areeba Payment
// AREEBA_USERNAME=apiuserIQ0055000101
// AREEBA_PASSWORD=ojAzboPK.C§§$E$V6Y$o9Jqj_xwu!
// AREEBA_API_KEY=KEYIQ0055000101