<?php

require_once __DIR__ . '/vendor/autoload.php';

$integrator_key = "YOUR_INTEGRATOR_KEY";

$stellitepay = new \Stellite\StellitePay();

$stellitepay->setIntegratorKey($integrator_key);

$stellitepay->login("CLIENT_EMAIL_ADDRESS","CLIENT_PASSWORD")->status === "success" || die("Unable to login");

$balance = $stellitepay->balance();

/*
Returns 
	status - the status of request
	message.balance - the balance of your wallet in long format with decimal places

	eg.

	object(stdClass)#2 (2) {
	  ["status"]=> string(7) "success"
	  ["message"]=> object(stdClass)#4 (1) {
	    	["balance"]=> int(500)
	  }
	}
*/

$user = $stellitepay->user();


/*

	status - the status of request
	message.id - the user id
	message.name - User's full name
	message.email - User's full email addresss
	message.address - User's full address
	message.payment_id - User's payment id
	message.email_notification - See if user have email notification enabled

	eg.

	object(stdClass)#5 (2) {
  		["status"]=> string(7) "success"
  		["message"]=> object(stdClass)#6 (13) {
		    ["id"]=> int(38)
		    ["name"]=> string(33) "Azizul Hakimi Mohd Yussuf Izzudin"
		    ["email"]=> string(21) "cryptoamity@gmail.com"
		    ["address"]=> string(109) "SEiTBcLGpfm3uj5b5RaZDGSUoAGnLCyG5aJjAwko67jqRwWEH26NFPd26EUpdL1zh4RTmTdRWLz8WCmk5F4umYaFByMtXHm6q6R3f3GoBn1Zv"
		    ["payment_id"]=> string(16) "aa87dc928246155b"
		    ["email_notification"]=> int(0)
		}
		}

*/
