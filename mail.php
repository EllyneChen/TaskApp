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
        // Redirect back with error
        header("Location: index.php?error=email");
        exit;
    }

    // 2. Check if user already exists
    try {
        // Load configuration
        require_once 'conf.php';
        
        // Create database connection
        $dsn = "mysql:host={$conf['db_host']};dbname={$conf['db_name']};charset=utf8";
        $db = new PDO($dsn, $conf['db_user'], $conf['db_pass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if pet already exists for this email
        $checkStmt = $db->prepare("SELECT id FROM users WHERE email = :email AND pet_name = :pet_name");
        $checkStmt->execute([
            ':email' => $email,
            ':pet_name' => $petName
        ]);
        
        $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existingUser) {
            // User already exists, redirect with error
            header("Location: index.php?error=duplicate");
            exit;
        }
        
    } catch (PDOException $e) {
        // Redirect back with database error
        header("Location: index.php?error=database");
        exit;
    }

    // 3. Save to database (only if user doesn't exist)
    try {
        // Prepare SQL statement
        $stmt = $db->prepare("INSERT INTO users (pet_name, pet_type, pet_breed, owner_name, email) 
                             VALUES (:pet_name, :pet_type, :pet_breed, :owner_name, :email)");
        
        // Execute with form data
        $stmt->execute([
            ':pet_name' => $petName,
            ':pet_type' => $petType,
            ':pet_breed' => $petBreed,
            ':owner_name' => $ownerName,
            ':email' => $email
        ]);
        
    } catch (PDOException $e) {
        // Check if it's a duplicate error (in case unique constraint is violated)
        if ($e->getCode() == 23000) { // MySQL duplicate entry error code
            header("Location: index.php?error=duplicate");
        } else {
            header("Location: index.php?error=database");
        }
        exit;
    }

    // 4. Send the email notification with pet-themed content
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
        $mail->isHTML(false); // Changed to false for plain text
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
        
        // Redirect back with success message
        header("Location: index.php?success=1&petName=" . urlencode($petName) . "&email=" . urlencode($email));
        exit;

    } catch (Exception $e) {
        // Redirect back with error
        header("Location: index.php?error=mailer");
        exit;
    }
}
?>