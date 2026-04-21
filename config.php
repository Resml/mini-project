<?php
// config.php
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    $supabase_url = rtrim($env['SUPABASE_URL'], '/') . '/rest/v1';
    $supabase_key = $env['SUPABASE_KEY'];
    $db_connected = true;
} else {
    $db_connected = false;
    die(".env file not found.");
}

function supabase_request($method, $endpoint, $data = null) {
    global $supabase_url, $supabase_key;
    $url = $supabase_url . $endpoint;
    
    $ch = curl_init($url);
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
       'status' => $httpCode,
       'data' => json_decode($response, true)
    ];
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
