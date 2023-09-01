document.addEventListener("DOMContentLoaded", function() {
    const editButton = document.getElementById("editButton");
    const details = document.querySelectorAll(".detail");
    const editFields = document.querySelectorAll(".edit-field");

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
