<?php
require_once 'config.php';
$event = null;

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
    $result = $conn->query("SELECT events.*, users.profile_picture FROM events JOIN users ON events.user_id = users.id WHERE events.id = $event_id");
    if ($result && $result->num_rows > 0) {
        $event = $result->fetch_assoc();
    }
}

if (!$event) {
    die('Event not found.');
}

function getReservationDeadline($created_at, $deadline_days, $deadline_hours, $deadline_minutes) {
    $deadline_seconds = ($deadline_days * 24 * 60 * 60) + ($deadline_hours * 60 * 60) + ($deadline_minutes * 60);
    $created_timestamp = strtotime($created_at);
    $deadline_timestamp = $created_timestamp + $deadline_seconds;

    $now = time();
    $secondsLeft = $deadline_timestamp - $now;

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
