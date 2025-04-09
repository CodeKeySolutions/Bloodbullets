<?php

// Tebex allowed IP addresses
$allowedIPs = ['18.209.80.3', '54.87.231.232'];

// Your Tebex webhook secret (from Developers > Webhooks > Endpoints)
$webhookSecret = '7142831dcfb50bed3bde4b5284c7538d';

// Get the IP address of the request (handling Cloudflare)
$requestIP = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];

// Verify the IP address
// if (!in_array($requestIP, $allowedIPs)) {
//     http_response_code(404); // Not Found
//     echo "Invalid IP address. Request ignored.";
//     exit;
// }

// Get the raw POST data (payload)
$json = file_get_contents('php://input');

// Get the X-Signature header
$signatureHeader = $_SERVER['HTTP_X_SIGNATURE'] ?? '';

// Generate the expected signature
$bodyHash = hash('sha256', $json); // Hash the raw JSON body
$expectedSignature = hash_hmac('sha256', $bodyHash, $webhookSecret); // Generate HMAC

// Verify the signature
// if (!isset($signatureHeader) || !hash_equals($expectedSignature, $signatureHeader)) {
//     http_response_code(403); // Forbidden
//     echo "Invalid webhook signature. Request ignored.";
//     exit;
// }

// Decode the JSON payload
$data = json_decode($json, true);
file_put_contents('webhook_log.txt', print_r($json, true), FILE_APPEND);
// Check if JSON decoding was successful
if (!isset($data)) {
    http_response_code(400); // Bad Request
    echo "Invalid webhook payload. Request ignored.";
    exit;
}

// Handle validation webhooks
if (isset($data['type']) && $data['type'] === 'validation.webhook') {
    // Respond with the validation response
    $validationResponse = [
        'id' => $data['id'] // Echo back the ID from the validation webhook
    ];
    header('Content-Type: application/json');
    file_put_contents('webhook_log.txt', print_r($data, true), FILE_APPEND);
    echo json_encode($validationResponse);
    http_response_code(200);
    exit;
}
$data['POST'] = $_POST;
// Handle regular webhooks
http_response_code(200); // Success
echo "Webhook received and processed successfully!";
var_dump($data);

// Process the webhook data here...
// Example: Log the webhook or update your database
file_put_contents('webhook_log.txt', print_r($data, true), FILE_APPEND);
?>