# StellitePay API

## Overview

Please notice! This API is still under development and only people with a **MERCHANT/INTEGRATOR KEY** can use it at the moment.

## Installation

Using composer 
`composer require stellitecoin/stellitepay`

Include composer autoload
`require_once __DIR__ . '/vendor/autoload.php';`


Now you can use in your code with your vendor's integrator key

```PHP
<?php

    $stellitepay = new \Stellite\StellitePay();

    $stellitepay->setIntegratorKey($your_integrator_key);

?>
```

To view more example checkout (example.php)[exmple.php]


## Structure

* [Format](#format-etc)
* [Request Format](#request-format)
* [Request & Response Examples](#request--response-examples)
* [Error Handling](#error-handling)

## Format etc.

1 UNIT: 0.01 XTL

Stellite Address: ^Se\d[0-9A-Za-z]{94}$

Stellite Integrated Address: ^SEi[0-9A-Za-z]{104}$

**'INTERN_TXID/INTERN_FEE'**: If a transaction is made within the system the transaction will be marked with a fixed transaction fee and intern txid

## Request Format

Please provide 
Header: Content-Type:application/json
Authorization: Bearer


## Request & Response Examples

### POST /v1/register

Example Request (POST): 
```
curl -X POST https://api.stellitepay.com/v1/register 
-H 'Content-Type:application/json' 
-d '{"user": {
        "email":"YOUR_EMAIL",
        "name":"YOUR_NAME",
        "password":"YOUR_PASSWORD",
        "key":"YOUR_MERCHANT_KEY",
        "betakey":"BETA_KEY"
    }
}'
```
Result:

```
{
    "status":"success",
    "message":{
        "id":1,
        "name":"Philip",
        "email":"philip119@gmx.de",
        "address":"SEiSnc98BDB562nrcHPMsJ41raZnEmsKmUCfn1hCCwbbRd4NbmRGDM1AbuDahyFW7MSJNbKYa6LDy7SPLqu2hCYNi72VaTtHwh1ABcMYcpjob",
        "payment_id":"3f742cb2d8f25278",
        "updated_at":"2018-06-21 17:56:35",
        "updated_at":"2018-06-21 17:56:35"
    }
}
```

### POST /v1/login

Example Request (POST): 
```
curl -X POST https://api.stellitepay.com/v1/login 
-H 'Content-Type:application/json' 
-d '{
    "email":"YOUR_EMAIL",
    "password":"YOUR_PASSWORD",
    "key":"YOUR_MERCHANT_KEY"
}'
```
Result:

```
{
    "status":"success",
    "message": {
        "access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijc2ZjY2ZjUwOTBhZjgzMzJhYjljMjcwYmE2Y2I2NGNmOWY1OTg5NGMzMjkwNjBiZDY3NzgwODA0OTJlMDg4MzI2ZTM1OTMzMWEzY2IzNjUzIn0.eyJhdWQiOiIyIiwianRpIjoiNzZmNjZmNTA5MGFmODMzMmFiOWMyNzBiYTZjYjY0Y2Y5ZjU5ODk0YzMyOTA2MGJkNjc3ODA4MDQ5MmUwODgzMjZlMzU5MzMxYTNjYjM2NTMiLCJpYXQiOjE1Mjc2MjI3NDIsIm5iZiI6MTUyNzYyMjc0MiwiZXhwIjoxNTI3NjI4NzQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.hqUzpx_EtutJUiuJGhZfpN01V57NLUsZf7_jwmwWf_G3zz0CEF_3G4fgaAOuiycPnrJtnmStu-pXvXM3L8K0mGrLtEtUMbtH4FectFtqXuQfp9KhPpNjCDz3NW-orjHW9igWNOmTg9daPljFiBxqi_rs7J0RGWBy1mILT-fw0eToGaegtRHezxc022xEgquTaPbw9ZQMETxYNAVaEmXdQyz6uEsOMOlIdDFe9aoxg522jzmcsDaQilXNswTNokLxfUHjAU2kRNa0ahCs14GsEJY9ucJgkkzwrajppTdcJ-mnyAd0Fmx0K-dvdb1h6z2ILPA5JZ7Pf_rlSXFPa5s5rej_tGzC08UX2fwO6qSfbiLCNKWXGz40ldSLlBVFK0bRSZ152TLEE-lWB5YPbqq1gg85GzBkzsp07X8omTXAfaDNxqAsn9ZHf_1d0Xt1jxKE9kuao-iqY4OwytrTLLGv_jQoDV5j6-BGnUAX-7NrugVwcuWk2kPN26xOn8Tvm3XCawkOZ622TM3OgbuVjrOSGS3AT4_vrYOloNtnSM_VjSdqeYrQxuVaE80GcSQJoK68HBgbUAfyUe1f49s1SpILbFPtfACK6Sslrl3C7IAqsnZad785gEt1q4pSIFysRsg8wwALl63mWzty4LgU3nqOsZFv_7iFbuJFH1osY4kEXSc",
        "expires_in":600
    }
}
```

### GET /v1/balance

Example Request (GET): 
```
curl -X GET https://api.stellitepay.com/v1/balance 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json'
```
Result:

```
{
    "status":"success",
    "message":{
        "balance":1337
    }
}
```

### POST /v1/logout

Example Request (POST): 
```
curl -X POST https://api.stellitepay.com/v1/logout 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json'
```
Result:

```
{

}
```

### POST /v1/activate

Example Request (POST): 
```
curl -X POST https://api.stellitepay.com/v1/activate 
-H 'Content-Type:application/json'
-d '{"activate":"EMAIL_ACTIVATION_KEY"}'
```
Result:

```
{
    "status":"success",
    "message":"successful"
}
```



### POST /v1/transfer

Example Request (POST): 
```
curl -X POST https://api.stellitepay.com/v1/transfer 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json' 
-d '{"address":"YOUR_EMAIL/ADDRESS","amount":"1337"}'

```
Result:

``` 
{
    "status":"success",
    "message":{
        "fee": 1,
        "txid":"fb24a5584e60b1a7773c19f4b2b30a798c228ce59fd4a4defcbc0e3cbb58492a",
        "amount":"1337"
    }
}
```

### GET /v1/transactions (MAX. 5) | GET /v1/alltransactions (ALL)

Example Request (GET): 
```
curl -X GET https://api.stellitepay.com/v1/transactions 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json'

```
Result:

``` 
{
    "status":"success",
    "message":[{
            "address": "felix@stellite.cash"
            "amount": 1337
            "created_at": 1531698603983
            "fee": 100
            "name": "WolfOfCrypto"
            "txid": "ec6cbc193e93ba99685fdd96ec939c4328"
            "type": "sent via email"
        },{
            "address": "erwin@stellite.cash"
            "amount": 420
            "created_at": 1531698603982
            "fee": 100
            "name": "Erwin Beij"
            "txid": "b7382a7ca5fda64966e01c0b22e161558f"
            "type": "sent via email"
        },{
            "amount": 7331
            "created_at": 1531698603981
            "name": "Hayzam Sherif"
            "txid": "b7382a7ca5fda64966e01c0b22e161558f"
            "type": "incoming"
        }
    ]
}
```

### GET /v1/addressbook

Example Request (GET): 
```
curl -X GET https://api.stellitepay.com/v1/addressbook 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
```
Result:
```
{
    "status":"success",
    "message":[
        {
            "address":"erwin@stellite.cash",
            "description":"Erwin"
        },
        {
            "address":"SEiT9B5ycGH7ZZ4HqEkEGVDLVqMxX9ZmjJeoGq3LMCj7DP9hBwCiFBF6kt1cWTx7FhZGwxKKFBsAzTA8VGMZo1Uo3MBtGvXTYr18JSja7j3qf",
            "description":"https://stellitecasino.win Deposit Address"
        },
        {
            "address":"Se3QZdzhRWWhFTpWR4NckhViZPWWPiiiEJCUG34x6TobfcW19Bgk2b71yeRuR97cbQEbYARuvF37QccpMC6tjV882cym6Czc8",
            "description":"My Private Address"
        }
    ]
}
```

### POST /v1/addressbook

Example Request (POST): 
```
curl -X POST https://api.stellitepay.com/v1/addressbook 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json' 
-d '{"address":"hayzam@stellite.cash","description":"Cool Dude"}'
```
Result:
```
{
    "status":"success",
    "message":
    {
        "address":"hayzam@stellite.cash",
        "description":"Cool Dude"
    }
}
```

### DELETE /v1/addressbook

Example Request (DELETE): 
```
curl -X DELETE https://api.stellitepay.com/v1/addressbook 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json' 
-d '{"address":"hayzam@stellite.cash"}'
```
Result:
```
{
    "status":"success",
    "message":"entrie(s) deleted"
}
```

### POST /v1/search

Example Request (DELETE): 
```
curl -X DELETE https://api.stellitepay.com/v1/addressbook 
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjE1OTc4MWUyMTUxYTQ1YWE5YmFiMzJmMDYxZjM0YTMyYTNjM2NjMzIyZjVlMjA2YzM4ZGFlMGE0ZTllYjY2MDBhMzRmOWQ3YmI1YmZkMDY2In0.eyJhdWQiOiIyIiwianRpIjoiMTU5NzgxZTIxNTFhNDVhYTliYWIzMmYwNjFmMzRhMzJhM2MzY2MzMjJmNWUyMDZjMzhkYWUwYTRlOWViNjYwMGEzNGY5ZDdiYjViZmQwNjYiLCJpYXQiOjE1Mjc0NTIyODYsIm5iZiI6MTUyNzQ1MjI4NiwiZXhwIjoxNTI3NDU4Mjg2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.MZoX_45zrgP9Cv6K17peg0F-anMw0Fdjk6us4SxAuCMAtGdIs7UwaxwIuzHp3xJ6rC3bCOe3oZSqlTkS2L-Wn4gbDFi4E8az368_pE6jefxY75byW8iG1MEqHxFVfoiffYu2_1GX0LhLS5NgguS-W7QktDJcBK6PZLWlJdLmZIX5bLxjGTauWIdUY9arpkrqSBT0vXow0VqwHhxrTRJazpN4-o7nOfrcLaErfXYpsQ8iy-LTWotcwH0gM1HRwMW-Gj0AnXv1S6nkqCe5nCX5VqGB156KgEVf0YsqBtXgqkVEgUoY0WF7ltekOWGiOiXv-V6vkPCjHJCVvUopHk5QnoT6wMveiqUyJea9c9ibuYloLOQ9Y4eH2XM2HyiCHt1xE00usZuwiMJhALVvxYseFjlacjGzO2WmcFsE8ixqCpdPt8aWBSP_i6OpODuILjIDQXblLibn7zOu3ZWiToL9JUTDodTcsCYuHZ14X-1tW-4yhB0rXP5UiOT0NNjMrKMDfJVHcM5SdvcZ5_54TV-akaL1ya65Sa-GP_NSQZRsBDFC85IoO0z4sXedd9Z7vCO56RZMe2IX9YjKK7K_DQa7IoMJR5XhEI8SBeH_5zaBpvqXUTYT8JzogbVWXe6eHG8SpAks_4WjH__j_n8nEETslczF9TIw-2UUnMVT59kCrgU'
-H 'Content-Type:application/json' 
-d '{"string":"hay"}'
```
Result:
```
{
    "status":"success",
    "message":[
        {"label":"hayzam@gmail.com"}
    ]
}
```

## Error Handling Outdated

| Error Message | Description | Handling |
| --- | --- | --- |
| 0 | Wrong IntAuth | Please enter a valid Integrator Authentification|
| 1 | Wrong Parameter | Please enter all of the needed Parameter |
| 2 | Wrong id/auth | Check both Parameters |
| 3 | Empty address or wrong Format | *Amount > 0* and right *ADDRESS* [format](#format) |
| 4 | Withdraw couldn't be inserted | Please check your Database or contact the Support |
| 5 | Something went wrong with the balance | Please check your Database or contact the Support |
| 6 | RPC call error | Please check the RPC (online?, synced?, right wallet?) |
| 7 | Not enough balance | Please enter a lower amount (min. Balance = 5 XTL)|
| 8 | Address type 1/2 is ATM not available | Please wait :) |
| 9 | Empty Addressbook | Set at least one Address |
| 10 | Error while inserting new Address | Check all Parameters |
| 11 | No Deposits | Please deposit first |
| 12 | Spam Error | Please let enough time between the queries to prevent overlapping queries |
| 13 | Email doesn't exists | Please enter an email address, which is registered|
| 14 | Same User | You can't transact XTL between the same User |
| 15 | Database Error | Please contact the Support |
| 16 | More coming | soon! |

## Authors

* **Philip Jovanovic** - *Initial work* - [Stellite Dev](https://stellite.cash)

See also the list of [contributors](https://github.com/stellitecoin/contributors) who participated in this project.