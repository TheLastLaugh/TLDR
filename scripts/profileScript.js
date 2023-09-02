document.addEventListener("DOMContentLoaded", function() {
    const editButton = document.getElementById("editButton");
    const details = document.querySelectorAll(".detail");
    const editFields = document.querySelectorAll(".edit-field");

    // if the user wants to edit their profile, switch the display of the details and edit fields
    editButton.addEventListener("click", function() {
        details.forEach(detail => {
            detail.style.display = detail.style.display === "none" ? "block" : "none";
        });
        editFields.forEach(field => {
            field.style.display = field.style.display === "none" ? "block" : "none";
        });
        
        // Change button text
        editButton.textContent = editButton.textContent === "Edit Profile" ? "Cancel Editing" : "Edit Profile";
    });
});
