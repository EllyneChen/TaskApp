<?php

class layouts {
    public function heading($conf) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$conf['site_name']}</title>
            <link rel='stylesheet' href='styles.css'>
        </head>
        <body>
            <div class='container'>
                <div class='paw-print-header'>
                    🐾 Welcome to {$conf['site_name']}! 🐾
                </div>";
    }
    
    public function welcome($conf) {
        echo "<div class='welcome-message'>
                <h2>Create an adorable online profile for your furry friend!</h2>
                <p>Show off your pet's personality with a custom paw-tfolio that you can share with friends and family.</p>
              </div>
              <div class='paw-prints'>
                🐕 🐈 🐠 🐇 🐢
              </div>";
              
        // Display success/error messages if they exist
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            $petName = isset($_GET['petName']) ? htmlspecialchars($_GET['petName']) : '';
            $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
            echo '<div class="success-message">';
            echo "Success! We've created $petName's paw-tfolio and sent a welcome email to $email.";
            echo '</div>';
        }
        
        if (isset($_GET['error'])) {
            $errorMessage = '';
            switch ($_GET['error']) {
                case 'email':
                    $errorMessage = "Invalid email format. Please provide a valid email address.";
                    break;
                case 'mailer':
                    $errorMessage = "Message could not be sent. Please try again later.";
                    break;
                default:
                    $errorMessage = "An error occurred. Please try again.";
            }
            echo '<div class="error-message">';
            echo $errorMessage;
            echo '</div>';
        }
    }
    
    public function footer($conf) {
        echo "</div>"; // Close container div
        
        echo "<footer class='paw-footer'>
                <div class='footer-content'>
                    Copyright &copy; " . date("Y") . " {$conf['site_name']}
                    <br>Contact us at <a href='mailto:{$conf['site_email']}'>{$conf['site_email']}</a>
                    <br>Follow us on social media: 
                    <a href='#'>🐕</a> 
                    <a href='#'>🐈</a> 
                    <a href='#'>🐠</a>
                </div>
              </footer>
            </body>
            </html>";
    }
}