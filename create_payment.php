<?php
$api_key = 'sk_sandbox_XzbA_dst3LNLDi5LX98xRWrd'; // TA CLÉ API SECRÈTE SANDBOX

$amount = $_POST['amount'];

$data = [
    "transaction" => [
        "amount" => $amount,
        "description" => "Abonnement PMU"
    ],
    "customer" => [
        "firstname" => "Client",
        "lastname" => "Premium",
        "email" => "test@chevalturf.com",
        "phone_number" => [
            "number" => "0145864300",
            "country" => "BJ"
        ]
    ]
];

$ch = curl_init('https://sandbox-api.fedapay.com/v1/checkout/initiate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (isset($result['url'])) {
    echo json_encode(["url" => $result['url']]);
} else {
    echo json_encode(["error" => "Impossible de créer la transaction"]);
}
?>
