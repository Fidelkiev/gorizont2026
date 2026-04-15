<?php
/**
 * Callback form handler with security hardening
 */

// Rate limiting by IP
$ip = $_SERVER['REMOTE_ADDR'];
$rate_limit_file = sys_get_temp_dir() . '/callback_rate_' . md5($ip) . '.json';
$max_attempts = 3;
$window_seconds = 300; // 5 minutes

$attempts = [];
if (file_exists($rate_limit_file)) {
    $attempts = json_decode(file_get_contents($rate_limit_file), true) ?: [];
}

// Clean old attempts
$now = time();
$attempts = array_filter($attempts, function($t) use ($now, $window_seconds) {
    return ($now - $t) < $window_seconds;
});

if (count($attempts) >= $max_attempts) {
    header('Content-Type: application/json');
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please try again later.']);
    exit;
}

// Include WordPress
$wp_load_path = __DIR__ . '/wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
} else {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Service unavailable']);
    exit;
}

// Record attempt
$attempts[] = $now;
file_put_contents($rate_limit_file, json_encode($attempts));

// Honeypot check - if hidden field is filled, it's a bot
if (!empty($_POST['website'])) {
    // Silent fail for bots
    header('Content-Type: application/json');
    echo json_encode(['success' => true]); // Fake success to not reveal detection
    exit;
}

// Verify nonce
if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'gorizont_nonce')) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Security check failed']);
    
    // Log potential attack
    error_log("Callback: Invalid nonce attempt from IP: $ip");
    exit;
}

// CSRF token check via referrer
if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
    error_log("Callback: Invalid referrer from IP: $ip");
}

// Validate required fields
if (!isset($_POST['cbPhoneCode']) || !isset($_POST['cbPhone']) || !isset($_POST['cbName'])) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Sanitize input
$phoneCode = sanitize_text_field($_POST['cbPhoneCode']);
$phone = sanitize_text_field($_POST['cbPhone']);
$name = sanitize_text_field($_POST['cbName']);

// Validate phone with stricter rules
$phoneCode = preg_replace('/[^0-9]/', '', $phoneCode);
$phone = preg_replace('/[^0-9]/', '', $phone);

if (empty($phoneCode) || empty($phone) || strlen($phone) < 9 || strlen($phone) > 15 || strlen($phoneCode) > 4) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
    exit;
}

// Validate name (no special chars, reasonable length)
$name = preg_replace('/[<>\\\'";%()&+]/', '', $name);
if (strlen($name) < 2 || strlen($name) > 50) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid name']);
    exit;
}

$fullPhone = '+' . $phoneCode . $phone;

// Prepare email
$to = get_option('admin_email', 'info@gorizont.com.ua');
$subject = 'gorizont.com.ua Callback Request';
$message = "Name: $name\nPhone: $fullPhone\n\nWants to be called back.";
$headers = array(
    'Content-Type: text/plain; charset=UTF-8',
    'From: ' . get_option('blogname') . ' <noreply@gorizont.com.ua>'
);

// Send email
$mail_sent = wp_mail($to, $subject, $message, $headers);

// Log the request for monitoring
$log_entry = date('Y-m-d H:i:s') . " | IP: $ip | Name: " . substr($name, 0, 20) . " | Phone: " . substr($fullPhone, 0, 15) . " | Status: " . ($mail_sent ? 'sent' : 'failed') . "\n";
error_log("Callback request: " . $log_entry);

// Additional security: log suspicious patterns
if (preg_match('/(script|javascript|onload|onerror|alert|document|window)/i', $name)) {
    error_log("Callback: Potential XSS attempt blocked from IP: $ip");
}

// Return response
header('Content-Type: application/json');
if ($mail_sent) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! We will call you back soon.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, there was an error. Please try again.'
    ]);
}
?>
