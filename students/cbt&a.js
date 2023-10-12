var acc = document.getElementsByClassName("accordion");
// var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {

    removeActive(this);
    closeAllPanels(this.nextElementSibling);

    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });

}

function closeAllPanels(object = null) {

    // Close all panels
    var panels = document.getElementsByClassName("panel");
    for (i = 0; i < panels.length; i++) {
        if (panels[i] !== object) {
            panels[i].style.display = "none";
        } else {
            console.log("skipppeeddd panelll");
        }
    }

}

function removeActive(object = null) {

    // Remove all active classes
    for (i = 0; i < acc.length; i++) {
        if (acc[i] !== object) {
            acc[i].classList.remove("active");
        } else {
            console.log("skipppeeddd");
        }
    }

}

function viewTask (task) {

    console.log(task);
    removeActive();
    closeAllPanels();

    document.getElementById("view-task").innerHTML = Tasks.get(Number(task));

    Tasks.getTaskData(task);

    document.getElementById('taskCompletion').addEventListener('submit', function(event) {

        event.preventDefault();
        console.log(event);
        Tasks.complete(event.target[0].value, event.target[1].value); 
    
    });

    document.getElementById('commentsForm').addEventListener('submit', function(event) {

        event.preventDefault();
        console.log(event);
        const comment = event.target[0].value;
        const unit = event.target[1].value;
        const task = event.target[2].value
        console.log(comment);
        Tasks.updateComment(unit, task, comment);
    
    });

}

function YYYY_MM_DD_2_DD_MM_YYYY (date) {

    var dateFormatted = new Date(date);
    var day = dateFormatted.getDate().toString().padStart(2,"0");
    var month = (dateFormatted.getMonth() + 1).toString().padStart(2,"0");
    var year = dateFormatted.getFullYear().toString().padStart(4,"0");
    dateFormatted = `${day}/${month}/${year}`;
    return dateFormatted;

}

class Tasks {

    static successAlert(message) {

        document.getElementById(`taskAlert`).innerHTML = `<div class="alert success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Success!</strong> ${message}
            </div>`;
        document.getElementById(`taskAlert`).style.display = "block";

        const element = document.getElementById("view-task");
        element.scrollIntoView();

        // document.getElementById('view-task').scrollIntoView({ behavior: 'smooth' });

        // Hide the div after 5000ms (the same amount of milliseconds it takes to fade out)
        // setTimeout(function(){ document.getElementById(`taskAlert`).style.display = "none"; }, 5000);
    }

    static getTaskData(task) {

        var params= `action=get-task&task=${task}`;
    
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                const result = JSON.parse(xhttp.responseText);
                if ('instructor_notes' in result['task'] && result['task']['instructor_notes'] != null) {
                    console.log("notes existtttt");
                    document.getElementById("notes").value = result['task']['instructor_notes'];
                } else if (result['usertype'] == "learner") {
                    document.getElementById("notes").placeholder = "No Notes"
                }
                if('completed' in result['task'] && result['task']['completed'] == 1){
                    disableFormInput();
                    document.getElementById("mark-task-completed").style.display = "none";
                    document.getElementById("mark-task-completed").parentElement.style.display = "none";
                    const formattedDate = YYYY_MM_DD_2_DD_MM_YYYY(result['task']['completed_date']);
                    if (result['task']['student_signature'] == 1) {
                        document.getElementById("taskCompletionMessage").innerHTML = `Task Completed on ${formattedDate}`;
                    } else if (result['usertype'] == "government" || result['usertype'] == "instructor") {
                        document.getElementById("taskCompletionMessage").innerHTML = `Task is marked complete, but still requires a student signature`;
                    } else if (result['usertype'] == "learner") {
                        document.getElementById("taskCompletionMessage").innerHTML = `Task is marked complete by your instructor, but still requires your signature`;
                    }
                    // document.getElementById("taskCompletionMessage").innerHTML = `Task Completed on ${formattedDate}`;
                    document.getElementById("drivers-name").innerHTML = result['task']['student_name'];
                    document.getElementById("completion-date").innerHTML = YYYY_MM_DD_2_DD_MM_YYYY(result['task']['completed_date']);
                    document.getElementById("student-license").innerHTML = result['task']['student_license'];
                    if (result['task']['student_signature'] == 1) {
                        document.getElementById("student-signature").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg> Signed`;
                    } else {
                        document.getElementById("student-signature").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg> Student Signature Required`; 
                    }
                    document.getElementById("instructor-signature").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                    </svg> Signed`;
                    document.getElementById("instructor-name").innerHTML = result['task']['instructor_name'];
                    document.getElementById("instructor-license").innerHTML = result['task']['instructor_license'];
                } else if (result['usertype'] == "learner") {
                    document.getElementById("taskCompletionMessage").innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                  </svg> Only an instructor may complete these items`;
                }
                if (result['usertype'] == "learner") {
                    document.getElementById("follow-up-actions").style.display = "none";
                    document.getElementById("notes-submit").style.display = "none";
                    document.getElementById("mark-task-completed").style.display = "none";
                    document.getElementById("mark-task-completed").parentElement.style.display = "none";
                    document.getElementById("notes").readOnly = true;
                    disableFormInput2();
                } else {
                    document.getElementById("follow-up-actions").style.display = "block";
                }
            }
        };
    
        xhttp.open("POST", "./task-action.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);

    }

    static snapshot () {

        var params= `action=snapshot`;
    
        var xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                const result = JSON.parse(xhttp.responseText);
                for (let i = 0; i < result.length; i++) {
                    let taskDescription = document.getElementById(`unit-${i+1}`).innerHTML;
                    const myArray = taskDescription.split(" (");
                    taskDescription = myArray[0];

                    document.getElementById(`unit-${i+1}`).innerHTML = `${taskDescription} ( Total Tasks: ${result[i].total}, Completed: ${result[i].completed}, Incomplete: ${result[i].incomplete}, Unsigned: ${result[i].unsigned} )`;
                    for (let j = 0; j < result[i].tasks.length; j++) {
                        if (result[i].tasks[j]['user-type'] == 'learner') {
                            if ((result[i].tasks[j].completed == 0 || result[i].tasks[j].completed == null) && result[i].tasks[j].student_followup == 0) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("warning"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("incomplete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                                <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                                </svg>
                                Incomplete`;
                            } else if ((result[i].tasks[j].completed == 0 || result[i].tasks[j].completed == null) && result[i].tasks[j].student_followup == 1) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("warning");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                </svg>
                                Practise Required`;
                            } else if (result[i].tasks[j].completed == 1 && (result[i].tasks[j].student_signature == 0 || result[i].tasks[j].student_signature == null)) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("warning");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg> Signature Required: <a href="#" onclick='Tasks.signTask("sign", ${result[i].tasks[j].task})'>Click here to sign</a>`;
                            } else if (result[i].tasks[j].completed == 1 && result[i].tasks[j].student_signature == 1) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("warning"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("complete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg> Task Completed`;
                            }

                        } else if (result[i].tasks[j]['user-type'] == 'instructor') {
                            if ((result[i].tasks[j].completed == 0 || result[i].tasks[j].completed == null) && result[i].tasks[j].instructor_followup == 0) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("warning"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("incomplete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                                <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                                </svg>
                                Incomplete`;
                            } else if ((result[i].tasks[j].completed == 0 || result[i].tasks[j].completed == null) && result[i].tasks[j].instructor_followup == 1) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("warning");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                </svg>
                                Follow-Up Required`;
                            } else if (result[i].tasks[j].completed == 1 && (result[i].tasks[j].student_signature == 0 || result[i].tasks[j].student_signature == null)) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("warning");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                                Student Signature Required`;
                            } else if (result[i].tasks[j].completed == 1 && result[i].tasks[j].student_signature == 1) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("warning"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("complete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg> Task Completed`;
                            } 
                        } else if (result[i].tasks[j]['user-type'] == 'government') {
                            if (result[i].tasks[j].completed == 0 || result[i].tasks[j].completed == null) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("incomplete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                                <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                                </svg>
                                Incomplete`;
                            } else if (result[i].tasks[j].completed == 1 && (result[i].tasks[j].student_signature == 0 || result[i].tasks[j].student_signature == null)) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("complete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("warning");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                                Student Signature Required`;
                            } else if (result[i].tasks[j].completed == 1 && result[i].tasks[j].student_signature == 1) {
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete"); 
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("complete");
                                document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg> Task Completed`;
                            }
                        }
                    }
                }
            }
        };
    
        xhttp.open("POST", "./task-action.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);

    }

    static complete (unit, task) {

        const action = 'complete-task';
        var params= `action=${action}&unit=${unit}&task=${task}`;
    
        var xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                // const result = JSON.parse(xhttp.responseText);
                // Tasks.successAlert("message");
                Tasks.snapshot();
                Tasks.getTaskData(task);
                Tasks.successAlert(`Task completed.`);
            }
        };
    
        xhttp.open("POST", "./task-action.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);

    }

    static updateComment (unit, task, message) {

        unit = encodeURIComponent(unit);
        task = encodeURIComponent(task);
        message = encodeURIComponent(message);

        var params= `action=update-comment&unit=${unit}&task=${task}&message=${message}`;
    
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                Tasks.successAlert("Comment Updated.");
                // Tasks.getTaskData(task);
            }
        };
    
        xhttp.open("POST", "./task-action.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);

    }

    static signTask (action, task) {

        var params= `action=${action}&task=${task}`;
    
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                // Tasks.successAlert();
                Tasks.snapshot();
            }
        };
    
        xhttp.open("POST", "./task-action.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);
    }


    static taskAction (action, unit, task) {

        var params= `action=${action}&unit=${unit}&task=${task}`;
    
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                // Tasks.successAlert();
                Tasks.snapshot();
                if (action == 'incomplete-task') {
                    enableFormInput();
                    document.getElementById("mark-task-completed").style.display = "block";
                    document.getElementById("mark-task-completed").parentElement.style.display = "table-cell";
                    Tasks.successAlert("Task has been marked incomplete.");
                } else if (action == 'instructor_followup') {
                    Tasks.successAlert("Task has been flagged for instructor followup.");
                } else if (action == 'student_followup') {
                    Tasks.successAlert("Task has been flagged for student followup.");
                }
            }
        };
    
        xhttp.open("POST", "./task-action.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);

    }

    static clear () {

        document.getElementById("view-task").innerHTML = "";

    }

    static get(task) {

        var taskData = null;

        switch(task) {
            case 1:
                taskData = this.task1();
                break;
            case 2:
                taskData = this.task2();
                break;
            case 3:
                taskData = this.task3();
                break;
            case 4:
                taskData = this.task4();
                break;
            case 5:
                taskData = this.task5();
                break;
            case 6:
                taskData = this.task6();
                break;
            case 7:
                taskData = this.task7();
                break;
            case 8:
                taskData = this.task8();
                break;
            case 9:
                taskData = this.task9();
                break;
            case 10:
                taskData = this.task10();
                break;
            case 11:
                taskData = this.task11();
                break;
            case 12:
                taskData = this.task12();
                break;
            case 13:
                taskData = this.task13();
                break;
            case 14:
                taskData = this.task14();
                break;
            case 15:
                taskData = this.task15();
                break;
            case 16:
                taskData = this.task16();
                break;
            case 17:
                taskData = this.task17();
                break;
            case 18:
                taskData = this.task18();
                break;
            case 19:
                taskData = this.task19();
                break;
            case 20:
                taskData = this.task20();
                break;
            case 21:
                taskData = this.task21();
                break;
            case 22:
                taskData = this.task22();
                break;
            case 23:
                taskData = this.task23();
                break;
            case 24:
                taskData = this.task24();
                break;
            case 25:
                taskData = this.task25();
                break;
            case 26:
                taskData = this.task26();
                break;
            case 27:
                taskData = this.task27();
                break;
            case 28:
                taskData = this.task28();
                break;
            case 29:
                taskData = this.task29();
                break;
            case 30:
                taskData = this.task30();
                break;
            case 31:
                taskData = this.task31();
                break;
            case 32:
                taskData = this.task32();
                break;
            default:
                this.clear();
        }
        var htmlform = this.taskTemplate(taskData);
        return htmlform;

    }

    static taskTemplate(taskData) {

        console.log(taskData);
        const unit = taskData["unit"];
        const unitNumber = taskData["unitNumber"];
        const task = taskData["task"];
        const taskNumber = taskData["taskNumber"];
        const taskDescription = taskData["taskDescription"];
        const taskRequirements = taskData["taskRequirements"];
        const learningOutcome = taskData["learningOutcome"];
        const assessmentStandard = taskData["assessmentStandard"];
        const taskCompletionTitle = taskData["taskCompletionTitle"]
        const taskCompletionForm = taskData["taskCompletionForm"]
        
        
        const form = `
        <h2 class="task-header">Unit ${unit}: Task ${task} - ${taskDescription}</h2>
        <div id="taskAlert"></div>
        <div class="stats-container">

            <div class="stat-card">
                <h3>Learning Outcome</h3>
                <p>${learningOutcome}</p>
            </div>

            <div class="stat-card">
                <h3>Assessment Standard</h3>
                <p>${assessmentStandard}</p>
            </div>

            <div class="stat-card">
                <h3>Task ${task} Requirements</h3>
                <p>${taskRequirements}</p>
            </div>

            <div class="stat-card">
                <h3>${taskCompletionTitle}</h3>
                ${taskCompletionForm}
                <p id="taskCompletionMessage"></>
            </div>

            <div id="follow-up-actions" class="stat-card">
                <h3>Actions</h3>
                <button type="button" onclick="Tasks.taskAction('student_followup', ${unitNumber}, ${taskNumber})">Flag for student practice</button>
                <button type="button" onclick="Tasks.taskAction('instructor_followup', ${unitNumber}, ${taskNumber})">Flag for instructor follow-up</button>
                <button type="button" onclick="Tasks.taskAction('incomplete-task', ${unitNumber}, ${taskNumber})">Mark task incomplete</button>
            </div>

            <div class="stat-card">
                <h3>Authorised Examiner Notes</h3>
                <form id="commentsForm">
                    <textarea id="notes" rows="4" cols="50" placeholder="Enter notes here..."></textarea><br>
                    <input type="hidden" value="${unitNumber}">
                    <input type="hidden" value="${taskNumber}">
                    <input type="submit" value="Update" id="notes-submit">
                </form>
            </div>

            <div class="stat-card">
                <h3>Task ${task} Sign Off</h3>
                <table>
                    <tr>
                        <td>Drivers Name</td>
                        <td id='drivers-name'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                    <tr>
                        <td>Licence Number</td>
                        <td id="student-license"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                    <tr>
                        <td>Learner Driver's Signature</td>
                        <td id='student-signature'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                    <tr>
                        <td>Authorised Examiner's Name</td>
                        <td id="instructor-name"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                    <tr>
                        <td>Authorised Examiner's Signature</td>
                        <td id='instructor-signature'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                    <tr>
                        <td>MDI No.</td>
                        <td id="instructor-license"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td id="completion-date"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg> Pending Task Completion</td>
                    </tr>
                </table>
            </div>

        </div>`

        return form;

    }

    static task1() {

        const unitNumber = 1;
        const taskNumber = 1;

        const task = {
            "unit":"1",
            "task":"1",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Cabin drill and controls",
            "taskRequirements":`
                (a) Ensure the doors are closed (and locked for security and safety - optional);
                <br>(b) Check that the park brake is firmly applied;
                <br>(c) Adjust the seat, head restraint and steering wheel (as required);
                <br>(d) Adjust all mirrors (electric mirrors, if fitted, may be adjusted after "starting the engine" - Task 2);
                <br>(e) Locate, identify and be able to use all vehicle controls (as required) when driving (including "climate" controls);
                <br>(f) Perform all steps (a) to (e) in sequence;
                <br>(g) Ensure all required seat belts are fastened correctly.`,
            "learningOutcome":"(1) The learner will be able to set up the cabin of the vehicle in order to safely, efficiently and effectively drive the vehicle (cabin drill) and be able to locate and identify all controls.",
            "assessmentStandard":`
                The learner will accurately perform this task without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`

                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Cabin drill:</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td><label for="group1">Group 1 - control name:</label></td>
                            <td>
                                <select name="group1" id="group1" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="Brake">Brake</option>
                                    <option value="Accelerator">Accelerator</option>
                                    <option value="Steering wheel">Steering wheel</option>
                                    <option value="audi">Gear lever (including autos)</option>
                                </select>
                            </td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td>Group 2 - control name:</td>
                            <td>
                                <select name="group2" id="group2" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="Clutch - (Manuals only)">Clutch - (Manuals only)</option>
                                    <option value="Park brake">Park brake</option>
                                    <option value="Warning device">Warning device</option>
                                    <option value="Signals">Signals</option>
                                </select>
                            </td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td>Group 2 - control name:</td>
                            <td>
                                <select name="group3" id="group3" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="Heater/demister">Heater/demister</option>
                                    <option value="Wipers and washers">Wipers and washers</option>
                                    <option value="Warning lights (any 3)">Warning lights (any 3)</option>
                                    <option value="Vehicle lights">Vehicle lights</option>
                                    <option value="Gauges">Gauges</option>
                                </select>
                            </td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>
                
                </form>`
        }

        return task;

    }

    static task2() {

        const unitNumber = 1;
        const taskNumber = 2;

        const task = {
            "unit":"1",
            "task":"2",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Starting up and shutting down the engine",
            "taskRequirements":`
                (1) Starting the engine
                <br>(a) If the park brake is not on, correctly apply it;
                <br>(b) Clutch down to the floor and keep it down (manuals only);
                <br>(c) Check gear lever in "Neutral" (manuals) or "Neutral/Park" (automatics);
                <br>(d) Switch the ignition (key) to the "ON" position;
                <br>(e) Check all gauges and warning lights for operation;
                <br>(f) Start the engine;
                <br>(g) Check all gauges and warning lights again for operation; and
                <br>(h) Performs all steps 1(a) to 1(g) in sequence.
                <br><br>(2) Shutting down the engine
                <br>(a) Bring the vehicle to a complete stop (clutch down-manuals);
                <br>(b) Secure the vehicle using the park brake;
                <br>(c) Select "Neutral" (manuals) or "Neutral/Park" (automatics);
                <br>(d) Release brake pedal (to check for rolling);
                <br>(e) Release clutch pedal (manuals only);
                <br>(f) Switch off appropriate controls (eg lights, air conditioner etc);
                <br>(g) Check all gauges and warning lights for operation;
                <br>(h) Turn ignition to "OFF" or "LOCK" position; and
                <br>(i) Perform all steps 2(a) to 2(h) in sequence.`,
            "learningOutcome":`
                (1) The learner will be able to safely start the engine of the vehicle; and
                <br>(2) The learner will be able to safely shut down the engine of the vehicle.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task without assistance.
                <br><br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Starting the engine</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Shutting down the engine</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task3() {

        const unitNumber = 1;
        const taskNumber = 3;

        const task = {
            "unit":"1",
            "task":"3",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Moving off from the kerb",
            "taskRequirements":`
                (a) If the park brake is not applied, correctly apply it;
                <br>(b) Check the centre mirror, then the right mirror, then signal right for at least 5 seconds;
                <br>(c) Push clutch pedal down (manuals) / Right foot on footbrake (automatics);
                <br>(d) Select 1st gear (manuals) / Select "Drive" (automatics);
                <br>(e) Apply appropriate power, (and for manuals) clutch to "friction point";
                <br>(f) Check the centre mirror again, then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic);
                <br>(g) If safe, look forward and release the park brake;
                <br>(h) Accelerate smoothly away from the kerb without stalling or rolling back, and cancel the signal; and
                <br>(i) Perform all steps (a) to (h) in sequence.`,
            "learningOutcome":`
                The learner will be able to move off from the left kerb in a safe and efficient manner with the vehicle under full control at the first attempt.`,
            "assessmentStandard":`
                The learner will accurately perform this task without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`

                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Move off from the kerb</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task4() {

        const unitNumber = 1;
        const taskNumber = 4;

        const task = {
            "unit":"1",
            "task":"4",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Stopping and securing the vehicle",
            "taskRequirements":`
                (1) Stopping the vehicle (including slowing)
                <br>(a) Select appropriate stopping position;
                <br>(b) Check the centre mirror, then the left mirror (for cyclists etc.) and signal left ;
                <br>(c) Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot
                <br>(d) (For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake;
                <br>(e) Bring vehicle to a smooth stop without jerking the vehicle; and
                <br>(f) Perform all steps 1(a) to 1 (e) in sequence.
                <br><br>(2) Securing the vehicle (to prevent rolling)
                <br>(a) Check that the vehicle has stopped (as above) and correctly apply the park brake to prevent rolling;
                <br>(b) Select "Neutral" (manuals) or "Park" (automatics);
                <br>(c) Release the brake pedal and then (for manuals) release the clutch;
                <br>(d) Perform all steps 2(a) to 2(c) in sequence; and
                <br>(e) Cancel any signal after stopping.`,
            "learningOutcome":`
                (1) The learner will bring the vehicle to a smooth and controlled stop at the left kerb from 30-60 km/h with safety, without stalling and when requested; and
                <br>(2) The learner will correctly secure the vehicle to avoid rolling.`,
            "assessmentStandard":`
                The learner will accurately perform this task without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.
                `,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Stop the vehicle (including slowing)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Secure the vehicle to prevent rolling (a prolonged stop)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task5() {

        const unitNumber = 1;
        const taskNumber = 5;

        const task = {
            "unit":"1",
            "task":"5",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Stop and go (using the park brake)",
            "taskRequirements":`
                (a) Select the suitable stopping position on the road (e.g. - stop lines, positioning for view and proximity to other vehicles);
                <br>(b) Check the centre mirror, (then if required the appropriate side mirror), and if required signal intention;
                <br>(c) Slow the vehicle smoothly using the footbrake only;
                <br>(d) For manuals only, when the vehicle slows to just above stalling speed, push the clutch down;
                <br>(e) For manuals only, just as the vehicle is stopping, select first gear;
                <br>(f) When the vehicle comes to a complete stop, apply the park brake (holding the handbrake button in, where possible*) and release the footbrake (right foot placed over accelerator);
                <br>(g) Check that it is safe to move off and apply appropriate power (and for manuals, clutch to friction point);
                <br>(h) If safe, look forward and release the park brake which results in the vehicle immediately moving off in a smooth manner without stalling and under full control; and
                <br>(i) Perform all steps (a) to (h) in sequence.`,
            "learningOutcome":`
            The learner will be able to bring the vehicle to a smooth stop in first gear (manuals only) and, with the aid of the park brake, immediately move off smoothly while maintaining full control of the vehicle.`,
            "assessmentStandard":`
                The learner will accurately perform this task without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Stop and go (using the park brake)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task6() {

        const unitNumber = 1;
        const taskNumber = 6;

        const task = {
            "unit":"1",
            "task":"6",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Gear changing (up and down)",
            "taskRequirements":`
                (1) Changing gears (up and down, manual and automatics)
                <br>(a) Move off smoothly from a stationary position in first gear (manuals) or (automatics);
                <br>(b) Adjust the speed of the vehicle prior to selecting the new gear;
                <br>(c) Change gears, one at a time from first gear (manuals) or the lowest gear (automatics) through to the highest gear without clashing, missing the gear, unnecessarily jerking the vehicle OR looking at the gear lever;
                <br>(d) Change gear from a high gear (4th, 5th or "Drive") to various appropriate gears without significantly jerking the vehicle OR looking at the gear lever/selector; and
                <br>(e) Demonstrate full control (including steering) over the vehicle during gear changing.
                <br><br>(2) Accurate selection of appropriate gears for varying speeds
                <br>(a) Adjust the speed of the vehicle up and down and then select the appropriate gear for that speed (manuals and automatics);
                <br>(b) When the vehicle is moving, demonstrate all gear selections without looking at the gear lever or gear selector; and
                <br>(c) Demonstrate accurate selection of the gears without significant jerking of the vehicle or clashing of gears.
                <br>(d) Demonstrate the selection of appropriate gears, whilst descending and ascending gradients; and
                <br>(e) Be able to select an appropriate gear to avoid unnecessary braking on descents and to have control on ascents.`,
            "learningOutcome":`
                (1) The learner will be able to change gears (in either a manual or automatic vehicle) up and down in the transmission in a reasonably smooth manner without looking at the gear lever while maintaining full steering control; and
                <br>(2) The learner will be able to accurately select any appropriate gear on demand without looking at the gear lever (including automatics).`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2' rowspan='2'>(1) Change gears up and down (100% accurate and a minimum of 5 demonstrations)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2' rowspan='2'>(2) Accurately select appropriate gears for varying speeds (100% accuracy and a minimum of 5 demonstrations)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='12'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task7() {

        const unitNumber = 1;
        const taskNumber = 7;

        const task = {
            "unit":"1",
            "task":"7",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Steering (forward and reverse)",
            "taskRequirements":`
                (1) Steering in a forward direction
                <br>(a) Maintain a straight course of at least 100 metres between turns with the hands placed in approximately the“10 to 2”clock position on the steering wheel with a light grip pressure;
                <br>(b) Demonstrate turning to the left and right through 90 degrees using either the “Pull-Push” or “Hand over Hand” method of steering while maintaining full vehicle control without over-steering;and
                <br>(c) Look in the direction where the driver is intending to go when turning (First Rule of Observation - Aim high in steering).
                <br><br>(2) Steering in reverse
                <br>(a) Reverse the vehicle in a straight line for a minimum of 20 metres with a deviation not exceeding 1 metre, followed by step 2(b);
                <br>(b) Reverse the vehicle through an angle of approximately 90 degrees to the left followed by reversing in a straight line for 5 metres with a deviation not exceeding half a metre (500mm); and;
                <br>(c) Look in the appropriate directions and to the rear while reversing.`,
            "learningOutcome":`
                (1) The learner will be able to competently and accurately steer the vehicle on a straight course, and turn to the right and to the left through 90 degrees when travelling in a forward direction while maintaining full vehicle control; and
                <br><br>(2) The learner will be able to competently steer the vehicle on a straight course, and turn to the left through approximately 90 degrees, when travelling in reverse.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task without assistance.
                <br><br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='7'>Demonstration 1</td>
                        </tr>

                        <tr>
                            <td colspan='2' rowspan='2'>(1) Steer in a forward direction (minimum of 4 left and 4 right turns)</td>
                            <td>100% (left)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td>100% (right)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Steer in reverse (minimum of 1 left reverse)</td>
                            <td>100% (left reverse)</td>
                            <td colspan='4'><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='7'>Demonstration 2</td>
                        </tr>

                        <tr>
                            <td colspan='2' rowspan='2'>(1) Steer in a forward direction (minimum of 4 left and 4 right turns)</td>
                            <td>100% (left)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td>100% (right)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Steer in reverse (minimum of 1 left reverse)</td>
                            <td>100% (left reverse)</td>
                            <td colspan='4'><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='7'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task8() {

        const unitNumber = 1;
        const taskNumber = 8;

        const task = {
            "unit":"1",
            "task":"8",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Review all basic driving procedures (T1 - T7)",
            "taskRequirements":`
                (a) Demonstrate Task 1 - cabin drill and controls
                <br>(b) Demonstrate Task 2 - starting up and shutting down the engine
                <br>(c) Demonstrate Task 3 - moving off from the kerb
                <br>(d) Demonstrate Task 4 - stopping and securing the vehicle
                <br>(e) Demonstrate Task 5 - stop and go (using the park brake)
                <br>(f) Demonstrate Task 6 - gear changing (up and down)
                <br>(g) Demonstrate Task 7 - control of the steering (forward and reverse)`,
            "learningOutcome":`
                The learner will competently demonstrate each of the learning outcomes from Tasks 1 to 7.`,
            "assessmentStandard":`
                The learner will perform one complete example of each of the learning outcomes for Tasks 1 to 7 without assistance. Any learning outcome that does not meet the standard for the task must be re-trained and re-assessed in accordance with the assessment method and standard for that original task.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Task 1 - cabin drill and controls</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 2 - starting up and shutting down the engine</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 3 - moving off from the kerb</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 4 - stopping and securing the vehicle</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 5 - stop and go (using the park brake)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 6 - gear changing (up and down)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 7 - steering (forward and reverse)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task9() {

        const unitNumber = 2;
        const taskNumber = 9;

        const task = {
            "unit":"2",
            "task":"9",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Moving off uphill",
            "taskRequirements":`
                (1) Stopping and securing the vehicle on a hill
                <br>(a) Select a suitable safe and legal place on the gradient to stop;
                <br>(b) Check the centre mirror, then the left mirror (for cyclists etc.), and signal left;
                <br>(c) Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot;
                <br>(d) (For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake;
                <br>(e) Bring vehicle to a smooth stop without jerking the vehicle;
                <br>(f) Check that the vehicle has stopped (as above) and correctly apply the park brake to prevent rolling;
                <br>(g) Select ‘Neutral’ (manuals) or ‘Park’ (automatics), then release the brake pedal, then (for manuals) release the clutch;
                <br>(h) Perform all steps 1(a) to 1(g) in sequence;
                <br>(i) cancel any signal after stopping.
                <br><br>(2) Moving off uphill
                <br>(a) If the park brake is not applied, correctly apply it;
                <br>(b) Check the centre mirror, then the right mirror, then signal right for at least 5 seconds;
                <br>(c) Push clutch pedal down (manuals) / right foot on brake pedal (automatics);
                <br>(d) Select first gear (manuals) / or select ‘drive’ (automatics);
                <br>(e) Apply appropriate power to prevent rolling backwards and/or stalling, (and for manuals) bring the clutch to ‘friction point’ absorbing about half of the engine noise;
                <br>(f) Check the centre mirror again then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic);
                <br>(g) If safe, look forward, release the park brake;
                <br>(h) Accelerate smoothly from the kerb without stalling or rolling back, and then cancel the signal;
                <br>(i) Perform all steps 2(a) to 2(h) in sequence while maintaining full control of the vehicle.`,
            "learningOutcome":`
                (1) The learner will be able to smoothly stop and secure the vehicle on any reasonable uphill gradient; and
                <br>(2) The learner will be able to move off competently and safely on any reasonable uphill gradient while in full control of the vehicle without stalling or rolling backwards.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task together without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Stop and secure the vehicle on a hill</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Moving off uphill (using the park brake)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task10() {

        const unitNumber = 2;
        const taskNumber = 10;

        const task = {
            "unit":"2",
            "task":"10",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"The U-turn",
            "taskRequirements":`
                (1) Selecting a location for the U-turn
                <br>(a) Select a location where the U-turn is legally permitted, can be completed without reversing and is not in a ‘No Stopping’ area, or opposite parked vehicles or where visibility in any direction is poor;
                <br>(b) Select a location where there is sufficient visibility in all directions to enable the U-turn to be done safely; and
                <br>(c) When stopping at the kerb comply with Task 4.
                <br><br>(2) The ‘U’ Turn
                <br>(a) Comply with the Give Way rules (for U-turn) by giving way to all other traffic using the road during this manoeuvre;
                <br>(b) Comply with the ‘moving off from the kerb’ procedure where practicable as stated in Task 3;
                <br>(c) Move the vehicle slowly forward (signalling appropriately) while turning the steering wheel (while not prohibited, dry/stationary steering is not encouraged) until on full steering lock (if required);
                <br>(d) Prior to the vehicle changing direction, observe in all directions for approaching traffic and other road users e.g. pedestrians (also paying attention to driveways and roads opposite); and
                <br>(e) When safe, accelerate smoothly away without stalling or over-steering while maintaining full control of the vehicle.`,
            "learningOutcome":`
                (1) The learner will be able to select a suitable and safe location to perform the U-turn (kerb to kerb and at intersections); and
                <br>(2) The learner will be able to turn the vehicle around competently and safely within the confines of the carriageway of a road without the need for reversing while maintaining full control
                of the vehicle.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task together without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Selecting the location for the U-turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) The U-turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task11() {

        const unitNumber = 2;
        const taskNumber = 11;

        const task = {
            "unit":"2",
            "task":"11",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"The 3-point turn",
            "taskRequirements":`
                (1) Selecting a location for the 3-point turn
                <br>(a) Select a suitable safe and legal place at the kerb to stop;
                <br>(b) Check the centre mirror, then the left mirror (for cyclists etc.) and signal left.
                <br>(c) Ensure that there are no obstructions next to the kerb forward of the centre of the vehicle on the left (reversing area);
                <br>(d) Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot;
                <br>(e) (For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake;
                <br>(f) Bring vehicle to a smooth stop without jerking the vehicle;
                <br>(g) Check that the vehicle has stopped;
                <br>(h) If preparing to immediately commence the 3-point turn, ensure the correct gear has been selected in preparation to move off (apply park brake if required);
                <br>OR If intending to fully secure the vehicle, apply the park brake and select neutral (manuals) Park (automatics) and release the brake pedal and then (for manuals) release the clutch;
                <br>(i) Perform all steps 1(a) to 1(h) in sequence;
                <br>(j) Cancel any signal after stopping.
                <br><br>(2) The 3-point turn (U-turn including reversing)
                <br>(a) Check the centre mirror, then the right mirror, then signal right for at least 5 seconds;
                <br>(b) (If moving off from fully secured) Push clutch pedal down (manuals) / right foot on brake pedal (automatics) / select 1st gear (manuals) / select ‘drive’ (automatics);
                <br>(c) Apply appropriate power, (and for manuals) clutch to ‘friction point’;
                <br>(d) Check the centre mirror again, then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic);
                <br>(e) If safe, look forward (release the park brake as required);
                <br>(f) Accelerate smoothly away from the kerb without stalling or rolling back while turning the steering wheel to the right (while not prohibited, dry/stationary steering is not encouraged) until on full steering lock (if required) and cancel the signal;
                <br>(g) About 1 metre from the right kerb and whilst keeping the vehicle moving, turn the steering wheel sufficiently to the left (while not prohibited, dry/stationary steering is not encouraged);
                <br>(h) Stop before touching the kerb;
                <br>(i) Select reverse gear, apply the park brake if required (holding the button in - optional) and check both directions and behind (over shoulders);
                <br>(j) Move off in reverse without rolling or stalling (continue steering left as required), under full control and continue checking in all directions (moving head and eyes) whilst reversing;
                <br>(k) About 1 metre from the kerb whilst keeping the vehicle moving, steer sufficiently to the right (while not prohibited, dry/stationary steering is not encouraged); and prepare to move off down the road;
                <br>(l) Stop before touching the kerb;
                <br>(m) Select first gear or ‘Drive’, apply the park brake if required (holding the button in - optional) and check both ways for traffic;
                <br>(n) When safe, move off down the road maintaining full control of the vehicle without stalling or over-steering (aim high in steering); and
                <br>(o) Perform all steps 2(a) to 2(n) in sequence.`,
            "learningOutcome":`
                (1) The learner will be able to select a safe and suitable location to perform the 3-point turn; and
                <br>(2) The learner will be able to turn the vehicle around safely and competently within
                the boundaries of a carriageway that is narrower than the turning circle of the vehicle while maintaining full control of the vehicle.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task together without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Selecting the location for the 3-point turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) The 3-point turn (U-turn including reverse)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task12() {

        const unitNumber = 2;
        const taskNumber = 12;

        const task = {
            "unit":"2",
            "task":"12",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"90 degree angle park (front to kerb)",
            "taskRequirements":`
                (1) Entering a 90 degree angle park (front to kerb)
                <br>(a) Select a suitable parking bay, check the centre mirror, then check the appropriate side mirror, then apply the appropriate signal for sufficient time and slow the vehicle to a safe and controllable speed;
                <br>(b) Choose the appropriate gear for control (if required);
                <br>(c) Check appropriate mirror/s or blind spot/s (for approaching vehicles and/or pedestrians) prior to turning into the parking bay; and
                <br>(d) Correctly position the vehicle, front to kerb, wholly within the bay (on the first attempt) while maintaining full control without touching the kerb:
                <br>(i) Not more than 300 mm out of parallel with the lines;
                <br>(ii) Not more than 300 mm from the kerb or end of parking bay; &
                <br>(iii) Where practicable, central within the parking bay with the front wheels pointing straight ahead towards the kerb.
                <br><br>(2) Leaving a 90 degree angle park
                <br>(a) Select reverse gear;
                <br>(b) Constantly check behind (over shoulders), both sides and to the front before moving and during reversing;
                <br>(c) Reverse slowly under full control of the vehicle and check for clearance of the front of the vehicle (where appropriate);
                <br>(d) Reverse the vehicle only for such a distance as is necessary and turn the steering wheel sufficiently to allow the vehicle to safely clear the parking bay alongside and counter steering sufficiently (while not prohibited, dry/stationary steering is not encouraged) in preparation to move off safely down the road without stalling or rolling; and
                <br>(e) Perform all steps above in sequence.`,
            "learningOutcome":`
                (1) The learner will be able to enter a 90 degree angle park (if available), front to the kerb, safely and competently while maintaining full control of the vehicle; and
                <br>(2) The learner will be able to leave a 90 degree angle park (if available) safely and competently while maintaining full control of the vehicle.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task together without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Enter a 90 degree angle parking bay</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Leave a 90 degree angle parking bay</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task13() {

        const unitNumber = 2;
        const taskNumber = 13;

        const task = {
            "unit":"2",
            "task":"13",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Reverse parallel parking",
            "taskRequirements":`
                (1) Leaving a confined parallel parking bay
                <br>(a) Prior to and during reversing, check right, left and behind (over shoulders) for other road users, including cyclists and pedestrians;
                <br>(b) Check the centre mirror, then check the right mirror, then signal right for minimum of five (5) seconds whilst complying with Task 3 (moving off from the kerb); (use of the park brake is optional as required)
                <br>(c) Exit the parking bay without touching the poles and without driving between the pole and the kerb.
                <br>(d) Stop so that the rear of the vehicle is just past the parking bay’s front pole and parallel to the kerb.
                <br><br>(2) Parking in a confined parallel parking bay
                <br>(a) Prior to and during reversing, check right, left and behind (over shoulders) for other road users, including cyclists and pedestrians;
                <br>(b) Check all around prior to turning the wheel to the left when reversing into the bay.
                <br>(c) After entering the parking bay, complete the exercise with no more than two directional changes (i.e. changes direction to drive forward to straighten, then changes direction for the second time to centralise between the poles);
                <br>(d) Parallel park the vehicle so that the left wheels are within 300mm of the kerb and straight, and centrally located not less than 900mm to the nearest pole;
                <br>(e) The wheels must not touch the kerb and the vehicle must not touch any pole or pass between any pole and the kerb; and
                <br>(f) Maintain full control of the vehicle (without stalling).`,
            "learningOutcome":`
                (1) The learner will be able to leave a confined parallel parking bay safely and competently while maintaining full control of the vehicle; and
                <br>(2) The learner will be able to park the vehicle in a confined parallel parking bay safely and competently while maintaining full control of the vehicle.`,
            "assessmentStandard":`
                The learner will accurately perform parts (1) and (2) of this task together without assistance.
                <br>The assessment will be a demonstration on at least two consecutive but separated occasions
                if training has been given. Two attempts at the manoeuvre are allowed to achieve each successful demonstration.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>(1) Leave a confined parallel parking bay</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>(2) Park in a confined parallel parking bay</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task14() {

        const unitNumber = 2;
        const taskNumber = 14;

        const task = {
            "unit":"2",
            "task":"14",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Review all slow speed manoeuvres",
            "taskRequirements":`
                (a) Demonstrate one complete example of Task 9 (‘stopping and securing the vehicle on a hill’ and ‘moving off uphill’ procedure) on request;
                <br>(b) Demonstrate one complete example of Task 10 (‘the U-turn’) on request;
                <br>(c) Demonstrate one complete example of Task 11 (‘the 3-point turn’) on request;
                <br>(d) Demonstrate one complete example of Task 12 (‘entering and leaving a 90 degree angle park’) on request; and
                <br>(e) Demonstrate one complete example of Task 13 (‘reverse parallel parking’) on request.*`,
            "learningOutcome":`
                The learner will be able to competently demonstrate each learning outcome from Tasks 9 to 13.`,
            "assessmentStandard":`
                The learner will perform one complete example of each of the learning outcomes for Tasks 9 to 13 without assistance. Any learning outcome that does not meet the standard for the task must be re-trained and re-assessed in accordance with the assessment method and standard for that original task.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Task 9 - moving off up hill</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 10 - the simple U-turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 11 - the 3-point turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 12 -  90 degree angle park (front to kerb)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 13 - reverse parallel parking</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task15() {

        const unitNumber = 3;
        const taskNumber = 15;

        const task = {
            "unit":"3",
            "task":"15",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Vehicle road positioning",
            "taskRequirements":`
                (1) Vehicle positioning on laned and unlaned roads
                <br>(a) Keep the vehicle as near as practicable to the left on unlaned roads without unnecessarily obstructing other traffic;
                <br>(b) Keep the vehicle wholly within the marked lane when travelling straight or in bends; and
                <br>(c) Use the space within the lane to maintain safety margins.
                <br><br>(2) Maintain safe following distances and safety margins
                <br>(a) Maintain a minimum of three (3) seconds following interval (see page 17) from the vehicle in front;
                <br>(b) Allow a safety margin of at least 1.2 m (where practicable) when passing objects, vehicles/ obstructions;
                <br>(c) Allow a minimum safety margin of 1 metre when passing a cyclist where the speed limit is 60kmh or less, and 1.5 metres where the speed limit is over 60kmh; and
                <br>(d) Stop in a position behind other vehicles allowing sufficient space to turn away from the vehicle in front if necessary.
                <br><br>(3) Positioning for turns
                <br>(a) Correctly position the vehicle at ‘Stop’ lines (associated with ‘Stop’ signs, crossings and traffic lights etc.);
                <br>(b) Demonstrate appropriate road position at intersections when view is obstructed; and
                <br>(c) Demonstrate the correct approach and turn positions for turning left and right at intersections in accordance with the law.`,
            "learningOutcome":`
                (1) The learner will safely and competently position the vehicle correctly on laned and unlaned roads in accordance with the law and ’System of Car Control’;
                <br>(2) The learner will maintain safe following distances from other vehicles and safety margins when passing stationary objects or bicycle riders; and
                <br>(3) The learner will correctly position the vehicle when turning left or right.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='3'><b>Turns: </b>Left Turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Turns: </b>Right Turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Wide Unlaned: </b>Straight</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Stop sign with a line: </b>Straight, Left or Right</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Laned Roads: </b>Straight</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Intersections - Obstructed View: </b>Straight, Left or Right</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task16() {

        const unitNumber = 3;
        const taskNumber = 16;

        const task = {
            "unit":"3",
            "task":"16",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Lane changing and diverging/merging",
            "taskRequirements":`
                (1) Changing lanes procedure
                <br>(a) Select a suitable location (not approaching traffic lights etc.);
                <br>(b) Accurately apply the ‘System of Car Control’ when changing from one lane to another (either left or right); and
                <br>(c) Check the appropriate blind spot just before changing to the new lane.
                <br>(2) Diverging or merging procedure
                <br>(a) When attempting to diverge, merge or zip merge ensure the vehicle is not directly alongside another vehicle (i.e. where practicable keep the vehicle off-set to others - Rules of Observation);
                <br>(b) When merging or diverging by more than 1 metre or crossing a lane line, comply with the ‘Lane Changing Procedure’(steps 1(a) to 3(c)) above and give way rules; and
                <br>(c) When merging or diverging by less than 1 metre, or diverging over a long distance when passing parked vehicles on an unlaned road, comply with step 1(b) above except signals and blind spots may be omitted only if safe.
                <br>(d) When merging with the flow of traffic, ensure that adequate speed is achieved prior to entering. The merge must have minimal impact on other road users (freeway on-ramps, extended slip lanes etc.); and
                <br>(e) When zip merging, pay particular attention when approaching signs and lane markings.`,
            "learningOutcome":`
                (1) The learner will be able to change lanes safely and competently to the right and to the left while complying with the ‘System of Car Control’; and
                <br>(2) The learner will be able to diverge safely and competently to the left or right or merge with other traffic while complying with the ‘System of Car Control’.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time
                (see pages 10 to 17) and compliance with the law over the complete assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'><b>Wide unlaned roads: </b>Passing a parked vehicle</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Laned roads: </b>Lane changes (left)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Laned roads: </b>Lane changes (right)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Merge with the flow of traffic: </b>Zip merge to the right</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Merge with the flow of traffic: </b>Zip merge to the left</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task17() {

        const unitNumber = 3;
        const taskNumber = 17;

        const task = {
            "unit":"3",
            "task":"17",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Turning at intersections",
            "taskRequirements":`
                (1) Turning at intersections (with a stop)
                <br>(a) Demonstrate turning left and right at intersections incorporating a stop while complying with the laws for turning;
                <br>(b) Demonstrate the ‘System of Car Control’ when turning right and left at intersections;
                <br>(c) Demonstrate safe observation patterns (Rules of Observation) while maintaining full vehicle control; and
                <br>(d) Comply with signalling requirements, ‘Stop’ and ‘Give Way’ signs and lines, and the give way rules at all times.
                <br><br>(2) Turning at intersections (without a stop)
                <br>(a) Demonstrate turning left and right at intersections without a stop where practicable while complying with the laws for turning;
                <br>(b) Demonstrate the ‘System of Car Control’ when turning right and left at intersections;
                <br>(c) Demonstrate correct and timely observation patterns when turning left and right at intersections while maintaining full control of the vehicle; and
                <br>(d) Comply with signalling and ‘Give Way’ rules.
                <br><br>(3) Negotiate ‘Stop’ and ‘Give Way’ signs/lines
                <br>(a) Comply with the ‘System of Car Control’ when negotiating ‘Stop’ and ‘Give Way’ signs and lines; and
                <br>(b) Comply with ‘Stop’ and ‘Give Way’ signs and lines.`,
            "learningOutcome":`
                (1 & 2)The learner will be able to turn safely and competently to the left and to the right (with and without a stop) at simple intersections while complying with the ‘System of Car Control’ and the rules for turning and giving way; and
                <br>(3) The learner will demonstrate correct compliance with ‘Stop’ and ‘Give Way’ signs.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'><b>With a stop: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>With a stop: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>With a ‘Stop’ sign: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>With a ‘Stop’ sign: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Without a stop: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Without a stop: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>'Give way' sign: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>'Give way' sign: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task18() {

        const unitNumber = 3;
        const taskNumber = 18;

        const task = {
            "unit":"3",
            "task":"18",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Turning onto and from laned roads",
            "taskRequirements":`
                (1) Turning left onto and from laned roads
                <br>(a) Comply with all laws relating to signalling, turning and ‘Giving Way’;
                <br>(b) Approach every turn at a safe speed under full control;
                <br>(c) Correct and timely observation of any conflicting traffic when turning left;
                <br>(d) Apply appropriate acceleration during and after turning when entering the traffic flow of the other road; and
                <br>(e) Comply with the ‘System of Car Control’
                <br><br>(2) Turning right onto and from laned roads
                <br>(a) Comply with all laws relating to signalling, turning and ‘Giving Way’;
                <br>(b) Approach every turn at a safe speed under full control;
                <br>(c) Correct and timely observation of any conflicting traffic when turning right;
                <br>(d) Apply appropriate acceleration during and after turning when entering the traffic flow of the other road; and
                <br>(e) Comply with the ‘System of Car Control’.`,
            "learningOutcome":`
                The learner will be able to demonstrate turning left and right safely on to and from laned roads using the ‘System of Car Control’ while complying with the ‘Give Way’ rules and the laws relating to turning.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'><b>Onto: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Onto: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>From: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>From: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Compound turns: </b>Left turn followed by a right turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Compound turns: </b>Right turn followed by a left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task19() {

        const unitNumber = 3;
        const taskNumber = 19;

        const task = {
            "unit":"3",
            "task":"19",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Negotiating roundabouts",
            "taskRequirements":`
                (1) Turning at unlaned roundabouts
                <br>(a) Comply with give way rules, signalling and correct vehicle positioning at unlaned roundabouts;
                <br>(b) Negotiate every roundabout at a safe speed under full control;
                <br>(c) Observe in the appropriate directions when approaching and during turns at unlaned roundabouts; and
                <br>(d) Comply with the ‘System of Car Control’.
                <br><br>(2) Turning at laned roundabouts
                <br>(a) Demonstrate compliance with give way rules, signalling, arrows and correct vehicle positioning at roundabouts;
                <br>(b) Negotiate every roundabout at a safe speed under full control;
                <br>(c) Observe in the appropriate directions when approaching and during turns at laned roundabouts; and
                <br>(d) Comply with the ‘System of Car Control’.
                <br><br>(3) Travelling straight on at a roundabout
                <br>(a) Demonstrate compliance with give way rules, signalling, arrows and co roundabout;
                <br>(b) Negotiate every roundabout at a safe speed under full control;
                <br>(c) Look in the appropriate directions when approaching and proceding through roundabouts; and
                <br>(d) Comply with the ‘System of Car Control’.`,
            "learningOutcome":`
                The learner will be able to turn left, turn right and go straight on safely at unlaned and laned roundabouts while complying with all laws relating to giving way and positioning on roundabouts, and the ‘System of Car Control’.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'><b>Unlaned: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Unlaned: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Unlaned: </b>Straight on</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned: </b>Straight on</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task20() {

        const unitNumber = 3;
        const taskNumber = 20;

        const task = {
            "unit":"3",
            "task":"20",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Negotiating traffic lights",
            "taskRequirements":`
                (1) Turning left and right at traffic lights (without arrows)
                <br>(a) Comply with the law for traffic light signals, associated stop lines, turning lines and arrows;
                <br>(b) Enter and correctly position vehicle lawfully within the intersection when stopping to give way to opposing traffic;
                <br>(c) When turning right, keep the front wheels straight (where practicable) while waiting to give way to on-coming traffic; and
                <br>(d) Comply with Tasks 17 and 18 requirements when turning.
                <br><br>(2) Following a straight course through traffic lights
                <br>(a) Comply with the law for traffic light signals and associated stop lines;
                <br>(b) Comply with ‘System of Car Control’ approaching lights; and
                <br>(c) Apply correct stopping procedure (Task 4) as applicable.
                <br><br>(3) Turning left through a slip lane (without arrows)
                <br>(a) Comply with all ‘Give Way’, signalling and road law;
                <br>(b) Comply with turning left requirements for Tasks 17 and 18 including safe speed of approach to the turn; and
                <br>(c) Demonstrate appropriate and timely observation patterns, and ‘System of Car Control’.`,
            "learningOutcome":`
                (1 & 2) The learner will safely negotiate traffic lights (without arrows) by turning right, left and proceeding straight ahead while complying with all laws and ‘System of Car Control’; and
                <br>(3) The learner will safely demonstrate turning left at slip lanes.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='3'><b>No arrows: </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>No arrows: </b>Right turns</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'><b>No arrows: </b>Straight on at intersections</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Slip lane (no arrows): </b>Left turns</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task21() {

        const unitNumber = 3;
        const taskNumber = 21;

        const task = {
            "unit":"3",
            "task":"21",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Light traffic urban driving",
            "taskRequirements":`
                (1) Pedestrian crossings, school zones and cross road intersections
                <br>(a) Comply with the laws for pedestrian crossings and school zones; and
                <br>(b) Accurately comply with the ‘System of Car Control’ at all cross road intersections on unlaned roads (centre mirror must be checked prior to observation).
                <br><br>(2) Speed limits
                <br>(a) Comply with all speed limits in speed zones and built-up areas whilst demonstrating awareness of changing speed limits; and
                <br>(b) Comply with speed limits for bridges, roadworks, schools, car parks and learner requirements.
                <br><br>(3) Maintain reasonable progress
                <br>(a) Where safe and practicable, maintain a speed which is within 5 km/h of the legal speed limit but does not exceed the speed limit;
                <br>(b) Move off in a line of traffic without any unnecessary delay or obstructing other traffic;
                <br>(c) Does not slow excessively or stop unnecessarily at intersections where the view is open and clear, and it is safe to go; and
                <br>(d) Maintain at least a ‘3 second’ following distance between the vehicle in front and the learner’s vehicle.`,
            "learningOutcome":`
                (1) The learner will comply with the law while negotiating Emu, Koala and Wombat pedestrian crossings, school zones and cross road intersections (where available);
                <br>(2) The learner will comply with all speed limits associated with speed zones, road works, bridges, built-up areas, schools and car parks; and
                <br>(3) The learner will demonstrate reasonable progress:
                <br>(i) by keeping up with the flow of traffic when it is practicable, legal and safe,
                <br>(ii) when negotiating cross road intersections whilst complying with the ‘System of Car Control’.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='4'><b>Straight driving: </b>Operating pedestrian crossing</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><b>Straight driving: </b>School zone</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><b>Straight driving: </b>Speed limit change</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Straight driving: </b>Intersections with a good view</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'><b>Straight driving: </b>Cross road intersections without facing any type of control (give way signs, stop signs or traffic lights)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='5'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task22() {

        const unitNumber = 3;
        const taskNumber = 22;

        const task = {
            "unit":"3",
            "task":"22",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Country driving (driving at higher speeds)",
            "taskRequirements":`
                (1) Negotiating bends and crests
                <br>(a) Comply with speed limits, road markings, keeping left and ‘Due Care’ requirements while maintaining reasonable progress;
                <br>(b) Demonstrate a safe speed and position of approach to all bends and crests;
                <br>(c) Comply with ‘System of Car Control’ approaching bends and crests (including selection of the correct gear before the bend or crest);
                <br>(d) Comply with the Rules of Braking and ‘acceleration sense’ approaching bends and crests;
                <br>(e) Comply with the Rules of Steering when braking and cornering;
                <br>(f) Demonstrate good forward observation (Aim high in steering) and complies with the Rules of Observation; and
                <br>(g) Display safe and complete control of the vehicle at all times.
                <br><br>(2) Overtaking other vehicles
                <br>(a) Correctly select a safe and suitable location to overtake while complying with the law (road markings, sufficient clear view);
                <br>(b) Maintain a reasonable following distance before overtaking in order to comply with the Rules of Observation; and
                <br>(c) Comply with ‘System of Car Control’ and use appropriate gears and acceleration where necessary; or
                <br>(d) If suitable overtaking situations do not occur, verbally demonstrate to the Authorised Examiner the selection of five safe and suitable locations where there is sufficient distance to overtake safely.`,
            "learningOutcome":`
                (1) The learner will demonstrate accurate compliance with the ‘System of Car Control’, Rules of Braking, Steering and Observation (see pages 10 to 17) as applied to bends, crests and overtaking while driving at higher speeds; and
                <br>(2) The learner will maintain full control of the vehicle while driving at higher speeds.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='5'><b>Driving at higher speeds: </b>Entering a road</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='5'><b>Driving at higher speeds: </b>Leaving a road</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'><b>Driving at higher speeds: </b>Bends - right</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'><b>Driving at higher speeds: </b>Bends - left</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><b>Driving at higher speeds: </b>Crests</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='5'><b>Driving at higher speeds: </b>Overtaking</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='6'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task23() {

        const unitNumber = 4;
        const taskNumber = 23;

        const task = {
            "unit":"4",
            "task":"23",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Safe driving strategies",
            "taskRequirements":`
                (1) Safe positioning of the vehicle in traffic
                <br>(a) Keep at least 3 seconds time interval between the learner’s vehicle and the vehicle in front, increasing this interval for adverse weather conditions or if being closely followed;
                <br>(b) Where safe and practicable, keep at least 1.2 metre clearance when passing parked vehicles, or other hazards;
                <br>(c) Allow a minimum safety margin of 1 metre when passing a cyclist where the speed limit is 60kmh or less, and 1.5 metres where the speed limit is over 60kmh;
                <br>(d) Adjust the vehicle’s position by holding back if the vehicle in front obstructs the view ahead (Observation - Get the big picture);
                <br>(e) Maintain the vehicle’s position in a line of traffic without obstructing following traffic where it is safe and legal to do so;
                <br>(f) Avoid unnecessary travel in blind spots of other vehicles (Observation - Leave yourself an OUT);
                <br>(g) Where practicable, stop in a position behind other vehicles to allow sufficient space to turn away from the vehicle in front;
                <br>(h) Without obstructing the intersection stop in a line of traffic (road law); and
                <br>(i) Comply with all appropriate road rules.
                <br><br>(2) ‘System of Car Control’ as applied to traffic hazards
                <br>(a) Comply with the features of the ‘System of Car Control’ in the correct sequence when approaching hazards in traffic;
                <br>(b) Comply with ‘System of Car Control’ when approaching traffic lights (eg. check mirror, cover the brake, etc.);
                <br>(c) Demonstrate ‘System of Car Control’ when passing stationary buses or other similar hazards; and
                <br>(d) Demonstrate ‘System of Car Control’ when giving way.`,
            "learningOutcome":`
                (1) The learner will competently maintain safe following distances, passing clearances and appropriate positioning of the vehicle for improved forward observation in medium to heavy traffic; and
                <br>(2) Demonstrate compliance with the ‘System of Car Control’ when approaching potential hazards in traffic.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                    <tr>
                        <td colspan='2'><b>Wide unlaned roads: </b>Straight drive following traffic
                        (with two stops in a line of traffic)</td>
                        <td><input type="checkbox" required></td>
                        <td><input type="checkbox" required></td>
                    </tr>

                    <tr>
                        <td colspan='2'><b>Laned roads: </b>Straight drive following traffic
                        (with two stops in a line of traffic)</td>
                        <td><input type="checkbox" required></td>
                        <td><input type="checkbox" required></td>
                    </tr>

                    <tr>
                        <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                    <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task24() {

        const unitNumber = 4;
        const taskNumber = 24;

        const task = {
            "unit":"4",
            "task":"24",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Lane management in traffic",
            "taskRequirements":`
                (1) Lane selection in traffic
                <br>(a) Identify potential hazards well in advance and take safe and appropriate action (Observation - Get the Big Picture);
                <br>(b) Confidently select safe gaps when changing lanes; and
                <br>(c) Select suitable and timely locations when changing lanes (‘System of Car Control’ - select the course).
                <br><br>(2) Lane changing in traffic
                <br>(a) Competently apply the ‘System of Car Control’ when changing from one lane to another (either left or right);
                <br>(b) Check the appropriate blind spot just before changing lanes;
                <br>(c) Co-operate with other drivers by accepting and giving reasonable offers of courtesy when safe; and
                <br>(d) Change lanes in traffic only when safe without significantly interfering with the flow of traffic in the newly selected lane.`,
            "learningOutcome":`
                (1) The learner will be able to select the appropriate lane safely and competently well in advance to maintain reasonable progress and efficient traffic flow; and
                <br>(2) The learner will be able to change lanes safely and competently in traffic while complying with the ‘System of Car Control’.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'><b>Laned Roads: </b>Lane changes (left)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned Roads: </b>Lane changes (right)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='5'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task25() {

        const unitNumber = 4;
        const taskNumber = 25;

        const task = {
            "unit":"4",
            "task":"25",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Turning in traffic",
            "taskRequirements":`
                (1) Turning left onto and from busy roads
                <br>(a) Display compliance with all ‘Give Way’ and ‘turning’ rules (observation, braking and steering);
                <br>(b) Maintain full vehicle control throughout each turn (ie. no wide exits, question-mark turns, or stalls);
                <br>(c) When exiting or entering a busy road, keep as near as reasonably practicable to the left;
                <br>(d) Comply with the ‘System of Car Control’ throughout the assessment;
                <br>(e) Display competent selection of safe gaps when entering a traffic flow; and
                <br>(f) Display competent acceleration skills when entering a gap (See ‘System of Car Control’).
                <br><br>(2) Turning right onto and from busy roads
                <br>(a) Display compliance with all ‘Give Way’ and turning’ rules (observation, braking and steering);
                <br>(b) Maintain full vehicle control throughout each turn (ie. no wide exits, question-mark turns, or stalls);
                <br>(c) Comply with the ‘System of Car Control’ throughout the assessment;
                <br>(d) Make early selection of the most appropriate and lawful lane for turning;
                <br>(e) Display competent selection of safe gaps when entering or crossing a traffic flow when turning right; and
                <br>(f) Display competent acceleration skills when entering a safe gap or crossing a flow of traffic - (See ‘System of Car Control’).`,
            "learningOutcome":`
                (1) The learner will turn right and left safely and competently in traffic under full control while complying with the ‘Give Way’ laws, ‘turning’ laws and the ‘System of Car Control’; and
                <br>(2) The learner will competently select safe gaps when entering or crossing a flow of traffic on busy roads without unnecessary hesitation.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='3'><b>Unlaned roads: </b>On to - left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Unlaned roads: </b>On to - right turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Unlaned roads: </b>From - left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Unlaned roads: </b>From - right turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned roads: </b>On to - left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Laned roads: </b>On to - right turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned roads: </b>From - left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Laned roads: </b>From - right turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task26() {

        const unitNumber = 4;
        const taskNumber = 26;

        const task = {
            "unit":"4",
            "task":"26",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Managing traffic at roundabouts",
            "taskRequirements":`
                (1) Managing traffic at unlaned roundabouts
                <br>(a) Comply with the requirements and standard as documented in Task 19 (1) - turning at unlaned roundabouts;
                <br>(b) Display competent and confident decision making when selecting safe gaps in traffic on the roundabout; and
                <br>(c) Demonstrate competent use of acceleration when joining and leaving a traffic stream on the carriageway of the roundabout.
                <br><br>(2) Managing traffic at laned roundabouts
                <br>(a) Comply with the requirements and standard as documented in Task 19 (2) - turning at laned roundabouts;
                <br>(b) Demonstrate early selection of correct lanes before, during and after turning or when travelling straight on at the roundabout;
                <br>(c) Display competent and confident decision making when selecting safe gaps in traffic at the roundabout; and
                <br>(d) Demonstrate competent use of acceleration when joining and leaving a traffic stream on the carriageway of the roundabout.`,
            "learningOutcome":`
                The learner will be able to turn right, left and travel straight-on safely and competently at laned and unlaned roundabouts in medium to heavy traffic while complying with the law and the ‘System of Car Control’.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'><b>Unlaned roads: </b>Left turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Unlaned roads: </b>Right turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>Unlaned roads: </b>Straight on</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned roads: </b>Left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned roads: </b>Right turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>Laned roads: </b>Straight on</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task27() {

        const unitNumber = 4;
        const taskNumber = 27;

        const task = {
            "unit":"4",
            "task":"27",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"U-turn in traffic manoeuvre",
            "taskRequirements":`
                (1) Selecting a safe U-turn starting position
                <br>(a) Select a suitable position whilst complying with ‘System of Car Control’;
                <br>(b) Select a position where only one major flow of traffic is required to be crossed during the U-turn; and
                <br>(c) Select the most appropriate position that minimises the disruption to overtaking or following traffic for that road (eg. a right turn store lane opposite a quiet road).
                <br><br>(2) Perform a safe and complete U-turn
                <br>(a) Comply with all road markings, and the ‘Give Way’ rules for turning and moving off (as required);
                <br>(b) Confidently select a safe gap in the traffic flow when presented;
                <br>(c) Use safe stopping areas within the U-turn as required; and
                <br>(d) Complete the U-turn safely without reversing while maintaining full control of the vehicle.
                <br><br>(3) Select a safe alternative to the U-turn due to traffic
                <br>(a) If traffic conditions change where the U-turn could become confusing or dangerous to any road users, select an acceptable safe option; and
                <br>(b) Perform the optional action with safety.`,
            "learningOutcome":`
                (1) The learner will be able to select a safe and suitable location on a busy road and competently perform a U-turn with safety without the need for reversing; and
                <br>(2 & 3) The learner will be able to choose a safer option to a U-turn where the turn may be obstructed due to changing traffic conditions.`,
            "assessmentStandard":`
                The learner will accurately perform Parts (1) and (2), or (1) and (3) of this task without assistance. The assessment will be a demonstration on at least two consecutive but separate occasions.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='1'>(1) Select a safe U-turn starting position (eg. 'store' lane - clear view)</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'>(2) Perform a safe and complete U-turn on a busy road</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'>(3) Select a safe alternative to the U-turn due to changing traffic conditions</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task28() {

        const unitNumber = 4;
        const taskNumber = 28;

        const task = {
            "unit":"4",
            "task":"28",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Negotiating traffic lights in traffic",
            "taskRequirements":`
                (1) Turning left and right at traffic lights (without arrows)
                <br>(a) Comply with Task 20;
                <br>(b) While waiting to turn right or left , correctly position the vehicle within the intersection when permitted by the traffic lights;
                <br>(c) Demonstrate confident selection of safe gaps when turning into or across a traffic flow;
                <br>(d) Display appropriate use of acceleration for safety during the turn while maintaining full control of the vehicle; and
                <br>(e) Ensure that other vehicles are not unnecessarily obstructed when turning.
                <br><br>(2) Following a straight course through traffic lights
                <br>(a) Comply with Task 20; and
                <br>(b) Display correct and confident decision making on approach to traffic lights having regard for weather, road conditions and following traffic (type of vehicle and how near they are).
                <br><br>(3) Negotiating ‘slip’ lanes (without arrows)
                <br>(a) Comply with Task 20;
                <br>(b) Demonstrate confident selection of safe gaps when turning left through a ‘slip’ lane into a flow of traffic; and
                <br>(c) Display appropriate use of acceleration for safety during and after the turn while maintaining full control of the vehicle.`,
            "learningOutcome":`
                (1) The learner will be able to travel straight on, turn left and right safely and competently at traffic lights (with and without arrows) in medium to heavy traffic in accordance with the ‘System of Car Control’; and
                <br>(2) The learner will comply with the appropriate road laws governing the operation of traffic lights, signalling, turning, positioning the vehicle and ‘Giving Way’.
                <br>(3) The learner will comply with the appropriate road laws when negotiating ‘slip’ lanes`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='4'><b>No arrows: </b>Left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><b>No arrows: </b>Right turn</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'><b>No arrows: </b>Straight on</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><b>'Slip lane' (no arrows): </b>Left turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='5'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task29() {

        const unitNumber = 4;
        const taskNumber = 29;

        const task = {
            "unit":"4",
            "task":"28A",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Driving on unsealed roads",
            "taskRequirements":`
                (a) Demonstrate compliance with all appropriate road laws (eg. as near as practicable to the left, etc.);
                <br>(b) Maintain full control of the vehicle at all times (skidding or sliding at any time is considered to be loss of control – see system of car control);
                <br>(c) Demonstrate a safe speed of approach to bends, crests and intersections at all times;
                <br>(d) Demonstrate safe and correct entry lines into bends (for good view and being seen - Rules of Observation);
                <br>(e) Demonstrate safe and correct exit lines from bends (ensuring the vehicle leaves the bend on the correct side of the road – if any part of the vehicle strays onto the incorrect side of the road it is a road law fault – see step (a));
                <br>(f) Comply with the ‘System of Car Control’, Rules of Braking, Steering and Observation;
                <br>(g) Correctly adjust speed to that which is suitable to any change of road surface;
                <br>(h) Correctly adjust the following distance and use headlights as required when following another vehicle (eg. decreased visibility due to dust etc.); and
                <br>(i) Correctly adjust the speed (minimum use of the accelerator) when passing another vehicle travelling in the opposite direction (to reduce the risk of possible windscreen damage).`,
            "learningOutcome":`
                The learner will be able to negotiate bends, crests and intersections safely and competently on unsealed roads using the ‘System of Car Control’, Rules of Braking, Steering and Observation while complying with the law.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Range Statement",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='4'><b>No arrows: </b>Left turn at intersections</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><b>No arrows: </b>Right turn at intersections</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'><b>No arrows: </b>Bends - left</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='1'><b>No arrows: </b>Bends - right</td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='5'><b>No arrows: </b>Crests</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='6'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task30() {

        const unitNumber = 4;
        const taskNumber = 30;

        const task = {
            "unit":"4",
            "task":"28B",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Driving at night",
            "taskRequirements":`
                (a) Recognition of current skills and knowledge
                <br>• Question learner on speed limits, keeping to the left, 3-Second Rule Formula, Use of headlights, ‘System of Car Control’, Rules of Braking, Steering and Observation; and
                <br><br>(b) Driving at night
                <br>• Explain adjustments required in speed and positioning in regard to visual deficiencies.
                <br>• Explain the requirements in relation to clean windscreens and headlights.
                <br>• Explain the requirements in relation to dipping headlights. (eg when following within 200m from the rear of other traffic and when approaching vehicle reaches a point 200m from your vehicle or immediately the headlights of an approaching vehicle are dipped, whichever is sooner).
                <br>• Explain the confusion that may occur when driving in built up areas due to the mixture of neon signs, traffic lights, store lights, street lighting, etc.
                <br>• Explain the need to be ‘seen’ (eg do not forget to turn on headlights). Explain the lack of visual eye contact with other road users.
                <br>• Demonstrate correct application of ‘System’.
                <br><br>(c) Demonstrate night driving
                <br>• Trainee to demonstrate under full instruction.
                <br>• Trainee to demonstrate with instruction as required; and
                <br>• Trainee to practice until competent.`,
            "learningOutcome":`
                The learner will be able to safely and competently demonstrate the maintenance of safe following distances, passing clearances and appropriate position of the vehicle for improved forward observation in relation to visual and speed adjustments using the ‘System of Car Control’, Rules of Braking, Steering and Observation while complying with the law.`,
            "assessmentStandard":`
                Task 28B is an optional Task. It is not compulsory for the Authorised Examiner to sign. This task has been placed in the Driving Companion primarily for the use by the Qualified Supervising Driver for guidance when recording the compulsory 15 hours of night driving.`,
            "taskCompletionTitle":"Log Book Entry",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Complete the log book entry. (In the case of training given by an Authorised Examiner)</td>
                        </tr>

                        <tr>
                            <td colspan='2'>Complete the Form 11 and Form 12, 'Record of Night-time Driving Hours' in this book.
                            (In the case of training given by a Qualified Supervising Driver or a Motor Driving Instructor).</td>
                        </tr>

                        <tr>
                            <td colspan='2'>Sign only if accompanied by an Authorised Examiner.</td>
                        </tr>

                        <tr>
                            <td colspan='2'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task31() {

        const unitNumber = 5;
        const taskNumber = 31;

        const task = {
            "unit":"1-2",
            "task":"29",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Review of basic driving skills",
            "taskRequirements":`
                (1) Review of all tasks in Unit 1
                <br>(a) Accurately perform Task 1 - cabin drill and controls
                <br>(b) Accurately perform Task 2 - starting up and shutting down the engine
                <br>(c) Accurately perform Task 3 - moving off from the kerb
                <br>(d) Accurately perform Task 4 - stopping and securing the vehicle
                <br>(e) Accurately perform Task 5 - stop and go (using the park brake)
                <br>(f) Accurately demonstrate Task 6 - gear changing
                <br>(g) Accurately demonstrate Task 7 - control of the steering (forward and reverse)
                <br><br>(2) Review of all tasks in Unit 2
                <br>(a) Accurately perform Task 9 - stopping and securing the vehicle on a hill and moving off uphill
                <br>(b) Accurately perform Task 10 - the U-turn
                <br>(c) Accurately perform Task 11 - the 3-point turn
                <br>(d) Accurately perform Task 12 - entering and leaving a 90 degree angle park
                <br>(e) Accurately perform Task 13 - reverse parallel parking`,
            "learningOutcome":`
                (1) The learner will be able to accurately perform one example of each of the learning outcomes for the Basic Driving Procedures as identified in Unit 1, Tasks 1 to 7 without assistance; and
                <br>(2) The learner will be able to accurately perform one example of each of the Slow Speed Manoeuvres as identified in Unit 2, Tasks 9 to 13 without assistance.`,
            "assessmentStandard":`
                The learner will accurately perform one example of each of the learning outcomes for Tasks 1 to 7 and 9 to 13 without assistance. Any learning outcome that does not meet the standard for the original task must be re-assessed (after any retraining) in accordance with the assessment method and standard for that original task.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Task 1 - cabin drill and controls</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 2 - starting up and shutting down the engine</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 3 -  moving off from the kerb</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 4 - stopping and securing the vehicle</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 5 - stop and go (using the park brake)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 6 - gear changing</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 7 - steering (forward and reverse)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 9 - moving off up hill</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 10 - the U–turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 11 - the 3–point turn</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 12 - 90 Degree Angle Park (front to kerb)</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'>Task 13 -  reverse parallel parking</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

    static task32() {

        const unitNumber = 6;
        const taskNumber = 32;

        const task = {
            "unit":"3-4",
            "task":"30",
            "unitNumber":unitNumber,
            "taskNumber":taskNumber,
            "taskDescription":"Review of road skills and traffic management",
            "taskRequirements":`
                a Comply with all road laws;
                <br>b Comply with the ‘System of Car Control’ to left and right turns, traffic lights, stopping, lane changes and other potential traffic hazards;
                <br>c Comply with the Rules of Braking, Steering and Observation; and
                <br>d Demonstrate appropriate forward planning, correct and timely road positioning, and safe driving strategies.`,
            "learningOutcome":`
                The learner will competently demonstrate a safe, efficient drive in medium to heavy traffic where practicable, of not less than 25 minutes duration without assistance while complying with all road laws, the ‘System of Car Control’, Rules of Braking, Steering and Observation.`,
            "assessmentStandard":`
                The learner will demonstrate compliance with road craft concepts at least 80% of the time (see pages 10 to 17) and compliance with the law during the assessment without assistance.`,
            "taskCompletionTitle":"Task Assessment Records",
            "taskCompletionForm":`
                <form id="taskCompletion">

                    <input type="hidden" id="unit" name="unit" value="${unitNumber}">
                    <input type="hidden" id="task" name="task" value="${taskNumber}">

                    <table>

                        <tr>
                            <td colspan='2'>Task 30 – A short drive of not less than 25 minutes duration in medium to heavy traffic.</td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='3'><input type="submit" value="Mark task completed" id="mark-task-completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

}

function disableFormInput () {

    const allInputElements = document.getElementById("taskCompletion").querySelectorAll("input");

    for (let i = 0; i < allInputElements.length; i++) {
        allInputElements[i].disabled = true;
    }

    const allSelectElements = document.getElementById("taskCompletion").querySelectorAll("select");

    for (let i = 0; i < allSelectElements.length; i++) {
        allSelectElements[i].disabled = true;
    }

    const allCheckboxElements = document.getElementById("taskCompletion").querySelectorAll("input[type=checkbox]");

    for (let i = 0; i < allCheckboxElements.length; i++) {
        allCheckboxElements[i].checked = true;
    }

}

function disableFormInput2 () {

    const allInputElements = document.getElementById("taskCompletion").querySelectorAll("input");

    for (let i = 0; i < allInputElements.length; i++) {
        allInputElements[i].disabled = true;
    }

    const allSelectElements = document.getElementById("taskCompletion").querySelectorAll("select");

    for (let i = 0; i < allSelectElements.length; i++) {
        allSelectElements[i].disabled = true;
    }

}

function enableFormInput () {

    const allInputElements = document.getElementById("taskCompletion").querySelectorAll("input");

    for (let i = 0; i < allInputElements.length; i++) {
        allInputElements[i].disabled = false;
    }

    const allSelectElements = document.getElementById("taskCompletion").querySelectorAll("select");

    for (let i = 0; i < allSelectElements.length; i++) {
        allSelectElements[i].disabled = false;
    }

    const allCheckboxElements = document.getElementById("taskCompletion").querySelectorAll("input[type=checkbox]");

    for (let i = 0; i < allCheckboxElements.length; i++) {
        allCheckboxElements[i].checked = false;
    }

    document.getElementById("taskCompletionMessage").innerHTML = "";

}


Tasks.snapshot();