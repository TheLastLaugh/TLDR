function toggleModules(unitId) {
    const moduleDiv = document.getElementById('modules-' + unitId);
    if (moduleDiv.style.display === "none") {
        moduleDiv.style.display = "block";
    } else {
        moduleDiv.style.display = "none";
    }
}

function toggleDescriptions(moduleNumber, taskNumber) {
    const descriptionDiv = document.getElementById('descriptions-' + moduleNumber + '-' + taskNumber);
    if (descriptionDiv.style.display === "none") {
        descriptionDiv.style.display = "block";
    } else {
        descriptionDiv.style.display = "none";
    }
}

function toggleSubModules(moduleNumber) {
    const submoduleDiv = document.getElementById('submodules-' + moduleNumber);
    if (submoduleDiv.style.display === "none") {
        submoduleDiv.style.display = "block";
    } else {
        submoduleDiv.style.display = "none";
    }
}
