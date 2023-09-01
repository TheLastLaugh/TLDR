document.addEventListener("DOMContentLoaded", function() {
    const goBackButton = document.getElementById('go_back');

    function goBack() {
        history.back(); // This will take the user back to the previous page (registration page)
    }

    goBackButton.addEventListener('click', goBack);
});