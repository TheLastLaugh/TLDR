-- -----------------------------------------------------------------------------------------------*
-- ** READ ME FOR SET-UP INSTRUCTIONS **----------------------------------------------------------*
-- -----------------------------------------------------------------------------------------------*
-- 1. Opem XAMPP Manager                                                                          *
-- 2. Start All Servers in the "Manage Servers" tab                                               *
-- 3. Click to the "Welcome tab" and click "Go to Application"                                    *
-- 4. Once you have the XAMPP page open in your localhost,                                        *
--      click on the "phpMyAdmin" button on the page's header                                     *
-- 5. Once you have phpMyAdmin open, click on the "SQL" tab                                       *   
-- 6. Copy and paste the code below into the text box                                             *
-- 7. Click "Go" at the bottom of the page                                                        *
-- 8. You should now have a database called "TLDR" with all the tables and data                   *
-- 9. You can now run the application and test queries.                                           *
-- -----------------------------------------------------------------------------------------------*
-- ** If you mess something up and need to start again, just repeat the above steps.              *
-- ** The first couple lines of the database will drop the existing database and create a new one *
-- ** If you need to add more data, just add it to the bottom of the file and repeat steps 6-8    *
-- -----------------------------------------------------------------------------------------------*


SET @@AUTOCOMMIT = 1;

DROP DATABASE IF EXISTS TLDR;
CREATE DATABASE TLDR;

USE TLDR;

-- Each type of user is stored within this table, and identified by their user_type
CREATE TABLE users(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password char(255) NOT NULL,
    address varchar(100) NOT NULL,
    license varchar(100) NOT NULL UNIQUE,
    dob DATE NOT NULL,
    user_type ENUM('learner', 'instructor', 'government', 'qsd') NOT NULL
) AUTO_INCREMENT = 1;

-- This table stores the modules and their corresponding unit number and unit name
CREATE TABLE cbta_modules(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    unit_number int NOT NULL,
    unit_name varchar(255) NOT NULL,
    module_number int NOT NULL,
    module_name varchar(255) NOT NULL
);

-- This table stores the tasks that are associated with each module
CREATE TABLE cbta_module_tasks(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    module_number int NOT NULL,
    task_name varchar(255) NOT NULL,
    task_number int  NOT NULL
);

-- This table stores the descriptions of each task
CREATE TABLE cbta_module_task_description(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    module_number int NOT NULL,
    task_number int NOT NULL,
    module_task_listing varchar(255) NOT NULL,
    description TEXT NOT NULL
);

-- This table stores the types of lessons that can be booked (I have just set this to be the full module, but we can split it later if we want)
CREATE TABLE lessons (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    unit_number int NOT NULL,
    unit_name varchar(255) NOT NULL
);

-- REMIND ME TO TAKE THE USERNAME OUT OF THIS LATER I'M AN IDIOT 
-- This table stores the instructors, the lessons they offer, and the price of each lesson (They can be different for final drives etc)
CREATE TABLE instructors (
    user_id int NOT NULL PRIMARY KEY,
    username varchar(100) NOT NULL,
    company varchar(100) NOT NULL,
    company_address varchar(100) NOT NULL,
    phone int NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- This table stores the learners associated with an instructor (Can't use arrays in mysql rip)
CREATE TABLE instructor_learners (
    instructor_id int NOT NULL,
    learner_id int NOT NULL,
    FOREIGN KEY (instructor_id) REFERENCES users(id),
    FOREIGN KEY (learner_id) REFERENCES users(id)
);

-- This table stores the learners associated with a qsd (Can't use arrays in mysql rip)
CREATE TABLE qsd_learners (
    qsd_id int NOT NULL,
    learner_id int NOT NULL,
    FOREIGN KEY (qsd_id) REFERENCES users(id),
    FOREIGN KEY (learner_id) REFERENCES users(id)
);

-- This table has the times and dates that are available to be booked (unique to each instructor)
CREATE TABLE availability (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    instructor_id int NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    is_booked BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (instructor_id) REFERENCES users(id)
);

-- This table stores the bookings that have been made, linked to learner by their ID
CREATE TABLE bookings (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    learner_id int NOT NULL,
    availability_id int NOT NULL,
    booking_date DATE NOT NULL, 
    paid BOOLEAN NOT NULL DEFAULT FALSE,
    lesson_id int NOT NULL,
    FOREIGN KEY (learner_id) REFERENCES users(id),
    FOREIGN KEY (availability_id) REFERENCES availability(id)
);

-- This table stores the lessons that have been completed, linked to learner by their ID
CREATE TABLE completed_lessons (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    learner_id int NOT NULL,
    lesson_id int NOT NULL,
    completion_date DATE NOT NULL,
    FOREIGN KEY (learner_id) REFERENCES users(id),
    FOREIGN KEY (lesson_id) REFERENCES lessons(id)
);

-- This stores the payment methods that the learner has added to their account
CREATE TABLE payment_methods (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    learner_id int NOT NULL,
    method_name varchar(50) NOT NULL,
    address varchar(255) NOT NULL,
    card_type enum('visa', 'mastercard') NOT NULL,
    card_number char(16) NOT NULL,
    cvv char(3) NOT NULL,
    last_four_digits char(4) NOT NULL,
    expiry_month int NOT NULL,
    expiry_year int NOT NULL,
    FOREIGN KEY (learner_id) REFERENCES users(id)
);

-- This table holds all of the logbook entries that the learner has made
CREATE TABLE logbooks (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    learner_id int NOT NULL,
    qsd_id int NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    duration int NOT NULL,
    start_location varchar(255) NOT NULL,
    end_location varchar(255) NOT NULL,
    road_type enum('Sealed', 'Unsealed', 'Quiet Street', 'Busy Road', 'Multi-laned Road') NOT NULL,
    weather enum('Dry', 'Wet'),
    traffic enum('Light', 'Medium', 'Heavy'),
    qsd_name varchar(255) NOT NULL,
    qsd_license varchar(255) NOT NULL,
    confirmed BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (learner_id) REFERENCES users(id)
);

-- ------------------------------------------------------------------------------------------------*
-- ** BELOW ARE DEFAULT ENTRIES FOR EACH TABLE **-------------------------------------------------*
-- ------------------------------------------------------------------------------------------------*
-- Password is Password1! for all of these
INSERT INTO users (username, email, password, address, license, dob, user_type) VALUES
('Joe Rogan', 'learner@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Fake Street', '1', '1999-01-01', 'learner'), -- We can allow more entries for learner as they log in through the mySAGOV portal
('Brett Wilkinson', 'instructor@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Fake Street', '2', '1999-01-01', 'instructor'), -- same here but with the instructor portal
('government', 'admin@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Fake Street', '3', '1999-01-01', 'government'); -- not sure if we should have a gov login or just have an account with admin rights

-- Each lesson is the unit, I haven't included the modules since they're part of the unit, but we can add them if we want
INSERT INTO lessons (unit_number, unit_name) VALUES
(1, 'Basic driving procedures'),
(2, 'Slow speed manoeuvres'),
(3, 'Basic road skills'),
(4, 'Traffic management skills'),
(0, 'Units 1 and 2 - Review'),
(0, 'Units 3 and 4 - Review');

-- I just set the default price of each lesson (for the only default instructor) to be $50, but we can allow them to set their own prices when we make the page
INSERT INTO instructors (user_id, username, company, company_address, phone, price) VALUES
(2, 'Brett Wilkinson', 'Flinders', 'Tonsley', 0404040404, 50.00);

-- These are all of the modulees, split up by units. I've tried to keep them with the same number they have in the real logbook but there are some differences (outlined next to them)
INSERT INTO cbta_modules (unit_number, unit_name, module_number, module_name) VALUES
(1, 'Basic driving procedures', 1, 'Cabin drill and controls'),
(1, 'Basic driving procedures', 2, 'Starting up and shutting down the engine'),
(1, 'Basic driving procedures', 3, 'Moving off from the kerb'),
(1, 'Basic driving procedures', 4, 'Stopping and securing the vehicle'),
(1, 'Basic driving procedures', 5, 'Stop and go (using the park brake)'),
(1, 'Basic driving procedures', 6, 'Gear changing (up and down)'),
(1, 'Basic driving procedures', 7, 'Steering (forward and reverse)'),
(1, 'Basic driving procedures', 8, 'Review of all basic driving procedures'),

(2, 'Slow speed manoeuvres', 9, 'Moving off uphill'),
(2, 'Slow speed manoeuvres', 10, 'The U-turn'),
(2, 'Slow speed manoeuvres', 11, 'The 3-point turn'),
(2, 'Slow speed manoeuvres', 12, '90-degree angle park (front to kerb)'),
(2, 'Slow speed manoeuvres', 13, 'Reverse parallel parking'),
(2, 'Slow speed manoeuvres', 14, 'Review all slow speed manoeuvres'),

(3, 'Basic road skills', 15, 'Vehicle road positioning'),
(3, 'Basic road skills', 16, 'Lane changing and diverging/merging'),
(3, 'Basic road skills', 17, 'Turning at intersections'),
(3, 'Basic road skills', 18, 'Turning onto and from laned roads'),
(3, 'Basic road skills', 19, 'Negotiating roundabouts'),
(3, 'Basic road skills', 20, 'Negotiating traffic lights'),
(3, 'Basic road skills', 21, 'Light traffic urban driving'),
(3, 'Basic road skills', 22, 'Country driving (driving at higher speeds)'),

(4, 'Traffic management skills', 23, 'Safe driving strategies'),
(4, 'Traffic management skills', 24, 'Lane management in traffic'),
(4, 'Traffic management skills', 25, 'Turning in traffic'),
(4, 'Traffic management skills', 26, 'Managing traffic at roundabouts'),
(4, 'Traffic management skills', 27, 'U-turn in traffic manoeuvre'),
(4, 'Traffic management skills', 28, 'Negotiating traffic lights in traffic'), -- These 3 have the module numbers 28,A,B... idk maybe ill deal with it later
(4, 'Traffic management skills', 28, 'Driving on unsealed roads'),-- These 3 have the module numbers 28,A,B... idk maybe ill deal with it later
(4, 'Traffic management skills', 28, 'Driving at night'),-- These 3 have the module numbers 28,A,B... idk maybe ill deal with it later

(0, 'Units 1 and 2 - Review', 30, 'Review of basic driving skills'), -- These 2 don't have a unit number so I just set it to 0
(0, 'Units 3 and 4 - Review', 31, 'Review of road skills and traffic management'); -- These 2 don't have a unit number so I just set it to 0

-- Just have hour-long lessons from 9am to 5pm. We can let instructors add these later
-- I think this is the format SQL has to use for date and time so I'm not sure what the 
-- best way is to enter the info into the database but we'll cross that bridge later
INSERT INTO availability (instructor_id, start_time, end_time) VALUES
(2, '2023-08-24 09:00:00', '2023-08-24 10:00:00'),
(2, '2023-08-24 10:00:00', '2023-08-24 11:00:00'),
(2, '2023-08-24 11:00:00', '2023-08-24 12:00:00'),
(2, '2023-08-24 12:00:00', '2023-08-24 13:00:00'),
(2, '2023-08-24 13:00:00', '2023-08-24 14:00:00'),
(2, '2023-08-24 14:00:00', '2023-08-24 15:00:00'),
(2, '2023-08-24 15:00:00', '2023-08-24 16:00:00'),
(2, '2023-08-24 16:00:00', '2023-08-24 17:00:00');


-- Just some test bookings so that I can test the instructor logbook entries
INSERT INTO bookings (learner_id, availability_id, booking_date, lesson_id) VALUES
(1, 1, '2023-08-24', 1),
(1, 2, '2023-08-24', 2);

-- Default link between instructor and learner
INSERT INTO instructor_learners (instructor_id, learner_id) VALUES
(2, 1);

INSERT INTO cbta_module_tasks(module_number, task_name, task_number) VALUES
(1, "Cabin drill and controls", 1),
(2, "Starting the engine", 1),
(2, "Shutting down the engine", 2),
(3, "Moving off from the kerb", 1),
(4, "Stopping the vehicle (including slowing)", 1),
(4, "Securing the vehicle (to prevent rolling)", 2),
(5, "Stop and go (using the park brake)", 1),
(6, "Changing gears (up and down, manual and automatics)", 1),
(6, "Accurate selection of appropriate gears for varying speeds", 2),
(7, "Steering in a forward direction", 1),
(7, "Steering in reverse", 2),
(8, "Review all basic driving procedures", 1),
(9, "Stopping and securing the vehicle on a hill", 1),
(9, "Moving off uphill", 2),
(10, "Selecting a location for the U-turn", 1),
(10, "The 'U' turn", 2),
(11, "Selecting a locatino for the 3-point turn", 1),
(11, "The 3-point turn (U-turn including reversing)", 2),
(12, "Enter a 90 degree angle park (front to kerb)", 1),
(12, "Leaving a 90 degree angle park", 2),
(13, "Leaving a refined parallel parking bay", 1),
(13, "Parking in a confined parallel parking bay", 2),
(14, "Review all slow speed manoeuvres", 1),
(15, "Vehicle positioning on laned and unlaned roads", 1),
(15, "Maintain safe following distances and safety margins", 2),
(15, "Positioning for turns", 3),
(16, "Changing lanes procedure", 1),
(16, "Diverging or merging procedure", 2),
(17, "Turning at intersections (with a stop)", 1),
(17, "Turning at intersections (without a stop)", 2),
(17, "Negotiate 'Stop' and 'Give Way' signs/lines", 3),
(18, "Turning left onto and from laned roads", 1),
(18, "Turning right onto and from laned roads", 2),
(19, "Turning at unlaned roundabouts", 1),
(19, "Turning at laned roundabouts", 2),
(19, "Travelling straight on at a roundabout", 3),
(20, "Turning left and right at traffic lights (without arrows)", 1),
(20, "Following a straight course through traffic lights", 2),
(20, "Turning left through a slip lane (without arrows)", 3),
(21, "Pedestrian crossings, school zones and cross road intersections", 1),
(21, "Speed limits", 2),
(21, "Maintain reasonable progress", 3),
(22, "Negotiating bends and crests", 1),
(22, "Overtaking other vehicles", 2),
(23, "Safe positioning of the vehicle in traffic", 1),
(23, "'System of Car Control' as applied to traffic hazards", 2),
(24, "Lane selection in traffic", 1),
(24, "Lane changing in traffic", 2),
(25, "Turning left onto and from busy roads", 1),
(25, "Turning right onto and from busy roads", 2),
(26, "Managing traffic at unlaned roundabouts", 1),
(26, "Managing traffic at laned roundabouts", 2),
(27, "Selecting a safe U-turn starting position", 1),
(27, "Performing a safe and complete U-turn", 2),
(27, "Select a safe alternative to the U-turn due to traffic", 3),
(28, "Turning left and right at traffic lights (without arrows)", 1),
(28, "Following a straight course through traffic lights", 2),
(28, "Negotiating 'slip' lanes (without arrows)", 3),
(28, "Driving on unsealed roads", 4),
(28, "Recognition of current skills and knowledge", 5),
(28, "Driving at night", 6),
(28, "Demonstrate night driving", 7),
(29, "Review of all tasks in Unit 1", 1),
(29, "Review of all tasks in Unit 2", 2),
(30, "Review of road skills and traffic management", 1);

INSERT INTO cbta_module_task_description (module_number, task_number, module_task_listing, description) VALUES
(1, 1, '(a)', 'Ensure the doors are closed (and locked for security and safety - optional)'),
(1, 1, '(b)', 'Check that the park brake is firmly applied'),
(1, 1, '(c)', 'Adjust the seat, head restraint and steering wheel (as required)'),
(1, 1, '(d)', "Adjust all mirrors (electric mirrors, if fitted, may be adjusted after 'starting the engine' - Task 2)"),
(1, 1, '(e)', "Locate, identify and be able to use all vehicle controls (as required) when driving (including 'climate' controls)"),
(1, 1, '(f)', 'Perform all steps (a) to (e) in sequence'),
(1, 1, '(g)', 'Ensure all required seat belts are fastened correctly.'),
(2, 1, '(a)', 'If the park brake is not on, correctly apply it'),
(2, 1, '(b)', 'Clutch down to the floor and keep it down (manuals only)'),
(2, 1, '(c)', "Check gear lever in 'Neutral' (manuals) or 'Neutral/Park' (automatics)"),
(2, 1, '(d)', "Switch the ignition (key) to the 'ON' position"),
(2, 1, '(e)', 'Check all gauges and warning lights for operation'),
(2, 1, '(f)', 'Start the engine'),
(2, 1, '(g)', 'Check all gauges and warning lights again for operation; and'),
(2, 1, '(h)', 'Performs all steps 1(a) to 1(g) in sequence'),
(2, 2, '(a)', 'Bring the vehicle to a complete stop (clutch down-manuals)'),
(2, 2, '(b)', 'Secure the vehicle using the park brake'),
(2, 2, '(c)', "Select 'Neutral' (manuals) or 'Neutral/Park' (automatics)"),
(2, 2, '(d)', 'Release brake pedal (to check for rolling)'),
(2, 2, '(e)', 'Release clutch pedal (manuals only)'),
(2, 2, '(f)', 'Switch off appropriate controls (eg lights, air conditioner etc)'),
(2, 2, '(g)', 'Check all gauges and warning lights for operation'),
(2, 2, '(h)', "Turn ignition to 'OFF' or 'LOCK' position"),
(2, 2, '(i)', 'Perform all steps 2(a) to 2(h) in sequence'),
(3, 1, '(a)', 'If the park brake is not applied, correctly apply it'),
(3, 1, '(b)', 'Check the centre mirror, then the right mirror, then signal right for at least 5 seconds'),
(3, 1, '(c)', 'Push clutch pedal down (manuals) / Right foot on footbrake (automatics)'),
(3, 1, '(d)', "Select 1st gear (manuals) / Select 'Drive' (automatics)"),
(3, 1, '(e)', "Apply appropriate power, (and for manuals) clutch to 'friction point'"),
(3, 1, '(f)', 'Check the centre mirror again, then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic)'),
(3, 1, '(g)', 'If safe, look forward and release the park brake'),
(3, 1, '(h)', 'Accelerate smoothly away from the kerb without stalling or rolling back, and cancel the signal'),
(3, 1, '(i)', 'Perform all steps (a) to (h) in sequence'),
(4, 1, '(a)', 'Select appropriate stopping position'),
(4, 1, '(b)', 'Check the centre mirror, then the left mirror (for cyclists etc.) and signal left'),
(4, 1, '(c)', 'Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot'),
(4, 1, '(d)', '(For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake'),
(4, 1, '(e)', 'Bring vehicle to a smooth stop without jerking the vehicle'),
(4, 1, '(f)', 'Perform all steps 1(a) to 1 (e) in sequence'),
(4, 2, '(a)', 'Check that the vehicle has stopped (as above) and correctly apply the park brake to prevent rolling'),
(4, 2, '(b)', "Select 'Neutral' (manuals) or 'Park' (automatics)"),
(4, 2, '(c)', 'Release the brake pedal and then (for manuals) release the clutch'),
(4, 2, '(d)', 'Perform all steps 2(a) to 2(c) in sequence'),
(4, 2, '(e)', 'Cancel any signal after stopping'),
(5, 1, '(a)', 'Select the suitable stopping position on the road (e.g. - stop lines, positioning for view and proximity to other vehicles)'),
(5, 1, '(b)', 'Check the centre mirror, (then if required the appropriate side mirror), and if required signal intention'),
(5, 1, '(c)', 'Slow the vehicle smoothly using the footbrake only'),
(5, 1, '(d)', 'For manuals only, when the vehicle slows to just above stalling speed, push the clutch down'),
(5, 1, '(e)', 'For manuals only, just as the vehicle is stopping, select first gear'),
(5, 1, '(f)', 'When the vehicle comes to a complete stop, apply the park brake (holding the handbrake button in, where possible*) and release the footbrake (right foot placed over accelerator)'),
(5, 1, '(g)', 'Check that it is safe to move off and apply appropriate power (and for manuals, clutch to friction point)'),
(5, 1, '(h)', 'If safe, look forward and release the park brake which results in the vehicle immediately moving off in a smooth manner without stalling and under full control'),
(5, 1, '(i)', 'Perform all steps (a) to (h) in sequence'),
(6, 1, '(a)', 'Move off smoothly from a stationary position in first gear (manuals) or (automatics)'),
(6, 1, '(b)', 'Adjust the speed of the vehicle prior to selecting the new gear'),
(6, 1, '(c)', 'Change gears, one at a time from first gear (manuals) or the lowest gear (automatics) through to the highest gear without clashing, missing the gear, unnecessarily jerking the vehicle OR looking at the gear lever'),
(6, 1, '(d)', "Change gear from a high gear (4th, 5th or 'Drive') to various appropriate gears without significantly jerking the vehicle OR looking at the gear lever/selector"),
(6, 1, '(e)', 'Demonstrate full control (including steering) over the vehicle during gear changing'),
(6, 2, '(a)', 'Adjust the speed of the vehicle up and down and then select the appropriate gear for that speed (manuals and automatics)'),
(6, 2, '(b)', 'When the vehicle is moving, demonstrate all gear selections without looking at the gear lever or gear selector'),
(6, 2, '(c)', 'Demonstrate accurate selection of the gears without significant jerking of the vehicle or clashing of gears'),
(6, 2, '(d)', 'Demonstrate the selection of appropriate gears, whilst descending and ascending gradients'),
(6, 2, '(e)', 'Be able to select an appropriate gear to avoid unnecessary braking on descents and to have control on ascents'),
(7, 1, '(a)', 'Maintain a straight course of at least 100 metres between turns with the hands placed in approximately the “10 to 2” clock position on the steering wheel with a light grip pressure'),
(7, 1, '(b)', 'Demonstrate turning to the left and right through 90 degrees using either the “Pull-Push” or “Hand over Hand” method of steering while maintaining full vehicle control without over-steering'),
(7, 1, '(c)', 'Look in the direction where the driver is intending to go when turning (First Rule of Observation - Aim high in steering)'),
(7, 2, '(a)', 'Reverse the vehicle in a straight line for a minimum of 20 metres with a deviation not exceeding 1 metre, followed by step 2(b)'),
(7, 2, '(b)', 'Reverse the vehicle through an angle of approximately 90 degrees to the left followed by reversing in a straight line for 5 metres with a deviation not exceeding half a metre (500mm)'),
(7, 2, '(c)', 'Look in the appropriate directions and to the rear while reversing'),
(8, 1, '(a)', 'Demonstrate Task 1 - cabin drill and controls'),
(8, 1, '(b)', 'Demonstrate Task 2 - starting up and shutting down the engine'),
(8, 1, '(c)', 'Demonstrate Task 3 - moving off from the kerb'),
(8, 1, '(d)', 'Demonstrate Task 4 - stopping and securing the vehicle'),
(8, 1, '(e)', 'Demonstrate Task 5 - stop and go (using the park brake)'),
(8, 1, '(f)', 'Demonstrate Task 6 - gear changing (up and down)'),
(8, 1, '(g)', 'Demonstrate Task 7 - control of the steering (forward and reverse)'),
(9, 1, '(a)', 'Select a suitable safe and legal place on the gradient to stop'),
(9, 1, '(b)', 'Check the centre mirror, then the left mirror (for cyclists etc.), and signal left'),
(9, 1, '(c)', 'Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot'),
(9, 1, '(d)', '(For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake'),
(9, 1, '(e)', 'Bring vehicle to a smooth stop without jerking the vehicle'),
(9, 1, '(f)', 'Check that the vehicle has stopped (as above) and correctly apply the park brake to prevent rolling'),
(9, 1, '(g)', "Select 'Neutral' (manuals) or 'Park' (automatics), then release the brake pedal, then (for manuals) release the clutch"),
(9, 1, '(h)', 'Perform all steps 1(a) to 1(g) in sequence'),
(9, 1, '(i)', 'cancel any signal after stopping'),
(9, 2, '(a)', 'If the park brake is not applied, correctly apply it'),
(9, 2, '(b)', 'Check the centre mirror, then the right mirror, then signal right for at least 5 seconds'),
(9, 2, '(c)', 'Push clutch pedal down (manuals) / right foot on brake pedal (automatics)'),
(9, 2, '(d)', "Select first gear (manuals) / or select 'drive' (automatics)"),
(9, 2, '(e)', "Apply appropriate power to prevent rolling backwards and/or stalling, (and for manuals) bring the clutch to 'friction point' absorbing about half of the engine noise"),
(9, 2, '(f)', 'Check the centre mirror again then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic)'),
(9, 2, '(g)', 'If safe, look forward, release the park brake'),
(9, 2, '(h)', 'Accelerate smoothly from the kerb without stalling or rolling back, and then cancel the signal'),
(9, 2, '(i)', 'Perform all steps 2(a) to 2(h) in sequence while maintaining full control of the vehicle'),
(10, 1, '(a)', "Select a location where the U-turn is legally permitted, can be completed without reversing and is not in a 'No Stopping' area, or opposite parked vehicles or where visibility in any direction is poor"),
(10, 1, '(b)', 'Select a location where there is sufficient visibility in all directions to enable the U-turn to be done safely'),
(10, 1, '(c)', 'When stopping at the kerb comply with Task 4'),
(10, 2, '(a)', 'Comply with the Give Way rules (for U-turn) by giving way to all other traffic using the road during this manoeuvre'),
(10, 2, '(b)', "Comply with the 'moving off from the kerb' procedure where practicable as stated in Task 3"),
(10, 2, '(c)', 'Move the vehicle slowly forward (signalling appropriately) while turning the steering wheel (while not prohibited, dry/stationary steering is not encouraged) until on full steering lock (if required)'),
(10, 2, '(d)', 'Prior to the vehicle changing direction, observe in all directions for approaching traffic and other road users e.g. pedestrians (also paying attention to driveways and roads opposite)'),
(10, 2, '(e)', 'When safe, accelerate smoothly away without stalling or over-steering while maintaining full control of the vehicle'),
(11, 1, '(a)', 'Select a suitable safe and legal place at the kerb to stop'),
(11, 1, '(b)', 'Check the centre mirror, then the left mirror (for cyclists etc.) and signal left.'),
(11, 1, '(c)', 'Ensure that there are no obstructions next to the kerb forward of the centre of the vehicle on the left (reversing area)'),
(11, 1, '(d)', 'Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot'),
(11, 1, '(e)', '(For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake'),
(11, 1, '(f)', 'Bring vehicle to a smooth stop without jerking the vehicle'),
(11, 1, '(g)', 'Check that the vehicle has stopped'),
(11, 1, '(h)', 'If preparing to immediately commence the 3-point turn, ensure the correct gear has been selected in preparation to move off (apply park brake if required)'),
(11, 1, '(i)', 'If intending to fully secure the vehicle, apply the park brake and select neutral (manuals) or Park (automatics) and release the brake pedal and then (for manuals) release the clutch'),
(11, 1, '(j)', 'Perform all steps 1(a) to 1(h) in sequence'),
(11, 1, '(k)', 'Cancel any signal after stopping'),
(11, 2, '(a)', 'Check the centre mirror, then the right mirror, then signal right for at least 5 seconds'),
(11, 2, '(b)', "(If moving off from fully secured) Push clutch pedal down (manuals) / right foot on brake pedal (automatics) / select 1st gear (manuals) / select 'drive' (automatics)"),
(11, 2, '(c)', "Apply appropriate power, (and for manuals) clutch to 'friction point'"),
(11, 2, '(d)', 'Check the centre mirror again, then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic)'),
(11, 2, '(e)', 'If safe, look forward (release the park brake as required)'),
(11, 2, '(f)', 'Accelerate smoothly away from the kerb without stalling or rolling back while turning the steering wheel to the right (while not prohibited, dry/stationary steering is not encouraged) until on full steering lock (if required) and cancel the signal'),
(11, 2, '(g)', 'About 1 metre from the right kerb and whilst keeping the vehicle moving, turn the steering wheel sufficiently to the left (while not prohibited, dry/stationary steering is not encouraged)'),
(11, 2, '(h)', 'Stop before touching the kerb'),
(11, 2, '(i)', 'Select reverse gear, apply the park brake if required (holding the button in - optional) and check both directions and behind (over shoulders)'),
(11, 2, '(j)', 'Move off in reverse without rolling or stalling (continue steering left as required), under full control and continue checking in all directions (moving head and eyes) whilst reversing'),
(11, 2, '(k)', 'About 1 metre from the kerb whilst keeping the vehicle moving, steer sufficiently to the right (while not prohibited, dry/stationary steering is not encouraged); and prepare to move off down the road'),
(11, 2, '(l)', 'Stop before touching the kerb'),
(11, 2, '(m)', "Select first gear or 'Drive', apply the park brake if required (holding the button in - optional) and check both ways for traffic"),
(11, 2, '(n)', 'When safe, move off down the road maintaining full control of the vehicle without stalling or over-steering (aim high in steering)'),
(11, 2, '(o)', 'Perform all steps 2(a) to 2(n) in sequence'),
(12, 1, '(a)', 'Select a suitable parking bay, check the centre mirror, then check the appropriate side mirror, then apply the appropriate signal for sufficient time and slow the vehicle to a safe and controllable speed'),
(12, 1, '(b)', 'Choose the appropriate gear for control (if required)'),
(12, 1, '(c)', 'Check appropriate mirror/s or blind spot/s (for approaching vehicles and/or pedestrians) prior to turning into the parking bay'),
(12, 1, '(d)', 'Correctly position the vehicle, front to kerb, wholly within the bay (on the first attempt) while maintaining full control without touching the kerb:'),
(12, 1, '(d)(i)', 'Not more than 300 mm out of parallel with the lines'),
(12, 1, '(d)(ii)', 'Not more than 300 mm from the kerb or end of parking bay'),
(12, 1, '(d)(iii)', 'Where practicable, central within the parking bay with the front wheels pointing straight ahead towards the kerb'),
(12, 2, '(a)', 'Select reverse gear'),
(12, 2, '(b)', 'Constantly check behind (over shoulders), both sides and to the front before moving and during reversing'),
(12, 2, '(c)', 'Reverse slowly under full control of the vehicle and check for clearance of the front of the vehicle (where appropriate)'),
(12, 2, '(d)', 'Reverse the vehicle only for such a distance as is necessary and turn the steering wheel sufficiently to allow the vehicle to safely clear the parking bay alongside and counter steering sufficiently (while not prohibited, dry/stationary steering is not encouraged) in preparation to move off safely down the road without stalling or rolling'),
(12, 2, '(e)', 'Perform all steps above in sequence'),
(13, 1, '(a)', 'Prior to and during reversing, check right, left and behind (over shoulders) for other road users, including cyclists and pedestrians'),
(13, 1, '(b)', 'Check the centre mirror, then check the right mirror, then signal right for minimum of five (5) seconds whilst complying with Task 3 (moving off from the kerb); (use of the park brake is optional as required)'),
(13, 1, '(c)', 'Exit the parking bay without touching the poles and without driving between the pole and the kerb'),
(13, 1, '(d)', "Stop so that the rear of the vehicle is just past the parking bay's front pole and parallel to the kerb"),
(13, 2, '(a)', 'Prior to and during reversing, check right, left and behind (over shoulders) for other road users, including cyclists and pedestrians'),
(13, 2, '(b)', 'Check all around prior to turning the wheel to the left when reversing into the bay'),
(13, 2, '(c)', 'After entering the parking bay, complete the exercise with no more than two directional changes (i.e. changes direction to drive forward to straighten, then changes direction for the second time to centralise between the poles)'),
(13, 2, '(d)', 'Parallel park the vehicle so that the left wheels are within 300mm of the kerb and straight, and centrally located not less than 900mm to the nearest pole'),
(13, 2, '(e)', 'The wheels must not touch the kerb and the vehicle must not touch any pole or pass between any pole and the kerb'),
(13, 2, '(f)', 'Maintain full control of the vehicle (without stalling)'),
(14, 1, '(a)', "Demonstrate one complete example of Task 9 ('stopping and securing the vehicle on a hill' and 'moving off uphill' procedure) on request"),
(14, 1, '(b)', "Demonstrate one complete example of Task 10 ('the U-turn') on request"),
(14, 1, '(c)', "Demonstrate one complete example of Task 11 ('the 3-point turn') on request"),
(14, 1, '(d)', "Demonstrate one complete example of Task 12 ('entering and leaving a 90 degree angle park') on request"),
(14, 1, '(e)', "Demonstrate one complete example of Task 13 ('reverse parallel parking') on request"),
(15, 1, '(a)', 'Keep the vehicle as near as practicable to the left on unlaned roads without unnecessarily obstructing other traffic'),
(15, 1, '(b)', 'Keep the vehicle wholly within the marked lane when travelling straight or in bends'),
(15, 1, '(c)', 'Use the space within the lane to maintain safety margins'),
(15, 2, '(a)', 'Maintain a minimum of three (3) seconds following interval (see page 17) from the vehicle in front'),
(15, 2, '(b)', 'Allow a safety margin of at least 1.2 m (where practicable) when passing objects, vehicles/obstructions'),
(15, 2, '(c)', 'Allow a minimum safety margin of 1 metre when passing a cyclist where the speed limit is 60kmh or less, and 1.5 metres where the speed limit is over 60kmh'),
(15, 2, '(d)', 'Stop in a position behind other vehicles allowing sufficient space to turn away from the vehicle in front if necessary'),
(15, 3, '(a)', "Correctly position the vehicle at 'Stop' lines (associated with 'Stop' signs, crossings and traffic lights etc.)"),
(15, 3, '(b)', 'Demonstrate appropriate road position at intersections when view is obstructed'),
(15, 3, '(c)', 'Demonstrate the correct approach and turn positions for turning left and right at intersections in accordance with the law'),
(16, 1, '(a)', 'Select a suitable location (not approaching traffic lights etc.)'),
(16, 1, '(b)', "Accurately apply the 'System of Car Control' when changing from one lane to another (either left or right)"),
(16, 1, '(c)', 'Check the appropriate blind spot just before changing to the new lane'),
(16, 2, '(a)', 'When attempting to diverge, merge or zip merge ensure the vehicle is not directly alongside another vehicle (i.e. where practicable keep the vehicle off-set to others - Rules of Observation)'),
(16, 2, '(b)', "When merging or diverging by more than 1 metre or crossing a lane line, comply with the 'Lane Changing Procedure'(steps 1(a) to 3(c)) above and give way rules"),
(16, 2, '(c)', 'When merging or diverging by less than 1 metre, or diverging over a long distance when passing parked vehicles on an unlaned road, comply with step 1(b) above except signals and blind spots may be omitted only if safe'),
(16, 2, '(d)', 'When merging with the flow of traffic, ensure that adequate speed is achieved prior to entering. The merge must have minimal impact on other road users (freeway on-ramps, extended slip lanes etc.)'),
(16, 2, '(e)', 'When zip merging, pay particular attention when approaching signs and lane markings'),
(17, 1, '(a)', 'Demonstrate turning left and right at intersections incorporating a stop while complying with the laws for turning'),
(17, 1, '(b)', "Demonstrate the 'System of Car Control' when turning right and left at intersections"),
(17, 1, '(c)', "Demonstrate safe observation patterns (Rules of Observation) while maintaining full vehicle contro"),
(17, 1, '(d)', "Comply with signalling requirements, 'Stop' and 'Give Way' signs and lines, and the give way rules at all times"),
(17, 2, '(a)', "Demonstrate turning left and right at intersections without a stop where practicable while complying with the laws for turning"),
(17, 2, '(b)', "Demonstrate the 'System of Car Control' when turning right and left at intersections"),
(17, 2, '(c)', "Demonstrate correct and timely observation patterns when turning left and right at intersections while maintaining full control of the vehicle"),
(17, 2, '(d)', "Comply with signalling and 'Give Way' rules"),
(17, 3, '(a)', "Comply with the 'System of Car Control' when negotiating 'Stop' and 'Give Way' signs and lines"),
(17, 3, '(b)', "Comply with 'Stop' and 'Give Way' signs and lines"),
(18, 1, '(a)', "Comply with all laws relating to signalling, turning and 'Giving Way'"),
(18, 1, '(b)', 'Approach every turn at a safe speed under full control'),
(18, 1, '(c)', 'Correct and timely observation of any conflicting traffic when turning left'),
(18, 1, '(d)', 'Apply appropriate acceleration during and after turning when entering the traffic flow of the other road'),
(18, 1, '(e)', "Comply with the 'System of Car Control'"),
(18, 2, '(a)', "Comply with all laws relating to signalling, turning and 'Giving Way'"),
(18, 2, '(b)', 'Approach every turn at a safe speed under full control'),
(18, 2, '(c)', 'Correct and timely observation of any conflicting traffic when turning right'),
(18, 2, '(d)', 'Apply appropriate acceleration during and after turning when entering the traffic flow of the other road'),
(18, 2, '(e)', "Comply with the 'System of Car Control'"),
(19, 1, '(a)', 'Comply with give way rules, signalling and correct vehicle positioning at unlaned roundabouts'),
(19, 1, '(b)', 'Negotiate every roundabout at a safe speed under full control'),
(19, 1, '(c)', 'Observe in the appropriate directions when approaching and during turns at unlaned roundabouts'),
(19, 1, '(d)', "Comply with the 'System of Car Control'"),
(19, 2, '(a)', 'Demonstrate compliance with give way rules, signalling, arrows and correct vehicle positioning at roundabouts'),
(19, 2, '(b)', 'Negotiate every roundabout at a safe speed under full control'),
(19, 2, '(c)', 'Observe in the appropriate directions when approaching and during turns at laned roundabouts'),
(19, 2, '(d)', "Comply with the 'System of Car Control'"),
(19, 3, '(a)', 'Demonstrate compliance with give way rules, signalling, arrows and co roundabout'),
(19, 3, '(b)', 'Negotiate every roundabout at a safe speed under full control'),
(19, 3, '(c)', 'Look in the appropriate directions when approaching and proceding through roundabouts'),
(19, 3, '(d)', "Comply with the 'System of Car Control'"),
(20, 1, '(a)', 'Comply with the law for traffic light signals, associated stop lines, turning lines and arrows'),
(20, 1, '(b)', 'Enter and correctly position vehicle lawfully within the intersection when stopping to give way to opposing traffic'),
(20, 1, '(c)', 'When turning right, keep the front wheels straight (where practicable) while waiting to give way to on-coming traffic'),
(20, 1, '(d)', 'Comply with Tasks 17 and 18 requirements when turning'),
(20, 2, '(a)', 'Comply with the law for traffic light signals and associated stop lines'),
(20, 2, '(b)', "Comply with 'System of Car Control' approaching lights"),
(20, 2, '(c)', 'Apply correct stopping procedure (Task 4) as applicable'),
(20, 3, '(a)', "Comply with all 'Give Way', signalling and road law"),
(20, 3, '(b)', 'Comply with turning left requirements for Tasks 17 and 18 including safe speed of approach to the turn'),
(20, 3, '(c)', "Demonstrate appropriate and timely observation patterns, and 'System of Car Control'"),
(21, 1, '(a)', 'Comply with the laws for pedestrian crossings and school zones'),
(21, 1, '(b)', "Accurately comply with the 'System of Car Control' at all cross road intersections on unlaned roads (centre mirror must be checked prior to observation)"),
(21, 2, '(a)', 'Comply with all speed limits in speed zones and built-up areas whilst demonstrating awareness of changing speed limits'),
(21, 2, '(b)', 'Comply with speed limits for bridges, roadworks, schools, car parks and learner requirements'),
(21, 3, '(a)', 'Where safe and practicable, maintain a speed which is within 5 km/h of the legal speed limit but does not exceed the speed limit'),
(21, 3, '(b)', 'Move off in a line of traffic without any unnecessary delay or obstructing other traffic'),
(21, 3, '(c)', 'Does not slow excessively or stop unnecessarily at intersections where the view is open and clear, and it is safe to go'),
(21, 3, '(d)', "Maintain at least a '3 second' following distance between the vehicle in front and the learner's vehicle"),
(22, 1, '(a)', "Comply with speed limits, road markings, keeping left and 'Due Care' requirements while maintaining reasonable progress"),
(22, 1, '(b)', 'Demonstrate a safe speed and position of approach to all bends and crests'),
(22, 1, '(c)', "Comply with 'System of Car Control' approaching bends and crests (including selection of the correct gear before the bend or crest)"),
(22, 1, '(d)', "Comply with the Rules of Braking and 'acceleration sense' approaching bends and crests"),
(22, 1, '(e)', 'Comply with the Rules of Steering when braking and cornering'),
(22, 1, '(f)', 'Demonstrate good forward observation (Aim high in steering) and complies with the Rules of Observation'),
(22, 1, '(g)', 'Display safe and complete control of the vehicle at all times'),
(22, 2, '(a)', 'Correctly select a safe and suitable location to overtake while complying with the law (road markings, sufficient clear view)'),
(22, 2, '(b)', 'Maintain a reasonable following distance before overtaking in order to comply with the Rules of Observation'),
(22, 2, '(c)', "Comply with 'System of Car Control' and use appropriate gears and acceleration where necessary"),
(22, 2, '(d)', 'If suitable overtaking situations do not occur, verbally demonstrate to the Authorised Examiner the selection of five safe and suitable locations where there is sufficient distance to overtake safely'),
(23, 1, '(a)', "Keep at least 3 seconds time interval between the learner's vehicle and the vehicle in front, increasing this interval for adverse weather conditions or if being closely followed"),
(23, 1, '(b)', 'Where safe and practicable, keep at least 1.2 metre clearance when passing parked vehicles, or other hazards'),
(23, 1, '(c)', 'Allow a minimum safety margin of 1 metre when passing a cyclist where the speed limit is 60kmh or less, and 1.5 metres where the speed limit is over 60kmh'),
(23, 1, '(d)', "Adjust the vehicle's position by holding back if the vehicle in front obstructs the view ahead (Observation - Get the big picture)"),
(23, 1, '(e)', "Maintain the vehicle's position in a line of traffic without obstructing following traffic where it is safe and legal to do so"),
(23, 1, '(f)', 'Avoid unnecessary travel in blind spots of other vehicles (Observation - Leave yourself an OUT)'),
(23, 1, '(g)', 'Where practicable, stop in a position behind other vehicles to allow sufficient space to turn away from the vehicle in front'),
(23, 1, '(h)', 'Without obstructing the intersection stop in a line of traffic (road law)'),
(23, 1, '(i)', 'Comply with all appropriate road rules'),
(23, 2, '(a)', "Comply with the features of the 'System of Car Control' in the correct sequence when approaching hazards in traffic"),
(23, 2, '(b)', "Comply with 'System of Car Control' when approaching traffic lights (eg. check mirror, cover the brake, etc.)"),
(23, 2, '(c)', "Demonstrate 'System of Car Control' when passing stationary buses or other similar hazards"),
(23, 2, '(d)', "Demonstrate 'System of Car Control' when giving way"),
(24, 1, '(a)', 'Identify potential hazards well in advance and take safe and appropriate action (Observation - Get the Big Picture)'),
(24, 1, '(b)', 'Confidently select safe gaps when changing lanes'),
(24, 1, '(c)', "Select suitable and timely locations when changing lanes ('System of Car Control' - select the course)"),
(24, 2, '(a)', "Competently apply the 'System of Car Control' when changing from one lane to another (either left or right)"),
(24, 2, '(b)', 'Check the appropriate blind spot just before changing lanes'),
(24, 2, '(c)', 'Co-operate with other drivers by accepting and giving reasonable offers of courtesy when safe'),
(24, 2, '(d)', 'Change lanes in traffic only when safe without significantly interfering with the flow of traffic in the newly selected lane'),
(25, 1, '(a)', "Display compliance with all 'Give Way' and 'turning' rules (observation, braking and steering)"),
(25, 1, '(b)', 'Maintain full vehicle control throughout each turn (ie. no wide exits, question-mark turns, or stalls)'),
(25, 1, '(c)', 'When exiting or entering a busy road, keep as near as reasonably practicable to the left'),
(25, 1, '(d)', "Comply with the 'System of Car Control' throughout the assessment"),
(25, 1, '(e)', 'Display competent selection of safe gaps when entering a traffic flow'),
(25, 1, '(f)', "Display competent acceleration skills when entering a gap (See 'System of Car Control')"),
(25, 2, '(a)', "Display compliance with all 'Give Way' and turning rules (observation, braking and steering)"),
(25, 2, '(b)', 'Maintain full vehicle control throughout each turn (ie. no wide exits, question-mark turns, or stalls)'),
(25, 2, '(c)', "Comply with the 'System of Car Control' throughout the assessment"),
(25, 2, '(d)', 'Make early selection of the most appropriate and lawful lane for turning'),
(25, 2, '(e)', 'Display competent selection of safe gaps when entering or crossing a traffic flow when turning right'),
(25, 2, '(f)', "Display competent acceleration skills when entering a safe gap or crossing a flow of traffic - (See 'System of Car Control')"),
(26, 1, '(a)', 'Comply with the requirements and standard as documented in Task 19 (1) - turning at unlaned roundabouts'),
(26, 1, '(b)', 'Display competent and confident decision making when selecting safe gaps in traffic on the roundabout'),
(26, 1, '(c)', 'Demonstrate competent use of acceleration when joining and leaving a traffic stream on the carriageway of the roundabout'),
(26, 2, '(a)', 'Comply with the requirements and standard as documented in Task 19 (2) - turning at laned roundabouts'),
(26, 2, '(b)', 'Demonstrate early selection of correct lanes before, during and after turning or when travelling straight on at the roundabout'),
(26, 2, '(c)', 'Display competent and confident decision making when selecting safe gaps in traffic at the roundabout'),
(26, 2, '(d)', 'Demonstrate competent use of acceleration when joining and leaving a traffic stream on the carriageway of the roundabout'),
(27, 1, '(a)', "Select a suitable position whilst complying with 'System of Car Control'"),
(27, 1, '(b)', 'Select a position where only one major flow of traffic is required to be crossed during the U-turn'),
(27, 1, '(c)', 'Select the most appropriate position that minimises the disruption to overtaking or following traffic for that road (eg. a right turn store lane opposite a quiet road)'),
(27, 2, '(a)', "Comply with all road markings, and the 'Give Way' rules for turning and moving off (as required)"),
(27, 2, '(b)', 'Confidently select a safe gap in the traffic flow when presented'),
(27, 2, '(c)', 'Use safe stopping areas within the U-turn as required'),
(27, 2, '(d)', 'Complete the U-turn safely without reversing while maintaining full control of the vehicle'),
(27, 3, '(a)', 'If traffic conditions change where the U-turn could become confusing or dangerous to any road users, select an acceptable safe option'),
(27, 3, '(b)', 'Perform the optional action with safety'),
(28, 1, '(a)', 'Comply with Task 20'),
(28, 1, '(b)', 'While waiting to turn right or left , correctly position the vehicle within the intersection when permitted by the traffic lights'),
(28, 1, '(c)', 'Demonstrate confident selection of safe gaps when turning into or across a traffic flow'),
(28, 1, '(d)', 'Display appropriate use of acceleration for safety during the turn while maintaining full control of the vehicle'),
(28, 1, '(e)', 'Ensure that other vehicles are not unnecessarily obstructed when turning'),
(28, 2, '(a)', 'Comply with Task 20'),
(28, 2, '(b)', 'Display correct and confident decision making on approach to traffic lights having regard for weather, road conditions and following traffic (type of vehicle and how near they are)'),
(28, 3, '(a)', 'Comply with Task 20'),
(28, 3, '(b)', "Demonstrate confident selection of safe gaps when turning left through a 'slip' lane into a flow of traffic"),
(28, 3, '(c)', 'Display appropriate use of acceleration for safety during and after the turn while maintaining full control of the vehicle'),
(28, 4, '(i)(a)', 'Demonstrate compliance with all appropriate road laws (eg. as near as practicable to the left, etc.)'),
(28, 4, '(i)(b)', 'Maintain full control of the vehicle at all times (skidding or sliding at any time is considered to be loss of control - see system of car control)'),
(28, 4, '(i)(c)', 'Demonstrate a safe speed of approach to bends, crests and intersections at all times'),
(28, 4, '(i)(d)', 'Demonstrate safe and correct entry lines into bends (for good view and being seen - Rules of Observation)'),
(28, 4, '(i)(e)', 'Demonstrate safe and correct exit lines from bends (ensuring the vehicle leaves the bend on the correct side of the road - if any part of the vehicle strays onto the incorrect side of the road it is a road law fault – see step (a))'),
(28, 4, '(i)(f)', "Comply with the 'System of Car Control', Rules of Braking, Steering and Observation"),
(28, 4, '(i)(g)', 'Correctly adjust speed to that which is suitable to any change of road surface'),
(28, 4, '(i)(h)', 'Correctly adjust the following distance and use headlights as required when following another vehicle (eg. decreased visibility due to dust etc.)'),
(28, 4, '(i)(i)', 'Correctly adjust the speed (minimum use of the accelerator) when passing another vehicle travelling in the opposite direction (to reduce the risk of possible windscreen damage)'),
(28, 5, '(ii)(a)', "Question learner on speed limits, keeping to the left, 3-Second Rule Formula, Use of headlights, 'System of Car Control', Rules of Braking, Steering and Observation; and"),
(28, 6, '(ii)(a)', 'Explain adjustments required in speed and positioning in regard to visual deficiencies.'),
(28, 6, '(ii)(b)', 'Explain the requirements in relation to clean windscreens and headlights.'),
(28, 6, '(ii)(c)', 'Explain the requirements in relation to dipping headlights. (eg when following within 200m from the rear of other traffic and when approaching vehicle reaches a point 200m from your vehicle or immediately the headlights of an approaching vehicle are dipped, whichever is sooner).'),
(28, 6, '(ii)(d)', 'Explain the confusion that may occur when driving in built up areas due to the mixture of neon signs, traffic lights, store lights, street lighting, etc.'),
(28, 6, '(ii)(e)', "Explain the need to be 'seen' (eg do not forget to turn on headlights). Explain the lack of visual eye contact with other road users."),
(28, 6, '(ii)(f)', "Demonstrate correct application of 'System'."),
(28, 7, '(iii)(a)', 'Trainee to demonstrate under full instruction.'),
(28, 7, '(iii)(b)', 'Trainee to demonstrate with instruction as required; and'),
(28, 7, '(iii)(c)', 'Trainee to practice until competent.'),
(29, 1, '(a)', 'Accurately perform Task 1 - cabin drill and controls'),
(29, 1, '(b)', 'Accurately perform Task 2 - starting up and shutting down the engine'),
(29, 1, '(c)', 'Accurately perform Task 3 - moving off from the kerb'),
(29, 1, '(d)', 'Accurately perform Task 4 - stopping and securing the vehicle'),
(29, 1, '(e)', 'Accurately perform Task 5 - stop and go (using the park brake)'),
(29, 1, '(f)', 'Accurately demonstrate Task 6 - gear changing'),
(29, 1, '(g)', 'Accurately demonstrate Task 7 - control of the steering (forward and reverse)'),
(29, 2, '(a)', 'Accurately perform Task 9 - stopping and securing the vehicle on a hill and moving off uphill'),
(29, 2, '(b)', 'Accurately perform Task 10 - the U-turn'),
(29, 2, '(c)', 'Accurately perform Task 11 - the 3-point turn'),
(29, 2, '(d)', 'Accurately perform Task 12 - entering and leaving a 90 degree angle park'),
(29, 2, '(e)', 'Accurately perform Task 13 - reverse parallel parking'),
(30, 1, '(a)', 'Comply with all road laws'),
(30, 1, '(b)', "Comply with the 'System of Car Control' to left and right turns, traffic lights, stopping, lane changes and other potential traffic hazards"),
(30, 1, '(c)', 'Comply with the Rules of Braking, Steering and Observation'),
(30, 1, '(d)', 'Demonstrate appropriate forward planning, correct and timely road positioning, and safe driving strategies');

-- This part is important for testing since you'll need all mod rights. I'm not sure if we have to change this later for the submission
CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON TLDR TO dbadmin@localhost;