<?php include_once 'profile-logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify - Profile</title>
    <link rel="stylesheet" href="./profle-style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Eventify</h1>
    </header>

    <main>
        <div class="content">
            <button name="back button"><img src="./assets/back.png" alt="back button"></button>

            <div class="profile-card">
                <div class="profile-pic-wrapper">
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile" class="profile-pic">
                    <form id="profile-pic-form" action="profile-logic.php" method="post" enctype="multipart/form-data">
                        <label for="profile-picture-input" class="change-pic-btn" style="cursor:pointer;display:inline-block;">
                             Change Profile Picture
                            <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*" style="display:none;">
                        </label>
                    </form>
                </div>
                <div class="profile-info">
                    <h2><?php echo $user['username']; ?></h2>
                    <div class="profile-email"><?php echo $user['email']; ?></div>
                    <div class="profile-joined"><img src="./assets/calander.png" alt="time">  Joined Eventify on <?php echo date('F Y', strtotime($user['created_at'])); ?></div>
                </div>
            </div>

            <div class="events-section">
                <h2 class="events-title">MY EVENTS</h2>
                <hr>
                <?php if (empty($user_events)): ?>
                    <div class="event-card">
                        <div class="event-details">
                            <div class="event-title">No events created yet.</div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($user_events as $event): ?>
                        <div class="event-card">
                            <img src="<?php echo htmlspecialchars($event['photo']); ?>" alt="Event" class="event-img">
                            <div class="event-details">
                                <div class="event-date"><?php echo date('F j, Y – g:i A', strtotime($event['event_datetime'])); ?></div>
                                <div class="event-title"><?php echo htmlspecialchars($event['event_name']); ?></div>
                                <div class="event-location"><?php echo htmlspecialchars($event['location']); ?></div>
                                <div class="event-attendees">
                                    <?php
                                    $eid = $event['id'];
                                    $attendees_result = $conn->query("SELECT COUNT(*) as cnt FROM reservations WHERE event_id = $eid");
                                    $attendees_count = 0;
                                    if ($attendees_result && $attendees_result->num_rows > 0) {
                                        $attendees_row = $attendees_result->fetch_assoc();
                                        $attendees_count = $attendees_row['cnt'];
                                    }
                                    echo $attendees_count . ' attendees joined';
                                    ?>
                                </div>
                            </div>
                            <form method="post" action="profile-logic.php" style="display:inline;">
                                <input type="hidden" name="delete_event_id" value="<?php echo $event['id']; ?>">
                                <button class="remove-btn" type="submit" onclick="return confirm('Are you sure you want to delete this event for everyone?');">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-left">
            <div class="footer-follow">Follow Us</div>
            <div class="footer-socials">
            <img src="./assets/facebook.png" alt="Facebook" />
            <img src="./assets/x.png" alt="X" />
            <img src="./assets/instagram.png" alt="Instagram" />
            <img src="./assets/youtube.png" alt="YouTube" />
            <img src="./assets/tiktok.png" alt="TikTok" />
            </div>
            <div class="footer-copyright">© 2025 <b>Eventify</b></div>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-right">
            <div class="footer-contact">
            For more information contact us on<br />
            <b>Eventifysupport@gmail.com</b>
            </div>
        </div>
    </footer>


    <script src="./profile-script.js"></script>
    <script>
    document.getElementById('profile-picture-input').addEventListener('change', function() {
        document.getElementById('profile-pic-form').submit();
    });
    </script>
</body>
</html>