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
// Disable SSL verification for testing (not recommended for production)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

// Log amount and raw response for debugging
error_log("Amount sent: " . $amount);
error_log("Raw API response: " . $response);

if ($curl_error) {
    echo json_encode(["error" => "Erreur cURL: " . $curl_error]);
    exit;
}

// For debugging: output raw response if json_decode fails
$result = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Réponse API invalide", "raw_response" => $response]);
    exit;
}

if (isset($result['url'])) {
    echo json_encode(["url" => $result['url']]);
} else {
    // Return the full API response for debugging
    echo json_encode(["error" => "Impossible de créer la transaction", "details" => $result]);
}
?>
