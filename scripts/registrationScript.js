document.addEventListener("DOMContentLoaded", function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    const checkPasswordValidity = function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    password.addEventListener('change', checkPasswordValidity);
    confirmPassword.addEventListener('keyup', checkPasswordValidity);
});