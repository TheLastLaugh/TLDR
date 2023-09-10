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

    document.getElementById('taskCompletion').addEventListener('submit', function(event) {

        event.preventDefault();
        console.log(event);
        Tasks.complete(event.target[0].value, event.target[1].value); 
    
    });

}

class Tasks {

    static snapshot () {

        var params= `action=snapshot`;
    
        var xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                const result = JSON.parse(xhttp.responseText);
                for (let i = 0; i < result.length; i++) {
                    let taskDescription = document.getElementById(`unit-${i+1}`).innerHTML;
                    document.getElementById(`unit-${i+1}`).innerHTML = `${taskDescription} ( Total Tasks: ${result[i].total}, Completed: ${result[i].completed}, Incomplete: ${result[i].incomplete})`;
                    for (let j = 0; j < result[i].tasks.length; j++) {
                        if (result[i].tasks[j].completed == 1) {
                            document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.remove("incomplete"); 
                            document.getElementById(`task-${result[i].tasks[j].task}-status`).classList.add("complete");
                            document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                          </svg> Task Completed`;
                        } 
                        
                        // else {
                        //     document.getElementById(`task-${result[i].tasks[j].task}-status`).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        //     <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        //     <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        //   </svg> Task incomplete`;
                        // }
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
        <h2>Unit ${unit}: Task ${task} - ${taskDescription}</h2>
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
            </div>

            <div class="stat-card">
                <h3>Actions</h3>
                <button type="button" onclick="Tasks.taskAction('student_followup', ${unitNumber}, ${taskNumber})">Flag for student practice</button>
                <button type="button" onclick="Tasks.taskAction('instructor_followup', ${unitNumber}, ${taskNumber})">Flag for instructor follow-up</button>
                <button type="button" onclick="Tasks.taskAction('incomplete-task', ${unitNumber}, ${taskNumber})">Mark task incomplete</button>
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
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='12'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='2'></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='2'></td>
                            <td><input type="checkbox" required></td>
                            <td><input type="checkbox" required></td>
                        </tr>

                        <tr>
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
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
                            <td colspan='4'><input type="submit" value="Mark task completed"></td>
                        <tr>

                    </table>

                </form>`
        }

        return task;

    }

}

Tasks.snapshot();