###################
Design Decisions
###################

Approach of MVC is used for the separation of concerns. FullCalender Library is used for calender events generation.

Bootstrap is used for alerts dialog. It can be improved or developed completely with custom code.

Codeigniter is used as a PHP framework

Database used is MySql


#################
MySql Table
#################

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
