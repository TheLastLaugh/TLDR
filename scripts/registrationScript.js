document.addEventListener("DOMContentLoaded", function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    // Checks if the password is valid
    const isValidPassword = function(password) {
        // Regular expression for a strong password
        // I stole this from https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/; 
        // cmon like i'm ever gonna figure that regex out 
        
        return regex.test(password);
    }

    // Gives the user an error if the passwords don't match when registering, or if the password is not strong enough
    const checkPasswordValidity = function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        }else if (!isValidPassword(password.value)) {
            password.setCustomValidity('Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
        } 
        else {
            confirmPassword.setCustomValidity('');
            password.setCustomValidity('');
        }
    }    

    password.addEventListener('change', checkPasswordValidity);
    confirmPassword.addEventListener('keyup', checkPasswordValidity);

});