-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2015 at 07:54 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iadet`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date_registered` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `role`, `date_registered`) VALUES
(1, 'Kaiste Ventures Limited', 'info@kaisteventures.com', 'Kaiste Ventures', 'ae2b1fca515949e5d54fb22b8ed95575', 'Admin', '2015-08-20'),
(15, 'Mojolagbe Jamiu Babatunde', 'mojolagbe@gmail.com', 'Mojolagbe', 'ae2b1fca515949e5d54fb22b8ed95575', 'Sub-Admin', '2015-09-09'),
(17, 'Iyad Abou Rabii', 'iyad@iadet.net', 'iyad', '0158156955595e17b02bc160e6b3f145', 'Admin', '2015-10-06'),
(18, 'Irene', 'irene@iadet.net', 'Irene', 'b99a04b262d08ed46ff24e95a81255e8', 'Admin', '2015-10-06');

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE IF NOT EXISTS `assessment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson` int(11) NOT NULL,
  `title` varchar(700) NOT NULL,
  `question` text NOT NULL,
  `mark` varchar(20) NOT NULL,
  `submission_date` date NOT NULL,
  `date_added` date NOT NULL,
  `attachment` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lesson` (`lesson`,`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`id`, `lesson`, `title`, `question`, `mark`, `submission_date`, `date_added`, `attachment`, `status`) VALUES
(7, 1, 'Assessment 2', '<p>Assessment 22</p>\r\n', '40', '2015-10-21', '2015-09-12', '927655_assessment_2.png', 1),
(8, 6, 'Assessment 1', '<p>Please download the attachment file</p>\r\n', '34', '2015-10-22', '2015-09-13', '375564_assessment_1.pdf', 1),
(9, 7, 'Assessment 1', '<p>Attached</p>\r\n', '23', '2015-10-27', '2015-09-13', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE IF NOT EXISTS `cart_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`,`course`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id`, `user`, `course`, `date_added`) VALUES
(6, 23, 10, '2015-10-05'),
(7, 23, 3, '2015-10-06'),
(9, 29, 25, '2015-10-14'),
(10, 29, 24, '2015-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `name` varchar(300) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `promotion_amount` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`name`, `amount`, `promotion_amount`, `status`) VALUES
('Basic Armatmentarium for Minor Oral Surgery', '79.90', '68.89', 0),
('Dental Implant terminology and components', '29.90', '19.90', 1),
('Implant Design and Structure', '79.90', '59.90', 0),
('Implant materials and microstructure', '79.90', '59.90', 0),
('Implant Patient assessment and special investigation', '79.90', '59.90', 0),
('Implant planning and peri-implant esthetics', '79.90', '59.90', 0),
('Implant Surgery and Flap Design', '69.90', '49.90', 0),
('Laboratory Procedures', '79.90', '59.90', 0),
('Local Surgical Site Factor', '79.90', '59.90', 0),
('Patient Risk factor', '79.90', '69.90', 0),
('Rational for Dental Implant', '79.90', '69.90', 0),
('Surgical Anatomic considerations for Dental implants', '69.90', '59.90', 0),
('Suturing Tools and Techniques', '59.90', '49.90', 0),
('The Dental Implant and Osseointegration', '69.90', '59.90', 0),
('Therapeutics in Implant Dentistry- Infection Control', '49.90', '39.90', 0),
('Therapeutics in Implant Dentistry- Pain Control', '49.90', '39.90', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE IF NOT EXISTS `course_categories` (
  `name` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `promotion_amount` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `installment` tinyint(4) NOT NULL,
  `first_installment` varchar(100) NOT NULL,
  `other_installment` varchar(100) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`name`, `amount`, `promotion_amount`, `status`, `image`, `installment`, `first_installment`, `other_installment`) VALUES
('BPDID', '4490.00', '2290.00', '', '186026_bpdid.jpg', 1, '750', '500'),
('DENTAL PHARMACOLOGY', '199', '148', '', '982593_dental_pharmacology.jpg', 0, '', ''),
('Short Course in Basic Implant Dentistry', '299', '199', '', '322019_short_course_on_basic_implant_dentistry.jpg', 0, '', ''),
('Short Course on Clinical Implant Dentistry', '299', '199', '', '800150_short_course_on_clinical_implant_dentistry.jpg', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_review`
--

CREATE TABLE IF NOT EXISTS `course_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `review` text NOT NULL,
  `date_added` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course` (`course`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `course_review`
--

INSERT INTO `course_review` (`id`, `course`, `name`, `email`, `review`, `date_added`, `status`) VALUES
(1, 2, 'Mojolagbe Jamiu Babatunde', 'mojolagbe@gmail.com', 'A nice and easy to follow course', '2015-09-19', 1),
(6, 3, 'Adewale Seun', 'adex_2915@yahoo.com', 'Nice course with nice lesson... kudos to you guys at IADET', '2015-09-22', 1),
(7, 3, 'Ayanwale Alex', 'alex_3423@gmail.com', 'I hope to enrol for this course soon. Nice course description.', '2015-10-02', 1),
(9, 10, 'Jones Liu', 'info@kaisteventures.com', 'Nice and easy to follow course.', '2015-10-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(300) NOT NULL,
  `image` varchar(300) NOT NULL,
  `date_time` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `location`, `image`, `date_time`, `status`, `date_added`) VALUES
(5, 'Annual National Conference', '<p>Blended Postgraduate Diploma in Implant Dentistry is the first program of its kind on the international level and not limited to a specific period or place. With IADET&nbsp;Blended Postgraduate Diploma in Implant Dentistry you study Implant Dentistry &nbsp;whenever and wherever</p>\r\n\r\n<p><strong>Lower your&nbsp;</strong><strong>cost</strong></p>\r\n\r\n<p>Tuition is lower online with BPDID, lessons are written by professors and uploaded or delivered online. They do not require textbooks, which further reduces costs.</p>\r\n', 'Lagos, Nigeria.', '646817_annual_national_conference.jpg', '2015/10/04 21:00', 1, '2015-09-29 17:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(700) NOT NULL,
  `answer` text NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `question` (`question`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`, `date_added`) VALUES
(1, 'Will we need to travel for any part of the training?', 'It may not be necessary to travel. If there are up to 10 delegates from a country, the two workshops for the first year will be done in the country of the delegates. Otherwise, you would need to travel to the training centre in Switzerland.', '2015-09-15'),
(7, 'What help will I get with my clinical cases for the second year?', 'A mentor will come to your clinic to help you with your first two cases after helping you with the planning on-line. You would have learnt all that is needed to understand how to plan your patientÃ¢â‚¬â„¢s treatment during the first year, but you will now get practical help with your first two patients.', '2015-09-17'),
(8, 'What if I work in the hospital and do not have a clinic?', 'We will inform you of the nearest mentoring centre to your location for you and your patient to attend for you to complete your first 2 cases under supervision.', '2015-09-17'),
(9, 'What if I still do not feel confident with the final 3 cases I need to complete to obtain the Diploma?', 'There will be a lot of on-line interactive help available for you and you can visit a mentoring centre outside your country to go and observe as many cases as you would like to. You would also be given the opportunity to come and observe and participate in surgeries in the country where you are registered to practice. The workshops during the first year are designed to tackle the issues that prevent many from developing the skills needed in Implantology. The aim of this course is to empower people with the knowledge of Implant Dentistry as well as the clinical skills.', '2015-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form` varchar(100) NOT NULL,
  `title` varchar(600) NOT NULL,
  `body` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `tutor` int(11) NOT NULL,
  `material` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` date NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `form` (`form`,`title`,`tutor`,`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `form`, `title`, `body`, `start_date`, `end_date`, `tutor`, `material`, `status`, `date_added`, `parent`) VALUES
(1, 'course', 'Beginning of Session Course', 'Beginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session CourseBeginning of Session Course', '2015-09-23', '2015-09-30', 3, '739322_end_of_session.xlsx', 1, '2015-09-11', 28),
(6, 'course', 'Start of Lessons', '<p><span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">But last year his form dipped alarmingly, following an injury, enduring a Grand Slam-less season that saw his world rankings dip to No.7. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">&quot;I don&#39;t know. I don&#39;t know if I can win another Grand Slam. I believe yes. I don&#39;t know if I&#39;m going to do it, but I can do it,&quot; Nadal was quoted as saying by SkySports on Sunday. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">&quot;I&#39;m going to work hard to create more opportunities in the next couple of years so let&#39;s see if I&#39;m able to relax, to control my emotions again and if that happens, and I believe it will happen soon because I feel much better, I&#39;m going to find my level of tennis,&quot; the Spaniard said. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">Nadal believes he is approaching 100 percent fitness, but admitted he also had to overcome mental scars as on his return to competitive action. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">&quot;It was a tough year in terms of everything because I was playing with too much anxiety, especially at the beginning of the season,&quot; he said. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">&quot;Now I feel much better. Not 100 percent fit but much better. Close to being 100 per cent fit and I am enjoying it again. I&#39;m enjoying being on the tennis court, enjoying, practicing and enjoying the competition because I don&#39;t have that anxiety anymore,&quot; the 29-year-old said. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">Nadal also hailed Andy Murray as one of the &quot;most talented&quot; players he has encountered during his playing career but admits the Scott could have won a few more tournaments. </span><br />\r\n<br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(63, 63, 63); font-family:georgia; font-size:15px">&quot;He&#39;s (Murray) a great guy, a natural guy and for me that is important. I am natural, I am honest with the people I&#39;m talking to,&quot; he said. </span></p>\r\n', '2015-09-25', '2015-09-30', 1, '887088_start_of_lessons.mp4', 1, '2015-09-11', 30),
(7, 'lesson', 'Section 1', '<p>Preparatory Lesson and Introduction</p>\r\n', '2015-09-17', '2015-09-23', 2, '151251_section_1.xls', 1, '2015-09-13', 6),
(8, 'course', 'End of Course Lesson', '<p>This mark the end of this course.</p>\r\n\r\n<p>Thanks</p>\r\n', '2015-09-18', '2015-09-25', 1, '958225_end_of_course_lesson.doc', 1, '2015-09-18', 28);

-- --------------------------------------------------------

--
-- Table structure for table `logged_cpd`
--

CREATE TABLE IF NOT EXISTS `logged_cpd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `speciality` varchar(300) NOT NULL,
  `topic` varchar(600) NOT NULL,
  `attendance_date` datetime NOT NULL,
  `point` varchar(100) NOT NULL,
  `location` varchar(300) NOT NULL,
  `comment` text NOT NULL,
  `certificate` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`,`topic`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `logged_cpd`
--

INSERT INTO `logged_cpd` (`id`, `user`, `speciality`, `topic`, `attendance_date`, `point`, `location`, `comment`, `certificate`) VALUES
(1, 3, 'Dentistry', 'Teeth Surgery', '2015-11-04 12:29:00', '10', 'Lagos', '', '341699_teeth_surgery.txt'),
(2, 3, 'Oral Dentistry', 'Gum Repair', '2015-09-10 00:00:00', '15', 'Lagos', 'Great Job', '483121_.pdf'),
(3, 3, 'Blended Diploma In', 'Introduction to course', '2015-10-27 18:00:00', '18', 'Lagos, Ketu', 'Yeah..', '107003_introduction.pdf'),
(5, 3, 'Testing', 'Tester', '2015-10-31 16:00:00', '12', 'Lagos', 'Alright', '732950_tester.doc'),
(6, 3, 'App Logged Cpd', 'New Logger', '2015-10-09 00:00:00', '12', 'Lagos', 'Great', '213708_new_logger.pdf'),
(7, 3, 'Best Offer', 'Really Great Job', '2015-10-27 12:30:00', '29', 'Lagos, Nigeria', 'Yeah', '');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_record`
--

CREATE TABLE IF NOT EXISTS `purchase_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(110) NOT NULL,
  `course` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `currency` varchar(25) NOT NULL,
  `method` varchar(100) NOT NULL,
  `state` varchar(200) NOT NULL,
  `date_purchased` varchar(100) NOT NULL,
  `item_type` varchar(90) NOT NULL,
  `mode` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `purchase_record`
--

INSERT INTO `purchase_record` (`id`, `transaction_id`, `course`, `user`, `amount`, `currency`, `method`, `state`, `date_purchased`, `item_type`, `mode`) VALUES
(1, 'PAY-4C980664G9746924VKYN4YVY', 27, 2, '70', 'GBP', 'Mobile Payment', 'approved', '2015-10-12T15:05:59Z', 'course', 'full'),
(2, 'PAY-6EE27081H00589237KYN5TGA', 1, 5, '299', 'GBP', 'Mobile Payment', 'approved', '2015-10-12T16:02:32Z', 'category', 'full'),
(3, 'PAY-5VR872536N509570NKYN5XXY', 2, 2, '299', 'GBP', 'Mobile Payment', 'approved', '2015-10-12T16:12:15Z', 'category', 'full'),
(4, 'PAY-34M64771TN704364FKYOEPFY', 28, 2, '1', 'GBP', 'Mobile Payment', 'approved', '2015-10-12T23:51:51Z', 'course', 'full'),
(10, 'YHD98432', 1, 3, '900', 'NGN', 'Manual Log', 'approved', '2015/11/09 15:15', 'category', 'installment'),
(11, 'YHD9843289', 2, 3, '900', 'NGN', 'Manual Log', 'approved', '2015/11/16 11:02', 'category', 'full'),
(12, 'YHD9843288', 2, 3, '900', 'NGN', 'Manual Log', 'approved', '2015/11/10 11:04', 'course', 'full'),
(13, 'HJ2342342', 3, 3, '900', 'NGN', 'Manual Log', 'approved', '2015/11/09 15:15', 'category', 'full'),
(14, 'YHJ2342342', 1, 3, '900', 'NGN', 'Manual Log', 'approved', '2015/11/30 11:07', 'category', 'installment');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE IF NOT EXISTS `sponsor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(700) NOT NULL,
  `logo` varchar(700) NOT NULL,
  `website` varchar(700) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` date NOT NULL,
  `product` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`logo`),
  UNIQUE KEY `website` (`website`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`id`, `name`, `logo`, `website`, `status`, `date_added`, `product`, `description`, `image`) VALUES
(1, 'DIO Implant ', '111049_dio_implant_.gif', 'http://www.dioimplant.com', 1, '2015-09-16', 'Dental Implant/', '<iframe width="560" height="315" src="https://www.youtube.com/embed/Iu_wG_OC3t4" frameborder="0" allowfullscreen></iframe>', '747033_dio_implant_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE IF NOT EXISTS `tutor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `qualification` text NOT NULL,
  `field` text NOT NULL,
  `bio` text NOT NULL,
  `email` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `website` varchar(500) NOT NULL,
  `picture` varchar(300) NOT NULL,
  `visible` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`id`, `name`, `qualification`, `field`, `bio`, `email`, `username`, `password`, `website`, `picture`, `visible`) VALUES
(1, 'Prof. Iyad Abou-Rabii', 'DDS. OMFS. MRes. PhD . FADFE', 'Medical Education, Mucoadhesive tablets and new buccal drug delivery systems, analysis of the secretion of drugs and toxic substances in saliva after their oral ingestion.Technology in the education and learning (e-learning)', '<p>Dr.Abou-Rabii is an Oral and Macillo-Facial Surgeon with extensive background in Implant Dentistry. He is also a multidisciplinary academic staff, leading multiple researches in dental , pharmaceutical and educational fields. He graduated in 1991, and received PG Diploma in Oral and Maxillo-Facial Surgery in 1993 after two years of residency training in the University Hospital of Damascus. He obtained his Master of Research in Biology and Medicine from Joseph Fourier University in France in 1998 and his PhD in Dental and Oral Pharmacology from Auvergne University (France) in 2004. Dr Abou-Rabii has has practiced implant dentistry and oral surgery for more than 15 years before joining the University of Warwick in 2011 as Academic Course Director of MSc in Implant Dentistry program. He is occupying also other key academic, and research roles and positions. He keeps a keen interest in academics and actively involved with scientific research, he conducted several research projects on mucosdhesive tablets and Saliva as diagnostic tool, and he gave several oral presentations in top world research conferences. He is actually the President of the Pharmacology and Toxicology Group in the IADR (international Association of Dental Research).</p>\r\n', 'iyad@iadet.net', 'Iyad', '', 'http://www2.warwick.ac.uk/fac/med/staff/iabou-rabii/', '922052_prof._iyad_abou-rabii.jpg', 1),
(2, 'Dr Diyari Abdah', 'DDS. MSc ImpDent', 'Daan is highly experience and has wide interest in general dentistry', '<p>Diyari Abdah DDS MSc ImpDent is a cosmetic dentist and implantologist. He has a private clinic in Cambridge dealing with all aspects of implantology and grafting techniques. He is a visiting academic at the University of Warwick on the Implant MSc Programme. Dr Abdah runs a successful mentoring programme with emphasis on problem solving in implantology and how to avoid them.DA</p>\r\n', 'diyari@iadet.net', 'Diyari', '', 'http://www.iadet.net/author', '215823_dr_diyari_abdah.jpg', 1),
(3, 'Dr. Irene Amrore', 'BDS. PGCert Med Ed. MSc Imp', 'Implant Dentistry', '<p>Dr. Irene Amrore is a General Dental Practitioner with a special interest in Implant Dentistry. She has done a substantial amount of post graduate training in Cosmetic Dentistry and Short Term Orthodontics for General Dental Practitioners. Dr Amrore graduated in 1994 receiving a Bachelors in Dental Surgery from the University of Benin, Nigeria. She obtained the Statutory Examination qualification from the General Dental Council, UK in the year 2000. Between the years 1997 and 2001, Dr Amrore worked as a Senior House Officer/Staff Grade Oral Surgeon in a number of Hospitals in the UK where she gained skills and experience in surgical dentistry. She also runs her own Dental Practice in the UK which offers a variety of treatment including Implant therapy. Her passion for Implant Dentistry moved her to obtain a Masters Degree in this field from the University of Warwick, UK in 2012. She has been practising Implant Dentistry for 10 years. Dr. Amrore is involved in Implant mentoring programmes in Nigeria and she works closely with the Obafemi Awolowo University, Ife, Nigeria to help establish adequate training for dentists interested in the field of Implant Dentistry. She is a member of the Faculty of General Dental Practitioners, Royal College of Surgeons England and the Association of Dental Implantology. She also has a Post Graduate Certificate Degree in Medical Education from the University of Cardiff, Wales.</p>\r\n', 'irene@iadet.net', 'Irene', '', 'http://www.iadet.net/author', '275204_dr._irene_amrore.jpg', 1),
(4, 'Dr Alain Carre', 'DDS. MSc ImpDent', 'Dr Carre is one of the prominent implantologists practicing in Paris, he is the founding President of the Implant Formation Association, accredited CNFCO: Assistance in fitting different implant brands and constructing prostheses on implants', '<p>Dr Carre is one of the prominent implantologists practicing in Paris, he is the founding President of the Implant Formation Association, accredited CNFCO: Assistance in fitting different implant brands and constructing prostheses on implants Dr Carre is named as Ã‚â€œNobel mentorÃ‚â€? by the Nobel Biocare Company for training colleagues to fit implants in complete safety. EDUCATION 2008 Ã‚â€“ 2010 Postgraduate degree Ã‚â€“ Las Vegas Institute in aesthetic and neuromuscular dentistry. Montreal Canada 2006 Ã‚â€“ 2008 Postgraduate degree Ã‚â€“ Periodotology and Implantology Ã‚â€“ New York University.U.S.A 1990 Degree of the National Academy of Dental Surgery. 1989 Doctor in Dental Surgery Ã‚â€“ Congratulations of the jury and right of publication. 1982-1988 Faculty of Dental Surgery of the University of PARIS V 1982 French baccalaur&eacute;at with major in Science</p>\r\n', 'allain@iadet.net', 'Allain', '', 'http://www.iadet.net/author', '390506_dr_alain_carre.jpg', 1),
(5, 'Dr. Ismael Soriano', 'BDS. MClin. PhD', 'Dental Sciences', '<p>Dr. Ismael Soriano Ã‚â€¢ Bachelor Degree in Dentistry. UAX (Universidad Alfonso X et Sabio, Madrid) . Ã‚â€¢ Master of Oral Surgery and Implantology. US. Ã‚â€¢ Master of Dental Science. UAX (Universidad Alfonso X et Sabio, Madrid). Ã‚â€¢ PhD in Dental Sciences. UAX (Universidad Alfonso X et Sabio, Madrid) . Ã‚â€¢ Clinical Expert in Periodontology. UCM (Universidad Complutense de Madrid) . Ã‚â€¢ Speaker and presenter of live surgeries. Ã‚â€¢ Medical Director in the field of ??surgery, periodontics, prosthodontics and implantology. Ã‚â€¢ Speaker at national and international courses surgery. Ã‚â€¢ Member of the SEI (Spanish Society of Implantology) and SECIB (Spanish Society of Oral Surgery).</p>\r\n', 'ismael@iadet.net', 'Ismael', '', 'http://www.iadet.net/author', '339914_dr._ismael_soriano.jpg', 1),
(6, 'Sammy Noumbissi', 'DDS MS', 'Implant Dentistry', '<p>Sammy Noumbissi obtained his Doctorate in Dental Surgery from Howard University in Washington DC. He then attended Loma Linda University where he received three years of formal training in Implant Dentistry which culminated with a Certificate and a Master of Science degree in Implant Dentistry. He has published abstracts and articles in peer reviewed dental journals namely the Journal of Dental Research, the Journal of Oral Implantology and the Journal of Implant and Clinical Dentistry. He is a member of the editorial board of the Journal of Implant and Advanced Clinical Dentistry, the Dentistry and Medical Online Journal, a reviewer for the Journal of Oral Implantology and the current president for the International Academy of Ceramic Implantology. Dr. Noumbissi is the founder, current owner and president of Miles of Smiles Institute for Implant Dentistry LLC, a holistic dental implantology practice that delivers advanced education and patient care in state of the art metal-free dental implantology. He practices in Silver Spring, Maryland USA.</p>\r\n', 'Sammy@iadet.net', 'Sammy', '', 'http://www.iadet.net/author', '316183_sammy_noumbissi.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `email` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `picture` text NOT NULL,
  `website` varchar(300) NOT NULL,
  `skype_id` varchar(200) NOT NULL,
  `yahoo_id` varchar(200) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(500) NOT NULL,
  `date_registered` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `facebook_id` varchar(300) NOT NULL,
  `twitter_id` varchar(400) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `city`, `country`, `description`, `picture`, `website`, `skype_id`, `yahoo_id`, `phone`, `address`, `username`, `password`, `date_registered`, `status`, `facebook_id`, `twitter_id`) VALUES
(1, 'Mojolagbe Jamiu Babatunde', 'mojolagbe@gmail.com', 'Lagos', 'Nigeria', 'A computer Engineer by qualification and a computer scientist by profession.', '424179_mojolagbe_jamiu_babatunde.jpg', 'https://nigerianseminarsandtrainings.com', 'Mojolagbe Jamiu', 'Mojolagbe', '2348151373643', 'Ketu lagos', 'Babatunde', 'ae2b1fca515949e5d54fb22b8ed95575', '2015-08-19', 1, 'mojolagbe', 'Mojolagbe1'),
(2, 'Adewale  Seun', 'seunadex@gmail.com', '', '', '', '149273_adewale__seun.jpg', '', '', '', '897653445442', 'Lagos', 'Adewale', 'ae2b1fca515949e5d54fb22b8ed95575', '2015-09-20', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_course`
--

CREATE TABLE IF NOT EXISTS `user_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `topic` varchar(200) NOT NULL,
  `sub_topic` varchar(200) NOT NULL,
  `title` varchar(400) NOT NULL,
  `time` varchar(100) NOT NULL,
  `media` varchar(500) NOT NULL,
  `provider` varchar(400) NOT NULL,
  `location` varchar(300) NOT NULL,
  `notes` text NOT NULL,
  `certificate` varchar(400) NOT NULL,
  `date_registered` date NOT NULL,
  `point` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user_course`
--

INSERT INTO `user_course` (`id`, `user`, `topic`, `sub_topic`, `title`, `time`, `media`, `provider`, `location`, `notes`, `certificate`, `date_registered`, `point`) VALUES
(1, 3, 'Mouth Managements', 'Oral Tests', 'Managing Decayed Teeth', '1hour 30minutes', 'teeth_management.mp4', 'Nitro Inter Training Firm', 'London, Uk', 'None is available', 'teeth_management.pdf', '2015-08-27', ''),
(5, 41, 'Usrertvb', 'dddd', 'ffff', '122', '577054_ffff.txt', 'ggg', 'ddd', 'bb', '448871_ffff.xls', '2015-08-30', ''),
(6, 3, 'Teeth', 'Gums', 'Retreating the gum', '1:30mins', '182397_retreating_the_gum.mp4', 'New Horizon', 'London, UK', 'It is all about us surgery', '304538_retreating_the_gum.pdf', '2015-09-04', ''),
(7, 40, 'Tongue Health', 'Tongue Management', 'Tongue Cleaning Approach', '1:30hrs', '293249_tongue_cleaning_approach.mp4', 'Center for African Health', 'Uganda', 'Several Notes', '198657_tongue_cleaning_approach.one', '2015-09-28', ''),
(8, 3, 'Testing CPD', 'Testing', 'CPD Tester', '1hr', '883130_cpd_tester.pdf', 'Kaiste Ventures', 'Ketu, Lagos', 'None', '479031_cpd_tester.doc', '2015-10-05', ''),
(9, 23, '', '', 'My Trier', '', '', '', '', '', '', '2015-10-06', '34.6'),
(10, 23, '', '', 'New Trier', '', '', '', '', '', '671557_new_trier.png', '2015-10-06', '54'),
(11, 23, '', '', 'My Test', '', '', '', '', '', '215846_my_test.png', '2015-10-06', '89.0'),
(12, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '', '', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '', '2015-10-12', '10'),
(13, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '', '', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '', '2015-10-12', '10'),
(14, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '9-5 pm', '', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '', '2015-10-12', '10'),
(15, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '9-5 pm', '', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '501149_bone_grafting.pdf', '2015-10-12', '10'),
(16, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '9-5 pm', '', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '822055_bone_grafting.pdf', '2015-10-12', '10'),
(17, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '9-5 pm', '', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '967600_bone_grafting.pdf', '2015-10-12', '10'),
(18, 27, 'Dentistry in General', 'Implant Dentistry', 'Bone grafting', '9-5 pm', '526601_bone_grafting.mp3', 'NDA', 'Eko Hotel, Lagos', 'Great conference.', '121024_bone_grafting.pdf', '2015-10-12', '10'),
(19, 24, 'Radiology', 'CBCT guidelines', 'CBCT Course', '', '', 'Alexandra Hospital', '', '', '', '2015-10-23', '6'),
(20, 24, 'Radiology', 'CBCT guidelines', 'CBCT Course', '', '', 'Alexandra Hospital', '', '', '', '2015-10-23', '6'),
(21, 24, 'Radiology', 'CBCT guidelines', 'CBCT Course', '', '', 'Alexandra Hospital', '', '', '', '2015-10-23', '6');

-- --------------------------------------------------------

--
-- Table structure for table `website_about`
--

CREATE TABLE IF NOT EXISTS `website_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `content_header` varchar(700) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_about`
--

INSERT INTO `website_about` (`id`, `title`, `description`, `keywords`, `content_header`, `content`) VALUES
(1, 'About US - International Academy of Dental Education and Training (IADET)', 'My description goes here', 'about IADET, IADET memebers, IADET tutors', 'Who we are', '<p>Our passion is education. We are constantly moving with the rapidly evolving field of education and have integrated many new ways of making our courses benefit learners. We are committed to innovation so we can continue to help learners learn.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `website_contact`
--

CREATE TABLE IF NOT EXISTS `website_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(700) NOT NULL,
  `description` varchar(900) NOT NULL,
  `keywords` text NOT NULL,
  `phone` varchar(800) NOT NULL,
  `email` varchar(800) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_contact`
--

INSERT INTO `website_contact` (`id`, `title`, `description`, `keywords`, `phone`, `email`, `address`) VALUES
(1, 'Contact Us - International Academy of Dental Education and Training (IADET)', 'My description goes here', 'contact IADET, contact admin, contact trainer', '+4420 3289 7720', 'info@iadet.net', '25 Parsonage Road, Takeley, Essex, CM22 6RA, UK');

-- --------------------------------------------------------

--
-- Table structure for table `website_faq`
--

CREATE TABLE IF NOT EXISTS `website_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_faq`
--

INSERT INTO `website_faq` (`id`, `title`, `description`, `keywords`) VALUES
(1, 'FAQ Archive - International Academy of Dental Education and Training (IADET)', 'Page descriptions goes here', 'faq, frequently, asked, question');

-- --------------------------------------------------------

--
-- Table structure for table `website_index`
--

CREATE TABLE IF NOT EXISTS `website_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `top_slider_background` varchar(500) NOT NULL,
  `top_slider_logo` varchar(300) NOT NULL,
  `top_slider_h1` text NOT NULL,
  `top_slider_h3` text NOT NULL,
  `bottom_slider_background` varchar(400) NOT NULL,
  `bottom_slider_h1` text NOT NULL,
  `bottom_slider_h2` text NOT NULL,
  `bottom_slider_video` varchar(300) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(700) NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_index`
--

INSERT INTO `website_index` (`id`, `top_slider_background`, `top_slider_logo`, `top_slider_h1`, `top_slider_h3`, `bottom_slider_background`, `bottom_slider_h1`, `bottom_slider_h2`, `bottom_slider_video`, `title`, `description`, `keywords`) VALUES
(1, '868631_top_slider_background.jpg', '104284_top_slider_logo.png', 'International Academy of Dental Education and Training', 'Up to date with Dental Science, Technology and Innovation', '372214_bottom_slider_background.jpg', 'IADET Learning', '<ul>\r\n	<li>Lower your cost</li>\r\n	<li>Save your time</li>\r\n	<li>Flexible study time</li>\r\n	<li>Flexibility with your practice</li>\r\n	<li>Approved curriculum</li>\r\n</ul>\r\n', '577493_bottom_slider_video.mp4', 'Home - International Academy of Dental Education and Training (IADET)', 'My website description goes here', 'elearning, online training, website training, IADET training,');

-- --------------------------------------------------------

--
-- Table structure for table `website_services`
--

CREATE TABLE IF NOT EXISTS `website_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(700) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `content_header` varchar(700) NOT NULL,
  `content` text NOT NULL,
  `content_image` varchar(400) NOT NULL,
  `first_tab_header` varchar(800) NOT NULL,
  `second_tab_header` varchar(800) NOT NULL,
  `third_tab_header` varchar(800) NOT NULL,
  `first_tab_content` text NOT NULL,
  `second_tab_content` text NOT NULL,
  `third_tab_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_services`
--

INSERT INTO `website_services` (`id`, `title`, `description`, `keywords`, `content_header`, `content`, `content_image`, `first_tab_header`, `second_tab_header`, `third_tab_header`, `first_tab_content`, `second_tab_content`, `third_tab_content`) VALUES
(1, 'Our Services - International Academy of Dental Education and Training (IADET)', 'My description goes here', 'services, training, ecourses', 'Our Services', '<p>The Academy offers multiple&nbsp;services; for Dentists, Dental Educational Institutions and Colleges, &nbsp;and Dental Companies.</p>\r\n', '747782_our_services_image.png', 'For Dental Educational Institutions and Dental Colleges', 'For dentist', 'For Dental Companiess', '<ul>\r\n	<li>Our Special Education Curriculum Consultants provide support to Dental Colleges in the areas of curriculum, instruction and assessment for students. It can also work with the organizing team to help design the process and provide behind-the-scenes support.</li>\r\n	<li>Our e-Learning Consultant Team provide e-Learning background resources as requested and can assist Dental Colleges and Educational Institutions in building a comprehensive, fully functional, and interactive e-Learning system, we are able to host the e-Learning system and plan staff development and students&rsquo; training.</li>\r\n</ul>\r\n', '<ul>\r\n	<li>We provide individual packages tailored to offer support to newly qualified dentists. We can help prepare foreign-trained dentists for the necessary examinations to help them validate their Diplomas in Europe (ORE Exam in England, Equivalence Procedure in France etc). Dentist will be assigned to an individual tutor, will have access to online foundation course and documents, and will be linked to a networking group of peers facilitated by a dedicated supervisor.</li>\r\n	<li>online verified CPD courses.</li>\r\n	<li>Training and providing Certificate/Diploma in Implant Dentistry.</li>\r\n</ul>\r\n', '<ul>\r\n	<li>We help plan scientific events and support dental companies strategic plan implementation in a number of countries. Our Team are competent and have the professional network necessary to implement dental companies in Europe, Middle East, Africa, and Asia). Dental Companies don&rsquo;t have to worry about booking the local speakers either, we arrange the entire event and allowing the dental company to focus on its commercial development in the region.</li>\r\n	<li>We provide training packages (Online and Offline) for Dental Company workers and clients.</li>\r\n</ul>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `website_training_facility`
--

CREATE TABLE IF NOT EXISTS `website_training_facility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(400) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `top_slider_header` varchar(700) NOT NULL,
  `top_slider_background` varchar(300) NOT NULL,
  `top_slider_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_training_facility`
--

INSERT INTO `website_training_facility` (`id`, `title`, `description`, `keywords`, `top_slider_header`, `top_slider_background`, `top_slider_text`) VALUES
(1, 'Europe Training Facility - International Academy of Dental Education and Training (IADET)', 'Page description goes here', 'facility, training equipment', 'Europe Training Facility', '361557_top_slider_background.jpg', 'IADET Blended Diploma in Implant Dentistry <br> training workshops will take place in the <br> Clinique Dentaire De Lausanne + Implantologie,<br> Lausanne, Switzerland where trainees are <br> welcomed in a modern and cozy environment. ');

-- --------------------------------------------------------

--
-- Table structure for table `website_what_we_do`
--

CREATE TABLE IF NOT EXISTS `website_what_we_do` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(800) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `top_slider_header` varchar(400) NOT NULL,
  `top_slider_background` varchar(400) NOT NULL,
  `top_slider_first_text` text NOT NULL,
  `top_slider_second_text` text NOT NULL,
  `top_slider_third_text` text NOT NULL,
  `top_slider_fourth_text` text NOT NULL,
  `content_header` varchar(400) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `website_what_we_do`
--

INSERT INTO `website_what_we_do` (`id`, `title`, `description`, `keywords`, `top_slider_header`, `top_slider_background`, `top_slider_first_text`, `top_slider_second_text`, `top_slider_third_text`, `top_slider_fourth_text`, `content_header`, `content`) VALUES
(1, 'What we do - International Academy of Dental Education and Training (IADET)', 'My description goes here', 'what we do, who we are, our goal, our purpose', 'What We Do', '891236_top_slider_background.jpg', 'Offer practical solutions for dental education', 'Continuous Professional Development', 'Expanding the dentist''s knowledge', 'Offering him or her new career opportunities', 'What we do?', '<p>The philosophy of IADET is to offer practical solutions for dental education, not only in terms of Continuous Professional Development but also in terms of expanding the dentist&rsquo;s knowledge and offering him or her new career opportunities.<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This objective is achieved through the team of consultants, professors and mentors throughout the world. They would assist trainees through our blended learning courses which can be accessed from most countries.<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Why not enhance your career, skills and keep up to date with the latest innovations at your own pace and in your own time? IADET Learning can help you shape your very own individual success in the best way suitable for you.</p>\r\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
