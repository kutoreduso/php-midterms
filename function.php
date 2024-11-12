<?php
function getUsers() {
    return [
        ["email" => "user1@example.com", "password" => "user1"],
        ["email" => "user2@example.com", "password" => "user2"],
        ["email" => "user3@example.com", "password" => "user3"],
        ["email" => "user4@example.com", "password" => "user4"],
        ["email" => "user5@example.com", "password" => "user5"]
    ];
}

function validateLoginCredentials($email, $password) {
    $errors = [];
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email.";
    } else {
        $users = getUsers();
        $emailExists = false;
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $emailExists = true;
                break;
            }
        }
        if (!$emailExists) {
            $errors[] = "Invalid Email.";
        }
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    return $errors;
}

function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true;
        }
    }
    return false;
}

function checkUserSessionIsActive() {
    if (isset($_SESSION['email']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
        header("Location: dashboard.php");
        exit;
    }
}
function guard() {
    if (empty($_SESSION['email']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
        
        header("Location: index.php"); 
        exit;
    }
}
function displayErrors($errors) {

    $output = "<ul>";
    foreach ($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error) . "</li>";
    }
    $output .= "</ul>";
    return $output;
}
?>
