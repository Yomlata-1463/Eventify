const backButton = document.querySelector('button[name="back button"]');

if (backButton) {
    backButton.onclick = function () {
        history.back();
  };
}