<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$result = $conn->query("SELECT * FROM users WHERE username = '$username'");

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

$user_events = [];
if (isset($user['id'])) {
    $uid = $user['id'];
    $result = $conn->query("SELECT * FROM events WHERE user_id = $uid ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()) {
        $user_events[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $user_id = $user['id'];

    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $original_name = basename($_FILES['profile_picture']['name']);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            die('Invalid file type.');
        }

        $filename = 'assets/uploads/profile_' . uniqid() . '.' . $ext;
        if (!move_uploaded_file($tmp_name, $filename)) {
            die('Failed to move uploaded file.');
        }

        $conn->query("UPDATE users SET profile_picture = '$filename' WHERE id = $user_id");

        header("Location: profile.php");
        exit();
    } else {
        die('File upload error.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event_id'])) {
    $event_id = intval($_POST['delete_event_id']);
    //Optionally, only allow the owner to delete
    $username = $_SESSION['username'];
    $user_result = $conn->query("SELECT id FROM users WHERE username = '$username'");
    $user = $user_result->fetch_assoc();
    $user_id = $user['id'];
    //Only allow if the event belongs to the user
    $event_check = $conn->query("SELECT id FROM events WHERE id = $event_id AND user_id = $user_id");
    if ($event_check && $event_check->num_rows > 0) {
        //Delete reservations for this event
        $conn->query("DELETE FROM reservations WHERE event_id = $event_id");
        //Delete the event itself
        $conn->query("DELETE FROM events WHERE id = $event_id");
    }
    header("Location: profile.php");
    exit();
}
