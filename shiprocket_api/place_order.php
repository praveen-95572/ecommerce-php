<?php
$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'{"order_id": "224-47821",
  "order_date": "2021-01-23 11:11",
  "pickup_location": "garhwal",
  "billing_customer_name": "Praveen",
  "billing_last_name": "Bisht",
  "billing_address": "26,vill. Harbhajwala P.O. Mehuwala Mafi",
  "billing_address_2": "Dehradun",
  "billing_city": "Dehradun",
  "billing_pincode": "248171",
  "billing_state": "Uttarakhand",
  "billing_country": "India",
  "billing_email": "rockysingh99300@gmail.com",
  "billing_phone": "7895394307",
  "shipping_is_billing": true,
  "shipping_customer_name": "",
  "shipping_last_name": "",
  "shipping_address": "",
  "shipping_address_2": "",
  "shipping_city": "",
  "shipping_pincode": "",
  "shipping_country": "",
  "shipping_state": "",
  "shipping_email": "",
  "shipping_phone": "",
  "order_items": [
    {
      "name": "TShirt",
      "sku": "tshirt",
      "units": 10,
      "selling_price": "900",
      "discount": "",
      "tax": "",
      "hsn": 441122
    }
  ],
  "payment_method": "Prepaid",
  "shipping_charges": 0,
  "giftwrap_charges": 0,
  "transaction_charges": 0,
  "total_discount": 0,
  "sub_total": 9000,
  "length": 10,
  "breadth": 15,
  "height": 20,
  "weight": 2.5
	}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
	   "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEyMTE5MDAsImlzcyI6Imh0dHBzOi8vYXBpdjIuc2hpcHJvY2tldC5pbi92MS9leHRlcm5hbC9hdXRoL2xvZ2luIiwiaWF0IjoxNjEzMDUwNDEwLCJleHAiOjE2MTM5MTQ0MTAsIm5iZiI6MTYxMzA1MDQxMCwianRpIjoiZmJjMXlYcGJ2WlkwZlNqRiJ9.bqmFCMgFAbUbbO7h8qdy2OtE9Upwdm3uqB6OuM6T8Ew"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  //$SR_login_Response_out = json_decode($SR_login_Response);
  echo '<pre>';
  print_r($SR_login_Response);
?>