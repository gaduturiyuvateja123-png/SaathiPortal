<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = trim($_POST["message"] ?? '');

    // Validate data
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill all fields with valid information.";
        exit;
    }

    // Recipient email - update this to your support email address
    $recipient = "support@saathi.vizianagaram.gov.in";

    // Email subject
    $email_subject = "Support Request: $subject";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Try to send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Redirect to a thank you page after successful email sending
        header("Location: support_thanks.html");
        exit;
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
        exit;
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
    exit;
}
?>
