// Navigation functionality 
const home = document.getElementById('home-nav');
const add_event = document.getElementById('addevent-nav');
const my_reservations = document.getElementById('myreservations-nav');

const mobile_home = document.getElementById('mobile-home-nav');
const mobile_addevent = document.getElementById('mobile-add-nav');
const mobile_myreservations = document.getElementById('mobile-myreservation-nav');

const my_reservations_section = document.getElementById('my-reservations-section');
const content = document.getElementById('content');
const hr = document.getElementById('my-reservations-hr');
const title = document.querySelector('h2');
const mobile_content = document.getElementById('mobile-content');
const eventClass = document.getElementById('content');
let previouslySelectedNav = home

let navLocked = false;

// Search bar functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('.search');
    const eventCards = document.querySelectorAll('.event-card');
    const mobileEventCards = document.querySelectorAll('.mobile-event-card');
    const myReservationCards = document.querySelectorAll('#my-reservations-card');

    console.log('Search inputs found:', searchInputs.length);
    console.log('Event cards found:', eventCards.length);
    console.log('Mobile event cards found:', mobileEventCards.length);
    console.log('My reservation cards found:', myReservationCards.length);

    function filterEvents(searchTerm) {
        console.log('Filtering events with term:', searchTerm);
        const term = searchTerm.toLowerCase().trim();
        
        eventCards.forEach(card => {
            const eventNameElement = card.querySelector('.event-details .event-row:first-child span:first-child');
            
            if (eventNameElement) {
                const eventName = eventNameElement.textContent.toLowerCase();
                const matches = eventName.includes(term);
                console.log('Event name:', eventName, 'Matches:', matches);
                
                card.style.display = matches ? 'block' : 'none';
            }
        });
        
        mobileEventCards.forEach(card => {
            const eventNameElement = card.querySelector('.event-name');
            
            if (eventNameElement) {
                const eventName = eventNameElement.textContent.toLowerCase();
                const matches = eventName.includes(term);
                console.log('Mobile event name:', eventName, 'Matches:', matches);
                
                card.style.display = matches ? 'block' : 'none';
            }
        });
        
        myReservationCards.forEach(card => {
            const eventNameElement = card.querySelector('#my-reservations-name');
            
            if (eventNameElement) {
                const eventName = eventNameElement.textContent.toLowerCase();
                const matches = eventName.includes(term);
                console.log('My reservation event name:', eventName, 'Matches:', matches);
                
                card.style.display = matches ? 'flex' : 'none';
            }
        });
    }

    searchInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            filterEvents(e.target.value);
        });
        
        input.addEventListener('keyup', (e) => {
            if (e.key === 'Escape') {
                input.value = '';
                filterEvents('');
            }
        });
    });
});

if (home) {
    home.onclick = function () {
        if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        my_reservations_section.style.display = 'none'
        content.style.display = 'flex'
        mobile_content.style.display = 'flex'
        hr.style.display = 'none'
        title.innerHTML = 'UPCOMING EVENTS';
        home.style.backgroundColor = '#B8CFCE';
        add_event.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        previouslySelectedNav = home;
    };
}

if (mobile_home) {
    mobile_home.onclick = function () {
        if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        my_reservations_section.style.display = 'none'
        hr.style.display = 'none'
        content.style.display = 'flex'
        mobile_content.style.display = 'flex'
        title.innerHTML = 'UPCOMING EVENTS';
        home.style.backgroundColor = '#B8CFCE';
        add_event.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';
        previouslySelectedNav = home;
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
        mobile_content.style.display = 'none'
        my_reservations_section.style.display = 'flex'
        hr.style.display = 'block'
        title.innerHTML = 'MY RESERVATIONS';
        my_reservations.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        add_event.style.backgroundColor = '#7F8CAA';
        previouslySelectedNav = my_reservations;
    };
}

if (mobile_myreservations) {
    mobile_myreservations.onclick = function () {
        if (navLocked) {
            alert("Please submit the event or close the form before navigating.");
            return;
        }
        content.style.display = 'none'
        mobile_content.style.display = 'none'
        my_reservations_section.style.display = 'flex'
        hr.style.display = 'block'
        title.innerHTML = 'MY RESERVATIONS';
        my_reservations.style.backgroundColor = '#B8CFCE';
        home.style.backgroundColor = '#7F8CAA';
        add_event.style.backgroundColor = '#7F8CAA';
        previouslySelectedNav = my_reservations;
    };
}



// Mobile menu fuctionality
const mobile_home_Btn = document.getElementById('mobile-home-nav');
const mobile_add_Btn = document.getElementById('mobile-add-nav');
const mobile_my_reservation_Btn = document.getElementById('mobile-myreservation-nav');

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







const close_add = document.getElementById('close-btn');
const add_section = document.getElementById('add-event-section')

if (close_add) {
    close_add.onclick = function () {
        add_section.style.display = 'none';
        navLocked = false;

        home.style.backgroundColor = '#7F8CAA';
        add_event.style.backgroundColor = '#7F8CAA';
        my_reservations.style.backgroundColor = '#7F8CAA';

        if (previouslySelectedNav) {
            previouslySelectedNav.style.backgroundColor = '#B8CFCE';
        }
    };
}

document.querySelectorAll('.event-card').forEach(card => {
    card.addEventListener('click', () => {
        const eventId = card.getAttribute('data-event-id');
        if (eventId) {
            window.location.href = `detail.php?id=${eventId}`;
        }
    });
});

document.querySelectorAll('.mobile-event-card').forEach(card => {
    card.addEventListener('click', function(e) {
        if (e.target.tagName === 'BUTTON' || e.target.closest('form')) return;
        const eventId = card.getAttribute('data-event-id');
        if (eventId) {
            window.location.href = `detail.php?id=${eventId}`;
        }
    });
});

