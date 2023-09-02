document.addEventListener("DOMContentLoaded", function() {
    const addLearnerButton = document.getElementById('addLearnerButton');
    const removeLearnerButton = document.getElementById('removeLearnerButton');
    let countLearners = 1;

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
    
    addLearnerButton.addEventListener('click', addLearner);
    removeLearnerButton.addEventListener('click', removeLearner);

});