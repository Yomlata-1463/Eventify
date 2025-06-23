// Navigation functionality 
const home = document.getElementById('home-nav');
const add_event = document.getElementById('addevent-nav');
const my_reservations = document.getElementById('myreservations-nav');
const logout = document.getElementById('logout-nav');

if (home) {
    home.onclick = function () {
        home.style.backgroundColor = '#B8CFCE';
        add_event.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        logout.style.backgroundColor = '#7F8CAA';
    };
}

if (add_event) {
    add_event.onclick = function () {
        add_event.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        logout.style.backgroundColor = '#7F8CAA';
    };
}

if (my_reservations) {
    my_reservations.onclick = function () {
        my_reservations.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        add_event.style.backgroundColor = '#7F8CAA';
        logout.style.backgroundColor = '#7F8CAA';
    };
}

if (logout) {
    logout.onclick = function () {
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


