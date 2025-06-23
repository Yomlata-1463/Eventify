// Navigation functionality 
const home = document.getElementById('home-nav');
const add_event = document.getElementById('addevent-nav');
const my_reservations = document.getElementById('myreservations-nav');
const logout = document.getElementById('logout-nav');
const mobile_home = document.getElementById('mobile-home-nav');
const mobile_addevent = document.getElementById('mobile-add-nav');
const mobile_myreservations = document.getElementById('mobile-myreservation-nav');
const mobile_logout = document.getElementById('mobile-logout-nav');
const my_reservations_section = document.getElementById('my-reservations-section');
const content = document.getElementById('content');
const hr = document.getElementById('my-reservations-hr');
const title = document.querySelector('h2');

let navLocked = false;

if (home) {
    home.onclick = function () {
         if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        my_reservations_section.style.display = 'none'
        content.style.display = 'flex'
        hr.style.display = 'none'
        title.innerHTML = 'UPCOMING EVENTS';
        home.style.backgroundColor = '#B8CFCE';
        add_event.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
    };
}

if (mobile_home) {
    mobile_home.onclick = function () {
         if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
    };
}

if (add_event) {
    add_event.onclick = function () {
        add_section.style.display = 'block';
        add_event.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        navLocked = true;
    };
}

if (mobile_addevent) {
    mobile_addevent.onclick = function () {
        add_section.style.display = 'block';
        add_event.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        navLocked = true;
    };
}

if (my_reservations) {
    my_reservations.onclick = function () {
         if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        content.style.display = 'none'
        my_reservations_section.style.display = 'flex'
        hr.style.display = 'block'
        title.innerHTML = 'MY RESERVATIONS';
        my_reservations.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        add_event.style.backgroundColor = '#7F8CAA';
    };
}

if (logout) {
    logout.onclick = function () {
        if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        if (confirm("Are you sure you want to logout?")) {
            location.href = "login.html";
        } else {
            history.back();
        }
    };
}

if (mobile_logout) {
    mobile_logout.onclick = function () {
        if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        if (confirm("Are you sure you want to logout?")) {
            location.href = "login.html";
        } else {
            history.back();
        }
    };
}

// Sort dropdown functionality
const sortDropdown = document.querySelector('.sort-dropdown-container');
const sortBtn = document.getElementById('sort-btn');
const sortOptions = document.getElementById('sort-options');

if (sortBtn && sortDropdown && sortOptions) {
    sortBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sortDropdown.classList.toggle('active');
    });

    sortOptions.addEventListener('click', function(e) {
        if (e.target.tagName === 'LI') {
            sortBtn.innerHTML = e.target.textContent + ' <img src="./assets/dropdown.png" alt="dropdown icon" class="dropdown-icon">';
            sortDropdown.classList.remove('active');
        }
    });

    document.addEventListener('click', function(e) {
        if (!sortDropdown.contains(e.target)) {
            sortDropdown.classList.remove('active');
        }
    });
}

// Mobile menu fuctionality
const mobile_home_Btn = document.getElementById('mobile-home-nav');
const mobile_add_Btn = document.getElementById('mobile-add-nav');
const mobile_my_reservation_Btn = document.getElementById('mobile-myreservation-nav');
const mobile_logout_Btn = document.getElementById('mobile-logout-nav');

const minimized = document.getElementById('menu-icon');
const expanded = document.getElementById('menu-icon-clicked');
if (minimized && expanded) {
    minimized.onclick = function() {
        minimized.style.display = 'none';
        expanded.style.display = 'flex';
    }

    window.onscroll = function() {
        minimized.style.display = 'flex';
        expanded.style.display = 'none';
    }
}

if (mobile_home_Btn) {
    mobile_home_Btn.onclick = function () {
        location.href = "home.html"
    }
}

if (mobile_logout_Btn) {
    mobile_logout_Btn.onclick = function () {
        location.href = "login.html"
    }
}



const close_add = document.getElementById('close-btn');
const add_section = document.getElementById('add-event-section')

if (close_add) {
    close_add.onclick = function () {
        add_section.style.display = 'none';
        home.style.backgroundColor = '#B8CFCE';
        add_event.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        navLocked = false;
    };
}

