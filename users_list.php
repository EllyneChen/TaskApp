<?php
require_once 'ClassAutoLoad.php';
require_once 'conf.php';

class UsersList {
    public function displayUsers($conf) {
        try {
            // Create database connection
            $dsn = "mysql:host={$conf['db_host']};dbname={$conf['db_name']};charset=utf8";
            $db = new PDO($dsn, $conf['db_user'], $conf['db_pass']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Fetch users from database ordered by creation date (ascending)
            $stmt = $db->query("SELECT * FROM users ORDER BY created_at ASC");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($users) > 0) {
                echo "<div class='container'>";
                echo "<h2>Registered Pets</h2>";
                echo "<ol class='users-list'>";
                
                $count = 1;
                foreach ($users as $user) {
                    echo "<li>";
                    echo "<strong>Pet Name:</strong> " . htmlspecialchars($user['pet_name']) . "<br>";
                    echo "<strong>Type:</strong> " . htmlspecialchars($user['pet_type']) . "<br>";
                    if (!empty($user['pet_breed'])) {
                        echo "<strong>Breed:</strong> " . htmlspecialchars($user['pet_breed']) . "<br>";
                    }
                    echo "<strong>Owner:</strong> " . htmlspecialchars($user['owner_name']) . "<br>";
                    echo "<strong>Email:</strong> " . htmlspecialchars($user['email']) . "<br>";
                    echo "<strong>Registered:</strong> " . $user['created_at'];
                    echo "</li>";
                    $count++;
                }
                
                echo "</ol>";
                echo "</div>";
            } else {
                echo "<div class='container'>";
                echo "<p>No pets registered yet.</p>";
                echo "</div>";
            }
            
        } catch (PDOException $e) {
            echo "<div class='container'>";
            echo "<p class='error-message'>Error retrieving data: " . $e->getMessage() . "</p>";
            echo "</div>";
        }
    }
}

// Display the page
$layoutsInstance = new layouts();
$usersListInstance = new UsersList();

$layoutsInstance->heading($conf);
$usersListInstance->displayUsers($conf);
$layoutsInstance->footer($conf);
?>