// Password toggle for main password field
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

if (togglePassword && password) {
  togglePassword.addEventListener('click', () => {
    const isPassword = password.type === 'password';
    password.type = isPassword ? 'text' : 'password';
    togglePassword.src = isPassword ? './assets/icons8-eye-24 1.png' : './assets/icons8-closed-eye-24.png';
  });
}

// Password toggle for confirm password field
const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
const confirmPassword = document.getElementById('confirmPassword');

if (toggleConfirmPassword && confirmPassword) {
  toggleConfirmPassword.addEventListener('click', () => {
    const isPassword = confirmPassword.type === 'password';
    confirmPassword.type = isPassword ? 'text' : 'password';
    toggleConfirmPassword.src = isPassword ? './assets/icons8-eye-24 1.png' : './assets/icons8-closed-eye-24.png';
  });
}

// Redirection to the login and sign up page
const loginButton = document.getElementById('login-button');
const signupButton = document.getElementById('sign-up-button');

if (loginButton) {
  loginButton.onclick = function () {
    location.href = "login.html";
  };
}

if (signupButton) {
  signupButton.onclick = function () {
    location.href = "signup.html";
  };
}

// Redirection to the home page

const login_Button = document.querySelector('button[name="login button"]');
const formInputs = document.querySelectorAll('.formInput');

if (login_Button) {
    login_Button.onclick = function () {
        const usernameOrEmail = formInputs[0].value.trim();
        const password = formInputs[1].value.trim();

        if (usernameOrEmail && password) {
            // Redirect to home page
            window.location.href = 'home.html';
        } else {
            alert('Please fill in both fields.');
        }
    };
}

