function toggleModules(unitId) {
    const moduleDiv = document.getElementById('modules-' + unitId);
    if (moduleDiv.style.display === "none") {
        moduleDiv.style.display = "block";
    } else {
        moduleDiv.style.display = "none";
    }
}    
