<?php
namespace Stellite;
/**
 * Reference implementation for StellitePay's REST API.
 *
 * See https://www.github.com/stellitecoin/stellitepay-api for more info.
 *
 *
*/

class StellitePay
{
    protected $access_token;    // API key
    protected $url;             // API base URL
    protected $version;         // API version
    protected $curl;            // curl handle
    protected $key;             // Your Integrator Key

    /**
     * Constructor for StelliteAPI
     *
     * @param string $access_token API access token
     * @param string $version      API version
     *
     * @return void
    */
    public function __construct($access_token = '0', $version = '1')
    {
        $this->url = 'https://api.stellitepay.com';
        $this->access_token = $access_token;
        $this->version = '/v'.$version;
        $this->key = "";
        $this->curl = curl_init();

        curl_setopt_array($this->curl, [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'StellitePayBETA',
            CURLOPT_RETURNTRANSFER => true,
        ]);
    }

    /**
     * Set integratoe key
     *
     * @param string $key
     *
     * @return void
     */
    public function setIntegratorKey($key)
    {
        $this->key = $key;
    }

    /**
     * Destruct StellitePay class
     *
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * Query login
     *
     * @param string $email   method path
     * @param array $password request parameters
     *
     * @return array access token
    */
    public function login($email, $password)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/login",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                "email" => $email,
                "password" => $password,
                "key" => $this->key,
            ])
        ]);

        $r = json_decode(curl_exec($this->curl));
        if ($r->status == 'success') {
            $this->access_token = $r->message->access_token;
        }

        return $r;
    }

    /**
     * Query create a new user
     *
     * @param string $email method path
     * @param string $name user's name
     * @param string $password request parameters
     *
     * @return array created user
    */
    public function register($name, $email, $password, $beta, $ref='')
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/register",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                "user" => [
                    "name" => $name,
                    "email" => $email,
                    "password" => $password,
                    "key" => $this->key,
                    "betakey" => $beta,
                ],
            ]),
        ]);

        $r = json_decode(curl_exec($this->curl));

        if (isset($r->message->access_token)) {
            $this->access_token = $r->message->access_token;
        }

        return $r;
    }

    /**
     * Query Send Password Reset E-Mail
     *
     * @param string $email
     *
     * @return object response JSON object
     *
    */
    public function sendresetemail($email)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/sendresetemail",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                "email" => $email,
                "key" => $this->key,
                "ip" => $_SERVER['REMOTE_ADDR'],
                "http_request" => $_SERVER['HTTP_USER_AGENT'],
            ])
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query Send Password Reset Credentials
     *
     * @param string $email
     * @param string $token
     * @param string $new_password
     *
     * @return object response JSON object
     *
    */
    public function passwordreset($email, $token, $new_password)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/passwordreset",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                "email" => $email,
                "token" => $token,
                "new_password" => $new_password,
                "key" => $this->key,
            ])
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query logout
     *
     * @return object response JSON object
     *
    */
    public function logout()
    {
        $this->lofi();
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version.'/logout',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query activate email
     *
     * @param string $activate activation string
     *
     * @return object response JSON object
     *
    */
    public function activate($activate)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/activate",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(["activate" => $activate]),
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query balance
     *
     * @return object response JSON object
    */
    public function balance()
    {
        $this->lofi();
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version.'/balance',
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query userdata
     *
     * @return array userdata
    */
    public function user()
    {
        $this->lofi();
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version.'/user',
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query transfer
     *
     * @param string $address Integrated-Address, Normal-Address, E-Mail
     * @param string $amount  amount
     *
     * @return object response JSON object
    */
    public function transfer($address, $amount)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/transfer",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
            CURLOPT_POSTFIELDS => json_encode([
                "address" => $address,
                "amount" => $amount,
            ]),
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query transactoins
     *
     * @return object response JSON object
    */
    public function transactions()
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/transactions",
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query addressbook
     *
     * @return object response JSON object
    */
    public function getaddressbook()
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/addressbook",
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query add addressbook
     *
     * @param string $address
     * @param string $description
     *
     * @return object response JSON object
    */
    public function addaddressbook($address, $description)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/addressbook" ,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
            CURLOPT_POSTFIELDS => json_encode([
                "address" => $address,
                "description" => $description,
            ]),
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query add addressbook
     *
     * @param string $address
     *
     * @return object response JSON object
    */
    public function deladdressbook($address)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/addressbook" ,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
            CURLOPT_POSTFIELDS => json_encode(["address" => $address]),
        ]);

        return json_decode(curl_exec($this->curl));
    }
    /**
     * Query search address from  addressbook
     *
     * @param string $string
     *
     * @return object response JSON object
    */
    public function search($string)
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/search" ,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
            CURLOPT_POSTFIELDS => json_encode(["string" => $string]),
        ]);

        return json_decode(curl_exec($this->curl));
    }
    /**
     * Query all transactoins
     *
     * @return object response JSON object
    */
    public function alltransactions()
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/alltransactions" ,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
        ]);

        return json_decode(curl_exec($this->curl));
    }

    /**
     * Query notifications
     *
     * @param string $timestamp default timestamp value is 0
     *
     * @return object response JSON object
    */
    public function notifications($timestamp = '0')
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $this->url . $this->version . "/notifications" ,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ],
            CURLOPT_POSTFIELDS => json_encode(["timestamp" => (string) $timestamp]),
        ]);

        return json_decode(curl_exec($this->curl));;
    }

    /**
     *  @return object "Login First" Error
    */
    private function lofi()
    {
        if($this->access_token == '') {
            $o = new \stdClass;
            $o->success = false;
            $o->message = "login first";

            return $o;
        }
    }
}
