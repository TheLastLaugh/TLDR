-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2023 at 06:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `tldr`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `paid` tinyint(1) DEFAULT 0,
  `paid_date` date DEFAULT NULL,
  `hourly_rate` decimal(10,2) NOT NULL,
  `billed_minutes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `learner_id`, `instructor_id`, `issue_date`, `due_date`, `paid`, `paid_date`, `hourly_rate`, `billed_minutes`) VALUES
(1, 1, 2, '2023-09-14', '2023-09-28', 0, NULL, 100.00, 60),
(2, 1, 2, '2023-09-14', '2023-09-28', 0, NULL, 100.00, 90),
(3, 1, 2, '2023-09-14', '2023-09-28', 0, NULL, 100.00, 60),
(4, 5, 2, '2023-09-14', '2023-09-28', 0, NULL, 75.00, 120);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `pickup_location` char(100) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `instructor_id`, `learner_id`, `booking_date`, `booking_time`, `pickup_location`, `paid`) VALUES
(1, 2, 1, '2023-10-11', '10:00:00', 'Tonsley Campus', 1),
(2, 7, 1, '2023-10-11', '11:00:00', 'Tonsley Campus', 0),
(3, 7, 5, '2023-10-11', '12:00:00', 'Yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cbta_modules`
--

DROP TABLE IF EXISTS `cbta_modules`;
CREATE TABLE `cbta_modules` (
  `id` int(11) NOT NULL,
  `unit_number` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `module_number` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cbta_modules`
--

INSERT INTO `cbta_modules` (`id`, `unit_number`, `unit_name`, `module_number`, `module_name`) VALUES
(1, 1, 'Basic driving procedures', 1, 'Cabin drill and controls'),
(2, 1, 'Basic driving procedures', 2, 'Starting up and shutting down the engine'),
(3, 1, 'Basic driving procedures', 3, 'Moving off from the kerb'),
(4, 1, 'Basic driving procedures', 4, 'Stopping and securing the vehicle'),
(5, 1, 'Basic driving procedures', 5, 'Stop and go (using the park brake)'),
(6, 1, 'Basic driving procedures', 6, 'Gear changing (up and down)'),
(7, 1, 'Basic driving procedures', 7, 'Steering (forward and reverse)'),
(8, 1, 'Basic driving procedures', 8, 'Review of all basic driving procedures'),
(9, 2, 'Slow speed manoeuvres', 9, 'Moving off uphill'),
(10, 2, 'Slow speed manoeuvres', 10, 'The U-turn'),
(11, 2, 'Slow speed manoeuvres', 11, 'The 3-point turn'),
(12, 2, 'Slow speed manoeuvres', 12, '90-degree angle park (front to kerb)'),
(13, 2, 'Slow speed manoeuvres', 13, 'Reverse parallel parking'),
(14, 2, 'Slow speed manoeuvres', 14, 'Review all slow speed manoeuvres'),
(15, 3, 'Basic road skills', 15, 'Vehicle road positioning'),
(16, 3, 'Basic road skills', 16, 'Lane changing and diverging/merging'),
(17, 3, 'Basic road skills', 17, 'Turning at intersections'),
(18, 3, 'Basic road skills', 18, 'Turning onto and from laned roads'),
(19, 3, 'Basic road skills', 19, 'Negotiating roundabouts'),
(20, 3, 'Basic road skills', 20, 'Negotiating traffic lights'),
(21, 3, 'Basic road skills', 21, 'Light traffic urban driving'),
(22, 3, 'Basic road skills', 22, 'Country driving (driving at higher speeds)'),
(23, 4, 'Traffic management skills', 23, 'Safe driving strategies'),
(24, 4, 'Traffic management skills', 24, 'Lane management in traffic'),
(25, 4, 'Traffic management skills', 25, 'Turning in traffic'),
(26, 4, 'Traffic management skills', 26, 'Managing traffic at roundabouts'),
(27, 4, 'Traffic management skills', 27, 'U-turn in traffic manoeuvre'),
(28, 4, 'Traffic management skills', 28, 'Negotiating traffic lights in traffic'),
(29, 4, 'Traffic management skills', 28, 'Driving on unsealed roads'),
(30, 4, 'Traffic management skills', 28, 'Driving at night'),
(31, 0, 'Units 1 and 2 - Review', 30, 'Review of basic driving skills'),
(32, 0, 'Units 3 and 4 - Review', 31, 'Review of road skills and traffic management');

-- --------------------------------------------------------

--
-- Table structure for table `cbta_module_tasks`
--

DROP TABLE IF EXISTS `cbta_module_tasks`;
CREATE TABLE `cbta_module_tasks` (
  `id` int(11) NOT NULL,
  `module_number` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cbta_module_tasks`
--

INSERT INTO `cbta_module_tasks` (`id`, `module_number`, `task_name`, `task_number`) VALUES
(1, 1, 'Cabin drill and controls', 1),
(2, 2, 'Starting the engine', 1),
(3, 2, 'Shutting down the engine', 2),
(4, 3, 'Moving off from the kerb', 1),
(5, 4, 'Stopping the vehicle (including slowing)', 1),
(6, 4, 'Securing the vehicle (to prevent rolling)', 2),
(7, 5, 'Stop and go (using the park brake)', 1),
(8, 6, 'Changing gears (up and down, manual and automatics)', 1),
(9, 6, 'Accurate selection of appropriate gears for varying speeds', 2),
(10, 7, 'Steering in a forward direction', 1),
(11, 7, 'Steering in reverse', 2),
(12, 8, 'Review all basic driving procedures', 1),
(13, 9, 'Stopping and securing the vehicle on a hill', 1),
(14, 9, 'Moving off uphill', 2),
(15, 10, 'Selecting a location for the U-turn', 1),
(16, 10, 'The \'U\' turn', 2),
(17, 11, 'Selecting a locatino for the 3-point turn', 1),
(18, 11, 'The 3-point turn (U-turn including reversing)', 2),
(19, 12, 'Enter a 90 degree angle park (front to kerb)', 1),
(20, 12, 'Leaving a 90 degree angle park', 2),
(21, 13, 'Leaving a refined parallel parking bay', 1),
(22, 13, 'Parking in a confined parallel parking bay', 2),
(23, 14, 'Review all slow speed manoeuvres', 1),
(24, 15, 'Vehicle positioning on laned and unlaned roads', 1),
(25, 15, 'Maintain safe following distances and safety margins', 2),
(26, 15, 'Positioning for turns', 3),
(27, 16, 'Changing lanes procedure', 1),
(28, 16, 'Diverging or merging procedure', 2),
(29, 17, 'Turning at intersections (with a stop)', 1),
(30, 17, 'Turning at intersections (without a stop)', 2),
(31, 17, 'Negotiate \'Stop\' and \'Give Way\' signs/lines', 3),
(32, 18, 'Turning left onto and from laned roads', 1),
(33, 18, 'Turning right onto and from laned roads', 2),
(34, 19, 'Turning at unlaned roundabouts', 1),
(35, 19, 'Turning at laned roundabouts', 2),
(36, 19, 'Travelling straight on at a roundabout', 3),
(37, 20, 'Turning left and right at traffic lights (without arrows)', 1),
(38, 20, 'Following a straight course through traffic lights', 2),
(39, 20, 'Turning left through a slip lane (without arrows)', 3),
(40, 21, 'Pedestrian crossings, school zones and cross road intersections', 1),
(41, 21, 'Speed limits', 2),
(42, 21, 'Maintain reasonable progress', 3),
(43, 22, 'Negotiating bends and crests', 1),
(44, 22, 'Overtaking other vehicles', 2),
(45, 23, 'Safe positioning of the vehicle in traffic', 1),
(46, 23, '\'System of Car Control\' as applied to traffic hazards', 2),
(47, 24, 'Lane selection in traffic', 1),
(48, 24, 'Lane changing in traffic', 2),
(49, 25, 'Turning left onto and from busy roads', 1),
(50, 25, 'Turning right onto and from busy roads', 2),
(51, 26, 'Managing traffic at unlaned roundabouts', 1),
(52, 26, 'Managing traffic at laned roundabouts', 2),
(53, 27, 'Selecting a safe U-turn starting position', 1),
(54, 27, 'Performing a safe and complete U-turn', 2),
(55, 27, 'Select a safe alternative to the U-turn due to traffic', 3),
(56, 28, 'Turning left and right at traffic lights (without arrows)', 1),
(57, 28, 'Following a straight course through traffic lights', 2),
(58, 28, 'Negotiating \'slip\' lanes (without arrows)', 3),
(59, 28, 'Driving on unsealed roads', 4),
(60, 28, 'Recognition of current skills and knowledge', 5),
(61, 28, 'Driving at night', 6),
(62, 28, 'Demonstrate night driving', 7),
(63, 29, 'Review of all tasks in Unit 1', 1),
(64, 29, 'Review of all tasks in Unit 2', 2),
(65, 30, 'Review of road skills and traffic management', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbta_module_task_description`
--

DROP TABLE IF EXISTS `cbta_module_task_description`;
CREATE TABLE `cbta_module_task_description` (
  `id` int(11) NOT NULL,
  `module_number` int(11) NOT NULL,
  `task_number` int(11) NOT NULL,
  `module_task_listing` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cbta_module_task_description`
--

INSERT INTO `cbta_module_task_description` (`id`, `module_number`, `task_number`, `module_task_listing`, `description`) VALUES
(1, 1, 1, '(a)', 'Ensure the doors are closed (and locked for security and safety - optional)'),
(2, 1, 1, '(b)', 'Check that the park brake is firmly applied'),
(3, 1, 1, '(c)', 'Adjust the seat, head restraint and steering wheel (as required)'),
(4, 1, 1, '(d)', 'Adjust all mirrors (electric mirrors, if fitted, may be adjusted after \'starting the engine\' - Task 2)'),
(5, 1, 1, '(e)', 'Locate, identify and be able to use all vehicle controls (as required) when driving (including \'climate\' controls)'),
(6, 1, 1, '(f)', 'Perform all steps (a) to (e) in sequence'),
(7, 1, 1, '(g)', 'Ensure all required seat belts are fastened correctly.'),
(8, 2, 1, '(a)', 'If the park brake is not on, correctly apply it'),
(9, 2, 1, '(b)', 'Clutch down to the floor and keep it down (manuals only)'),
(10, 2, 1, '(c)', 'Check gear lever in \'Neutral\' (manuals) or \'Neutral/Park\' (automatics)'),
(11, 2, 1, '(d)', 'Switch the ignition (key) to the \'ON\' position'),
(12, 2, 1, '(e)', 'Check all gauges and warning lights for operation'),
(13, 2, 1, '(f)', 'Start the engine'),
(14, 2, 1, '(g)', 'Check all gauges and warning lights again for operation; and'),
(15, 2, 1, '(h)', 'Performs all steps 1(a) to 1(g) in sequence'),
(16, 2, 2, '(a)', 'Bring the vehicle to a complete stop (clutch down-manuals)'),
(17, 2, 2, '(b)', 'Secure the vehicle using the park brake'),
(18, 2, 2, '(c)', 'Select \'Neutral\' (manuals) or \'Neutral/Park\' (automatics)'),
(19, 2, 2, '(d)', 'Release brake pedal (to check for rolling)'),
(20, 2, 2, '(e)', 'Release clutch pedal (manuals only)'),
(21, 2, 2, '(f)', 'Switch off appropriate controls (eg lights, air conditioner etc)'),
(22, 2, 2, '(g)', 'Check all gauges and warning lights for operation'),
(23, 2, 2, '(h)', 'Turn ignition to \'OFF\' or \'LOCK\' position'),
(24, 2, 2, '(i)', 'Perform all steps 2(a) to 2(h) in sequence'),
(25, 3, 1, '(a)', 'If the park brake is not applied, correctly apply it'),
(26, 3, 1, '(b)', 'Check the centre mirror, then the right mirror, then signal right for at least 5 seconds'),
(27, 3, 1, '(c)', 'Push clutch pedal down (manuals) / Right foot on footbrake (automatics)'),
(28, 3, 1, '(d)', 'Select 1st gear (manuals) / Select \'Drive\' (automatics)'),
(29, 3, 1, '(e)', 'Apply appropriate power, (and for manuals) clutch to \'friction point\''),
(30, 3, 1, '(f)', 'Check the centre mirror again, then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic)'),
(31, 3, 1, '(g)', 'If safe, look forward and release the park brake'),
(32, 3, 1, '(h)', 'Accelerate smoothly away from the kerb without stalling or rolling back, and cancel the signal'),
(33, 3, 1, '(i)', 'Perform all steps (a) to (h) in sequence'),
(34, 4, 1, '(a)', 'Select appropriate stopping position'),
(35, 4, 1, '(b)', 'Check the centre mirror, then the left mirror (for cyclists etc.) and signal left'),
(36, 4, 1, '(c)', 'Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot'),
(37, 4, 1, '(d)', '(For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake'),
(38, 4, 1, '(e)', 'Bring vehicle to a smooth stop without jerking the vehicle'),
(39, 4, 1, '(f)', 'Perform all steps 1(a) to 1 (e) in sequence'),
(40, 4, 2, '(a)', 'Check that the vehicle has stopped (as above) and correctly apply the park brake to prevent rolling'),
(41, 4, 2, '(b)', 'Select \'Neutral\' (manuals) or \'Park\' (automatics)'),
(42, 4, 2, '(c)', 'Release the brake pedal and then (for manuals) release the clutch'),
(43, 4, 2, '(d)', 'Perform all steps 2(a) to 2(c) in sequence'),
(44, 4, 2, '(e)', 'Cancel any signal after stopping'),
(45, 5, 1, '(a)', 'Select the suitable stopping position on the road (e.g. - stop lines, positioning for view and proximity to other vehicles)'),
(46, 5, 1, '(b)', 'Check the centre mirror, (then if required the appropriate side mirror), and if required signal intention'),
(47, 5, 1, '(c)', 'Slow the vehicle smoothly using the footbrake only'),
(48, 5, 1, '(d)', 'For manuals only, when the vehicle slows to just above stalling speed, push the clutch down'),
(49, 5, 1, '(e)', 'For manuals only, just as the vehicle is stopping, select first gear'),
(50, 5, 1, '(f)', 'When the vehicle comes to a complete stop, apply the park brake (holding the handbrake button in, where possible*) and release the footbrake (right foot placed over accelerator)'),
(51, 5, 1, '(g)', 'Check that it is safe to move off and apply appropriate power (and for manuals, clutch to friction point)'),
(52, 5, 1, '(h)', 'If safe, look forward and release the park brake which results in the vehicle immediately moving off in a smooth manner without stalling and under full control'),
(53, 5, 1, '(i)', 'Perform all steps (a) to (h) in sequence'),
(54, 6, 1, '(a)', 'Move off smoothly from a stationary position in first gear (manuals) or (automatics)'),
(55, 6, 1, '(b)', 'Adjust the speed of the vehicle prior to selecting the new gear'),
(56, 6, 1, '(c)', 'Change gears, one at a time from first gear (manuals) or the lowest gear (automatics) through to the highest gear without clashing, missing the gear, unnecessarily jerking the vehicle OR looking at the gear lever'),
(57, 6, 1, '(d)', 'Change gear from a high gear (4th, 5th or \'Drive\') to various appropriate gears without significantly jerking the vehicle OR looking at the gear lever/selector'),
(58, 6, 1, '(e)', 'Demonstrate full control (including steering) over the vehicle during gear changing'),
(59, 6, 2, '(a)', 'Adjust the speed of the vehicle up and down and then select the appropriate gear for that speed (manuals and automatics)'),
(60, 6, 2, '(b)', 'When the vehicle is moving, demonstrate all gear selections without looking at the gear lever or gear selector'),
(61, 6, 2, '(c)', 'Demonstrate accurate selection of the gears without significant jerking of the vehicle or clashing of gears'),
(62, 6, 2, '(d)', 'Demonstrate the selection of appropriate gears, whilst descending and ascending gradients'),
(63, 6, 2, '(e)', 'Be able to select an appropriate gear to avoid unnecessary braking on descents and to have control on ascents'),
(64, 7, 1, '(a)', 'Maintain a straight course of at least 100 metres between turns with the hands placed in approximately the “10 to 2” clock position on the steering wheel with a light grip pressure'),
(65, 7, 1, '(b)', 'Demonstrate turning to the left and right through 90 degrees using either the “Pull-Push” or “Hand over Hand” method of steering while maintaining full vehicle control without over-steering'),
(66, 7, 1, '(c)', 'Look in the direction where the driver is intending to go when turning (First Rule of Observation - Aim high in steering)'),
(67, 7, 2, '(a)', 'Reverse the vehicle in a straight line for a minimum of 20 metres with a deviation not exceeding 1 metre, followed by step 2(b)'),
(68, 7, 2, '(b)', 'Reverse the vehicle through an angle of approximately 90 degrees to the left followed by reversing in a straight line for 5 metres with a deviation not exceeding half a metre (500mm)'),
(69, 7, 2, '(c)', 'Look in the appropriate directions and to the rear while reversing'),
(70, 8, 1, '(a)', 'Demonstrate Task 1 - cabin drill and controls'),
(71, 8, 1, '(b)', 'Demonstrate Task 2 - starting up and shutting down the engine'),
(72, 8, 1, '(c)', 'Demonstrate Task 3 - moving off from the kerb'),
(73, 8, 1, '(d)', 'Demonstrate Task 4 - stopping and securing the vehicle'),
(74, 8, 1, '(e)', 'Demonstrate Task 5 - stop and go (using the park brake)'),
(75, 8, 1, '(f)', 'Demonstrate Task 6 - gear changing (up and down)'),
(76, 8, 1, '(g)', 'Demonstrate Task 7 - control of the steering (forward and reverse)'),
(77, 9, 1, '(a)', 'Select a suitable safe and legal place on the gradient to stop'),
(78, 9, 1, '(b)', 'Check the centre mirror, then the left mirror (for cyclists etc.), and signal left'),
(79, 9, 1, '(c)', 'Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot'),
(80, 9, 1, '(d)', '(For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake'),
(81, 9, 1, '(e)', 'Bring vehicle to a smooth stop without jerking the vehicle'),
(82, 9, 1, '(f)', 'Check that the vehicle has stopped (as above) and correctly apply the park brake to prevent rolling'),
(83, 9, 1, '(g)', 'Select \'Neutral\' (manuals) or \'Park\' (automatics), then release the brake pedal, then (for manuals) release the clutch'),
(84, 9, 1, '(h)', 'Perform all steps 1(a) to 1(g) in sequence'),
(85, 9, 1, '(i)', 'cancel any signal after stopping'),
(86, 9, 2, '(a)', 'If the park brake is not applied, correctly apply it'),
(87, 9, 2, '(b)', 'Check the centre mirror, then the right mirror, then signal right for at least 5 seconds'),
(88, 9, 2, '(c)', 'Push clutch pedal down (manuals) / right foot on brake pedal (automatics)'),
(89, 9, 2, '(d)', 'Select first gear (manuals) / or select \'drive\' (automatics)'),
(90, 9, 2, '(e)', 'Apply appropriate power to prevent rolling backwards and/or stalling, (and for manuals) bring the clutch to \'friction point\' absorbing about half of the engine noise'),
(91, 9, 2, '(f)', 'Check the centre mirror again then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic)'),
(92, 9, 2, '(g)', 'If safe, look forward, release the park brake'),
(93, 9, 2, '(h)', 'Accelerate smoothly from the kerb without stalling or rolling back, and then cancel the signal'),
(94, 9, 2, '(i)', 'Perform all steps 2(a) to 2(h) in sequence while maintaining full control of the vehicle'),
(95, 10, 1, '(a)', 'Select a location where the U-turn is legally permitted, can be completed without reversing and is not in a \'No Stopping\' area, or opposite parked vehicles or where visibility in any direction is poor'),
(96, 10, 1, '(b)', 'Select a location where there is sufficient visibility in all directions to enable the U-turn to be done safely'),
(97, 10, 1, '(c)', 'When stopping at the kerb comply with Task 4'),
(98, 10, 2, '(a)', 'Comply with the Give Way rules (for U-turn) by giving way to all other traffic using the road during this manoeuvre'),
(99, 10, 2, '(b)', 'Comply with the \'moving off from the kerb\' procedure where practicable as stated in Task 3'),
(100, 10, 2, '(c)', 'Move the vehicle slowly forward (signalling appropriately) while turning the steering wheel (while not prohibited, dry/stationary steering is not encouraged) until on full steering lock (if required)'),
(101, 10, 2, '(d)', 'Prior to the vehicle changing direction, observe in all directions for approaching traffic and other road users e.g. pedestrians (also paying attention to driveways and roads opposite)'),
(102, 10, 2, '(e)', 'When safe, accelerate smoothly away without stalling or over-steering while maintaining full control of the vehicle'),
(103, 11, 1, '(a)', 'Select a suitable safe and legal place at the kerb to stop'),
(104, 11, 1, '(b)', 'Check the centre mirror, then the left mirror (for cyclists etc.) and signal left.'),
(105, 11, 1, '(c)', 'Ensure that there are no obstructions next to the kerb forward of the centre of the vehicle on the left (reversing area)'),
(106, 11, 1, '(d)', 'Smoothly slow the vehicle (to just above engine idle speed) using the footbrake operated by the right foot'),
(107, 11, 1, '(e)', '(For manuals) push the clutch down just before reaching engine idle speed to prevent stalling while maintaining light pressure on the footbrake'),
(108, 11, 1, '(f)', 'Bring vehicle to a smooth stop without jerking the vehicle'),
(109, 11, 1, '(g)', 'Check that the vehicle has stopped'),
(110, 11, 1, '(h)', 'If preparing to immediately commence the 3-point turn, ensure the correct gear has been selected in preparation to move off (apply park brake if required)'),
(111, 11, 1, '(i)', 'If intending to fully secure the vehicle, apply the park brake and select neutral (manuals) or Park (automatics) and release the brake pedal and then (for manuals) release the clutch'),
(112, 11, 1, '(j)', 'Perform all steps 1(a) to 1(h) in sequence'),
(113, 11, 1, '(k)', 'Cancel any signal after stopping'),
(114, 11, 2, '(a)', 'Check the centre mirror, then the right mirror, then signal right for at least 5 seconds'),
(115, 11, 2, '(b)', '(If moving off from fully secured) Push clutch pedal down (manuals) / right foot on brake pedal (automatics) / select 1st gear (manuals) / select \'drive\' (automatics)'),
(116, 11, 2, '(c)', 'Apply appropriate power, (and for manuals) clutch to \'friction point\''),
(117, 11, 2, '(d)', 'Check the centre mirror again, then the right mirror, then over the right shoulder (blind spot check) for traffic (from driveways, roads opposite or U-turning traffic)'),
(118, 11, 2, '(e)', 'If safe, look forward (release the park brake as required)'),
(119, 11, 2, '(f)', 'Accelerate smoothly away from the kerb without stalling or rolling back while turning the steering wheel to the right (while not prohibited, dry/stationary steering is not encouraged) until on full steering lock (if required) and cancel the signal'),
(120, 11, 2, '(g)', 'About 1 metre from the right kerb and whilst keeping the vehicle moving, turn the steering wheel sufficiently to the left (while not prohibited, dry/stationary steering is not encouraged)'),
(121, 11, 2, '(h)', 'Stop before touching the kerb'),
(122, 11, 2, '(i)', 'Select reverse gear, apply the park brake if required (holding the button in - optional) and check both directions and behind (over shoulders)'),
(123, 11, 2, '(j)', 'Move off in reverse without rolling or stalling (continue steering left as required), under full control and continue checking in all directions (moving head and eyes) whilst reversing'),
(124, 11, 2, '(k)', 'About 1 metre from the kerb whilst keeping the vehicle moving, steer sufficiently to the right (while not prohibited, dry/stationary steering is not encouraged); and prepare to move off down the road'),
(125, 11, 2, '(l)', 'Stop before touching the kerb'),
(126, 11, 2, '(m)', 'Select first gear or \'Drive\', apply the park brake if required (holding the button in - optional) and check both ways for traffic'),
(127, 11, 2, '(n)', 'When safe, move off down the road maintaining full control of the vehicle without stalling or over-steering (aim high in steering)'),
(128, 11, 2, '(o)', 'Perform all steps 2(a) to 2(n) in sequence'),
(129, 12, 1, '(a)', 'Select a suitable parking bay, check the centre mirror, then check the appropriate side mirror, then apply the appropriate signal for sufficient time and slow the vehicle to a safe and controllable speed'),
(130, 12, 1, '(b)', 'Choose the appropriate gear for control (if required)'),
(131, 12, 1, '(c)', 'Check appropriate mirror/s or blind spot/s (for approaching vehicles and/or pedestrians) prior to turning into the parking bay'),
(132, 12, 1, '(d)', 'Correctly position the vehicle, front to kerb, wholly within the bay (on the first attempt) while maintaining full control without touching the kerb:'),
(133, 12, 1, '(d)(i)', 'Not more than 300 mm out of parallel with the lines'),
(134, 12, 1, '(d)(ii)', 'Not more than 300 mm from the kerb or end of parking bay'),
(135, 12, 1, '(d)(iii)', 'Where practicable, central within the parking bay with the front wheels pointing straight ahead towards the kerb'),
(136, 12, 2, '(a)', 'Select reverse gear'),
(137, 12, 2, '(b)', 'Constantly check behind (over shoulders), both sides and to the front before moving and during reversing'),
(138, 12, 2, '(c)', 'Reverse slowly under full control of the vehicle and check for clearance of the front of the vehicle (where appropriate)'),
(139, 12, 2, '(d)', 'Reverse the vehicle only for such a distance as is necessary and turn the steering wheel sufficiently to allow the vehicle to safely clear the parking bay alongside and counter steering sufficiently (while not prohibited, dry/stationary steering is not encouraged) in preparation to move off safely down the road without stalling or rolling'),
(140, 12, 2, '(e)', 'Perform all steps above in sequence'),
(141, 13, 1, '(a)', 'Prior to and during reversing, check right, left and behind (over shoulders) for other road users, including cyclists and pedestrians'),
(142, 13, 1, '(b)', 'Check the centre mirror, then check the right mirror, then signal right for minimum of five (5) seconds whilst complying with Task 3 (moving off from the kerb); (use of the park brake is optional as required)'),
(143, 13, 1, '(c)', 'Exit the parking bay without touching the poles and without driving between the pole and the kerb'),
(144, 13, 1, '(d)', 'Stop so that the rear of the vehicle is just past the parking bay\'s front pole and parallel to the kerb'),
(145, 13, 2, '(a)', 'Prior to and during reversing, check right, left and behind (over shoulders) for other road users, including cyclists and pedestrians'),
(146, 13, 2, '(b)', 'Check all around prior to turning the wheel to the left when reversing into the bay'),
(147, 13, 2, '(c)', 'After entering the parking bay, complete the exercise with no more than two directional changes (i.e. changes direction to drive forward to straighten, then changes direction for the second time to centralise between the poles)'),
(148, 13, 2, '(d)', 'Parallel park the vehicle so that the left wheels are within 300mm of the kerb and straight, and centrally located not less than 900mm to the nearest pole'),
(149, 13, 2, '(e)', 'The wheels must not touch the kerb and the vehicle must not touch any pole or pass between any pole and the kerb'),
(150, 13, 2, '(f)', 'Maintain full control of the vehicle (without stalling)'),
(151, 14, 1, '(a)', 'Demonstrate one complete example of Task 9 (\'stopping and securing the vehicle on a hill\' and \'moving off uphill\' procedure) on request'),
(152, 14, 1, '(b)', 'Demonstrate one complete example of Task 10 (\'the U-turn\') on request'),
(153, 14, 1, '(c)', 'Demonstrate one complete example of Task 11 (\'the 3-point turn\') on request'),
(154, 14, 1, '(d)', 'Demonstrate one complete example of Task 12 (\'entering and leaving a 90 degree angle park\') on request'),
(155, 14, 1, '(e)', 'Demonstrate one complete example of Task 13 (\'reverse parallel parking\') on request'),
(156, 15, 1, '(a)', 'Keep the vehicle as near as practicable to the left on unlaned roads without unnecessarily obstructing other traffic'),
(157, 15, 1, '(b)', 'Keep the vehicle wholly within the marked lane when travelling straight or in bends'),
(158, 15, 1, '(c)', 'Use the space within the lane to maintain safety margins'),
(159, 15, 2, '(a)', 'Maintain a minimum of three (3) seconds following interval (see page 17) from the vehicle in front'),
(160, 15, 2, '(b)', 'Allow a safety margin of at least 1.2 m (where practicable) when passing objects, vehicles/obstructions'),
(161, 15, 2, '(c)', 'Allow a minimum safety margin of 1 metre when passing a cyclist where the speed limit is 60kmh or less, and 1.5 metres where the speed limit is over 60kmh'),
(162, 15, 2, '(d)', 'Stop in a position behind other vehicles allowing sufficient space to turn away from the vehicle in front if necessary'),
(163, 15, 3, '(a)', 'Correctly position the vehicle at \'Stop\' lines (associated with \'Stop\' signs, crossings and traffic lights etc.)'),
(164, 15, 3, '(b)', 'Demonstrate appropriate road position at intersections when view is obstructed'),
(165, 15, 3, '(c)', 'Demonstrate the correct approach and turn positions for turning left and right at intersections in accordance with the law'),
(166, 16, 1, '(a)', 'Select a suitable location (not approaching traffic lights etc.)'),
(167, 16, 1, '(b)', 'Accurately apply the \'System of Car Control\' when changing from one lane to another (either left or right)'),
(168, 16, 1, '(c)', 'Check the appropriate blind spot just before changing to the new lane'),
(169, 16, 2, '(a)', 'When attempting to diverge, merge or zip merge ensure the vehicle is not directly alongside another vehicle (i.e. where practicable keep the vehicle off-set to others - Rules of Observation)'),
(170, 16, 2, '(b)', 'When merging or diverging by more than 1 metre or crossing a lane line, comply with the \'Lane Changing Procedure\'(steps 1(a) to 3(c)) above and give way rules'),
(171, 16, 2, '(c)', 'When merging or diverging by less than 1 metre, or diverging over a long distance when passing parked vehicles on an unlaned road, comply with step 1(b) above except signals and blind spots may be omitted only if safe'),
(172, 16, 2, '(d)', 'When merging with the flow of traffic, ensure that adequate speed is achieved prior to entering. The merge must have minimal impact on other road users (freeway on-ramps, extended slip lanes etc.)'),
(173, 16, 2, '(e)', 'When zip merging, pay particular attention when approaching signs and lane markings'),
(174, 17, 1, '(a)', 'Demonstrate turning left and right at intersections incorporating a stop while complying with the laws for turning'),
(175, 17, 1, '(b)', 'Demonstrate the \'System of Car Control\' when turning right and left at intersections'),
(176, 17, 1, '(c)', 'Demonstrate safe observation patterns (Rules of Observation) while maintaining full vehicle contro'),
(177, 17, 1, '(d)', 'Comply with signalling requirements, \'Stop\' and \'Give Way\' signs and lines, and the give way rules at all times'),
(178, 17, 2, '(a)', 'Demonstrate turning left and right at intersections without a stop where practicable while complying with the laws for turning'),
(179, 17, 2, '(b)', 'Demonstrate the \'System of Car Control\' when turning right and left at intersections'),
(180, 17, 2, '(c)', 'Demonstrate correct and timely observation patterns when turning left and right at intersections while maintaining full control of the vehicle'),
(181, 17, 2, '(d)', 'Comply with signalling and \'Give Way\' rules'),
(182, 17, 3, '(a)', 'Comply with the \'System of Car Control\' when negotiating \'Stop\' and \'Give Way\' signs and lines'),
(183, 17, 3, '(b)', 'Comply with \'Stop\' and \'Give Way\' signs and lines'),
(184, 18, 1, '(a)', 'Comply with all laws relating to signalling, turning and \'Giving Way\''),
(185, 18, 1, '(b)', 'Approach every turn at a safe speed under full control'),
(186, 18, 1, '(c)', 'Correct and timely observation of any conflicting traffic when turning left'),
(187, 18, 1, '(d)', 'Apply appropriate acceleration during and after turning when entering the traffic flow of the other road'),
(188, 18, 1, '(e)', 'Comply with the \'System of Car Control\''),
(189, 18, 2, '(a)', 'Comply with all laws relating to signalling, turning and \'Giving Way\''),
(190, 18, 2, '(b)', 'Approach every turn at a safe speed under full control'),
(191, 18, 2, '(c)', 'Correct and timely observation of any conflicting traffic when turning right'),
(192, 18, 2, '(d)', 'Apply appropriate acceleration during and after turning when entering the traffic flow of the other road'),
(193, 18, 2, '(e)', 'Comply with the \'System of Car Control\''),
(194, 19, 1, '(a)', 'Comply with give way rules, signalling and correct vehicle positioning at unlaned roundabouts'),
(195, 19, 1, '(b)', 'Negotiate every roundabout at a safe speed under full control'),
(196, 19, 1, '(c)', 'Observe in the appropriate directions when approaching and during turns at unlaned roundabouts'),
(197, 19, 1, '(d)', 'Comply with the \'System of Car Control\''),
(198, 19, 2, '(a)', 'Demonstrate compliance with give way rules, signalling, arrows and correct vehicle positioning at roundabouts'),
(199, 19, 2, '(b)', 'Negotiate every roundabout at a safe speed under full control'),
(200, 19, 2, '(c)', 'Observe in the appropriate directions when approaching and during turns at laned roundabouts'),
(201, 19, 2, '(d)', 'Comply with the \'System of Car Control\''),
(202, 19, 3, '(a)', 'Demonstrate compliance with give way rules, signalling, arrows and co roundabout'),
(203, 19, 3, '(b)', 'Negotiate every roundabout at a safe speed under full control'),
(204, 19, 3, '(c)', 'Look in the appropriate directions when approaching and proceding through roundabouts'),
(205, 19, 3, '(d)', 'Comply with the \'System of Car Control\''),
(206, 20, 1, '(a)', 'Comply with the law for traffic light signals, associated stop lines, turning lines and arrows'),
(207, 20, 1, '(b)', 'Enter and correctly position vehicle lawfully within the intersection when stopping to give way to opposing traffic'),
(208, 20, 1, '(c)', 'When turning right, keep the front wheels straight (where practicable) while waiting to give way to on-coming traffic'),
(209, 20, 1, '(d)', 'Comply with Tasks 17 and 18 requirements when turning'),
(210, 20, 2, '(a)', 'Comply with the law for traffic light signals and associated stop lines'),
(211, 20, 2, '(b)', 'Comply with \'System of Car Control\' approaching lights'),
(212, 20, 2, '(c)', 'Apply correct stopping procedure (Task 4) as applicable'),
(213, 20, 3, '(a)', 'Comply with all \'Give Way\', signalling and road law'),
(214, 20, 3, '(b)', 'Comply with turning left requirements for Tasks 17 and 18 including safe speed of approach to the turn'),
(215, 20, 3, '(c)', 'Demonstrate appropriate and timely observation patterns, and \'System of Car Control\''),
(216, 21, 1, '(a)', 'Comply with the laws for pedestrian crossings and school zones'),
(217, 21, 1, '(b)', 'Accurately comply with the \'System of Car Control\' at all cross road intersections on unlaned roads (centre mirror must be checked prior to observation)'),
(218, 21, 2, '(a)', 'Comply with all speed limits in speed zones and built-up areas whilst demonstrating awareness of changing speed limits'),
(219, 21, 2, '(b)', 'Comply with speed limits for bridges, roadworks, schools, car parks and learner requirements'),
(220, 21, 3, '(a)', 'Where safe and practicable, maintain a speed which is within 5 km/h of the legal speed limit but does not exceed the speed limit'),
(221, 21, 3, '(b)', 'Move off in a line of traffic without any unnecessary delay or obstructing other traffic'),
(222, 21, 3, '(c)', 'Does not slow excessively or stop unnecessarily at intersections where the view is open and clear, and it is safe to go'),
(223, 21, 3, '(d)', 'Maintain at least a \'3 second\' following distance between the vehicle in front and the learner\'s vehicle'),
(224, 22, 1, '(a)', 'Comply with speed limits, road markings, keeping left and \'Due Care\' requirements while maintaining reasonable progress'),
(225, 22, 1, '(b)', 'Demonstrate a safe speed and position of approach to all bends and crests'),
(226, 22, 1, '(c)', 'Comply with \'System of Car Control\' approaching bends and crests (including selection of the correct gear before the bend or crest)'),
(227, 22, 1, '(d)', 'Comply with the Rules of Braking and \'acceleration sense\' approaching bends and crests'),
(228, 22, 1, '(e)', 'Comply with the Rules of Steering when braking and cornering'),
(229, 22, 1, '(f)', 'Demonstrate good forward observation (Aim high in steering) and complies with the Rules of Observation'),
(230, 22, 1, '(g)', 'Display safe and complete control of the vehicle at all times'),
(231, 22, 2, '(a)', 'Correctly select a safe and suitable location to overtake while complying with the law (road markings, sufficient clear view)'),
(232, 22, 2, '(b)', 'Maintain a reasonable following distance before overtaking in order to comply with the Rules of Observation'),
(233, 22, 2, '(c)', 'Comply with \'System of Car Control\' and use appropriate gears and acceleration where necessary'),
(234, 22, 2, '(d)', 'If suitable overtaking situations do not occur, verbally demonstrate to the Authorised Examiner the selection of five safe and suitable locations where there is sufficient distance to overtake safely'),
(235, 23, 1, '(a)', 'Keep at least 3 seconds time interval between the learner\'s vehicle and the vehicle in front, increasing this interval for adverse weather conditions or if being closely followed'),
(236, 23, 1, '(b)', 'Where safe and practicable, keep at least 1.2 metre clearance when passing parked vehicles, or other hazards'),
(237, 23, 1, '(c)', 'Allow a minimum safety margin of 1 metre when passing a cyclist where the speed limit is 60kmh or less, and 1.5 metres where the speed limit is over 60kmh'),
(238, 23, 1, '(d)', 'Adjust the vehicle\'s position by holding back if the vehicle in front obstructs the view ahead (Observation - Get the big picture)'),
(239, 23, 1, '(e)', 'Maintain the vehicle\'s position in a line of traffic without obstructing following traffic where it is safe and legal to do so'),
(240, 23, 1, '(f)', 'Avoid unnecessary travel in blind spots of other vehicles (Observation - Leave yourself an OUT)'),
(241, 23, 1, '(g)', 'Where practicable, stop in a position behind other vehicles to allow sufficient space to turn away from the vehicle in front'),
(242, 23, 1, '(h)', 'Without obstructing the intersection stop in a line of traffic (road law)'),
(243, 23, 1, '(i)', 'Comply with all appropriate road rules'),
(244, 23, 2, '(a)', 'Comply with the features of the \'System of Car Control\' in the correct sequence when approaching hazards in traffic'),
(245, 23, 2, '(b)', 'Comply with \'System of Car Control\' when approaching traffic lights (eg. check mirror, cover the brake, etc.)'),
(246, 23, 2, '(c)', 'Demonstrate \'System of Car Control\' when passing stationary buses or other similar hazards'),
(247, 23, 2, '(d)', 'Demonstrate \'System of Car Control\' when giving way'),
(248, 24, 1, '(a)', 'Identify potential hazards well in advance and take safe and appropriate action (Observation - Get the Big Picture)'),
(249, 24, 1, '(b)', 'Confidently select safe gaps when changing lanes'),
(250, 24, 1, '(c)', 'Select suitable and timely locations when changing lanes (\'System of Car Control\' - select the course)'),
(251, 24, 2, '(a)', 'Competently apply the \'System of Car Control\' when changing from one lane to another (either left or right)'),
(252, 24, 2, '(b)', 'Check the appropriate blind spot just before changing lanes'),
(253, 24, 2, '(c)', 'Co-operate with other drivers by accepting and giving reasonable offers of courtesy when safe'),
(254, 24, 2, '(d)', 'Change lanes in traffic only when safe without significantly interfering with the flow of traffic in the newly selected lane'),
(255, 25, 1, '(a)', 'Display compliance with all \'Give Way\' and \'turning\' rules (observation, braking and steering)'),
(256, 25, 1, '(b)', 'Maintain full vehicle control throughout each turn (ie. no wide exits, question-mark turns, or stalls)'),
(257, 25, 1, '(c)', 'When exiting or entering a busy road, keep as near as reasonably practicable to the left'),
(258, 25, 1, '(d)', 'Comply with the \'System of Car Control\' throughout the assessment'),
(259, 25, 1, '(e)', 'Display competent selection of safe gaps when entering a traffic flow'),
(260, 25, 1, '(f)', 'Display competent acceleration skills when entering a gap (See \'System of Car Control\')'),
(261, 25, 2, '(a)', 'Display compliance with all \'Give Way\' and turning rules (observation, braking and steering)'),
(262, 25, 2, '(b)', 'Maintain full vehicle control throughout each turn (ie. no wide exits, question-mark turns, or stalls)'),
(263, 25, 2, '(c)', 'Comply with the \'System of Car Control\' throughout the assessment'),
(264, 25, 2, '(d)', 'Make early selection of the most appropriate and lawful lane for turning'),
(265, 25, 2, '(e)', 'Display competent selection of safe gaps when entering or crossing a traffic flow when turning right'),
(266, 25, 2, '(f)', 'Display competent acceleration skills when entering a safe gap or crossing a flow of traffic - (See \'System of Car Control\')'),
(267, 26, 1, '(a)', 'Comply with the requirements and standard as documented in Task 19 (1) - turning at unlaned roundabouts'),
(268, 26, 1, '(b)', 'Display competent and confident decision making when selecting safe gaps in traffic on the roundabout'),
(269, 26, 1, '(c)', 'Demonstrate competent use of acceleration when joining and leaving a traffic stream on the carriageway of the roundabout'),
(270, 26, 2, '(a)', 'Comply with the requirements and standard as documented in Task 19 (2) - turning at laned roundabouts'),
(271, 26, 2, '(b)', 'Demonstrate early selection of correct lanes before, during and after turning or when travelling straight on at the roundabout'),
(272, 26, 2, '(c)', 'Display competent and confident decision making when selecting safe gaps in traffic at the roundabout'),
(273, 26, 2, '(d)', 'Demonstrate competent use of acceleration when joining and leaving a traffic stream on the carriageway of the roundabout'),
(274, 27, 1, '(a)', 'Select a suitable position whilst complying with \'System of Car Control\''),
(275, 27, 1, '(b)', 'Select a position where only one major flow of traffic is required to be crossed during the U-turn'),
(276, 27, 1, '(c)', 'Select the most appropriate position that minimises the disruption to overtaking or following traffic for that road (eg. a right turn store lane opposite a quiet road)'),
(277, 27, 2, '(a)', 'Comply with all road markings, and the \'Give Way\' rules for turning and moving off (as required)'),
(278, 27, 2, '(b)', 'Confidently select a safe gap in the traffic flow when presented'),
(279, 27, 2, '(c)', 'Use safe stopping areas within the U-turn as required'),
(280, 27, 2, '(d)', 'Complete the U-turn safely without reversing while maintaining full control of the vehicle'),
(281, 27, 3, '(a)', 'If traffic conditions change where the U-turn could become confusing or dangerous to any road users, select an acceptable safe option'),
(282, 27, 3, '(b)', 'Perform the optional action with safety'),
(283, 28, 1, '(a)', 'Comply with Task 20'),
(284, 28, 1, '(b)', 'While waiting to turn right or left , correctly position the vehicle within the intersection when permitted by the traffic lights'),
(285, 28, 1, '(c)', 'Demonstrate confident selection of safe gaps when turning into or across a traffic flow'),
(286, 28, 1, '(d)', 'Display appropriate use of acceleration for safety during the turn while maintaining full control of the vehicle'),
(287, 28, 1, '(e)', 'Ensure that other vehicles are not unnecessarily obstructed when turning'),
(288, 28, 2, '(a)', 'Comply with Task 20'),
(289, 28, 2, '(b)', 'Display correct and confident decision making on approach to traffic lights having regard for weather, road conditions and following traffic (type of vehicle and how near they are)'),
(290, 28, 3, '(a)', 'Comply with Task 20'),
(291, 28, 3, '(b)', 'Demonstrate confident selection of safe gaps when turning left through a \'slip\' lane into a flow of traffic'),
(292, 28, 3, '(c)', 'Display appropriate use of acceleration for safety during and after the turn while maintaining full control of the vehicle'),
(293, 28, 4, '(i)(a)', 'Demonstrate compliance with all appropriate road laws (eg. as near as practicable to the left, etc.)'),
(294, 28, 4, '(i)(b)', 'Maintain full control of the vehicle at all times (skidding or sliding at any time is considered to be loss of control - see system of car control)'),
(295, 28, 4, '(i)(c)', 'Demonstrate a safe speed of approach to bends, crests and intersections at all times'),
(296, 28, 4, '(i)(d)', 'Demonstrate safe and correct entry lines into bends (for good view and being seen - Rules of Observation)'),
(297, 28, 4, '(i)(e)', 'Demonstrate safe and correct exit lines from bends (ensuring the vehicle leaves the bend on the correct side of the road - if any part of the vehicle strays onto the incorrect side of the road it is a road law fault – see step (a))'),
(298, 28, 4, '(i)(f)', 'Comply with the \'System of Car Control\', Rules of Braking, Steering and Observation'),
(299, 28, 4, '(i)(g)', 'Correctly adjust speed to that which is suitable to any change of road surface'),
(300, 28, 4, '(i)(h)', 'Correctly adjust the following distance and use headlights as required when following another vehicle (eg. decreased visibility due to dust etc.)'),
(301, 28, 4, '(i)(i)', 'Correctly adjust the speed (minimum use of the accelerator) when passing another vehicle travelling in the opposite direction (to reduce the risk of possible windscreen damage)'),
(302, 28, 5, '(ii)(a)', 'Question learner on speed limits, keeping to the left, 3-Second Rule Formula, Use of headlights, \'System of Car Control\', Rules of Braking, Steering and Observation; and'),
(303, 28, 6, '(ii)(a)', 'Explain adjustments required in speed and positioning in regard to visual deficiencies.'),
(304, 28, 6, '(ii)(b)', 'Explain the requirements in relation to clean windscreens and headlights.'),
(305, 28, 6, '(ii)(c)', 'Explain the requirements in relation to dipping headlights. (eg when following within 200m from the rear of other traffic and when approaching vehicle reaches a point 200m from your vehicle or immediately the headlights of an approaching vehicle are dipped, whichever is sooner).'),
(306, 28, 6, '(ii)(d)', 'Explain the confusion that may occur when driving in built up areas due to the mixture of neon signs, traffic lights, store lights, street lighting, etc.'),
(307, 28, 6, '(ii)(e)', 'Explain the need to be \'seen\' (eg do not forget to turn on headlights). Explain the lack of visual eye contact with other road users.'),
(308, 28, 6, '(ii)(f)', 'Demonstrate correct application of \'System\'.'),
(309, 28, 7, '(iii)(a)', 'Trainee to demonstrate under full instruction.'),
(310, 28, 7, '(iii)(b)', 'Trainee to demonstrate with instruction as required; and'),
(311, 28, 7, '(iii)(c)', 'Trainee to practice until competent.'),
(312, 29, 1, '(a)', 'Accurately perform Task 1 - cabin drill and controls'),
(313, 29, 1, '(b)', 'Accurately perform Task 2 - starting up and shutting down the engine'),
(314, 29, 1, '(c)', 'Accurately perform Task 3 - moving off from the kerb'),
(315, 29, 1, '(d)', 'Accurately perform Task 4 - stopping and securing the vehicle'),
(316, 29, 1, '(e)', 'Accurately perform Task 5 - stop and go (using the park brake)'),
(317, 29, 1, '(f)', 'Accurately demonstrate Task 6 - gear changing'),
(318, 29, 1, '(g)', 'Accurately demonstrate Task 7 - control of the steering (forward and reverse)'),
(319, 29, 2, '(a)', 'Accurately perform Task 9 - stopping and securing the vehicle on a hill and moving off uphill'),
(320, 29, 2, '(b)', 'Accurately perform Task 10 - the U-turn'),
(321, 29, 2, '(c)', 'Accurately perform Task 11 - the 3-point turn'),
(322, 29, 2, '(d)', 'Accurately perform Task 12 - entering and leaving a 90 degree angle park'),
(323, 29, 2, '(e)', 'Accurately perform Task 13 - reverse parallel parking'),
(324, 30, 1, '(a)', 'Comply with all road laws'),
(325, 30, 1, '(b)', 'Comply with the \'System of Car Control\' to left and right turns, traffic lights, stopping, lane changes and other potential traffic hazards'),
(326, 30, 1, '(c)', 'Comply with the Rules of Braking, Steering and Observation'),
(327, 30, 1, '(d)', 'Demonstrate appropriate forward planning, correct and timely road positioning, and safe driving strategies');

-- --------------------------------------------------------

--
-- Table structure for table `completed_lessons`
--

DROP TABLE IF EXISTS `completed_lessons`;
CREATE TABLE `completed_lessons` (
  `id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completion_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

DROP TABLE IF EXISTS `instructors`;
CREATE TABLE `instructors` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `company_address` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`user_id`, `username`, `company`, `company_address`, `phone`, `price`) VALUES
(2, 'Brett Wilkinson', 'Flinders', 'Tonsley', 404040404, 50.00),
(7, 'Kathryn Laneway', 'NA', 'NA', 0, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `instructor_learners`
--

DROP TABLE IF EXISTS `instructor_learners`;
CREATE TABLE `instructor_learners` (
  `instructor_id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor_learners`
--

INSERT INTO `instructor_learners` (`instructor_id`, `learner_id`) VALUES
(2, 1),
(2, 1),
(7, 5),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `unit_number` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `unit_number`, `unit_name`) VALUES
(1, 1, 'Basic driving procedures'),
(2, 2, 'Slow speed manoeuvres'),
(3, 3, 'Basic road skills'),
(4, 4, 'Traffic management skills'),
(5, 0, 'Units 1 and 2 - Review'),
(6, 0, 'Units 3 and 4 - Review');

-- --------------------------------------------------------

--
-- Table structure for table `logbooks`
--

DROP TABLE IF EXISTS `logbooks`;
CREATE TABLE `logbooks` (
  `id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `qsd_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration` int(11) NOT NULL,
  `start_location` enum('MOTPENA','MCLAREN VALE','PORT AUGUSTA NORTH','GAWLER RIVER','CHUNDARIA','ELIZABETH EAST','MULGUNDAWA','GAWLER RANGES','GAMMON RANGES','MOUNT COMPASS','BOONERDO','YANERBIE','MOUNT MCINTYRE','UWORRA','MALINONG','BRINKLEY','BLYTH','TORRENSVILLE PLAZA','MONTACUTE','COMAUM','ERINGA','TORRENSVILLE','CORTLINYE','HIGHGATE','BUNGAMA','STANLEY','LINCOLN GAP','BEVERLEY','HOYLETON','PANDIE PANDIE','WILD DOG VALLEY','KINGSTON SE','WHYALLA STUART','PUNTABIE','PICCADILLY','GOOLWA SOUTH','PAECHTOWN','MARREE','PORT MOOROWIE','SALISBURY HEIGHTS','BURR WELL','WOKURNA','EIGHT MILE CREEK','ANDAMOOKA','BALGOWAN','MINGARY','NARRIDY','POINT STURT','NOARLUNGA CENTRE','BOOKABIE','SALISBURY','WANGARY','GOOLWA BEACH','CORNY POINT','MOUNT BARKER JUNCTION','REID','PEEBINGA','ABERFOYLE PARK','BEATTY','CLAYPANS','MONARTO','MARREE STATION','WONGULLA','MITCHELL PARK','MUNNO PARA DOWNS','TARNMA','WILLOW BANKS','LONG FLAT','PADTHAWAY','WAITPINGA','JERUSALEM','SEACOMBE GARDENS','KYBYBOLITE','POONINDIE','PORT PIRIE SOUTH','WOODFORDE','PYGERY','FISHERMAN BAY','MANGALO','WARTAKA','ROCKY PLAIN','DEEP CREEK','COOBOWIE','PINDA SPRINGS','YUMBARRA','BURNSFIELD','PETINA','FARM BEACH','PARA HILLS WEST','KANPI','ASHFORD','PASADENA','TEPKO','MOUNT BRYAN','KINGSTON ON MURRAY','STANSBURY','CEDUNA WATERS','WALLALA','PETHERICK','GILBERTON','GREENBANKS','EDITHBURGH','SEMAPHORE','ELIZABETH','KILKENNY','SEMAPHORE PARK','HUMBUG SCRUB','TANUNDA','CLIFTON HILLS STATION','WOOLUMBOOL','WITCHITIE','COCATA','ISLAND BEACH','TUSMORE','REDHILL','CHERRY GARDENS','PANDURRA','PORT BONYTHON','PENONG','WOODVILLE PARK','PRICE','WHITE SANDS','BOOBOROWIE','COPLEY','MACCLESFIELD','GREEN PATCH','MORGAN','TOOTENILLA','WATERLOO','ULYERRA','HANSBOROUGH','LOUTH BAY','NEWLAND','WAYVILLE','ETADUNNA','AMERICAN BEACH','DAVOREN PARK','GLENROY','O''SULLIVAN BEACH','LAKE HARRIS','COLLINSVILLE','MOOCKRA','MURRAY BRIDGE SOUTH','PARADISE','BUCHANAN','THE PINES','POINT TURTON','WHITE HUT','PUNTHARI','FIRLE','PARK HOLME','BURTON','GLYNDE','TALDRA','KANNI','EMU FLAT','ORROROO','GLENSIDE','HACKHAM WEST','EVERARD PARK','BRIDGEWATER','JULIA','OLD TEAL FLAT','COOMANDOOK','HACKNEY','HAMPDEN','MERRITON','HILL RIVER','LAKE MACFARLANE','KAPUNDA','SEAFORD RISE','ST PETERS','WITJIRA','FLAGSTAFF HILL','MODBURY','MYRTLE SPRINGS','PORT BROUGHTON','NANGWARRY','THEBARTON','JERICHO','TOOLIGIE','WOODS POINT','KOPPIO','LAKE ALBERT','PALLAMANA','CUDLEE CREEK','WIRRINA COVE','ASHTON','LOWER INMAN VALLEY','QUONDONG','ROCKY GULLY','HAMBIDGE','KALBEEBA','ARDROSSAN','HINDMARSH TIERS','WEDGE ISLAND','ALTONA','PORT AUGUSTA','IRONBANK','FULHAM GARDENS','BURDETT','WELLINGTON','DULWICH','YARRAMBA','MARDEN','PINKERTON PLAINS','CROWN POINT','NORTH HILLS','YORKETOWN','GREENOCK','YUDNAPINNA','COLES','NORTH BEACH','OVINGHAM','NORTH HAVEN','COLLEGE PARK','TAPLAN','MOORAK','MULGA VIEW','GERMAN CREEK','ANGAS PLAINS','WITERA','POINT BOSTON','POLTALLOCH','CITY WEST CAMPUS','SEACOMBE HEIGHTS','EMEROO','MOUNT BRYAN EAST','ALFORD','TAILEM BEND','TOORA','KILBURN NORTH','WALKER FLAT','LANGS LANDING','SCHELL WELL','PIKE RIVER','PROSPECT EAST','MOUNT GAMBIER WEST','NUNJIKOMPITA','JULANKA HOLDINGS','WANDANA','ROSSLYN PARK','TOTNESS','GUM CREEK','QUEENSTOWN','ONE TREE HILL','CROYDON','BRIGHT','MENINGIE','PRELINNA','THORNGATE','EVANDALE','MAKIN','NADIA','SUNNYDALE','NORTH ADELAIDE MELBOURNE ST','HOLDER','DUDLEY EAST','WHYALLA JENKINS','ARNO BAY','BOATSWAIN POINT','WUNKAR','OUTER HARBOR','COWANDILLA','RIDGEHAVEN','HORSNELL GULLY','WILLUNGA','KYBUNGA','ARTHURTON','CUNGENA','DOUGLAS POINT','SQUARE MILE','HUTT STREET','FERRYDEN PARK','MOUNT OBSERVATION','CHILPENUNDA','ENCOUNTER BAY','SALISBURY EAST NORTHBRI AVE','HALBURY','YELLABINNA','PARKSIDE','BOLLARDS LAGOON','MARLESTON','MINLATON','CLARENCE GARDENS','GAWLER EAST','YALLUNDA FLAT','JUPITER CREEK','TENNYSON','MULGARIA','WHYALLA NORRIE EAST','ALBERT PARK','CANOWIE','HASLAM','MATTA FLAT','VENUS BAY','KENSINGTON GARDENS','MAGAREY','PORT LINCOLN SOUTH','TUMBY BAY','FRAYVILLE','PINKAWILLINIE','STUN''SAIL BOOM','MARCOLLAT','KALTJITI','HEATHPOOL','SALISBURY PARK','MOUNT PLEASANT','POINT LOWLY','WIAWERA','DIREK','BOWER','BLACK POINT','WELLINGTON EAST','TARATAP','TYRINGA','PENRICE','STEINFELD','NORTH SHIELDS','HILTABA','BRENTWOOD','WOODLEIGH','BINNUM','PARSONS BEACH','IRONSTONE','LAKE GAIRDNER','PATA','EVANSTON SOUTH','SANDERSTON','WYNN VALE','GOMERSAL','NEW TOWN','WAPPILKA','DARLINGTON','SIMPSON DESERT','UNO','MCDOUALL PEAK','CARALUE','BUNDALEER GARDENS','ASHBOURNE','LOCKES CLAYPAN','MONTARRA','BLAKISTON','CLEMENTS GAP','PORT GERMEIN','WATTLE FLAT','SUNNYVALE','TIATUKIA','CORDILLO DOWNS','SPALDING','KINGSFORD','HAWSON','WARBURTO','OLD CALPERUM','WARRADALE NORTH','KALLORA','MACGILLIVRAY','PORT RICKABY','GREEN HILLS RANGE','WHYALLA NORRIE','TEAL FLAT','MULGATHING','BERRI','LONSDALE','IRON KNOB','ST JOHNS','WITCHELINA','FLINDERS RANGES','NANGKITA','STRATHALBYN','BUNGEROO','CHAPEL HILL','MUTOOROO','HARROGATE','NORTH BOOBOROWIE','WATERLOO CORNER','PINJARRA STATION','PARA HILLS','CANNAWIGARA','THORNLEA','MURPUTJA','EBA ANCHORAGE','DANGGALI','HOPE GAP','ALDINGA BEACH','PETWOOD','YALANDA','MOONTA BAY','KALKA','FRAHNS','MULLAQUANA','MOBILONG','CHOWILLA','HYDE PARK','LEIGH CREEK','RAMSAY','LAKE EYRE','MILE END SOUTH','NEALES FLAT','WADDIKEE','MINNIPA','ROBERTSTOWN','BRAMFIELD','APPILA','COOLTONG','FOX','KARKOO','MURRAY TOWN','HAHNDORF','OVERLAND CORNER','NAPPERBY','MURRAWONG','GALGA','BOLIVAR','BELALIE EAST','FORRESTON','RIVERGLADES','DOUGLAS POINT SOUTH','SALEM','CULTANA','CALTOWIE NORTH','VICTOR HARBOR CENTRAL','LOWER MITCHAM','PUREBA','GERARD','SMITHFIELD','YEELANNA','URRBRAE','MASLIN BEACH','KOPPAMURRA','GULNARE','KOLENDO','PIPALYATJARA','WILLIPPA','FROME DOWNS','KILBURN','MOUNT DUTTON BAY','PORT MANNUM','MOSELEY','HINCKS','PORKY FLAT','PORT GAWLER','BLUFF BEACH','CROYDON PARK','WEEKEROO','ULEY','KURRALTA PARK','EDEN HILLS','BETHANY','WESTERN RIVER','WILLOCHRA','TOORAK GARDENS','PORT ADELAIDE','LOWER HERMITAGE','PIMBAACLA','GREEN FIELDS','CALTOWIE WEST','GAWLER','KALDOONERA','GILLENTOWN','WILLIAMSTOWN','TARCOOLA','ASCOT PARK','HARTLEY','ALPANA','STONE WELL','PEARLAH','KERSBROOK','TIKALINA','CUSTON','WALLAROO PLAIN','WESTALL','ROSTREVOR','GREENWAYS','WOODVILLE NORTH','CADELL','HATHERLEIGH','MURNINNIE BEACH','PLEASANT PARK','CRESCENT','WOOLSHEDS','HACKHAM','WALLAROO MINES','THEVENARD','ANDAMOOKA STATION','ROSEDALE','GULFVIEW HEIGHTS','BALDINA','MILLBROOK','KOONOONA','DELAMERE','BURRA','WOOMERA','LOCHABER','PELICAN POINT','MIDDLE BEACH','SHERINGA','WALLERBERDINA','MORPHETTS FLAT','GREENHILL','WERTALOONA','YACKA','ASHVILLE','SEPPELTSFIELD','GOOD HOPE LANDING','WISANGER','COCKBURN','WARD BELT','MANNANARIE','FRANKTON','HART','LOWER BROUGHTON','BOCKELBERG','HAWKER','PARILLA','TICKERA','MARION BAY','BROWNLOW KI','WONNA','SWAN REACH','WHYALLA','PANEY','BAKARA WELL','CLINTON CENTRE','MUNDULLA WEST','COMPTON','BAROOTA','CANOWIE BELT','SEAL BAY','STRUAN','MENINGIE WEST','PARCOOLA','PELICAN LAGOON','PUKATJA','LAKE CARLET','STUARTS CREEK','WHYALLA DC','GOLDEN GROVE VILLAGE','WIRRULLA','HENLEY BEACH','WHITES RIVER','YANINEE','CALTOWIE','ELIZABETH GROVE','VALLEY VIEW','NATURI','ANTECHAMBER BAY','FARINA STATION','MERGHINY','PORT VICTORIA','D''ESTREES BAY','SEVENHILL','WYNARKA','GLUEPOT','UNDERDALE','HANSON','BALAH','ROCKY POINT','COROMANDEL EAST','HONITON','HUNTFIELD HEIGHTS','LEIGH CREEK STATION','REEVES PLAINS','EDIACARA','ONKAPARINGA HILLS','GRANGE','MILTALIE','EMU DOWNS','LAURIE PARK','ILLEROO','MOUNT WEDGE','ANANGU PITJANTJATJARA YANKUNYTJATJARA','WILLOUGHBY','SOUTH KILKERRAN','WORLDS END','MOUNT LYNDHURST','ULEYBURY','APOINGA','BAUDIN BEACH','CAMDEN PARK','MURRAY BRIDGE','TEPCO STATION','WONUARRA','SAMPSON FLAT','GLOSSOP','ISLAND LAGOON','OWEN','WAIKERIE','POORAKA','KELLY','MOUNT ARDEN','AMERICAN RIVER','LAKE GILLES','MELROSE PARK DC','MUNDALLIO','PEEP HILL','MONBULLA','ANGLE PARK','GLENBURNIE','ARKAROOLA VILLAGE','CALOOTE','BOWILLIA','BRINKWORTH','WIRREALPA','RIDLEYTON','MINBURRA STATION','PINE VALLEY STATION','KAPINNIE','WHITE WELL CORNER','RUNDLE MALL','FITZROY','TULKA','COWELL','EXETER','WILKATANA STATION','SALT CREEK','WEBB BEACH','ABMINGA STATION','SECOND VALLEY','OODNADATTA','BOWDEN','MOODY','CHARRA','BLANCHE HARBOR','WINDSOR GARDENS','YUNTA','BRIMBAGO','FLINDERS CHASE','HAYBOROUGH','CLINTON','MAYLANDS','FLINDERS UNIVERSITY','TUNKALILLA','ST GEORGES','BOWHILL','WALLOWAY','NUROM','MAGILL NORTH','STEELTON','WIRRAMINNA','OB FLAT','TINTINARA','CHARLTON GULLY','CHERRYVILLE','COULTA','CURRENCY CREEK','CANUNDA','PROOF RANGE','ELIZABETH PARK','NARRINA','PORT AUGUSTA WEST','COORONG','AMYTON','REDWOOD PARK','DOWLINGVILLE','MOUNT JOY','CROMER','JOHNBURGH','KONGAL','INKSTER','MITCHELL','LARGS NORTH','COWLEDS LANDING','GOODWOOD','GURRA GURRA','EDINBURGH NORTH','KENTON VALLEY','LYNDHURST','WHYALLA BARSON','MOUNT CHARLES','MARYVALE','SALISBURY DOWNS','SANDLETON','SIAM','CARPENTER ROCKS','WOOLPUNDA','MIMILI','HAMPSTEAD GARDENS','KANGAROO FLAT','ROYSTON PARK','GEORGETOWN','WOOL BAY','BACK VALLEY','KORUNYE','BULLOO CREEK','WEST LAKES','WOOLSHED FLAT','PORT JULIA','WATERFALL GULLY','LONG PLAINS','PAGES FLAT','PETERSVILLE','BILLA KALINA','HAWTHORNDENE','O''HALLORAN HILL','DUDLEY WEST','MURBKO','WINKIE','YINKANIE','WOODCROFT','WARRADALE','KOOTABERRA','KEILIRA','BLETCHLEY','BURRA EASTERN DISTRICTS','HAY VALLEY','HIGHBURY','NGAPALA','SULTANA POINT','WOODVILLE','CAREY GULLY','OUTALPA','THOMPSON BEACH','MARRABEL','BORDERTOWN SOUTH','MANNINGHAM','WATINUMA','RIVERTON','RISDON PARK','WARNES','GEMMELLS','WARRAMBOO','WYOMI','EBA','YOUNGHUSBAND HOLDINGS','RENMARK','CRAIGBURN FARM','SALISBURY NORTH WHITES ROAD','BEETALOO VALLEY','BULGUNNIA','ARKAROOLA','MOONTA MINES','BLANCHETOWN','UPPER HERMITAGE','NORWOOD SOUTH','WALL FLAT','MONASH','WEST RANGE','INMAN VALLEY','LAFFER','LAKE FROME','CHINAMAN WELLS','HACKLINS CORNER','LAMEROO','WANDEARAH EAST','CHARLESTON','POINT LOWLY NORTH','LINWOOD','MOUNT TEMPLETON','OAKLANDS PARK','BULL CREEK','UNLEY PARK','HINDMARSH ISLAND','PUTTAPA','NOVAR GARDENS','HINDMARSH','DAVEYSTON','ALDINGA','PLYMPTON PARK','BANGHAM','BETHEL','BUTE','COLLEY','STOCKPORT','WEST RICHMOND','MINGBOOL','MARAMA','MURNPEOWIE','TOLDEROL','MALTEE','WADNAMINGA','CHANDADA','LIGHTSVIEW','CORUNNA STATION','BUNDALEER NORTH','SPENCE','DUBLIN','PORT NOARLUNGA SOUTH','AULDANA','LOWER LIGHT','REDBANKS','LAKE ALEXANDRINA','MALPAS','KIANA','NOARLUNGA DOWNS','BOOLGUN','ANAMA','BROOKER','TOWITTA','COOK','STEPNEY','STOCKYARD CREEK','HOSKIN CORNER','PIMBA','RAMCO HEIGHTS','TATACHILLA','PARAFIELD GARDENS','MARANANGA','WANGOLINA','BROWNLOW','SALISBURY SOUTH BC','POLDA','KUITPO COLONY','SEAFORD MEADOWS','WOODSIDE','KINGS PARK','KUITPO','BELTANA STATION','KRINGIN','ANGLE VALE','EDILLILIE','MITCHIDY MOOLA','GAWLER WEST','REGENCY PARK','WRATTONBULLY','FINDON','BUCKINGHAM','MAAOUPE','MOUNT EBA','GILLES PLAINS','GLADSTONE','MEDINDIE GARDENS','COROMANDEL VALLEY','PERPONDA','CAPE JAFFA','CHAFFEY','MILLICENT','BAKARA','MOUNT BARKER','SUTHERLANDS','NANTAWARRA','KULPARA','NORTHERN HEIGHTS','BRENDA PARK','KELLIDIE BAY','ARCKARINGA','NORTH CAPE','PARACHILNA','KOOLYWURTIE','WILLAMULKA','FLINDERS PARK','CAREW','MOYHALL','BRAY','DE ROSE HILL','EUROMINA','MOOLAWATANA','PALMER','TELOWIE','POINT PEARCE','BUCKLAND PARK','GLENELG','CLELAND','BOSTON','NAILSWORTH','YANTANABIE','HOLOWILIENA SOUTH','ATHELSTONE','CLARENDON','BRIGHTON','DUTTON EAST','WALLAROO','MOONTA','SEMAPHORE SOUTH','STONYFELL','GLENGOWRIE','WALKERVILLE','WILLALO','CLEVE','ARMAGH','STOCKYARD PLAIN','LANGHORNE CREEK','ANGAS VALLEY','BANGOR','PYAP WEST','CALIPH','COWIRRA','CAPE DOUGLAS','DOVER GARDENS','LOCHIEL','ULOOLOO','WALTOWA','VIVONNE BAY','KOONUNGA','WARRAWEENA','PROSPECT','BRUCE','KINGOONYA','KIMBA','BRAHMA LODGE','WILLASTON','AVENUE RANGE','PINE POINT','IRON BARON','LAURA','ST IVES','MAROLA','MORTANA','MONARTO SOUTH','PAYNEHAM','KIELPA','CONMURRA','MILANG','WHYALLA PLAYFORD','WHITE HILL','SEACLIFF','SPRING GULLY','YUNYARINYI','MANOORA','ROXBY DOWNS STATION','WINDSOR','TARPEENA','CHRISTIES BEACH','PELLARING FLAT','YAHL','THE RANGE','YATTALUNGA','CRAFERS WEST','SPECTACLE LAKE','BIBARINGA','MOUNT JAGGED','WILGENA','WORROLONG','WUDINNA','YARRAH','TONSLEY','MANUNDA STATION','STEWART RANGE','COOLILLIE','WATTLE RANGE EAST','CLARE','FELIXSTOW','CAPE BORDA','GUM CREEK STATION','TARLEE','WISTOW','SOLOMONTOWN','HALLELUJAH HILLS','BIBLIANDO','DAW PARK','ROYAL PARK','FINNISS','YANYARRIE','CHAIN OF PONDS','SALISBURY SOUTH DC','ANDREWS','ENFIELD PLAZA','COCKATOO VALLEY','SELLICKS BEACH','SCOTT CREEK','HOVE','SOUTH HUMMOCKS','GLENELG NORTH','MONTEITH','MYLOR','WATTLE PARK','MORPHETTVILLE','STREAKY BAY','NORWOOD','FIVE MILES','MARKARANKA','DAWESLEY','PLYMPTON','TAYLORVILLE STATION','PLUMBAGO','CUNNINGHAM','BARMERA','TOTHILL BELT','HAPPY VALLEY','THURLGA','STATION ARCADE','GREENWITH','URAIDLA','REYNELLA EAST','GLANDORE','COPEVILLE','FLAXMAN VALLEY','MULKA','KRONDORF','WINGFIELD','SALTER SPRINGS','PUALCO RANGE','BLEWITT SPRINGS','SHEA-OAK LOG','BEULAH PARK','GOULD CREEK','BACKY POINT','NENE VALLEY','CONDOWIE','MOUNT GEORGE','LARGS BAY','ROSEWORTHY','MUNDOO ISLAND','HOPE FOREST','ELIZABETH DOWNS','SUTTONTOWN','WEEROONA ISLAND','WOLSELEY','ETHELTON','MILLERS CREEK','STOW','KAPPAWANTA','WILKAWATT','COMMONWEALTH HILL','HOPE VALLEY','BLAKEVIEW','BEACHPORT','HECTORVILLE','DALKEY','CUMMINS','ERNABELLA (PUKATJA)','CLAYTON STATION','SOUTH BRIGHTON','MOUNT DAMPER','CULBURRA','SOUTHEND','EVELYN DOWNS','MINDARIE','INNAMINCKA','BARNA','MITCHAM SHOPPING CENTRE','YELTA','MOUNT IVE','NEW RESIDENCE','WANDEARAH WEST','OLD KOOMOOLOO','HAWTHORN','GOOLWA','CROSS ROADS','QUORN','AYERS RANGE SOUTH','BLACK SPRINGS','DRY CREEK','LUCINDALE','KOOLUNGA','CEDUNA','WAROOKA','FOUL BAY','DONOVANS','NORTH YELTA','SEFTON PARK','JERVOIS','CLAYTON BAY','BROOKLYN PARK','BARINIA','FRANCES','COLLINSFIELD','KOORINE','KIDMAN PARK','WILCOWIE','WANILLA','SHAUGH','WILLIAM CREEK','PONDE','GRACE PLAINS','KANGAROO INN','WILLOW CREEK','PENNESHAW','MINBURRA','MOUNT OSMOND','STIRLING','UNGARRA','RENMARK SOUTH','WARD HILL','MIRANDA','LAKE TORRENS STATION','GLENALTA','OSBORNE','BOOLEROO CENTRE','MOORLANDS','WIRREGA','HIGHLAND VALLEY','COOMUNGA','GIDGEALPA','ANGEPENA','BAY OF SHOALS','ROSEWATER EAST','BORRIKA','RISDON PARK SOUTH','TORRENS VALE','PENOLA','SALISBURY SOUTH','TRANMERE','EBENEZER','ALLANDALE STATION','OLARY','WASLEYS','WATARRU','PURPLE DOWNS','UPPER STURT','HOLOWILIENA','PARAMATTA','NALPA','NONNING','VINE VALE','MOOLEULOOLOO','CRADOCK','MINBURRA PLAIN','AMATA','KANGAROO HEAD','TORRENS ISLAND','OAKDEN HILLS','PORT ELLIOT','BUNGAREE','SHORT','FURNER','CRAIGMORE','CARRIETON','NINNES','PROSPECT HILL','ROCKLEIGH','ROXBY DOWNS','WINULTA','GLYNDE PLAZA','LENSWOOD','GAWLER BELT','AUSTRALIA PLAINS','BARABBA','MAGGEA','ROWLAND FLAT','WILD HORSE PLAINS','SEDDON','MARLA','LIPSON','LAKE PLAINS','KINGSWOOD','MARTINS WELL','NELSHABY','PORT PATERSON','SHERLOCK','ZADOWS LANDING','LAKE TORRENS','ROSETOWN','INGLEWOOD','COONDAMBO','SADDLEWORTH','VICTOR HARBOR','SNOWTOWN','NARRUNG','DUCK PONDS','BUGLE HUT','NEPEAN BAY','EMU BAY','HAMILTON','CLARENCE PARK','YAMBA','COWARIE','LITTLE DOUGLAS','PETERHEAD','YORKE VALLEY','HILLBANK','TWO WELLS','GRAMPUS','GREENACRES','AGERY','HOLDER SIDING','OULNINA','SOUTH PLYMPTON','HINDMARSH VALLEY','MUNDOORA','RUDALL','BRUKUNGA','BROWN BEACH','MAGDALA','MAWSON LAKES','KAROONDA','OAKVALE STATION','HORNSDALE','JAMIESON','INKERMAN','KOHINOOR','NORTH MOOLOOLOO','NURIOOTPA','KONDOOLKA','WALKLEY HEIGHTS','POLISH HILL RIVER','RIVERLEA PARK','WORUMBA','MYRTLE BANK','THRINGTON','MOOROOK','MOUNT MARY','WHITES FLAT','KOONGAWA','BIRKENHEAD','MCHARG CREEK','COLLINSWOOD','POOGINAGORIC','LINDLEY','KEITH','BANKSIA PARK','RAMCO','MORN HILL','LOCKLEYS','MODBURY NORTH','RHYNIE','OAKDEN','BELTON','SANDY GROVE','SANDALWOOD','ADELAIDE AIRPORT','PERLUBIE','PIRIE EAST','MCLAREN FLAT','EVERARD CENTRAL','CHINBINGINA','KALAMURINA','ROCHESTER','KATUNGA STATION','BELAIR','BEAUMONT','NORTHFIELD','SELLICKS HILL','LIGHT PASS','MCBEAN POUND','CAVETON','CUTTLEFISH BAY','BOSWORTH','DORSET VALE','WOOLUNDUNGA','CALPERUM STATION','IWANTJA','STURT VALE','LEASINGHAM','SALTIA','WARNERTOWN','HAY FLAT','DE MOLE RIVER','MINTARO','LOCK','EXPORT PARK','HILLCREST','HALLETT','WILLUNGA HILL','DEEPWATER','MOUNT TORRENS','KENT TOWN','EYRE','BOOL LAGOON','MOONAREE','COOMOOROO','JAMES WELL','MANNUM','NETLEY','WATERVALE','ST CLAIR','MEDINDIE','MOUNT HOPE','BROWN HILL CREEK','CARAWA','GLENUNGA','HAMMOND','FARRELL FLAT','WEST HINDMARSH','SILVERTON','GLANVILLE','ROGUES POINT','TILLEY SWAMP','FARINA','BIMBOWRIE','ALMA','GLENELG EAST','SHEIDOW PARK','MARION','CALCA','GLENELG SOUTH','MOUNT MAGNIFICENT','ERINDALE','FAIRVIEW PARK','MOUNT VIVIAN','OLYMPIC DAM','GUMERACHA','SHAGGY RIDGE','WILLALOOKA','ANNADALE','NORTH MOONTA','BLAIR ATHOL','NILPENA','AUBURN','PINE CREEK STATION','BILLIATT','HILLTOWN','MANSFIELD PARK','NARACOORTE','MULOORINA','MAGILL','DEVONBOROUGH DOWNS','ELIZABETH VALE','PARUNA','ELWOMPLE','KANGARILLA','BON BON','GOLDEN GROVE','SUNNYBRAE','BAGOT WELL','BUNYUNG','MOCULTA','KALANGADOO','LEAWOOD GARDENS','GILES CORNER','POINT MCLEAY','MOUNT COOPER','PARAWA','PINE CREEK','TROTT PARK','MOUNT GAMBIER EAST','PINE HILL','MCCRACKEN','URANIA','BUTLER','KOOROONA','PARNDANA','EASTWOOD','KARATTA','MOUNT MCKENZIE','WOMBATS REST','FOREST RANGE','LOXTON NORTH','YATALA VALE','MYPOLONGA','MURTHO','AVON','GLOBE DERBY PARK','PANITYA','MYOLA STATION','VERDUN','OAKBANK','EDEN VALLEY','FULHAM','TIDDY WIDDY BEACH','ALLENDALE EAST','BALD HILLS','TERINGIE','CURNAMONA','YANKALILLA','MOUNT BENSON','GARDEN ISLAND','WOODCHESTER','FISCHER','MIL-LEL','CAMBRAI','WAUKARINGA','WASHPOOL','WOOLTANA','PINERY','CAROLINE','KOONIBBA','BUNBURY','KADINA','OTTOWAY','MOUNT DRUMMOND','DUNCAN','ANGORIGINA','TORRENS PARK','VALE PARK','STONE HUT','WILLSON RIVER','TAPEROO','MAHANEWO','CUMBERLAND PARK','PYAP','ST AGNES','WEST BEACH','WHITWARTA','CUNLIFFE','CHANDLERS HILL','SEACLIFF PARK','DULKANINNA','MOUNT FALKLAND','NORTHGATE','GILLES DOWNS','COUCH BEACH','MOOROOK SOUTH','GLEN OSMOND','STRZELECKI DESERT','PORT LINCOLN','NORTH BRIGHTON','KINGSTON PARK','GERANIUM PLAINS','NILPINNA STATION','QUINYAMBIE','CYGNET RIVER','MULYUNGARIE','PANORAMA','NEWTON','ALAWOONA','NORTH ADELAIDE','ORATUNGA STATION','BELALIE NORTH','MOERLONG','BLACK FOREST','ALDGATE','MILLSWOOD','PARNAROO','BELVIDERE','PINNAROO','KOOLGERA','EDINBURGH RAAF','GOYDER','SOMERTON PARK','MAYFIELD','WELLAND','LOWBANK','RENMARK NORTH','MOSQUITO HILL','GOOLWA NORTH','LAMBINA','KI KI','MARKS LANDING','BENDA','NALYAPPA','PENFIELD GARDENS','CALOMBA','FLAXLEY','ROCKY CAMP','KANYAKA','NGARKAT','LYNDOCH','ERUDINA','MIDDLEBACK RANGE','WEPAR','BUMBUNGA','YELTANA','NURRAGI','COBDOGLA','TEA TREE GULLY','HUDDLESTON','ANNA CREEK','MOUNT HAVELOCK','FRANKLYN','KOONAMORE','PORT PIRIE','COORABIE','KEPA','VISTA','ALLENBY GARDENS','ALLENDALE NORTH','TAYLORVILLE','PEKINA','BLACKFORD','WILLUNGA SOUTH','EAST MOONTA','YUNDI','BURRUNGULE','CAVAN','MUNNO PARA','APAMURRA','PORT VINCENT','OLD NOARLUNGA','TUNGKILLO','COONAWARRA','GLENCOE','POINT SOUTTAR','BOCONNOC PARK','WHITES VALLEY','SEATON','BIRDWOOD','VEITCH','KONGORONG','MITCHELLVILLE','CONCORDIA','PIEDNIPPIE','WANDILO','HARDWICKE BAY','HAZELWOOD PARK','OAK VALLEY','BROMPTON','MERTY MERTY','ENFIELD','CADGEE','WILLYAROO','PORT ARTHUR','DERNANCOURT','MOUNT SERLE','CLOVELLY PARK','MOUNT BARKER SPRINGS','STIRLING NORTH','TEROWIE','PORTER LAGOON','NORTON SUMMIT','PENWORTHAM','OODLA WIRRA','STOKES BAY','FITZGERALD BAY','PARINGA','LINDEN PARK','CADELL LAGOON','SUNNYSIDE','NEW PORT','FLORINA STATION','POINT PASS','PARACOMBE','HENLEY BEACH SOUTH','MANNERS WELL','MANNA HILL','BALHANNAH','CHAPMAN BORE','ERITH','UNDALYA','THE GAP','PORT MACDONNELL','BUCHFELDE','NARLABY','MUNGERANIE','NAIN','YOUNGHUSBAND','JOANNA','KENSINGTON','MAMBRAY CREEK','WESTERN FLAT','SAINTS','YARDEA','MUSTON','ONKAPARINGA HEIGHTS','DEVLINS POUND','MUDAMUCKLA','WAMI KATA','BLACK HILL STATION','BAROSSA GOLDFIELDS','TARCOWIE','UMUWA','SWANPORT','LEWISTON','DAVOREN PARK SOUTH','PENFIELD','MILENDELLA','SEAFORD HEIGHTS','COLEBATCH','TOTHILL CREEK','MELTON STATION','ST KITTS','SANDY CREEK','LAKE VIEW','ATHOL PARK','INGOMAR','EUDUNDA','SKYE','MAUDE','NANBONA','WEST LAKES SHORE','BIRCHMORE','HOUGHTON','UCOLTA','MOUNT BARRY','BORDERTOWN','WHYTE YARCOWIE','LOBETHAL','INGLE FARM','WANBI','WEPOWIE','DUTTON','MOPPA','BINDARRAH','DAVENPORT','LINCOLN NATIONAL PARK','HEWETT','WATRABA','INNESTON','ETTRICK','EVANSTON GARDENS','BAIRD BAY','BLACK ROCK','UMBERATANA','KANMANTOO','GOLDEN HEIGHTS','DEVON PARK','CASSINI','UNLEY','SALISBURY NORTH','ROSE PARK','SOLOMON','STANLEY FLAT','MONGOLATA','DENIAL BAY','FORDS','PARRAKIE','BLACK HILL','BOWMANS','NEW WELL','TALIA','BEAUFORT','WESTBOURNE PARK','SMITHFIELD PLAINS','ANGASTON','KALKAROO','SALISBURY EAST','SLEAFORD','ALBERTON','COLONEL LIGHT GARDENS','VIRGINIA','CHITON','RENDELSHAM','PASKEVILLE','WINTABATINYANA','NETHERBY','MERCUNDA','LINDON','SAPPHIRETOWN','MEADOWS','MARLESTON DC','GERMEIN BAY','NOTTS WELL','CALLINGTON','INDULKANA (IWANTJA)','GIFFORD HILL','CALLANNA','KLEMZIG','PAISLEY','WELBOURN HILL','SANDERGROVE','WEST BUNDALEER','MOUNT VICTOR STATION','FREWVILLE','LITTLEHAMPTON','PORT PIRIE WEST','PORT HUGHES','KYEEMA','COCKALEECHIE','EURELIA','BRADBURY','MURRAY BRIDGE EAST','BLACKFELLOWS CREEK','SECRET ROCKS','NORMANVILLE','MORCHARD','CARCUMA','MALVERN','PARALOWIE','PENNINGTON','POMPOOTA','WOODLANE','PARATOO','PARIS CREEK','FIELD','WHARMINDA','TRINITY GARDENS','NAIRNE','KENSINGTON PARK','BUCKLEBOO','PORT WILLUNGA','MACDONALD PARK','CAMPBELLTOWN','BURNSIDE','SHERWOOD','CURRAMULKA','MENINGIE EAST','MENZIES','LEIGHTON','MURDINGA','PORT WAKEFIELD','BELLEVUE HEIGHTS','CAMPOONA','CASTAMBUL','SENIOR','WOODVILLE GARDENS','NORTH WEST BEND','BENBOURNIE','OLD REYNELLA','KALANBI','YONGALA','HAWKS NEST STATION','DUDLEY PARK','LYNTON','WOODVILLE SOUTH','STUART','TEMPLERS','TRURO','SANDILANDS','THOMAS PLAIN','TRANMERE NORTH','COLTON','PINKS BEACH','ADELAIDE','LUCKY BAY','HAMLEY BRIDGE','RACECOURSE BAY','CRAFERS','KATARAPKO','PORT DAVIS','POOGINOOK','MOUNT SCHANK','HALIDON','FOUNTAIN','EVANSTON PARK','MOUNT CRAWFORD','PORT KENNY','THREE CREEKS','HYNAM','YALYMBOO','CHRISTIE DOWNS','NETLEY GAP','MIDDLE RIVER','SPRINGTON','SPRINGFIELD','ARCOONA','KRONGART','MIDGEE','MINBRIE','MOUNT SARAH','NACKARA','DARKE PEAK','MACUMBA','NILDOTTIE','COONALPYN','ELIZABETH NORTH','KARTE','REEDY CREEK','ELLISTON','JAMESTOWN','BOOLCOOMATTA','WONGYARRA','SCEALE BAY','COFFIN BAY','AVOCA DELL','BIGGS FLAT','ELIZABETH SOUTH','GEPPS CROSS','YANKANINNA','PARA VISTA','MOANA','MINVALARA','QUALCO','BEAUMONTS','GOSSE','FISHER','COOBER PEDY','PAYNEHAM SOUTH','BROUGHTON RIVER VALLEY','COOYERDOO','COOMBE','WESTONS FLAT','LOWAN VALE','STURT','ANDREWS FARM','BOORS PLAIN','CANEGRASS','PARAFIELD','SWEDE FLAT','KARCULTABY','SUNLANDS','NYAPARI','MURLONG','NECTAR BROOK','UPALINNA','KEPPOCH','ROSEWATER','MOORILLAH','WINTINNA','LONSDALE DC','WILLOW SPRINGS','KOKATHA','NORA CREINA','BALAKLAVA','TODMORDEN','CARRICKALINGA','PALKAGEE','MUNDOWDNA','BROADVIEW','WAROONEE','MELTON','GERMAN FLAT','WEETULTA','CAVENAGH','CLAPHAM','FARAWAY HILL','MARRYATVILLE','HAMLEY','TANTANOOLA','MODBURY HEIGHTS','HILTON','WOMPINIE','BILLEROO WEST','ERSKINE','KESWICK TERMINAL','HALIFAX STREET','FALSE BAY','MOOLOOLOO','PEAKE','GERANIUM','MCCALLUM','LEABROOK','MOUNT CLARENCE STATION','RENMARK WEST','CARRIEWERLOO','LONGWOOD','ST KILDA','EVANSTON','HILLIER','LOXTON','BOLTO','WIGLEY FLAT','RED CREEK','GILLMAN','ECHUNGA','GLENDAMBO','KALABITY','PARHAM','KEYNETON','DINGABLEDINGA','LOVEDAY','SURREY DOWNS','MERIBAH','MYPONGA BEACH','CAURNAMONT','YADLAMALKA','POOCHERA','BARATTA','MUNNO PARA WEST','KYANCUTTA','CLEARVIEW','KONGOLIA','MOUNT FREELING','DISMAL SWAMP','MOUNT LIGHT','MANTUNG','PURNONG','WOODVILLE WEST','COONAMIA','WINNINOWIE','YALPARA','RAPID BAY','COOKE PLAINS','PORT NOARLUNGA','CHRISTIES BEACH NORTH','SMOKY BAY','BEDFORD PARK','SEDAN','SOUTH GAP','PARAKYLIA','NAIDIA','ADELAIDE BC','HAINES','ALTON DOWNS STATION','WIRRABARA','BARNDIOOTA','MARINO','MUNDIC CREEK','WAURALTEE','PEWSEY VALE','ST MORRIS','YUMALI','HENDON','CHELTENHAM','FORSTER','STEPHENSTON','WILCHERRY','MITCHAM','MAITLAND','HEATHFIELD','LAKE EVERARD','BASKET RANGE','PERNATTY','BIG BEND','EDINBURGH','NORTH PLYMPTON','MOUNT WILLOUGHBY','BOOKPURNONG','TIEYON','CUNYARIE','ROBE','MOUNT GAMBIER','WILLOWIE','FREELING','RENOWN PARK','BUGLE RANGES','PUNYELROO','MILE END','SUMMERTOWN','KESWICK','NEPABUNNA','BELTANA','WEST CROYDON','MUNDULLA','MABEL CREEK','YATINA','MURRAY BRIDGE NORTH','WATTLE RANGE','MYPONGA','STOCKWELL','RIVERGLEN','WYE','SALISBURY PLAIN','TAUNTON','BLACKFELLOWS CAVES','SEBASTOPOL','NULLARBOR','MORPHETT VALE','MIDDLETON','FORESTVILLE','SEAVIEW DOWNS','SPRING FARM','BUNDEY','EDWARDSTOWN','OULNINA PARK','FOWLERS BAY','COMMISSARIAT POINT','BALLAST HEAD','NETHERTON','ST MARYS','CRYSTAL BROOK','GAWLER SOUTH','CAPE JERVIS','CLAY WELLS','PETERBOROUGH','MOUNT BARKER SUMMIT','REYNELLA','YALATA','WHYALLA NORRIE NORTH','JOSLIN','HARDY','SHEAOAK FLAT','RICHMOND','FULLARTON','BLINMAN','KAINTON','HILTON PLAZA','PORT NEILL','WINNININNIE','MALLALA','COOTRA','WILMINGTON','BLACKWOOD','DAWSON','HALLETT COVE','VERRAN','PORT GIBBON','MELROSE','WATCHMAN','MUNDI MUNDI','MELROSE PARK','SEAFORD','MARBLE HILL','TOOPERANG','KUDLA','KINGSCOTE','LAURA BAY','HOLDEN HILL','LYRUP','MOUNT BURR','BRADY CREEK','BARUNGA GAP','JABUK') NOT NULL,
  `end_location` enum('MOTPENA','MCLAREN VALE','PORT AUGUSTA NORTH','GAWLER RIVER','CHUNDARIA','ELIZABETH EAST','MULGUNDAWA','GAWLER RANGES','GAMMON RANGES','MOUNT COMPASS','BOONERDO','YANERBIE','MOUNT MCINTYRE','UWORRA','MALINONG','BRINKLEY','BLYTH','TORRENSVILLE PLAZA','MONTACUTE','COMAUM','ERINGA','TORRENSVILLE','CORTLINYE','HIGHGATE','BUNGAMA','STANLEY','LINCOLN GAP','BEVERLEY','HOYLETON','PANDIE PANDIE','WILD DOG VALLEY','KINGSTON SE','WHYALLA STUART','PUNTABIE','PICCADILLY','GOOLWA SOUTH','PAECHTOWN','MARREE','PORT MOOROWIE','SALISBURY HEIGHTS','BURR WELL','WOKURNA','EIGHT MILE CREEK','ANDAMOOKA','BALGOWAN','MINGARY','NARRIDY','POINT STURT','NOARLUNGA CENTRE','BOOKABIE','SALISBURY','WANGARY','GOOLWA BEACH','CORNY POINT','MOUNT BARKER JUNCTION','REID','PEEBINGA','ABERFOYLE PARK','BEATTY','CLAYPANS','MONARTO','MARREE STATION','WONGULLA','MITCHELL PARK','MUNNO PARA DOWNS','TARNMA','WILLOW BANKS','LONG FLAT','PADTHAWAY','WAITPINGA','JERUSALEM','SEACOMBE GARDENS','KYBYBOLITE','POONINDIE','PORT PIRIE SOUTH','WOODFORDE','PYGERY','FISHERMAN BAY','MANGALO','WARTAKA','ROCKY PLAIN','DEEP CREEK','COOBOWIE','PINDA SPRINGS','YUMBARRA','BURNSFIELD','PETINA','FARM BEACH','PARA HILLS WEST','KANPI','ASHFORD','PASADENA','TEPKO','MOUNT BRYAN','KINGSTON ON MURRAY','STANSBURY','CEDUNA WATERS','WALLALA','PETHERICK','GILBERTON','GREENBANKS','EDITHBURGH','SEMAPHORE','ELIZABETH','KILKENNY','SEMAPHORE PARK','HUMBUG SCRUB','TANUNDA','CLIFTON HILLS STATION','WOOLUMBOOL','WITCHITIE','COCATA','ISLAND BEACH','TUSMORE','REDHILL','CHERRY GARDENS','PANDURRA','PORT BONYTHON','PENONG','WOODVILLE PARK','PRICE','WHITE SANDS','BOOBOROWIE','COPLEY','MACCLESFIELD','GREEN PATCH','MORGAN','TOOTENILLA','WATERLOO','ULYERRA','HANSBOROUGH','LOUTH BAY','NEWLAND','WAYVILLE','ETADUNNA','AMERICAN BEACH','DAVOREN PARK','GLENROY','O''SULLIVAN BEACH','LAKE HARRIS','COLLINSVILLE','MOOCKRA','MURRAY BRIDGE SOUTH','PARADISE','BUCHANAN','THE PINES','POINT TURTON','WHITE HUT','PUNTHARI','FIRLE','PARK HOLME','BURTON','GLYNDE','TALDRA','KANNI','EMU FLAT','ORROROO','GLENSIDE','HACKHAM WEST','EVERARD PARK','BRIDGEWATER','JULIA','OLD TEAL FLAT','COOMANDOOK','HACKNEY','HAMPDEN','MERRITON','HILL RIVER','LAKE MACFARLANE','KAPUNDA','SEAFORD RISE','ST PETERS','WITJIRA','FLAGSTAFF HILL','MODBURY','MYRTLE SPRINGS','PORT BROUGHTON','NANGWARRY','THEBARTON','JERICHO','TOOLIGIE','WOODS POINT','KOPPIO','LAKE ALBERT','PALLAMANA','CUDLEE CREEK','WIRRINA COVE','ASHTON','LOWER INMAN VALLEY','QUONDONG','ROCKY GULLY','HAMBIDGE','KALBEEBA','ARDROSSAN','HINDMARSH TIERS','WEDGE ISLAND','ALTONA','PORT AUGUSTA','IRONBANK','FULHAM GARDENS','BURDETT','WELLINGTON','DULWICH','YARRAMBA','MARDEN','PINKERTON PLAINS','CROWN POINT','NORTH HILLS','YORKETOWN','GREENOCK','YUDNAPINNA','COLES','NORTH BEACH','OVINGHAM','NORTH HAVEN','COLLEGE PARK','TAPLAN','MOORAK','MULGA VIEW','GERMAN CREEK','ANGAS PLAINS','WITERA','POINT BOSTON','POLTALLOCH','CITY WEST CAMPUS','SEACOMBE HEIGHTS','EMEROO','MOUNT BRYAN EAST','ALFORD','TAILEM BEND','TOORA','KILBURN NORTH','WALKER FLAT','LANGS LANDING','SCHELL WELL','PIKE RIVER','PROSPECT EAST','MOUNT GAMBIER WEST','NUNJIKOMPITA','JULANKA HOLDINGS','WANDANA','ROSSLYN PARK','TOTNESS','GUM CREEK','QUEENSTOWN','ONE TREE HILL','CROYDON','BRIGHT','MENINGIE','PRELINNA','THORNGATE','EVANDALE','MAKIN','NADIA','SUNNYDALE','NORTH ADELAIDE MELBOURNE ST','HOLDER','DUDLEY EAST','WHYALLA JENKINS','ARNO BAY','BOATSWAIN POINT','WUNKAR','OUTER HARBOR','COWANDILLA','RIDGEHAVEN','HORSNELL GULLY','WILLUNGA','KYBUNGA','ARTHURTON','CUNGENA','DOUGLAS POINT','SQUARE MILE','HUTT STREET','FERRYDEN PARK','MOUNT OBSERVATION','CHILPENUNDA','ENCOUNTER BAY','SALISBURY EAST NORTHBRI AVE','HALBURY','YELLABINNA','PARKSIDE','BOLLARDS LAGOON','MARLESTON','MINLATON','CLARENCE GARDENS','GAWLER EAST','YALLUNDA FLAT','JUPITER CREEK','TENNYSON','MULGARIA','WHYALLA NORRIE EAST','ALBERT PARK','CANOWIE','HASLAM','MATTA FLAT','VENUS BAY','KENSINGTON GARDENS','MAGAREY','PORT LINCOLN SOUTH','TUMBY BAY','FRAYVILLE','PINKAWILLINIE','STUN''SAIL BOOM','MARCOLLAT','KALTJITI','HEATHPOOL','SALISBURY PARK','MOUNT PLEASANT','POINT LOWLY','WIAWERA','DIREK','BOWER','BLACK POINT','WELLINGTON EAST','TARATAP','TYRINGA','PENRICE','STEINFELD','NORTH SHIELDS','HILTABA','BRENTWOOD','WOODLEIGH','BINNUM','PARSONS BEACH','IRONSTONE','LAKE GAIRDNER','PATA','EVANSTON SOUTH','SANDERSTON','WYNN VALE','GOMERSAL','NEW TOWN','WAPPILKA','DARLINGTON','SIMPSON DESERT','UNO','MCDOUALL PEAK','CARALUE','BUNDALEER GARDENS','ASHBOURNE','LOCKES CLAYPAN','MONTARRA','BLAKISTON','CLEMENTS GAP','PORT GERMEIN','WATTLE FLAT','SUNNYVALE','TIATUKIA','CORDILLO DOWNS','SPALDING','KINGSFORD','HAWSON','WARBURTO','OLD CALPERUM','WARRADALE NORTH','KALLORA','MACGILLIVRAY','PORT RICKABY','GREEN HILLS RANGE','WHYALLA NORRIE','TEAL FLAT','MULGATHING','BERRI','LONSDALE','IRON KNOB','ST JOHNS','WITCHELINA','FLINDERS RANGES','NANGKITA','STRATHALBYN','BUNGEROO','CHAPEL HILL','MUTOOROO','HARROGATE','NORTH BOOBOROWIE','WATERLOO CORNER','PINJARRA STATION','PARA HILLS','CANNAWIGARA','THORNLEA','MURPUTJA','EBA ANCHORAGE','DANGGALI','HOPE GAP','ALDINGA BEACH','PETWOOD','YALANDA','MOONTA BAY','KALKA','FRAHNS','MULLAQUANA','MOBILONG','CHOWILLA','HYDE PARK','LEIGH CREEK','RAMSAY','LAKE EYRE','MILE END SOUTH','NEALES FLAT','WADDIKEE','MINNIPA','ROBERTSTOWN','BRAMFIELD','APPILA','COOLTONG','FOX','KARKOO','MURRAY TOWN','HAHNDORF','OVERLAND CORNER','NAPPERBY','MURRAWONG','GALGA','BOLIVAR','BELALIE EAST','FORRESTON','RIVERGLADES','DOUGLAS POINT SOUTH','SALEM','CULTANA','CALTOWIE NORTH','VICTOR HARBOR CENTRAL','LOWER MITCHAM','PUREBA','GERARD','SMITHFIELD','YEELANNA','URRBRAE','MASLIN BEACH','KOPPAMURRA','GULNARE','KOLENDO','PIPALYATJARA','WILLIPPA','FROME DOWNS','KILBURN','MOUNT DUTTON BAY','PORT MANNUM','MOSELEY','HINCKS','PORKY FLAT','PORT GAWLER','BLUFF BEACH','CROYDON PARK','WEEKEROO','ULEY','KURRALTA PARK','EDEN HILLS','BETHANY','WESTERN RIVER','WILLOCHRA','TOORAK GARDENS','PORT ADELAIDE','LOWER HERMITAGE','PIMBAACLA','GREEN FIELDS','CALTOWIE WEST','GAWLER','KALDOONERA','GILLENTOWN','WILLIAMSTOWN','TARCOOLA','ASCOT PARK','HARTLEY','ALPANA','STONE WELL','PEARLAH','KERSBROOK','TIKALINA','CUSTON','WALLAROO PLAIN','WESTALL','ROSTREVOR','GREENWAYS','WOODVILLE NORTH','CADELL','HATHERLEIGH','MURNINNIE BEACH','PLEASANT PARK','CRESCENT','WOOLSHEDS','HACKHAM','WALLAROO MINES','THEVENARD','ANDAMOOKA STATION','ROSEDALE','GULFVIEW HEIGHTS','BALDINA','MILLBROOK','KOONOONA','DELAMERE','BURRA','WOOMERA','LOCHABER','PELICAN POINT','MIDDLE BEACH','SHERINGA','WALLERBERDINA','MORPHETTS FLAT','GREENHILL','WERTALOONA','YACKA','ASHVILLE','SEPPELTSFIELD','GOOD HOPE LANDING','WISANGER','COCKBURN','WARD BELT','MANNANARIE','FRANKTON','HART','LOWER BROUGHTON','BOCKELBERG','HAWKER','PARILLA','TICKERA','MARION BAY','BROWNLOW KI','WONNA','SWAN REACH','WHYALLA','PANEY','BAKARA WELL','CLINTON CENTRE','MUNDULLA WEST','COMPTON','BAROOTA','CANOWIE BELT','SEAL BAY','STRUAN','MENINGIE WEST','PARCOOLA','PELICAN LAGOON','PUKATJA','LAKE CARLET','STUARTS CREEK','WHYALLA DC','GOLDEN GROVE VILLAGE','WIRRULLA','HENLEY BEACH','WHITES RIVER','YANINEE','CALTOWIE','ELIZABETH GROVE','VALLEY VIEW','NATURI','ANTECHAMBER BAY','FARINA STATION','MERGHINY','PORT VICTORIA','D''ESTREES BAY','SEVENHILL','WYNARKA','GLUEPOT','UNDERDALE','HANSON','BALAH','ROCKY POINT','COROMANDEL EAST','HONITON','HUNTFIELD HEIGHTS','LEIGH CREEK STATION','REEVES PLAINS','EDIACARA','ONKAPARINGA HILLS','GRANGE','MILTALIE','EMU DOWNS','LAURIE PARK','ILLEROO','MOUNT WEDGE','ANANGU PITJANTJATJARA YANKUNYTJATJARA','WILLOUGHBY','SOUTH KILKERRAN','WORLDS END','MOUNT LYNDHURST','ULEYBURY','APOINGA','BAUDIN BEACH','CAMDEN PARK','MURRAY BRIDGE','TEPCO STATION','WONUARRA','SAMPSON FLAT','GLOSSOP','ISLAND LAGOON','OWEN','WAIKERIE','POORAKA','KELLY','MOUNT ARDEN','AMERICAN RIVER','LAKE GILLES','MELROSE PARK DC','MUNDALLIO','PEEP HILL','MONBULLA','ANGLE PARK','GLENBURNIE','ARKAROOLA VILLAGE','CALOOTE','BOWILLIA','BRINKWORTH','WIRREALPA','RIDLEYTON','MINBURRA STATION','PINE VALLEY STATION','KAPINNIE','WHITE WELL CORNER','RUNDLE MALL','FITZROY','TULKA','COWELL','EXETER','WILKATANA STATION','SALT CREEK','WEBB BEACH','ABMINGA STATION','SECOND VALLEY','OODNADATTA','BOWDEN','MOODY','CHARRA','BLANCHE HARBOR','WINDSOR GARDENS','YUNTA','BRIMBAGO','FLINDERS CHASE','HAYBOROUGH','CLINTON','MAYLANDS','FLINDERS UNIVERSITY','TUNKALILLA','ST GEORGES','BOWHILL','WALLOWAY','NUROM','MAGILL NORTH','STEELTON','WIRRAMINNA','OB FLAT','TINTINARA','CHARLTON GULLY','CHERRYVILLE','COULTA','CURRENCY CREEK','CANUNDA','PROOF RANGE','ELIZABETH PARK','NARRINA','PORT AUGUSTA WEST','COORONG','AMYTON','REDWOOD PARK','DOWLINGVILLE','MOUNT JOY','CROMER','JOHNBURGH','KONGAL','INKSTER','MITCHELL','LARGS NORTH','COWLEDS LANDING','GOODWOOD','GURRA GURRA','EDINBURGH NORTH','KENTON VALLEY','LYNDHURST','WHYALLA BARSON','MOUNT CHARLES','MARYVALE','SALISBURY DOWNS','SANDLETON','SIAM','CARPENTER ROCKS','WOOLPUNDA','MIMILI','HAMPSTEAD GARDENS','KANGAROO FLAT','ROYSTON PARK','GEORGETOWN','WOOL BAY','BACK VALLEY','KORUNYE','BULLOO CREEK','WEST LAKES','WOOLSHED FLAT','PORT JULIA','WATERFALL GULLY','LONG PLAINS','PAGES FLAT','PETERSVILLE','BILLA KALINA','HAWTHORNDENE','O''HALLORAN HILL','DUDLEY WEST','MURBKO','WINKIE','YINKANIE','WOODCROFT','WARRADALE','KOOTABERRA','KEILIRA','BLETCHLEY','BURRA EASTERN DISTRICTS','HAY VALLEY','HIGHBURY','NGAPALA','SULTANA POINT','WOODVILLE','CAREY GULLY','OUTALPA','THOMPSON BEACH','MARRABEL','BORDERTOWN SOUTH','MANNINGHAM','WATINUMA','RIVERTON','RISDON PARK','WARNES','GEMMELLS','WARRAMBOO','WYOMI','EBA','YOUNGHUSBAND HOLDINGS','RENMARK','CRAIGBURN FARM','SALISBURY NORTH WHITES ROAD','BEETALOO VALLEY','BULGUNNIA','ARKAROOLA','MOONTA MINES','BLANCHETOWN','UPPER HERMITAGE','NORWOOD SOUTH','WALL FLAT','MONASH','WEST RANGE','INMAN VALLEY','LAFFER','LAKE FROME','CHINAMAN WELLS','HACKLINS CORNER','LAMEROO','WANDEARAH EAST','CHARLESTON','POINT LOWLY NORTH','LINWOOD','MOUNT TEMPLETON','OAKLANDS PARK','BULL CREEK','UNLEY PARK','HINDMARSH ISLAND','PUTTAPA','NOVAR GARDENS','HINDMARSH','DAVEYSTON','ALDINGA','PLYMPTON PARK','BANGHAM','BETHEL','BUTE','COLLEY','STOCKPORT','WEST RICHMOND','MINGBOOL','MARAMA','MURNPEOWIE','TOLDEROL','MALTEE','WADNAMINGA','CHANDADA','LIGHTSVIEW','CORUNNA STATION','BUNDALEER NORTH','SPENCE','DUBLIN','PORT NOARLUNGA SOUTH','AULDANA','LOWER LIGHT','REDBANKS','LAKE ALEXANDRINA','MALPAS','KIANA','NOARLUNGA DOWNS','BOOLGUN','ANAMA','BROOKER','TOWITTA','COOK','STEPNEY','STOCKYARD CREEK','HOSKIN CORNER','PIMBA','RAMCO HEIGHTS','TATACHILLA','PARAFIELD GARDENS','MARANANGA','WANGOLINA','BROWNLOW','SALISBURY SOUTH BC','POLDA','KUITPO COLONY','SEAFORD MEADOWS','WOODSIDE','KINGS PARK','KUITPO','BELTANA STATION','KRINGIN','ANGLE VALE','EDILLILIE','MITCHIDY MOOLA','GAWLER WEST','REGENCY PARK','WRATTONBULLY','FINDON','BUCKINGHAM','MAAOUPE','MOUNT EBA','GILLES PLAINS','GLADSTONE','MEDINDIE GARDENS','COROMANDEL VALLEY','PERPONDA','CAPE JAFFA','CHAFFEY','MILLICENT','BAKARA','MOUNT BARKER','SUTHERLANDS','NANTAWARRA','KULPARA','NORTHERN HEIGHTS','BRENDA PARK','KELLIDIE BAY','ARCKARINGA','NORTH CAPE','PARACHILNA','KOOLYWURTIE','WILLAMULKA','FLINDERS PARK','CAREW','MOYHALL','BRAY','DE ROSE HILL','EUROMINA','MOOLAWATANA','PALMER','TELOWIE','POINT PEARCE','BUCKLAND PARK','GLENELG','CLELAND','BOSTON','NAILSWORTH','YANTANABIE','HOLOWILIENA SOUTH','ATHELSTONE','CLARENDON','BRIGHTON','DUTTON EAST','WALLAROO','MOONTA','SEMAPHORE SOUTH','STONYFELL','GLENGOWRIE','WALKERVILLE','WILLALO','CLEVE','ARMAGH','STOCKYARD PLAIN','LANGHORNE CREEK','ANGAS VALLEY','BANGOR','PYAP WEST','CALIPH','COWIRRA','CAPE DOUGLAS','DOVER GARDENS','LOCHIEL','ULOOLOO','WALTOWA','VIVONNE BAY','KOONUNGA','WARRAWEENA','PROSPECT','BRUCE','KINGOONYA','KIMBA','BRAHMA LODGE','WILLASTON','AVENUE RANGE','PINE POINT','IRON BARON','LAURA','ST IVES','MAROLA','MORTANA','MONARTO SOUTH','PAYNEHAM','KIELPA','CONMURRA','MILANG','WHYALLA PLAYFORD','WHITE HILL','SEACLIFF','SPRING GULLY','YUNYARINYI','MANOORA','ROXBY DOWNS STATION','WINDSOR','TARPEENA','CHRISTIES BEACH','PELLARING FLAT','YAHL','THE RANGE','YATTALUNGA','CRAFERS WEST','SPECTACLE LAKE','BIBARINGA','MOUNT JAGGED','WILGENA','WORROLONG','WUDINNA','YARRAH','TONSLEY','MANUNDA STATION','STEWART RANGE','COOLILLIE','WATTLE RANGE EAST','CLARE','FELIXSTOW','CAPE BORDA','GUM CREEK STATION','TARLEE','WISTOW','SOLOMONTOWN','HALLELUJAH HILLS','BIBLIANDO','DAW PARK','ROYAL PARK','FINNISS','YANYARRIE','CHAIN OF PONDS','SALISBURY SOUTH DC','ANDREWS','ENFIELD PLAZA','COCKATOO VALLEY','SELLICKS BEACH','SCOTT CREEK','HOVE','SOUTH HUMMOCKS','GLENELG NORTH','MONTEITH','MYLOR','WATTLE PARK','MORPHETTVILLE','STREAKY BAY','NORWOOD','FIVE MILES','MARKARANKA','DAWESLEY','PLYMPTON','TAYLORVILLE STATION','PLUMBAGO','CUNNINGHAM','BARMERA','TOTHILL BELT','HAPPY VALLEY','THURLGA','STATION ARCADE','GREENWITH','URAIDLA','REYNELLA EAST','GLANDORE','COPEVILLE','FLAXMAN VALLEY','MULKA','KRONDORF','WINGFIELD','SALTER SPRINGS','PUALCO RANGE','BLEWITT SPRINGS','SHEA-OAK LOG','BEULAH PARK','GOULD CREEK','BACKY POINT','NENE VALLEY','CONDOWIE','MOUNT GEORGE','LARGS BAY','ROSEWORTHY','MUNDOO ISLAND','HOPE FOREST','ELIZABETH DOWNS','SUTTONTOWN','WEEROONA ISLAND','WOLSELEY','ETHELTON','MILLERS CREEK','STOW','KAPPAWANTA','WILKAWATT','COMMONWEALTH HILL','HOPE VALLEY','BLAKEVIEW','BEACHPORT','HECTORVILLE','DALKEY','CUMMINS','ERNABELLA (PUKATJA)','CLAYTON STATION','SOUTH BRIGHTON','MOUNT DAMPER','CULBURRA','SOUTHEND','EVELYN DOWNS','MINDARIE','INNAMINCKA','BARNA','MITCHAM SHOPPING CENTRE','YELTA','MOUNT IVE','NEW RESIDENCE','WANDEARAH WEST','OLD KOOMOOLOO','HAWTHORN','GOOLWA','CROSS ROADS','QUORN','AYERS RANGE SOUTH','BLACK SPRINGS','DRY CREEK','LUCINDALE','KOOLUNGA','CEDUNA','WAROOKA','FOUL BAY','DONOVANS','NORTH YELTA','SEFTON PARK','JERVOIS','CLAYTON BAY','BROOKLYN PARK','BARINIA','FRANCES','COLLINSFIELD','KOORINE','KIDMAN PARK','WILCOWIE','WANILLA','SHAUGH','WILLIAM CREEK','PONDE','GRACE PLAINS','KANGAROO INN','WILLOW CREEK','PENNESHAW','MINBURRA','MOUNT OSMOND','STIRLING','UNGARRA','RENMARK SOUTH','WARD HILL','MIRANDA','LAKE TORRENS STATION','GLENALTA','OSBORNE','BOOLEROO CENTRE','MOORLANDS','WIRREGA','HIGHLAND VALLEY','COOMUNGA','GIDGEALPA','ANGEPENA','BAY OF SHOALS','ROSEWATER EAST','BORRIKA','RISDON PARK SOUTH','TORRENS VALE','PENOLA','SALISBURY SOUTH','TRANMERE','EBENEZER','ALLANDALE STATION','OLARY','WASLEYS','WATARRU','PURPLE DOWNS','UPPER STURT','HOLOWILIENA','PARAMATTA','NALPA','NONNING','VINE VALE','MOOLEULOOLOO','CRADOCK','MINBURRA PLAIN','AMATA','KANGAROO HEAD','TORRENS ISLAND','OAKDEN HILLS','PORT ELLIOT','BUNGAREE','SHORT','FURNER','CRAIGMORE','CARRIETON','NINNES','PROSPECT HILL','ROCKLEIGH','ROXBY DOWNS','WINULTA','GLYNDE PLAZA','LENSWOOD','GAWLER BELT','AUSTRALIA PLAINS','BARABBA','MAGGEA','ROWLAND FLAT','WILD HORSE PLAINS','SEDDON','MARLA','LIPSON','LAKE PLAINS','KINGSWOOD','MARTINS WELL','NELSHABY','PORT PATERSON','SHERLOCK','ZADOWS LANDING','LAKE TORRENS','ROSETOWN','INGLEWOOD','COONDAMBO','SADDLEWORTH','VICTOR HARBOR','SNOWTOWN','NARRUNG','DUCK PONDS','BUGLE HUT','NEPEAN BAY','EMU BAY','HAMILTON','CLARENCE PARK','YAMBA','COWARIE','LITTLE DOUGLAS','PETERHEAD','YORKE VALLEY','HILLBANK','TWO WELLS','GRAMPUS','GREENACRES','AGERY','HOLDER SIDING','OULNINA','SOUTH PLYMPTON','HINDMARSH VALLEY','MUNDOORA','RUDALL','BRUKUNGA','BROWN BEACH','MAGDALA','MAWSON LAKES','KAROONDA','OAKVALE STATION','HORNSDALE','JAMIESON','INKERMAN','KOHINOOR','NORTH MOOLOOLOO','NURIOOTPA','KONDOOLKA','WALKLEY HEIGHTS','POLISH HILL RIVER','RIVERLEA PARK','WORUMBA','MYRTLE BANK','THRINGTON','MOOROOK','MOUNT MARY','WHITES FLAT','KOONGAWA','BIRKENHEAD','MCHARG CREEK','COLLINSWOOD','POOGINAGORIC','LINDLEY','KEITH','BANKSIA PARK','RAMCO','MORN HILL','LOCKLEYS','MODBURY NORTH','RHYNIE','OAKDEN','BELTON','SANDY GROVE','SANDALWOOD','ADELAIDE AIRPORT','PERLUBIE','PIRIE EAST','MCLAREN FLAT','EVERARD CENTRAL','CHINBINGINA','KALAMURINA','ROCHESTER','KATUNGA STATION','BELAIR','BEAUMONT','NORTHFIELD','SELLICKS HILL','LIGHT PASS','MCBEAN POUND','CAVETON','CUTTLEFISH BAY','BOSWORTH','DORSET VALE','WOOLUNDUNGA','CALPERUM STATION','IWANTJA','STURT VALE','LEASINGHAM','SALTIA','WARNERTOWN','HAY FLAT','DE MOLE RIVER','MINTARO','LOCK','EXPORT PARK','HILLCREST','HALLETT','WILLUNGA HILL','DEEPWATER','MOUNT TORRENS','KENT TOWN','EYRE','BOOL LAGOON','MOONAREE','COOMOOROO','JAMES WELL','MANNUM','NETLEY','WATERVALE','ST CLAIR','MEDINDIE','MOUNT HOPE','BROWN HILL CREEK','CARAWA','GLENUNGA','HAMMOND','FARRELL FLAT','WEST HINDMARSH','SILVERTON','GLANVILLE','ROGUES POINT','TILLEY SWAMP','FARINA','BIMBOWRIE','ALMA','GLENELG EAST','SHEIDOW PARK','MARION','CALCA','GLENELG SOUTH','MOUNT MAGNIFICENT','ERINDALE','FAIRVIEW PARK','MOUNT VIVIAN','OLYMPIC DAM','GUMERACHA','SHAGGY RIDGE','WILLALOOKA','ANNADALE','NORTH MOONTA','BLAIR ATHOL','NILPENA','AUBURN','PINE CREEK STATION','BILLIATT','HILLTOWN','MANSFIELD PARK','NARACOORTE','MULOORINA','MAGILL','DEVONBOROUGH DOWNS','ELIZABETH VALE','PARUNA','ELWOMPLE','KANGARILLA','BON BON','GOLDEN GROVE','SUNNYBRAE','BAGOT WELL','BUNYUNG','MOCULTA','KALANGADOO','LEAWOOD GARDENS','GILES CORNER','POINT MCLEAY','MOUNT COOPER','PARAWA','PINE CREEK','TROTT PARK','MOUNT GAMBIER EAST','PINE HILL','MCCRACKEN','URANIA','BUTLER','KOOROONA','PARNDANA','EASTWOOD','KARATTA','MOUNT MCKENZIE','WOMBATS REST','FOREST RANGE','LOXTON NORTH','YATALA VALE','MYPOLONGA','MURTHO','AVON','GLOBE DERBY PARK','PANITYA','MYOLA STATION','VERDUN','OAKBANK','EDEN VALLEY','FULHAM','TIDDY WIDDY BEACH','ALLENDALE EAST','BALD HILLS','TERINGIE','CURNAMONA','YANKALILLA','MOUNT BENSON','GARDEN ISLAND','WOODCHESTER','FISCHER','MIL-LEL','CAMBRAI','WAUKARINGA','WASHPOOL','WOOLTANA','PINERY','CAROLINE','KOONIBBA','BUNBURY','KADINA','OTTOWAY','MOUNT DRUMMOND','DUNCAN','ANGORIGINA','TORRENS PARK','VALE PARK','STONE HUT','WILLSON RIVER','TAPEROO','MAHANEWO','CUMBERLAND PARK','PYAP','ST AGNES','WEST BEACH','WHITWARTA','CUNLIFFE','CHANDLERS HILL','SEACLIFF PARK','DULKANINNA','MOUNT FALKLAND','NORTHGATE','GILLES DOWNS','COUCH BEACH','MOOROOK SOUTH','GLEN OSMOND','STRZELECKI DESERT','PORT LINCOLN','NORTH BRIGHTON','KINGSTON PARK','GERANIUM PLAINS','NILPINNA STATION','QUINYAMBIE','CYGNET RIVER','MULYUNGARIE','PANORAMA','NEWTON','ALAWOONA','NORTH ADELAIDE','ORATUNGA STATION','BELALIE NORTH','MOERLONG','BLACK FOREST','ALDGATE','MILLSWOOD','PARNAROO','BELVIDERE','PINNAROO','KOOLGERA','EDINBURGH RAAF','GOYDER','SOMERTON PARK','MAYFIELD','WELLAND','LOWBANK','RENMARK NORTH','MOSQUITO HILL','GOOLWA NORTH','LAMBINA','KI KI','MARKS LANDING','BENDA','NALYAPPA','PENFIELD GARDENS','CALOMBA','FLAXLEY','ROCKY CAMP','KANYAKA','NGARKAT','LYNDOCH','ERUDINA','MIDDLEBACK RANGE','WEPAR','BUMBUNGA','YELTANA','NURRAGI','COBDOGLA','TEA TREE GULLY','HUDDLESTON','ANNA CREEK','MOUNT HAVELOCK','FRANKLYN','KOONAMORE','PORT PIRIE','COORABIE','KEPA','VISTA','ALLENBY GARDENS','ALLENDALE NORTH','TAYLORVILLE','PEKINA','BLACKFORD','WILLUNGA SOUTH','EAST MOONTA','YUNDI','BURRUNGULE','CAVAN','MUNNO PARA','APAMURRA','PORT VINCENT','OLD NOARLUNGA','TUNGKILLO','COONAWARRA','GLENCOE','POINT SOUTTAR','BOCONNOC PARK','WHITES VALLEY','SEATON','BIRDWOOD','VEITCH','KONGORONG','MITCHELLVILLE','CONCORDIA','PIEDNIPPIE','WANDILO','HARDWICKE BAY','HAZELWOOD PARK','OAK VALLEY','BROMPTON','MERTY MERTY','ENFIELD','CADGEE','WILLYAROO','PORT ARTHUR','DERNANCOURT','MOUNT SERLE','CLOVELLY PARK','MOUNT BARKER SPRINGS','STIRLING NORTH','TEROWIE','PORTER LAGOON','NORTON SUMMIT','PENWORTHAM','OODLA WIRRA','STOKES BAY','FITZGERALD BAY','PARINGA','LINDEN PARK','CADELL LAGOON','SUNNYSIDE','NEW PORT','FLORINA STATION','POINT PASS','PARACOMBE','HENLEY BEACH SOUTH','MANNERS WELL','MANNA HILL','BALHANNAH','CHAPMAN BORE','ERITH','UNDALYA','THE GAP','PORT MACDONNELL','BUCHFELDE','NARLABY','MUNGERANIE','NAIN','YOUNGHUSBAND','JOANNA','KENSINGTON','MAMBRAY CREEK','WESTERN FLAT','SAINTS','YARDEA','MUSTON','ONKAPARINGA HEIGHTS','DEVLINS POUND','MUDAMUCKLA','WAMI KATA','BLACK HILL STATION','BAROSSA GOLDFIELDS','TARCOWIE','UMUWA','SWANPORT','LEWISTON','DAVOREN PARK SOUTH','PENFIELD','MILENDELLA','SEAFORD HEIGHTS','COLEBATCH','TOTHILL CREEK','MELTON STATION','ST KITTS','SANDY CREEK','LAKE VIEW','ATHOL PARK','INGOMAR','EUDUNDA','SKYE','MAUDE','NANBONA','WEST LAKES SHORE','BIRCHMORE','HOUGHTON','UCOLTA','MOUNT BARRY','BORDERTOWN','WHYTE YARCOWIE','LOBETHAL','INGLE FARM','WANBI','WEPOWIE','DUTTON','MOPPA','BINDARRAH','DAVENPORT','LINCOLN NATIONAL PARK','HEWETT','WATRABA','INNESTON','ETTRICK','EVANSTON GARDENS','BAIRD BAY','BLACK ROCK','UMBERATANA','KANMANTOO','GOLDEN HEIGHTS','DEVON PARK','CASSINI','UNLEY','SALISBURY NORTH','ROSE PARK','SOLOMON','STANLEY FLAT','MONGOLATA','DENIAL BAY','FORDS','PARRAKIE','BLACK HILL','BOWMANS','NEW WELL','TALIA','BEAUFORT','WESTBOURNE PARK','SMITHFIELD PLAINS','ANGASTON','KALKAROO','SALISBURY EAST','SLEAFORD','ALBERTON','COLONEL LIGHT GARDENS','VIRGINIA','CHITON','RENDELSHAM','PASKEVILLE','WINTABATINYANA','NETHERBY','MERCUNDA','LINDON','SAPPHIRETOWN','MEADOWS','MARLESTON DC','GERMEIN BAY','NOTTS WELL','CALLINGTON','INDULKANA (IWANTJA)','GIFFORD HILL','CALLANNA','KLEMZIG','PAISLEY','WELBOURN HILL','SANDERGROVE','WEST BUNDALEER','MOUNT VICTOR STATION','FREWVILLE','LITTLEHAMPTON','PORT PIRIE WEST','PORT HUGHES','KYEEMA','COCKALEECHIE','EURELIA','BRADBURY','MURRAY BRIDGE EAST','BLACKFELLOWS CREEK','SECRET ROCKS','NORMANVILLE','MORCHARD','CARCUMA','MALVERN','PARALOWIE','PENNINGTON','POMPOOTA','WOODLANE','PARATOO','PARIS CREEK','FIELD','WHARMINDA','TRINITY GARDENS','NAIRNE','KENSINGTON PARK','BUCKLEBOO','PORT WILLUNGA','MACDONALD PARK','CAMPBELLTOWN','BURNSIDE','SHERWOOD','CURRAMULKA','MENINGIE EAST','MENZIES','LEIGHTON','MURDINGA','PORT WAKEFIELD','BELLEVUE HEIGHTS','CAMPOONA','CASTAMBUL','SENIOR','WOODVILLE GARDENS','NORTH WEST BEND','BENBOURNIE','OLD REYNELLA','KALANBI','YONGALA','HAWKS NEST STATION','DUDLEY PARK','LYNTON','WOODVILLE SOUTH','STUART','TEMPLERS','TRURO','SANDILANDS','THOMAS PLAIN','TRANMERE NORTH','COLTON','PINKS BEACH','ADELAIDE','LUCKY BAY','HAMLEY BRIDGE','RACECOURSE BAY','CRAFERS','KATARAPKO','PORT DAVIS','POOGINOOK','MOUNT SCHANK','HALIDON','FOUNTAIN','EVANSTON PARK','MOUNT CRAWFORD','PORT KENNY','THREE CREEKS','HYNAM','YALYMBOO','CHRISTIE DOWNS','NETLEY GAP','MIDDLE RIVER','SPRINGTON','SPRINGFIELD','ARCOONA','KRONGART','MIDGEE','MINBRIE','MOUNT SARAH','NACKARA','DARKE PEAK','MACUMBA','NILDOTTIE','COONALPYN','ELIZABETH NORTH','KARTE','REEDY CREEK','ELLISTON','JAMESTOWN','BOOLCOOMATTA','WONGYARRA','SCEALE BAY','COFFIN BAY','AVOCA DELL','BIGGS FLAT','ELIZABETH SOUTH','GEPPS CROSS','YANKANINNA','PARA VISTA','MOANA','MINVALARA','QUALCO','BEAUMONTS','GOSSE','FISHER','COOBER PEDY','PAYNEHAM SOUTH','BROUGHTON RIVER VALLEY','COOYERDOO','COOMBE','WESTONS FLAT','LOWAN VALE','STURT','ANDREWS FARM','BOORS PLAIN','CANEGRASS','PARAFIELD','SWEDE FLAT','KARCULTABY','SUNLANDS','NYAPARI','MURLONG','NECTAR BROOK','UPALINNA','KEPPOCH','ROSEWATER','MOORILLAH','WINTINNA','LONSDALE DC','WILLOW SPRINGS','KOKATHA','NORA CREINA','BALAKLAVA','TODMORDEN','CARRICKALINGA','PALKAGEE','MUNDOWDNA','BROADVIEW','WAROONEE','MELTON','GERMAN FLAT','WEETULTA','CAVENAGH','CLAPHAM','FARAWAY HILL','MARRYATVILLE','HAMLEY','TANTANOOLA','MODBURY HEIGHTS','HILTON','WOMPINIE','BILLEROO WEST','ERSKINE','KESWICK TERMINAL','HALIFAX STREET','FALSE BAY','MOOLOOLOO','PEAKE','GERANIUM','MCCALLUM','LEABROOK','MOUNT CLARENCE STATION','RENMARK WEST','CARRIEWERLOO','LONGWOOD','ST KILDA','EVANSTON','HILLIER','LOXTON','BOLTO','WIGLEY FLAT','RED CREEK','GILLMAN','ECHUNGA','GLENDAMBO','KALABITY','PARHAM','KEYNETON','DINGABLEDINGA','LOVEDAY','SURREY DOWNS','MERIBAH','MYPONGA BEACH','CAURNAMONT','YADLAMALKA','POOCHERA','BARATTA','MUNNO PARA WEST','KYANCUTTA','CLEARVIEW','KONGOLIA','MOUNT FREELING','DISMAL SWAMP','MOUNT LIGHT','MANTUNG','PURNONG','WOODVILLE WEST','COONAMIA','WINNINOWIE','YALPARA','RAPID BAY','COOKE PLAINS','PORT NOARLUNGA','CHRISTIES BEACH NORTH','SMOKY BAY','BEDFORD PARK','SEDAN','SOUTH GAP','PARAKYLIA','NAIDIA','ADELAIDE BC','HAINES','ALTON DOWNS STATION','WIRRABARA','BARNDIOOTA','MARINO','MUNDIC CREEK','WAURALTEE','PEWSEY VALE','ST MORRIS','YUMALI','HENDON','CHELTENHAM','FORSTER','STEPHENSTON','WILCHERRY','MITCHAM','MAITLAND','HEATHFIELD','LAKE EVERARD','BASKET RANGE','PERNATTY','BIG BEND','EDINBURGH','NORTH PLYMPTON','MOUNT WILLOUGHBY','BOOKPURNONG','TIEYON','CUNYARIE','ROBE','MOUNT GAMBIER','WILLOWIE','FREELING','RENOWN PARK','BUGLE RANGES','PUNYELROO','MILE END','SUMMERTOWN','KESWICK','NEPABUNNA','BELTANA','WEST CROYDON','MUNDULLA','MABEL CREEK','YATINA','MURRAY BRIDGE NORTH','WATTLE RANGE','MYPONGA','STOCKWELL','RIVERGLEN','WYE','SALISBURY PLAIN','TAUNTON','BLACKFELLOWS CAVES','SEBASTOPOL','NULLARBOR','MORPHETT VALE','MIDDLETON','FORESTVILLE','SEAVIEW DOWNS','SPRING FARM','BUNDEY','EDWARDSTOWN','OULNINA PARK','FOWLERS BAY','COMMISSARIAT POINT','BALLAST HEAD','NETHERTON','ST MARYS','CRYSTAL BROOK','GAWLER SOUTH','CAPE JERVIS','CLAY WELLS','PETERBOROUGH','MOUNT BARKER SUMMIT','REYNELLA','YALATA','WHYALLA NORRIE NORTH','JOSLIN','HARDY','SHEAOAK FLAT','RICHMOND','FULLARTON','BLINMAN','KAINTON','HILTON PLAZA','PORT NEILL','WINNININNIE','MALLALA','COOTRA','WILMINGTON','BLACKWOOD','DAWSON','HALLETT COVE','VERRAN','PORT GIBBON','MELROSE','WATCHMAN','MUNDI MUNDI','MELROSE PARK','SEAFORD','MARBLE HILL','TOOPERANG','KUDLA','KINGSCOTE','LAURA BAY','HOLDEN HILL','LYRUP','MOUNT BURR','BRADY CREEK','BARUNGA GAP','JABUK') NOT NULL,
  `road_type` enum('Sealed','Unsealed','Quiet Street','Busy Road','Multi-laned Road') NOT NULL,
  `weather` enum('Dry','Wet') DEFAULT NULL,
  `traffic` enum('Light','Medium','Heavy') DEFAULT NULL,
  `qsd_name` varchar(255) NOT NULL,
  `qsd_license` varchar(255) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `time_of_day` enum('Day','Night') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logbooks`
--

INSERT INTO `logbooks` (`id`, `learner_id`, `qsd_id`, `date`, `start_time`, `end_time`, `duration`, `start_location`, `end_location`, `road_type`, `weather`, `traffic`, `qsd_name`, `qsd_license`, `confirmed`, `time_of_day`) VALUES
(1, 1, 2, '2023-09-16', '12:30:00', '14:30:00', 120, 'WOODCROFT', 'HALLETT COVE', 'Sealed', 'Dry', 'Light', 'Brett Wilkinson', 'BW5467', 1, 'Day'),
(2, 1, 2, '2023-09-14', '09:30:00', '10:30:00', 60, 'MORPHETT VALE', 'BEDFORD PARK', 'Sealed', 'Dry', 'Light', 'Brett Wilkinson', 'BW5467', 1, 'Day'),
(3, 1, 2, '2023-09-12', '10:30:00', '11:30:00', 60, 'SEAFORD MEADOWS', 'ALDINGA', 'Sealed', 'Dry', 'Light', 'Brett Wilkinson', 'BW5467', 0, 'Day'),
(4, 1, 2, '2023-09-12', '22:00:00', '23:00:00', 60, 'GLENELG', 'ADELAIDE', 'Sealed', 'Dry', 'Light', 'Brett Wilkinson', 'BW5467', 1, 'Night'),
(5, 1, 2, '2023-09-10', '22:00:00', '23:00:00', 60, 'ONKAPARINGA HILLS', 'REYNELLA', 'Sealed', 'Dry', 'Light', 'Brett Wilkinson', 'BW5467', 1, 'Night');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `card_type` enum('visa','mastercard') NOT NULL,
  `card_number` char(16) NOT NULL,
  `cvv` char(3) NOT NULL,
  `last_four_digits` char(4) NOT NULL,
  `expiry_month` int(11) NOT NULL,
  `expiry_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `learner_id`, `method_name`, `address`, `card_type`, `card_number`, `cvv`, `last_four_digits`, `expiry_month`, `expiry_year`) VALUES
(1, 1, 'YA BOI', '1 Hall Terrace', 'visa', '1111111111111111', '111', '1111', 1, 2023);

-- --------------------------------------------------------

--
-- Table structure for table `qsd_learners`
--

DROP TABLE IF EXISTS `qsd_learners`;
CREATE TABLE `qsd_learners` (
  `qsd_id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_tasks`
--

DROP TABLE IF EXISTS `student_tasks`;
CREATE TABLE `student_tasks` (
  `student_id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_date` date DEFAULT NULL,
  `completed_instructor_id` int(11) DEFAULT NULL,
  `student_followup` tinyint(1) NOT NULL DEFAULT 0,
  `student_signature` tinyint(1) DEFAULT NULL,
  `instructor_followup` tinyint(1) NOT NULL DEFAULT 0,
  `instructor_notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tasks`
--

INSERT INTO `student_tasks` (`student_id`, `unit`, `task`, `completed`, `completed_date`, `completed_instructor_id`, `student_followup`, `student_signature`, `instructor_followup`, `instructor_notes`) VALUES
(1, 1, 1, 1, '2023-09-09', 2, 1, 1, 1, NULL),
(1, 1, 2, 1, '2023-09-09', 2, 0, 1, 0, NULL),
(1, 1, 3, 1, '2023-09-09', 2, 1, 1, 1, NULL),
(1, 1, 5, 1, '2023-09-09', 2, 0, 0, 0, NULL),
(1, 1, 8, 0, NULL, NULL, 1, 0, 0, NULL),
(5, 1, 1, 1, '2023-09-09', 2, 1, 0, 1, NULL),
(5, 1, 2, 1, '2023-09-09', 2, 0, 1, 0, NULL),
(5, 1, 3, 0, NULL, NULL, 1, 0, 1, NULL),
(5, 1, 8, 0, NULL, NULL, 1, 0, 0, NULL),
(6, 1, 2, 1, '2023-09-09', 2, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(255) NOT NULL,
  `address` varchar(100) NOT NULL,
  `license` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `user_type` enum('learner','instructor','government','qsd') NOT NULL,
  `contact_number` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`, `license`, `dob`, `user_type`, `contact_number`) VALUES
(1, 'Joe Rogan', 'learner@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Fake Street', 'JR0192', '1999-01-01', 'learner', '0412345678'),
(2, 'Brett Wilkinson', 'instructor@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Fake Street', 'BW5467', '1999-01-01', 'instructor', '0487654321'),
(3, 'government', 'admin@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Fake Street', '3', '1999-01-01', 'government', '0887654321'),
(4, 'qsd', 'qsd@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '123 Wisteria Lane', 'WK9378', '1980-06-20', 'qsd', '0445362718'),
(5, 'Naomi Wildman', 'naomi@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '567 Fake Street', 'NW1234', '2005-06-30', 'learner', '0412345678'),
(6, 'Donald Duck', 'donald@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '890 Fake Street', 'DD1234', '2006-09-03', 'learner', '0412000123'),
(7, 'Kathryn Laneway', 'kathryn@fake.com', '$2y$10$pj8wFJX9IQTfDsuVvo/yg.NzTJM69ye3Kerg3jIKr2oAjYZw5del6', '456 Wisteria Lane', 'KL0987', '1960-01-13', 'instructor', '0400112233');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learner_id` (`learner_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `cbta_modules`
--
ALTER TABLE `cbta_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbta_module_tasks`
--
ALTER TABLE `cbta_module_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbta_module_task_description`
--
ALTER TABLE `cbta_module_task_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `completed_lessons`
--
ALTER TABLE `completed_lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learner_id` (`learner_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `instructor_learners`
--
ALTER TABLE `instructor_learners`
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logbooks`
--
ALTER TABLE `logbooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `qsd_learners`
--
ALTER TABLE `qsd_learners`
  ADD KEY `qsd_id` (`qsd_id`),
  ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `student_tasks`
--
ALTER TABLE `student_tasks`
  ADD PRIMARY KEY (`student_id`,`unit`,`task`),
  ADD KEY `completed_instructor_id` (`completed_instructor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `license` (`license`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cbta_modules`
--
ALTER TABLE `cbta_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cbta_module_tasks`
--
ALTER TABLE `cbta_module_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `cbta_module_task_description`
--
ALTER TABLE `cbta_module_task_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `completed_lessons`
--
ALTER TABLE `completed_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logbooks`
--
ALTER TABLE `logbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `instructor_id` FOREIGN KEY (`instructor_id`) REFERENCES `instructor_learners` (`instructor_id`),
  ADD CONSTRAINT `learner_id` FOREIGN KEY (`learner_id`) REFERENCES `instructor_learners` (`learner_id`);

--
-- Constraints for table `completed_lessons`
--
ALTER TABLE `completed_lessons`
  ADD CONSTRAINT `completed_lessons_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `completed_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`);

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `instructor_learners`
--
ALTER TABLE `instructor_learners`
  ADD CONSTRAINT `instructor_learners_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `instructor_learners_ibfk_2` FOREIGN KEY (`learner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `logbooks`
--
ALTER TABLE `logbooks`
  ADD CONSTRAINT `logbooks_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `qsd_learners`
--
ALTER TABLE `qsd_learners`
  ADD CONSTRAINT `qsd_learners_ibfk_1` FOREIGN KEY (`qsd_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `qsd_learners_ibfk_2` FOREIGN KEY (`learner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `student_tasks`
--
ALTER TABLE `student_tasks`
  ADD CONSTRAINT `student_tasks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `student_tasks_ibfk_2` FOREIGN KEY (`completed_instructor_id`) REFERENCES `users` (`id`);
COMMIT;