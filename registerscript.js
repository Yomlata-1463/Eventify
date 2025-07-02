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
    location.href = "login.php";
  };
}

if (signupButton) {
  signupButton.onclick = function () {
    location.href = "signup.php";
  };
}

// Validation for Sign Up form
const signupForm = document.querySelector('form[action="login_register.php"][method="post"]');
if (signupForm) {
  signupForm.addEventListener('submit', function(e) {
    // Only run on the sign-up form (has 'register' button)
    const registerBtn = signupForm.querySelector('button[name="register"]');
    if (registerBtn) {
      let valid = true;
      let messages = [];
      const username = signupForm.querySelector('input[name="username"]');
      const email = signupForm.querySelector('input[name="email"]');
      const password = signupForm.querySelector('input[name="password"]');
      const confirm = signupForm.querySelector('input[name="confirm"]');
      if (username && username.value.trim() === '') {
        valid = false;
        messages.push('please fill username');
      }
      if (email && email.value.trim() === '') {
        valid = false;
        messages.push('please fill email');
      }
      if (password && password.value.trim() === '') {
        valid = false;
        messages.push('please fill password');
      }
      if (confirm && confirm.value.trim() === '') {
        valid = false;
        messages.push('please fill confirm password');
      }
      if (!valid) {
        e.preventDefault();
        alert(messages.join('\n'));
      }
    }
  });
}

// Validation for Login form
const loginForm = document.querySelector('form[action="login_register.php"][method="post"]');
if (loginForm) {
  loginForm.addEventListener('submit', function(e) {
    // Only run on the login form (has 'login' button)
    const loginBtn = loginForm.querySelector('button[name="login"]');
    if (loginBtn) {
      let valid = true;
      let messages = [];
      const login_id = loginForm.querySelector('input[name="login_id"]');
      const password = loginForm.querySelector('input[name="password"]');
      if (login_id && login_id.value.trim() === '') {
        valid = false;
        messages.push('please fill username or email');
      }
      if (password && password.value.trim() === '') {
        valid = false;
        messages.push('please fill password');
      }
      if (!valid) {
        e.preventDefault();
        alert(messages.join('\n'));
      }
    }
  });
}



