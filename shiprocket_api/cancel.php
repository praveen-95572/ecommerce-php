<?php

	$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"ids\": \"{16168898,16167171}\",\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
      "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEyMTE5MDAsImlzcyI6Imh0dHBzOi8vYXBpdjIuc2hpcHJvY2tldC5pbi92MS9leHRlcm5hbC9hdXRoL2xvZ2luIiwiaWF0IjoxNjEzMDY4MjIwLCJleHAiOjE2MTM5MzIyMjAsIm5iZiI6MTYxMzA2ODIyMCwianRpIjoiTWgyWkZUMElvRFFrRWNKYiJ9.-OSiVFNszxVgZaFO1ZIO5Hhw86X9bPEYrDgdSFg--1g"
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  echo $response;

?>