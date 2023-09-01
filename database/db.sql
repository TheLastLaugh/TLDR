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
    username varchar(100) NOT NULL UNIQUE,
    email varchar(100) NOT NULL UNIQUE,
    password char(255) NOT NULL,
    address varchar(100) NOT NULL,
    license varchar(100) NOT NULL,
    dob DATE NOT NULL,
    user_type ENUM('learner', 'instructor', 'government') NOT NULL,
    updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) AUTO_INCREMENT = 1;

-- This table stores the modules and their corresponding unit number and unit name
CREATE TABLE cbta_modules(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    unit_number int NOT NULL,
    unit_name varchar(255) NOT NULL,
    module_number int NOT NULL,
    module_name varchar(255) NOT NULL
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
    user_id int NOT NULL,
    username varchar(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
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

-- ------------------------------------------------------------------------------------------------*
-- ** BELOW ARE DEFAULT ENTRIES FOR EACH TABLE **-------------------------------------------------*
-- ------------------------------------------------------------------------------------------------*

INSERT INTO users (username, password, address, license, dob, user_type) VALUES
('Joe Rogan', 'password', '123 Fake Street', '123456789', '1999-01-01', 'learner'), -- We can allow more entries for learner as they log in through the mySAGOV portal
('Brett Wilkinson', 'password', '123 Fake Street', '123456789', '1999-01-01', 'instructor'), -- same here but with the instructor portal
('government', 'password', '123 Fake Street', '123456789', '1999-01-01', 'government'); -- not sure if we should have a gov login or just have an account with admin rights

-- Each lesson is the unit, I haven't included the modules since they're part of the unit, but we can add them if we want
INSERT INTO lessons (unit_number, unit_name) VALUES
(1, 'Basic driving procedures'),
(2, 'Slow speed manoeuvres'),
(3, 'Basic road skills'),
(4, 'Traffic management skills'),
(0, 'Units 1 and 2 - Review'),
(0, 'Units 3 and 4 - Review');

-- I just set the default price of each lesson (for the only default instructor) to be $50, but we can allow them to set their own prices when we make the page
INSERT INTO instructors (user_id, username, price) VALUES
(2, 'Brett Wilkinson', 50.00);

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

-- This part is important for testing since you'll need all mod rights. I'm not sure if we have to change this later for the submission
CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON TLDR TO dbadmin@localhost;