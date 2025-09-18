Pet Paw-tfolio Creator - Complete Project Documentation
 Project Overview
Pet Paw-tfolio Creator is a web application that allows users to create online profiles for their pets. The application features email validation, database storage, welcome email notifications, and a numbered list of registered pets.

 File Structure
text
TaskApp/
├── index.php              # Main application entry point
├── login.php              # Login page
├── mail.php               # Email processing and database handling
├── users_list.php         # Display registered pets
├── forms.php              # Form classes and rendering
├── layouts.php            # HTML layout structure
├── conf.php               # Configuration settings
├── styles.css             # Complete styling
├── ClassAutoLoad.php      # Class autoloader
├── autoload.php           # Composer autoloader
├── composer.json          # PHP dependencies
├── composer.lock          # Locked dependency versions
└── vendor/                # PHPMailer library 

File Specifications
1. index.php
Purpose: Main entry point of the application
php
<?php
require_once 'ClassAutoLoad.php';
$layoutsInstance->heading($conf);
$layoutsInstance->welcome($conf);
$formsInstance->signup();
$layoutsInstance->footer($conf);
?>
2. conf.php
Purpose: Configuration settings for the application
php
<?php
// Site configuration
$conf['site_name'] = "Pet Paw-tfolio Creator";
$conf['site_email'] = "welcome@pawtfolio.com";
$conf['site_url'] = "http://localhost/TaskApp";

// Database constants
$conf['db_type'] = "pdo";
$conf['db_host'] = "localhost";
$conf['db_user'] = "root";
$conf['db_pass'] = "my database password";
$conf['db_name'] = "taskapp";
?>
3. forms.php
Purpose: Form rendering and handling class
Features:
•	Pet registration form with validation
•	Login form structure
•	Bootstrap-style form classes
•	Pet-themed field names
4. layouts.php
Purpose: HTML layout and structure class
Features:
•	Complete HTML5 structure
•	Responsive container layout
•	Success/error message handling
•	Pet-themed header and footer
•	Dynamic content rendering
5. mail.php
Purpose: Email processing and database operations
Key Features:
•	Email validation with FILTER_VALIDATE_EMAIL
•	Database duplicate prevention
•	PHPMailer integration for welcome emails
•	MariaDB database connection
•	Comprehensive error handling
•	 Redirect-based user feedback
6. users_list.php
Purpose: Display numbered list of registered pets
Features:
•	Numbered list in ascending order by registration date
•	Database connection and error handling
•	Responsive design integration
•	Complete pet information display
7. styles.css
Purpose: Complete styling for the application
Features:
•	Responsive design for mobile/desktop
•	Pet-themed color scheme (#6b4e3d browns, #8bc34a greens)
•	Form styling with focus states
•	Success/error message styling
•	Numbered list styling for users list
•	Paw print emojis and decorative elements
8. ClassAutoLoad.php
Purpose: Automatic class loading system
php
<?php
require_once 'conf.php';
$directory = ['Layouts', 'Forms'];
spl_autoload_register(function ($className) use ($directory) {
    foreach ($directory as $dir) {
        $filePath = __DIR__ . '/' . $dir . '/' . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});
$layoutsInstance = new layouts();
$formsInstance = new forms();
?>

 Database Schema
Database: MariaDB/MySQL
Table: users
sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    pet_name VARCHAR(100) NOT NULL,
    pet_type VARCHAR(50) NOT NULL,
    pet_breed VARCHAR(100),
    owner_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_pet_email (email, pet_name)
);

 Technologies Used
•	Frontend: HTML5, CSS3, Responsive Design
•	Backend: PHP 7.4+
•	Database: MariaDB/MySQL with PDO
•	Email: PHPMailer v6.10.0 with Gmail SMTP
•	Version Control: Git with GitHub
•	Styling: Custom CSS with pet-themed design


 Key Features Implemented
1. User Registration System
•	Pet information collection (name, type, breed, owner, email)
•	Email validation and sanitization
•	Database storage with duplicate prevention
•	Unique constraint on email+pet_name combinations
2. Email Notification System
•	Welcome emails for new registrations
•	PHPMailer with Gmail SMTP configuration
•	Plain text email formatting
•	Pet-themed email content
3. Database Management
•	MariaDB/MySQL connection with PDO
•	CRUD operations for pet data
•	Error handling and validation
•	Unique constraint enforcement
4. User Interface
•	Responsive design works on all devices
•	Pet-themed color scheme and styling
•	Success/error message system
•	Numbered list display for registered pets
5. Error Handling
•	Email validation errors
•	Database connection errors
•	Duplicate submission prevention
•	Mailer service errors

 Email System Configuration
SMTP Settings:
•	Host: smtp.gmail.com
•	Port: 587
•	Encryption: TLS
•	Authentication: Required
•	From: ellyne.omondi@strathmore.edu

  Application Flow
1.	User accesses index.php
2.	Fills out pet registration form
3.	Form submits to mail.php for processing
4.	Email validation and duplicate checking
5.	Database insertion and email sending
6.	Redirect back with success/error message
7.	User can view all pets at users_list.php

 Setup Instructions
1. Database Setup:
sql
CREATE DATABASE taskapp;
USE taskapp;
CREATE TABLE users ( ... ); # As shown above
2. Configuration:
Update conf.php with correct database credentials and email settings
3. Dependencies:
bash
composer install  # Installs PHPMailer
4. Access Application:
Navigate to http://localhost/TaskApp/



