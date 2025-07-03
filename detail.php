<?php include_once 'detail-logic.php';

$is_reserved = false;

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $eid = $event['id'];
    $check = $conn->query("SELECT id FROM reservations WHERE user_id = $uid AND event_id = $eid");
    if ($check && $check->num_rows > 0) {
        $is_reserved = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify - Detail</title>
    <link rel="stylesheet" href="./detail-style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Eventify</h1>
        <a href="#"><img src="./assets/Group 16.png" alt="Profile Picture" class="profile-pic"></a>
    </header>

    <main>
        <div id="content-header">
            <button name="back button"><img src="./assets/back.png" alt="back button"></button>
            <div id="heading-intro">
                <h2 class="event-title"><?php echo $event['event_name']; ?></h2>
                <div id="head-image">
                    <img src="./assets/Group 16.png" alt="">
                    <div class="hosted-by">Hosted by <span><?php echo $event['organizer']; ?></span></div>
                </div>
            </div>
        </div>

        <hr>

        <div id="content">
            <div id="event-picture"><img src="<?php echo $event['photo']; ?>" alt="event Picture"></div>

            <div id="time-type">
                <div><img src="./assets/calander.png" alt="date and time"> <span><?php echo date('F j, Y – g:i A', strtotime($event['event_datetime'])); ?></span></div>
                <div><img src="./assets/type.png" alt="type"> <span><?php echo $event['event_type']; ?></span></div>
            </div>

            <div class="event-description">
                <h3>Description</h3>
                <p><?php echo $event['description']; ?></p>
            </div>

            <div class="event-info">
                <h3>Location</h3>
                <p><?php echo $event['location']; ?></p>
            </div>

            <div class="event-info">
                <h3>Available Spots</h3>
                <p><?php echo $event['available_spots']; ?> left</p>
            </div>

            <div class="event-info">
                <h3>Deadline</h3>
                <p><?php echo getReservationDeadline($event['created_at'], $event['deadline_days'], $event['deadline_hours'], $event['deadline_minutes']); ?></p>
            </div>

            <div class="event-info">
                <h3>For More Information</h3>
                <p><?php echo $event['contact_info']; ?></p>
            </div>

            <div id="reserve-btn">
                <form method="post" action="home-logic.php">
                    <input type="hidden" name="<?php echo $is_reserved ? 'unreserve_event_id' : 'reserve_event_id'; ?>" value="<?php echo $event['id']; ?>">
                    <button id="reserve-button" type="submit">
                        <?php echo $is_reserved ? 'Reserved' : 'Reserve'; ?>
                    </button>
                </form>
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


    <script src="./detail-script.js"></script>
</body>
</html>