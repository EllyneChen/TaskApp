<?php
require_once 'ClassAutoLoad.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data with pet-themed fields
    $petName = $_POST['petName'];
    $petType = $_POST['petType'];
    $petBreed = isset($_POST['petBreed']) ? $_POST['petBreed'] : '';
    $ownerName = $_POST['ownerName'];
    $email = $_POST['email'];

    // 1. Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email case
        echo "Invalid email format. Please provide a valid email address.";
        exit;
    }

    // 2. Send the email notification with pet-themed content
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ellyne.omondi@strathmore.edu';
        $mail->Password   = 'lyxk vvoj mpms eigz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('ellyne.omondi@strathmore.edu', 'Pet Paw-tfolio Creator');
        $mail->addAddress($email, $ownerName); // Add a recipient

        //Content
        $mail->isHTML(True); // Plain text 
        $mail->Subject = "Welcome to Your Pet's Paw-tfolio!";
        
        // Plain text email body
        $mail->Body = "Welcome to Pet Paw-tfolio Creator!\n\n"
                    . "Hello {$ownerName},\n\n"
                    . "We're thrilled to welcome {$petName} to our community of adorable pets!\n\n"
                    . "Your Pet's Details:\n"
                    . "- Name: {$petName}\n"
                    . "- Type: {$petType}\n"
                    . (!empty($petBreed) ? "- Breed: {$petBreed}\n" : "")
                    . "\n"
                    . "Your pet's paw-tfolio is now active! You can now:\n"
                    . "- Share {$petName}'s profile with friends and family\n"
                    . "- Connect with other pet owners\n"
                    . "- Receive tips and updates for your {$petType}\n\n"
                    . "If you have any questions, feel free to reach out to our support team.\n\n"
                    . "Warm regards,\n"
                    . "The Pet Paw-tfolio Team\n"
                    . "🐕🐈🐠";
        
        $mail->send();
        echo "Success! We've created {$petName}'s paw-tfolio and sent a welcome email to {$email}.";

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>