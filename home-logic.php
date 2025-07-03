<?php

require_once 'config.php';


if (isset($_POST['sort-control'])) {
    $_SESSION['sort_option'] = $_POST['sort-control'];
}

if (isset($_SESSION['sort_option'])) {
    switch ($_SESSION['sort_option']) {
        case 'oldest':
            $sort_option = "events.created_at ASC";
            break;
        case 'az':
            $sort_option = "events.event_name ASC";
            break;
        case 'za':
            $sort_option = "events.event_name DESC";
            break;
        case 'spots-desc':
            $sort_option = "events.available_spots DESC";
            break;
        case 'spots-asc':
            $sort_option = "events.available_spots ASC";
            break;
        default:
            $sort_option = "events.created_at DESC";
    }
} else {
    $sort_option = "events.created_at DESC";
}

$sql = "SELECT events.*, users.profile_picture 
        FROM events 
        JOIN users ON events.user_id = users.id 
        ORDER BY $sort_option";
$events = $conn->query($sql);

function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60)
        return $diff . ' seconds ago';
    $diff = round($diff / 60);
    if ($diff < 60)
        return $diff . ' minutes ago';
    $diff = round($diff / 60);
    if ($diff < 24)
        return $diff . ' hours ago';
    $diff = round($diff / 24);
    if ($diff < 7)
        return $diff . ' days ago';
    $diff = round($diff / 7);
    if ($diff < 4)
        return $diff . ' weeks ago';
    return date('M d, Y', $timestamp);
}

function getReservationDeadline($deadline_days, $deadline_hours, $deadline_minutes) {
    $secondsLeft =
        ($deadline_days * 24 * 60 * 60) +
        ($deadline_hours * 60 * 60) +
        ($deadline_minutes * 60);

    if ($secondsLeft <= 0) {
        return false;
    }


    $days = floor($secondsLeft / (24 * 60 * 60));
    $hours = floor(($secondsLeft % (24 * 60 * 60)) / (60 * 60));
    $minutes = floor(($secondsLeft % (60 * 60)) / 60);

    if ($days > 0) {
        return "$days days left";
    } elseif ($hours > 0) {
        return "$hours hours left";
    } else {
        return "$minutes minutes left";
    }
}



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_name'])) {
    require_once 'config.php';

    
    if (!isset($_SESSION['username'])) {
        die('You must be logged in to create an event.');
    }


    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        $username = $conn->real_escape_string($_SESSION['username']);
        $user_result = $conn->query("SELECT id FROM users WHERE username = '$username'");
        if ($user_result && $user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $user_id = $user['id'];
            $_SESSION['user_id'] = $user_id;
        } else {
            die('User not found.');
        }
    }

    $event_name = trim($_POST['event_name'] ?? '');
    $organizer = trim($_POST['organizer'] ?? '') ?: $_SESSION['username'];
    $location = trim($_POST['location'] ?? '');
    $event_datetime = trim($_POST['event_datetime'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $available_spots = isset($_POST['available_spots']) ? intval($_POST['available_spots']) : 0;
    $contact_info = trim($_POST['contact_info'] ?? '');
    $event_type = trim($_POST['event_type'] ?? '');
    $deadline_days = isset($_POST['deadline_days']) ? intval($_POST['deadline_days']) : 0;
    $deadline_hours = isset($_POST['deadline_hours']) ? intval($_POST['deadline_hours']) : 0;
    $deadline_minutes = isset($_POST['deadline_minutes']) ? intval($_POST['deadline_minutes']) : 0;

    $errors = [];
    if ($event_name === '') $errors[] = 'Event name is required.';
    if ($location === '') $errors[] = 'Location is required.';
    if ($event_datetime === '') $errors[] = 'Date/time is required.';
    if ($available_spots <= 0) $errors[] = 'Available spots must be greater than 0.';
    if ($contact_info === '') $errors[] = 'Contact info is required.';
    if ($event_type === '') $errors[] = 'Event type is required.';
    if ($deadline_days === 0 && $deadline_hours === 0 && $deadline_minutes === 0) $errors[] = 'At least one deadline value is required.';
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) $errors[] = 'Photo upload is required.';
    if (strlen($description) > 600) $errors[] = 'Description must be 600 characters or less.';
    
    if (!empty($errors)) {
        $_SESSION['event_errors'] = $errors;
        header('Location: home.php');
        exit();
    }

    
    $photo_path = '';
    $targetDir = "assets/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $originalName = basename($_FILES["photo"]["name"]);
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowed_exts)) {
        die('Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.');
    }
    $uniqueName = uniqid('event_', true) . '.' . $extension;
    $targetFile = $targetDir . $uniqueName;
    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        die('Error uploading file.');
    }
    $photo_path = $conn->real_escape_string($targetFile);

    
    $event_name = $conn->real_escape_string($event_name);
    $organizer = $conn->real_escape_string($organizer);
    $location = $conn->real_escape_string($location);
    $event_datetime = $conn->real_escape_string($event_datetime);
    $description = $conn->real_escape_string($description);
    $contact_info = $conn->real_escape_string($contact_info);
    $event_type = $conn->real_escape_string($event_type);

    $sql = "INSERT INTO events (user_id, event_name, organizer, location, event_datetime, description, available_spots, contact_info, event_type, deadline_days, deadline_hours, deadline_minutes, photo)
            VALUES ($user_id, '$event_name', '$organizer', '$location', '$event_datetime', '$description', $available_spots, '$contact_info', '$event_type', $deadline_days, $deadline_hours, $deadline_minutes, '$photo_path')";
    if ($conn->query($sql)) {
        header("Location: home.php");
        exit();
    } else {
        echo '<div style="color:red;">Database error: ' . htmlspecialchars($conn->error) . '</div>';
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserve_event_id'])) {
    require_once 'config.php';
    if (!isset($_SESSION['username'])) {
        die('You must be logged in to reserve an event.');
    }
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        $username = $conn->real_escape_string($_SESSION['username']);
        $user_result = $conn->query("SELECT id FROM users WHERE username = '$username'");
        if ($user_result && $user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $user_id = $user['id'];
            $_SESSION['user_id'] = $user_id;
        } else {
            die('User not found.');
        }
    }
    $event_id = intval($_POST['reserve_event_id']);

    $check = $conn->query("SELECT id FROM reservations WHERE user_id = $user_id AND event_id = $event_id");
    if ($check && $check->num_rows === 0) {
        $conn->query("INSERT INTO reservations (user_id, event_id, reserved_at) VALUES ($user_id, $event_id, NOW())");

        $conn->query("UPDATE events SET available_spots = available_spots - 1 WHERE id = $event_id AND available_spots > 0");
    }
    header('Location: home.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unreserve_event_id'])) {
    require_once 'config.php';
    if (!isset($_SESSION['username'])) {
        die('You must be logged in to unreserve an event.');
    }
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        $username = $conn->real_escape_string($_SESSION['username']);
        $user_result = $conn->query("SELECT id FROM users WHERE username = '$username'");
        if ($user_result && $user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $user_id = $user['id'];
            $_SESSION['user_id'] = $user_id;
        } else {
            die('User not found.');
        }
    }
    $event_id = intval($_POST['unreserve_event_id']);
    $conn->query("DELETE FROM reservations WHERE user_id = $user_id AND event_id = $event_id");
    header('Location: home.php');
    exit();
}

?>