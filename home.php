<?php
date_default_timezone_set('Africa/Addis_Ababa');

require_once 'config.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$user_id = null;
$user_result = $conn->query("SELECT id FROM users WHERE username = '$username'");
if ($user_result && $user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $user_id = $user['id'];
}

include_once 'home-logic.php';

$all_events = [];
while ($row = mysqli_fetch_assoc($events)) {
    $all_events[] = $row;
}


$reserved_event_ids = [];
$my_reservations = [];
if (isset(
    $_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT event_id FROM reservations WHERE user_id = $user_id");
    while ($row = $result->fetch_assoc()) {
        $reserved_event_ids[] = $row['event_id'];
    }
    
    if (!empty($reserved_event_ids)) {
        $ids = implode(',', $reserved_event_ids);
        $res = $conn->query("SELECT events.*, users.profile_picture FROM events JOIN users ON events.user_id = users.id WHERE events.id IN ($ids)");
        while ($row = $res->fetch_assoc()) {
            $my_reservations[] = $row;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sort-control'])) {
    $_SESSION['sort_option'] = $_POST['sort-control'];
    header("Location: home.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify</title>
    <link rel="stylesheet" href="home-style.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Eventify</h1>
        <div class="search-container">
            <img src="./assets/icons8-search-48 1.png" alt="Search Icon" class="search-icon">
            <input type="text" class="search" placeholder="Search Events">
        </div>
        <a href="./profile.php"><img src="./assets/Group 16.png" alt="Profile Picture" class="profile-pic"></a>
    </header>
    <header id="mobile-header">
        <div id="upper-header">
            <h1>Eventify</h1>
            <a href="./profile.html"><img src="./assets/Group 16.png" alt="Profile Picture" class="profile-pic"></a>
        </div>
        
        <div class="search-container" id="mobile-search-container">
            <img src="./assets/icons8-search-48 1.png" alt="Search Icon" class="search-icon">
            <input type="text" class="search" placeholder="Search Events">
        </div>
        <div id="menu-icon">
            <img src="./assets/menu.png" alt="Menu Icon">
        </div>
        <div id="menu-icon-clicked">
            <div id="mobile-home-nav">
                <img src="./assets/home-icon.png" alt="Home Icon">
            </div>
            <div id="mobile-add-nav">
                <img src="./assets/add-icon.png" alt="Add event">
            </div>
            <div id="mobile-myreservation-nav">
                <img src="./assets/icons8-ticket-48 1.png" alt="my Reservations icon">
            </div>
            <div id="mobile-logout-nav">
                <img src="./assets/logout-icon.png" alt="Logout icon">
            </div>
        </div>

    </header>
    <h2>UPCOMING EVENTS</h2>
    <div id="content-header">
        <hr id="content-line">
        <h3>Sort by:</h3>
        <form action="" method="post">
            <div class="sort-dropdown-container">
                <select name="sort-control" id="sort-control" onchange="this.form.submit()">
                    <option value="recent" <?php if (isset($_SESSION['sort_option']) && $_SESSION['sort_option'] == 'recent'){echo "selected";} ?>>Recent</option>
                    <option value="oldest" <?php if (isset($_SESSION['sort_option']) && $_SESSION['sort_option'] == 'oldest'){echo "selected";} ?>>Oldest</option>
                    <option value="az" <?php if (isset($_SESSION['sort_option']) && $_SESSION['sort_option'] == 'az'){echo "selected";} ?>>A-Z</option>
                    <option value="za" <?php if (isset($_SESSION['sort_option']) && $_SESSION['sort_option'] == 'za'){echo "selected";} ?>>Z-A</option>
                    <option value="spots-desc" <?php if (isset($_SESSION['sort_option']) && $_SESSION['sort_option'] == 'spots-desc'){echo "selected";} ?>>Available spots (most - least)</option>
                    <option value="spots-asc" <?php if (isset($_SESSION['sort_option']) && $_SESSION['sort_option'] == 'spots-asc'){echo "selected";} ?>>Available spots (least to most)</option>
                </select>
                
            </div>
        </form>
    </div>
    <?php if (isset($_SESSION['event_errors']) && !empty($_SESSION['event_errors'])): ?>
        <div id="event-error-message" class="error-message">
            <b>Error(s):</b>
            <ul>
                <?php foreach ($_SESSION['event_errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <script>
            setTimeout(function() {
                var msg = document.getElementById('event-error-message');
                if (msg) msg.style.display = 'none';
            }, 8000); // 8 seconds
        </script>
        <?php unset($_SESSION['event_errors']); ?>
    <?php endif; ?>
    
    <main>
        <nav class="navigation">
            <div class="nav-items" id="home-nav">
                <img src="./assets/home-icon.png" alt="home icon">
                <a href="#">Home</a>
            </div>
            <div class="nav-items" id="addevent-nav">
                <img src="./assets/add-icon.png" alt="add event icon">
                <a href="#">Add Event</a>
            </div>
            <div class="nav-items" id="myreservations-nav">
                <img src="./assets/icons8-ticket-48 1.png" alt="my Reservations icon">
                <a href="#">My Reservations</a>                
            </div>
            <br><br><br>
            <hr id="line">
            <br><br><br>
            <div class="nav-items" id="logout-nav">
                <img src="./assets/logout-icon.png" alt="Logout icon">
                <a href="logout.php">Logout</a>                
            </div>
            
        </nav>
        <section id="content">

            <?php

            foreach ($all_events as $row)
            {
                if ($row['available_spots'] == 0) {
                    continue;
                }
                if ($row['user_id'] == $user_id) {
                    continue;
                }
                if (in_array($row['id'], $reserved_event_ids)) {
                    continue;
                }
                $deadlineText = getReservationDeadline($row['created_at'], $row['deadline_days'], $row['deadline_hours'], $row['deadline_minutes']);
                if ($deadlineText === false) {
                    continue;
                }
            ?>
            
            <div class="event-card" data-event-id="<?php echo $row['id']; ?>">
                <div class="event-card-header">
                    <img src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture" class="event-avatar">
                    <div class="event-user-info">
                        <div class="event-user"><?php echo $row['organizer']; ?></div>
                        <div class="event-time"><?php echo timeAgo($row['created_at']); ?></div>
                    </div>
                    <div class="event-details">
                        <div class="event-row">
                            <span><strong>Event name:</strong> <?php echo $row['event_name']; ?></span>
                            <span><strong>Date:</strong>
                                <?php echo date('F j, Y – g:i A', strtotime($row['event_datetime'])); ?>
                            </span>
                        </div>
                        <div class="event-row">
                            <span><strong>Location:</strong> <?php echo $row['location']; ?></span>
                            <span><strong>Available spots:</strong><?php echo $row['available_spots']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="event-card-image">
                    <img src="<?php echo $row['photo']; ?>" alt="Event Photo">
                </div>
                <div class="event-card-footer">
                    <div><strong>Deadline:</strong> <span class="event-deadline"><?php echo getReservationDeadline($row['created_at'], $row['deadline_days'], $row['deadline_hours'], $row['deadline_minutes']); ?></span></div>
                    <div><strong>Event Type:</strong> <span class="event-type"><?php echo $row['event_type']; ?></span></div>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="reserve_event_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="event-add-btn">+</button>
                    </form>
                </div>
            </div>

            <?php
            }

            ?>


            
        </section>
        <section id="mobile-content">
            <?php
            foreach ($all_events as $row)
            {
                if ($row['available_spots'] == 0) {
                    continue;
                }
                if ($row['user_id'] == $user_id) {
                    continue;
                }
                if (in_array($row['id'], $reserved_event_ids)) {
                    continue;
                }
                $deadlineText = getReservationDeadline($row['created_at'], $row['deadline_days'], $row['deadline_hours'], $row['deadline_minutes']);
                if ($deadlineText === false) {
                    continue;
                }
            ?>
            <div class="mobile-event-card" data-event-id="<?php echo $row['id']; ?>">
                <div class="mobile-event-card-header">
                    <img src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture" class="event-avatar">
                    <div class="mobile-event-user-info">
                        <div class="event-user"><?php echo $row['organizer']; ?></div>
                        <div class="event-time"><?php echo timeAgo($row['created_at']); ?></div>
                    </div>
                </div>
                <div class="mobile-event-details">
                    <div class="mobile-event-row">                    
                        <div class="event-name"><?php echo $row['event_name']; ?></div>                         
                        <div class="event-item">
                            <img src="./assets/location.png" alt="location"> 
                            <div><?php echo $row['location']; ?></div> 
                        </div>
                        <div class="event-item">
                            <img src="./assets/calander.png" alt="date and time"> 
                            <div><?php echo date('F j, Y – g:i A', strtotime($row['event_datetime'])); ?></div>  
                        </div>
                    </div>
                    <div class="mobile-event-card-image">
                        <img src="<?php echo $row['photo']; ?>" alt="Event Photo">
                    </div>
                </div>
                <div class="mobile-event-card-footer">
                    <div class="event-item">
                        <img src="./assets/circle.png" alt="Available spots">
                        <div><?php echo $row['available_spots']; ?></div> 
                    </div>
                    <div class="event-item">
                        <img src="./assets/time.png" alt="deadline">
                        <div><?php echo getReservationDeadline($row['created_at'], $row['deadline_days'], $row['deadline_hours'], $row['deadline_minutes']); ?></div>
                    </div>
                    <div class="event-item">
                        <img src="./assets/type.png" alt="type"> 
                        <div><?php echo $row['event_type']; ?></div>
                    </div>
                </div> 
                <form method="post" style="display:inline;">
                    <input type="hidden" name="reserve_event_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="close-btn">+</button>
                </form>
            </div>
            <?php
            }

            ?>
            
        </section>
        <section id="add-event-section">
            <div class="add-event-container">
                <h2>ADD YOUR EVENT</h2>
                <button id="close-btn">&times;</button>
                <form action="home-logic.php" method="post" enctype="multipart/form-data">
                    <div class="form-row" id="form-event-name">
                        <label>Event Name:</label>
                        <input type="text" name="event_name" /><span class="required">*</span>
                    </div>
                    <div class="form-row" id="form-organizer">
                        <label>Organizer:</label>
                        <input type="text" name="organizer" placeholder="If left blank, your username will be used" />
                    </div>
                    <div class="form-row" id="form-location">
                        <label>Location:</label>
                        <input type="text" name="location" /><span class="required">*</span>
                    </div>
                    <div class="form-row" id="form-datetime">
                        <label>Date/time:</label>
                        <input type="datetime-local" name="event_datetime" /><span class="required">*</span>
                    </div>
                    <div class="form-row" id="form-description">
                        <label>Description:</label>
                        <textarea rows="10" name="description"></textarea><div id="description-req"><span class="required">* max 600 characters</span></div>
                    </div>
                    <div class="form-row" id="form-available">
                        <label>Available Spots:</label>
                        <input type="number" name="available_spots" /><span class="required">*</span>
                    </div>
                    <div class="form-row" id="form-contact-info">
                        <label>Contact Info:</label>
                        <input type="tel" name="contact_info" /><span class="required">*</span>
                    </div>
                    <div class="form-row" id="form-event-type">
                        <label>Event Type:</label>
                        <select name="event_type">
                            <option>Meetup</option>
                            <option>Conference</option>
                            <option>Workshop</option>
                        </select>   
                    </div>
                    <div class="form-row" id="form-deadline">
                        <label>Deadline:</label>
                        <input type="number" min="0" max="31" name="deadline_days" placeholder="DD" />
                        <span>:</span>
                        <input type="number" min="0" max="23" name="deadline_hours" placeholder="HH" />
                        <span>:</span>
                        <input type="number" min="0" max="59" name="deadline_minutes" placeholder="MM" /><span class="required">*</span>
                    </div>
                    <div class="form-row" id="form-upload">
                        <label>Upload Photo:</label>
                        <input type="file" name="photo" required />
                        <span class="required">*</span>
                    </div>
                    <button type="submit" class="submit-btn">Create Event</button>   
                </form>
            </div>
        </section>

        <section id="my-reservations-section">
            <?php
            foreach ($my_reservations as $row) {
            ?>
            <div id="my-reservations-card">
                <div id="my-reservations-image">
                    <img src="<?php echo $row['photo']; ?>" alt="Event Picture">
                </div>
                <div id="my-reservations-details">
                    <div id="my-reservations-date"><?php echo date('F j, Y – g:i A', strtotime($row['event_datetime'])); ?></div>
                    <div id="my-reservations-name"><?php echo $row['event_name']; ?></div>
                    <div id="my-reservations-location"><?php echo $row['location']; ?></div>
                    <div id="my-reservations-attendees">
                        <?php
                            $attendees_count = 0;
                            $event_id = $row['id'];
                            $attendees_result = $conn->query("SELECT COUNT(*) as cnt FROM reservations WHERE event_id = $event_id");
                            if ($attendees_result && $attendees_result->num_rows > 0) {
                                $attendees_row = $attendees_result->fetch_assoc();
                                $attendees_count = $attendees_row['cnt'];
                            }
                            echo $attendees_count;
                        ?> attendees joined
                    </div>
                </div>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="unreserve_event_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" id="close-btn">&times;</button>
                </form>
            </div>
            <?php
            }
            ?>
        </section>
        <hr id="my-reservations-hr">
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

    <script src="./home-script.js?v=<?php echo time(); ?>"></script>
    
</body>
</html>