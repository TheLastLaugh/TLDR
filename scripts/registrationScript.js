document.addEventListener("DOMContentLoaded", function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const addLearnerButton = document.getElementById('addLearnerButton');
    const removeLearnerButton = document.getElementById('removeLearnerButton');
    let countLearners = 1;

    // Gives the user an error if the passwords don't match when registering
    const checkPasswordValidity = function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    function addLearner() {
        const learnerContainer = document.getElementById("learnerContainer");
        const newInput = document.createElement("input");
        countLearners++;
        countLearners > 1 ? removeLearnerButton.style.display = "inline-block" : removeLearnerButton.style.display = "none";

        newInput.type = "text";
        newInput.name = "learners[]";
        learnerContainer.appendChild(newInput);
    }    

    function removeLearner() {
        const learnerContainer = document.getElementById("learnerContainer");
        const lastInput = learnerContainer.lastChild;
        countLearners--;
        countLearners > 1 ? removeLearnerButton.style.display = "inline-block" : removeLearnerButton.style.display = "none";
        learnerContainer.removeChild(lastInput);
    }

    password.addEventListener('change', checkPasswordValidity);
    confirmPassword.addEventListener('keyup', checkPasswordValidity);
    addLearnerButton.addEventListener('click', addLearner);
    removeLearnerButton.addEventListener('click', removeLearner);

});