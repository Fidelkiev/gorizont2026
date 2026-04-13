<?php
/**
 * Callback form handler
 */

// Include WordPress
$wp_load_path = __DIR__ . '/wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
} else {
    // Fallback for standalone use
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'WordPress not found']);
    exit;
}

// Verify nonce
if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'gorizont_nonce')) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Security check failed']);
    exit;
}

// Validate required fields
if (!isset($_POST['cbPhoneCode']) || !isset($_POST['cbPhone']) || !isset($_POST['cbName'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

// Sanitize input
$phoneCode = sanitize_text_field($_POST['cbPhoneCode']);
$phone = sanitize_text_field($_POST['cbPhone']);
$name = sanitize_text_field($_POST['cbName']);

// Validate phone
$phoneCode = preg_replace('/[^0-9]/', '', $phoneCode);
$phone = preg_replace('/[^0-9]/', '', $phone);

if (empty($phoneCode) || empty($phone) || strlen($phone) < 9) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
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

// Log the request for debugging
error_log("Callback request: $name, $fullPhone, " . ($mail_sent ? 'sent' : 'failed'));

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
