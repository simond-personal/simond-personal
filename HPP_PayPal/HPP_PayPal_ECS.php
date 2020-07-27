
<?php
    /*
     This PHP code provides a payment form for the Adyen Hosted Payment Pages
     */

    /*
     account details
     $skinCode:        the skin to be used
     $merchantAccount: the merchant account we want to process this payment with.
     $sharedSecret:    the shared HMAC key.
     */

    $skinCode        = "KwgfavEJ"; // your skinCode
    $merchantAccount = "DanIncCOM"; // your merchantAccount
    $hmacKey         = "32773F99CAB9C54F162F3C7F5E532476D56BCBDCBD469F96611983BD43D959FC"; // your Hmac Key


    /*
     payment-specific details
     */

     $params = array(
        "merchantReference" => "SKINTEST-143522199",
        "merchantAccount"   =>  $merchantAccount,
        "currencyCode"      => "GBP",
        "paymentAmount"     => "198",
        "sessionValidity"   => "2021-12-25T10:31:06Z",
        "shipBeforeDate"    => "2017-07-01",
        "shopperLocale"     => "en_GB",
        "skinCode"          => $skinCode,
        "brandCode"         => "paypal_ecs",
        "shopperReference"  => "123",
        "intent"            => "authorize",
        "shopperEmail"      => "daniel.watson@adyen.com",
        "merchantReturnData"=> "https://pay.test.netbanx.com/echo",
        "deliveryAddress.city" => "London",
        "deliveryAddress.country" => "GB",
        "deliveryAddress.houseNumberOrName" => "10",
        "deliveryAddress.postalCode" => "al7 3eq",
        "deliveryAddress.street" => "Otto Road",
        "deliveryAddressType" => 2
    );

    /*
     process fields
     */

    // The character escape function
     $escapeval = function($val) {
        return str_replace(':','\\:',str_replace('\\','\\\\',$val));
    };

    // Sort the array by key using SORT_STRING order
    ksort($params, SORT_STRING);

    // Generate the signing data string
    $signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));
echo "<h1>sign data</h1>      <br>" . $signData;
    // base64-encode the binary result of the HMAC computation
    $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
    $params["merchantSig"] = $merchantSig;
echo "<br>";

    echo "<h1>Merchant Signature</h1>" . $merchantSig;


    ?>


    <!-- Complete submission form -->

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Adyen Payment</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <form name="adyenForm" action="https://test.adyen.com/hpp/skipDetails.shtml" method="post">

            <?php
            foreach ($params as $key => $value){
                echo '        <input type="hidden" name="' .htmlspecialchars($key,   ENT_COMPAT | ENT_HTML401 ,'UTF-8').
                '" value="' .htmlspecialchars($value, ENT_COMPAT | ENT_HTML401 ,'UTF-8') . '" />' ."\n" ;
            }
            ?>
            <input type="submit" value="Redirect to paypal_ecs" />
        </form>
    </body>
    </html>
