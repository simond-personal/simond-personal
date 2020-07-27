
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
        <form name="adyenForm" action="https://test.adyen.com/hpp/3d/validate.shtml" method="post" onsubmit="return false);">
          <!-- <form name="adyenForm" action="https://test.adyen.com/hpp/3d/validate.shtml" method="post" onsubmit="return formValidate(this ,'default' );"> -->
          <input type="hidden" name="MD" value="Yk90TnROWlF1THU3RDFKVjBCTVpYZz09Iays4wd6ygDbft5xn025Qyw7SL9yhR6OXK7v7PsvBhxGeTm5z23W5KopD3P2WwMuPGFzZ3_3aug-VICRJCgJMxkS6BllKI15XyXKFc2o6wnbF-zsHexGaJRuEMst5b--qm-K-mvwPfconwxu_5po7I9UmHvrA_vK2m4hhuHKY6Bl1y-4kPu0qeFbD9t8LHxHlbn8J8Pc7zvm8eugfPqKfWwY-cs6fyLGPquuyXxw0do10TFa17NLc8ltdlfN6WksnlD4F1JBCddEqoXVC_3Yga0qOyNN-8QYVmE0kqCyBzUChj9ostAdyFsqe8k80j2o1GaM" />
          <input type="hidden" name="PaReq" value="eNpVUWFvgjAQ/SvOH0BLpVrJ2YTBkplFdE4+LwQuihugBYbs169FmVs/3Xt393r3DnYHhRi8YdIolLDCqor3OMrSxdgVfMLnfMoE48wRc38sYeNt8SzhC1WVlYW0LWoxIAPU7So5xEUtIU7Oj8tQcptNHCA3BDmqZSB3WNWbPPeSc5MpVECuNBRxjjLy3j3/wfXSDovoxV+vgPQ8JGVT1KqTgk2BDAAa9SkPdX2qXELatrVi02clZQ7EpIDcR9o0Jqq01CVL5TqIvsPdhx0el87qGHVhsOevrWfeAoipgDSuUTLKKJ0xZ8SYSx3X1uv2PMS5mUE+RdsRtSjVS14JOJl/vCvQ9F8I2mWFRdLJ+UzoLQYEeDmVBeoKLf8bA7mP7D8bT5Na+8SZMZVPZ2JOB3v7hFHJtCm2oKKXMQCIaSW3w5HbgXX07/A/Ut6p8g==" />
          <input type="hidden" name="TermUrl" value="https://your-company.com" />

            <input type="submit" value="Redirect to 3DS1" />
        </form>
    </body>
    </html>
