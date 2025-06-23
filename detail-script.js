const backButton = document.querySelector('button[name="back button"]');
const reserveButton = document.getElementById('reserve-button');

if (backButton) {
    backButton.onclick = function () {
        history.back();
  };
}

if (reserveButton) {
    reserveButton.onclick = function () {
        if (reserveButton.textContent === 'Reserve') {
            reserveButton.textContent = 'Reserved';
            reserveButton.style.backgroundColor = "#B8CFCE";
            reserveButton.style.color = "#7F8CAA";
        } else {
            reserveButton.textContent = 'Reserve';
            reserveButton.style.backgroundColor = "#7F8CAA";
            reserveButton.style.color = "#B8CFCE";
        }
    };
}