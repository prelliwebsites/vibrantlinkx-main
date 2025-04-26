<?php

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject_input = trim($_POST["subject"]);
    $number = trim($_POST["number"]);
    $message = trim($_POST["message"]);

    // Validate the form data
    if ( empty($name) || empty($message) || empty($number) || empty($subject_input) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Recipient email
    $recipient = "inquiry@vibrantlinkx.com"; // Change to your email

    // Email subject
    $email_subject = "New contact form submission: $subject_input";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone Number: $number\n";
    $email_content .= "Subject: $subject_input\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: VibrantLinkX <no-reply@vibrantlinkx.com>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    

    // Send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
