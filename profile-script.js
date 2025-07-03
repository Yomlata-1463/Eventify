const backButton = document.querySelector('button[name="back button"]');

if (backButton) {
    backButton.onclick = function () {
        history.back();
  };
}

document.querySelector('.change-pic-btn').addEventListener('click', function() {
  document.getElementById('profile-pic-form').style.display = 'block';
  document.getElementById('profile-picture-input').click();
});

document.getElementById('profile-picture-input').addEventListener('change', function() {
  document.getElementById('profile-pic-form').submit();
});