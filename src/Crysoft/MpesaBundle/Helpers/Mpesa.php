<?php
/*********************************************************************************
 * Developed by Maxx Ng'ang'a
 * (C) 2017 Crysoft Dynamics Ltd
 * Karbon V 2.1
 * User: Maxx
 * Date: 9/28/2017
 * Time: 4:26 PM
 ********************************************************************************/

namespace Crysoft\MpesaBundle\Helpers;
use GuzzleHttp\Client;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Mpesa
{
    private $container;

    /**
     * The Mpesa Endpoint
     * @var string
     */
    protected $endPoint;

    /**
     * The Mpesa Status Endpoint
     * @var string
     */
    protected $statusEndPoint;
    /**
     * The Token Endpoint
     * @var string
     */
    protected $tokenEndPoint;

    /**
     * The Callback URL to be queried on completion
     * @var string
     */
    protected $callbackUrl;
    /**
     * The Callback method to be used
     * @var string
     */
    protected $callbackMethod;
    /**
     * The Merchant's Paybill Number
     *
     * @var int
     */
    protected $paybillNumber;

    /**
     * The SAG passkey given on registration
     * @var string
     */
    protected $passKey;

    /**
     * The Hashed Password
     * @var string
     */
    protected $password;
    /*
     * The Transaction Timestamp
     * @var int
     */
    protected $timestamp;
    /**
     * The transaction reference id
     * @var int
     */
    protected $referenceId;
    /**
     * The amount to be deducted
     * @var int
     */
    protected $amount;
    /**
     * The Mpesa number to be billed
     * Must be in the format 2547XXXXXXXX
     * @var string
     */
    protected $number;
    /**
     * The Keys and data to be fill in the request body
     *
     * @var array
     */
    protected $keys;
    /**
     * Consumer key
     *
     * @var string
     */
    protected $consumerKey;
    /**
     * Consumer Secret
     *
     * @var string
     */
    protected $consumerSecret;
    /**
     * The request to be sent to the endpoint
     *
     * @var string
     */
    protected $request;
    /**
     * Generated Unique Transaction Number
     *
     * @var string
     */
    protected $transactionNumber;
    /**
     * Generated Unique Token
     *
     * @var string
     */
    protected $accessToken;


    /**
     * Transactor constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container= $container;

        $this->setUpAPI();

    }

    public function request($amount){
        if (!is_numeric($amount)){
            throw new \InvalidArgumentException('The Amount must be numeric');
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * setup the API options
     */
    protected function setUpAPI()
    {
        $config = $this->container->getParameter('crysoft_mpesa.config');

        $this->endPoint         = $config['mpesa']['endpoint'];
        $this->tokenEndPoint    = $config['mpesa']['token_endpoint'];
        $this->statusEndPoint   = $config['mpesa']['status_endpoint'];
        $this->callbackUrl      = $config['mpesa']['callback_url'];
        $this->callbackMethod   = $config['mpesa']['callback_method'];
        $this->paybillNumber    = $config['mpesa']['paybill_number'];
        $this->passKey          = $config['mpesa']['pass_key'];
        $this->consumerSecret   = $config['mpesa']['consumer_secret'];
        $this->consumerKey      = $config['mpesa']['consumer_key'];
    }


    /**
     * Set the Mpesa Number to deduct funds from
     * Must be in the format 2547XXXXXXXX
     *
     * @param $number
     * @return $this
     */
    public function from($number){

        if (substr($number,0,4)!='2547'){
            throw new \InvalidArgumentException("The subscriber number must start with 2547");
        }
        $this->number = $number;

        return $this;
    }

    /**
     * Set the Reference number to bill the account
     * @param int $referenceId
     * @return $this
     */
    public function usingReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }
    /**
     * Set the Transaction number to bill the account
     * @param string $transactionId
     * @return $this
     */
    public function usingTransactionId($transactionId)
    {
        $this->transactionNumber = $transactionId;

        return $this;
    }
    /**
     * Initiate the transaction
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function transact(){
        return $this->process($this->amount,$this->number,$this->referenceId);
    }
    /**
     * Initiate the request
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function requestStatus(){
        return $this->status($this->referenceId);
    }

    /**
     * Process the transaction request
     *
     * @param $amount
     * @param $number
     * @param $referenceId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function process($amount, $number, $referenceId){
        $this->number = $number;
        $this->amount = $amount;
        $this->referenceId = $referenceId;
        $this->initialize();

        return $this->handle();
    }
    /**
     * Validate and Handle the transaction
     * @return mixed | \Psr\Http\Message\ResponseInterface
     */
    protected function handle()
    {

        //$this->accessToken=$this->generateToken();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->endPoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $this->accessToken)); //setting custom header
            $curl_post_data = array(//Request Parameters
                'BusinessShortCode' => $this->paybillNumber,
                'Password' => $this->password,
                'Timestamp' => $this->timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => '10',
                'PartyA' => $this->number,
                'PartyB' => $this->paybillNumber,
                'PhoneNumber' => $this->number,
                'CallBackURL' => $this->callbackUrl.$this->referenceId,
                'AccountReference' => $this->referenceId,
                'TransactionDesc' => 'Membership Fee'
            );
           // var_dump($curl_post_data);exit;
            $data_string = json_encode($curl_post_data);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            $response = curl_exec($ch);
            //var_dump($response);exit;
            return $response;
    }


    /**
     * Initialize the transaction
     */
    protected function initialize()
    {
        $this->setTimestamp();
        $this->generatePassword();
        $this->generateToken();

    }
    /**
     * Set the Transaction timestamp
     * @return string
     */
    protected function setTimestamp()
    {
        $dateTime = new \DateTime();
        $timezone=$dateTime->format('YmdHis');
        //var_dump($timezone);exit;
        $this->timestamp = $timezone;
        return $this->timestamp;
    }

    protected function generatePassword()
    {
        $passwordSource = $this->paybillNumber.$this->passKey.$this->timestamp;
        $this->password = base64_encode($passwordSource);

        return $this->password;
    }
    protected function generateToken(){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->tokenEndPoint);
        $credentials = base64_encode($this->consumerKey.':'.$this->consumerSecret);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($curl_response,true);

        $this->accessToken = $response['access_token'];
        return $this->accessToken;

    }

    /**
     * Generate a random transaction number
     *
     * @return string
     */
    public function generateTransactionNumber()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 17; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function generateEncryptedPassword()
    {

        $cert = 'cert.cer';
        $plainTextPassword ="";
        /*$public_key = openssl_pkey_get_public(file_get_contents($cert));
        $keyData = openssl_pkey_get_details($public_key);
        //var_dump($keyData['key']);exit;

        openssl_public_encrypt($plainTextPassword, $encrypted, $keyData['key'], OPENSSL_PKCS1_PADDING);

        $password=base64_encode($encrypted);
       // var_dump($password);exit;
        return $password;
        */

        $fp = fopen('cert.cer','r');
        $public_key_string = fread($fp,8192);
        fclose($fp);
        $key_resource = openssl_get_publickey($public_key_string);
        openssl_public_encrypt($plainTextPassword,$encrypted,$key_resource, OPENSSL_PKCS1_PADDING);
        $password = base64_encode($encrypted);
       // var_dump($password);exit;

        return $password;


    }
    /**
     * Generate a random transaction number
     *
     * @return string
     */
    public function generateLongTransactionNumber()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 317; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}