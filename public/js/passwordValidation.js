function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var confirmPasswordInput = document.getElementById("password_confirmation");
  var showPasswordCheckbox = document.getElementById("showPassword");

  if (showPasswordCheckbox.checked) {
    passwordInput.type = "text";
    confirmPasswordInput.type = "text";
  } else {
    passwordInput.type = "password";
    confirmPasswordInput.type = "password";
  }
}

function validatePasswords() {
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("password_confirmation").value;
  var passwordError = document.getElementById("passwordError");

  if (password !== confirmPassword) {
    passwordError.style.display = "block";
    return false; // Prevent form submission
  } else {
    passwordError.style.display = "none";
  }

  // If passwords match, the form will be submitted
  return true;
}
