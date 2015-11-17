-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2015 at 12:57 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iadetmobile`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `role`, `date_registered`) VALUES
(1, 'Mojolagbe Jamiu Babatunde', 'mojolagbe@gmail.com', 'Mojolagbe', 'ae2b1fca515949e5d54fb22b8ed95575', 'Admin', '2015-08-20'),
(2, 'Akintunde Rashidat Romoke', 'rashrom4tunde@gmail.com', 'Parser', '9a83ab0d60fed7c37d928ccb30d1b6ae', 'Sub-Admin', '2015-08-20'),
(8, 'Demsond Tutuh', 'tuteh_desmoe@gmail.com', 'Demsond', '89d307546c6dd811c4fbddbfbe09bcbf', 'Sub-Admin', '2015-08-20'),
(11, 'Adewale Lanre', 'welear@gmail.com', 'Walexy', 'a5c4618fa9c0a45a548a53fdd1693425', 'Sub-Admin', '2015-08-20'),
(13, 'Alao Seffiu', 'alax@gmail.com', 'Alao', 'f678643b8cfd9c785845ad40d2099a51', 'Admin', '2015-08-21');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(800) NOT NULL,
  `short_name` varchar(200) NOT NULL,
  `category` varchar(500) NOT NULL,
  `start_date` date NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `media` varchar(600) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_registered` date NOT NULL,
  `image` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `start_date` (`start_date`,`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `short_name`, `category`, `start_date`, `code`, `description`, `media`, `amount`, `status`, `date_registered`, `image`) VALUES
(28, 'Continuos Professional Developments', 'CPDs', '2', '2015-08-29', 'CPD 450', '<p>descriptiondescriptiondescriptiondescription description</p>\r\n', '138177_cpd_450.doc', '500', 1, '2015-08-23', '434781_cpd_450.jpg'),
(30, 'Retirement Preratory Lesson', 'Ret Prep', '8', '2015-09-30', 'REP 431', '<p>Separeta Retirement Preratory Lesson</p>\r\n', '503857_rep_431.pdf', '304', 1, '2015-08-23', '970942_rep_431.jpg'),
(35, 'Blended Postgraduate Diploma in Implant Dentistry', 'Blended Diploma', '2', '2015-10-31', 'BPDID 110', '<p>Blended Blended Blended Blended Blended Blended Blended Blended Blended Blended Blended Blended Blended Blended</p>\r\n', '677744_bpdid_110.zip', '340', 1, '2015-08-26', '634869_bpdid_110.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE IF NOT EXISTS `course_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `course_category`
--

INSERT INTO `course_category` (`id`, `name`, `description`, `image`) VALUES
(2, 'Long Courses', 'These are courses that takes two to three months', 'longcourse.jpg'),
(8, 'Short Courses', 'Courses below three months are termed shot courses', '987504_short_courses.png');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_course`
--

CREATE TABLE IF NOT EXISTS `purchased_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `date_purchased` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `purchased_course`
--

INSERT INTO `purchased_course` (`id`, `course`, `user`, `date_purchased`) VALUES
(1, 28, 1, '2015-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `qualification` text NOT NULL,
  `field` text NOT NULL,
  `bio` text NOT NULL,
  `website` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `qualification`, `field`, `bio`, `website`) VALUES
(1, 'Prof. Iyad Abou-Rabii', 'DDS. OMFS. MRes. PhD . FADFE', 'Medical Education, Mucoadhesive tablets and new buccal drug delivery systems, analysis of the secretion of drugs and toxic substances in saliva after their oral ingestion.Technology in the education and learning (e-learning)', 'Dr.Abou-Rabii is an Oral and Macillo-Facial Surgeon with extensive background in Implant Dentistry. He is also a multidisciplinary academic staff, leading multiple researches in dental , pharmaceutical and educational fields. He graduated in 1991, and received PG Diploma in Oral and Maxillo-Facial Surgery in 1993 after two years of residency training in the University Hospital of Damascus. He obtained his Master of Research in Biology and Medicine from Joseph Fourier University in France in 1998 and his PhD in Dental and Oral Pharmacology from Auvergne University (France) in 2004. Dr Abou-Rabii has has practiced implant dentistry and oral surgery for more than 15 years before joining the University of Warwick in 2011 as Academic Course Director of MSc in Implant Dentistry program. He is occupying also other key academic, and research roles and positions. He keeps a keen interest in academics and actively involved with scientific research, he conducted several research projects on mucosdhesive tablets and Saliva as diagnostic tool, and he gave several oral presentations in top world research conferences. He is actually the President of the Pharmacology and Toxicology Group in the IADR (international Association of Dental Research).', 'http://www2.warwick.ac.uk/fac/med/staff/iabou-rabii/'),
(2, 'Dr Diyari Abdah', 'DDS. MSc ImpDent', 'Daan is highly experience and has wide interest in general dentistry', 'Diyari Abdah DDS MSc ImpDent is a cosmetic dentist and implantologist. He has a private clinic in Cambridge dealing with all aspects of implantology and grafting techniques. He is a visiting academic at the University of Warwick on the Implant MSc Programme.\r\nDr Abdah runs a successful mentoring programme with emphasis on problem solving in implantology and how to avoid them.DA', ''),
(3, 'Dr. Irene Amrore', 'BDS. PGCert Med Ed. MSc Imp', 'Implant Dentistry', 'Dr. Irene Amrore is a General Dental Practitioner with a special interest in Implant Dentistry. She has done a substantial amount of post graduate training in Cosmetic Dentistry and Short Term Orthodontics for General Dental Practitioners. Dr Amrore graduated in 1994 receiving a Bachelors in Dental Surgery from the University of Benin, Nigeria. She obtained the Statutory Examination qualification from the General Dental Council,  UK in the year 2000. Between the years 1997 and 2001, Dr Amrore worked as a Senior House Officer/Staff Grade Oral Surgeon in a number of Hospitals in the UK where she gained skills and experience in surgical dentistry. She also runs her own Dental Practice in the UK which offers a variety of treatment including Implant therapy.  Her passion for Implant Dentistry moved her to obtain a Masters Degree in this field from the University of Warwick, UK in 2012. She has been practising Implant Dentistry for 10 years. Dr. Amrore is involved in Implant mentoring programmes in Nigeria and she works closely with the Obafemi Awolowo University, Ife, Nigeria to help establish adequate training for dentists interested in the field of Implant Dentistry. She is a member of the Faculty of General Dental Practitioners,  Royal College  of Surgeons England and the Association of Dental Implantology. She also has a Post Graduate Certificate Degree in Medical Education from the University of Cardiff, Wales.', ''),
(4, 'Dr Alain Carre', 'DDS. MSc ImpDent', 'Dr Carre is one of the prominent implantologists practicing in Paris, he is the founding President of the Implant Formation Association, accredited CNFCO: Assistance in fitting different implant brands and constructing prostheses on implants', 'Dr Carre is one of the prominent implantologists practicing in Paris, he is the founding President of the Implant Formation Association, accredited CNFCO: Assistance in fitting different implant brands and constructing prostheses on implants\r\n\r\nDr Carre is named as “Nobel mentor” by the Nobel Biocare Company for training colleagues to fit implants in complete safety.\r\n\r\nEDUCATION\r\n\r\n2008 – 2010    Postgraduate degree – Las Vegas Institute in aesthetic and neuromuscular dentistry. Montreal Canada\r\n\r\n2006 – 2008    Postgraduate degree – Periodotology and Implantology – New York University.U.S.A\r\n\r\n1990                Degree of the National Academy of Dental Surgery.\r\n\r\n1989                Doctor in Dental Surgery – Congratulations of the jury and right of publication.\r\n\r\n1982-1988      Faculty of Dental Surgery of the University of PARIS V\r\n\r\n1982                French baccalauréat with major in Science', ''),
(5, 'Dr. Ismael Soriano', 'BDS. MClin. PhD', 'Dental Sciences', 'Dr. Ismael Soriano\r\n• Bachelor Degree in Dentistry. UAX  (Universidad Alfonso X et Sabio, Madrid) .\r\n• Master of Oral Surgery and Implantology. US.\r\n• Master of Dental Science. UAX  (Universidad Alfonso X et Sabio, Madrid).\r\n• PhD in Dental Sciences. UAX  (Universidad Alfonso X et Sabio, Madrid) .\r\n• Clinical Expert in Periodontology. UCM (Universidad Complutense de Madrid) .\r\n• Speaker and presenter of live surgeries.\r\n• Medical Director in the field of ??surgery, periodontics, prosthodontics and implantology.\r\n• Speaker at national and international courses surgery.\r\n• Member of the SEI (Spanish Society of Implantology)  and SECIB (Spanish Society of Oral Surgery).', ''),
(6, 'Sammy Noumbissi', 'DDS MS', 'Implant Dentistry', 'Sammy Noumbissi obtained his Doctorate in Dental Surgery from Howard University in Washington DC. He then attended Loma Linda University where he received three years of formal training in Implant Dentistry which culminated with a Certificate and a Master of Science degree in Implant Dentistry. He has published abstracts and articles in peer reviewed dental journals namely the Journal of Dental Research, the Journal of Oral Implantology and the Journal of Implant and Clinical Dentistry. He is a member of the editorial board of the Journal of Implant and Advanced Clinical Dentistry, the Dentistry and Medical Online Journal, a reviewer for the Journal of Oral Implantology and the current president for the International Academy of Ceramic Implantology. Dr. Noumbissi is the founder, current owner and president of Miles of Smiles Institute for Implant Dentistry LLC, a holistic dental implantology practice that delivers advanced education and patient care in state of the art metal-free dental implantology. He practices in Silver Spring, Maryland USA.', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `city`, `country`, `description`, `picture`, `website`, `skype_id`, `yahoo_id`, `phone`, `address`, `username`, `password`, `date_registered`, `status`, `facebook_id`, `twitter_id`) VALUES
(1, 'Mojolagbe Jamiu Babas', 'mojolagbe@gmail.com', 'Lagos', 'Nigeria', 'A computer Engineer by qualification and a computer scientist by profession.', '584222_mojolagbe_jamiu_babas.jpg', 'https://nigerianseminarsandtrainings.com', 'Mojolagbe Jamiu', 'Mojolagbe', '2348151373643', 'Ketu lagos', 'Mojolagbe', 'ae2b1fca515949e5d54fb22b8ed95575', '2015-08-19', 1, 'mojolagbe', 'Mojolagbe1'),
(4, 'James Coker', 'coker@gmail.com', '', '', '', '', '', '', '', '2333333333', 'Lagos', 'James Coker', 'd52e32f3a96a64786814ae9b5279fbe5', '2015-08-30', 1, '', ''),
(8, 'Kola', 'kola@gmail.com', '', '', '', '', '', '', '', '768698565657', 'Ketu', 'Kola', '86f41d669c9eb10fdd869715a77a25d4', '2015-08-30', 1, '', ''),
(10, 'Admin', 'admin@gmail.com', '', '', '', '', '', '', '', '2347654552', 'Lagos', 'Admin', '21232f297a57a5a743894a0e4a801fc3', '2015-08-30', 1, '', ''),
(11, 'Usrer Tester', 'user@gmail.com', '', '', '', '268667_usrer_tester.jpg', '', '', '', '3452425254', 'Lagos', 'Usrer ', 'ee11cbb19052e40b07aac0ca060c23ee', '2015-08-30', 1, '', '');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_course`
--

INSERT INTO `user_course` (`id`, `user`, `topic`, `sub_topic`, `title`, `time`, `media`, `provider`, `location`, `notes`, `certificate`, `date_registered`) VALUES
(1, 1, 'Mouth Management', 'Oral Tests', 'Managing Decayed Teeth', '1hour 30minutes', 'teeth_management.mp3', 'Nitro Inter Training Firm', 'London, Uk', 'None is available', 'teeth_management.pdf', '2015-08-27'),
(2, 1, 'a', 'b', 'c', 'd', '435055_c.jpg', 'e', 'f', 'g', '749182_c.jpg', '2015-08-30'),
(3, 1, 'aa', 'bb', 'cc', 'dd', '683731_cc.png', 'eee', 'ff', 'gg', '207940_cc.png', '2015-08-30'),
(4, 1, 'aa', 'bb', 'cc', 'dd', '145043_cc.png', 'eee', 'ff', 'gg', '286355_cc.png', '2015-08-30'),
(5, 11, 'Usrertvb', 'dddd', 'ffff', '122', '577054_ffff.txt', 'ggg', 'ddd', 'bb', '448871_ffff.xls', '2015-08-30');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
