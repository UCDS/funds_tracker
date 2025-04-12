-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2025 at 03:31 AM
-- Server version: 5.6.51
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spccf_funds_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `bank_account_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `account_number` varchar(30) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `account_id` varchar(30) NOT NULL,
  `bank_id` varchar(20) NOT NULL,
  `ifsc_code` varchar(30) NOT NULL,
  `micr_code` varchar(30) NOT NULL,
  `swift_code` varchar(30) NOT NULL COMMENT 'For International Payments',
  `branch` varchar(30) NOT NULL,
  `location` varchar(100) NOT NULL,
  `insert_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bank_book` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_book`
--

CREATE TABLE `bank_book` (
  `transaction_id` int(11) NOT NULL COMMENT 'With respect to the account.',
  `bank_annual_voucher_id` int(11) NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  `debit_credit` varchar(6) NOT NULL COMMENT 'DEBIT or CREDIT',
  `date` datetime NOT NULL,
  `party_id` int(11) NOT NULL COMMENT 'Party Table',
  `narration` text NOT NULL,
  `instrument_id` int(11) NOT NULL COMMENT 'If cheque pick values from cheque_book and cheque_leaves',
  `instrument_id_manual` varchar(100) NOT NULL,
  `instrument_type_id` int(11) NOT NULL,
  `instrument_date` date DEFAULT NULL,
  `bank_id` int(11) NOT NULL COMMENT 'Bank Table',
  `transaction_amount` decimal(13,4) NOT NULL,
  `balance` decimal(13,4) NOT NULL,
  `clearance_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'YES or NO',
  `clearance_date` date DEFAULT NULL,
  `statement_balance` decimal(13,4) NOT NULL,
  `bill_recieved` int(11) NOT NULL DEFAULT '0' COMMENT 'YES or NO',
  `notes` text NOT NULL,
  `project_id` int(11) NOT NULL COMMENT 'Project Table',
  `attachments_count` int(11) NOT NULL DEFAULT '0',
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL COMMENT 'User ID of the logged in user.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_book`
--

CREATE TABLE `cheque_book` (
  `cheque_book_id` int(11) NOT NULL,
  `cheque_book_number` varchar(30) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `from_cheque` varchar(30) NOT NULL,
  `to_cheque` varchar(30) NOT NULL,
  `account_id` int(11) NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_leaf`
--

CREATE TABLE `cheque_leaf` (
  `cheque_leaf_id` int(11) NOT NULL,
  `cheque_book_id` int(11) NOT NULL,
  `cheque_leaf_number` varchar(11) NOT NULL,
  `clearance_status` varchar(9) NOT NULL COMMENT 'Unused, Used, Cancelled',
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `FY18-19`
-- (See below for the actual view)
--
CREATE TABLE `FY18-19` (
`ledger_id` int(11)
,`t_date` varchar(40)
,`journal` varchar(11)
,`debit_credit` varchar(6)
,`amount` decimal(13,4)
,`account_type` varchar(50)
,`account` varchar(200)
,`sub_account` varchar(200)
,`narration` varchar(300)
,`party_name` varchar(200)
,`item` varchar(50)
,`project` varchar(200)
,`donor_party_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `instrument_type`
--

CREATE TABLE `instrument_type` (
  `instrument_type_id` int(11) NOT NULL,
  `instrument_type` varchar(14) NOT NULL COMMENT 'CHEQUE, DD, ONLINE TRANSFER, CASH DEPOSIT',
  `last_update_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `generic_item_id` int(11) DEFAULT NULL,
  `dosage_id` int(11) DEFAULT NULL,
  `item_form_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `manufacturer_vendor_id` int(11) DEFAULT NULL,
  `description` varchar(30) NOT NULL,
  `model` int(11) DEFAULT NULL,
  `lot_batch_id` varchar(50) NOT NULL,
  `supplier_vendor_id` int(11) DEFAULT NULL,
  `supply_date` date DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `warranty_period` int(3) DEFAULT NULL COMMENT 'in months',
  `manufacturing_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `item_status` varchar(50) NOT NULL COMMENT 'Expired, in stock, issued, partially issued, etc.,',
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `journal_id` int(11) NOT NULL,
  `journal_annual_voucher_id` int(11) NOT NULL,
  `journal_date_time` datetime NOT NULL,
  `journal_narration` varchar(300) DEFAULT NULL,
  `attachments_count` int(11) NOT NULL,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledger_id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL COMMENT 'Only for bank transactions',
  `debit_credit` varchar(6) NOT NULL,
  `narration` varchar(300) DEFAULT NULL,
  `amount` decimal(13,4) NOT NULL,
  `project_id` int(11) NOT NULL,
  `ledger_account_id` int(11) NOT NULL,
  `ledger_sub_account_id` int(11) NOT NULL,
  `payee_party_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `donor_party_id` int(11) NOT NULL,
  `ledger_reference_table` int(3) NOT NULL COMMENT '1-Bank Transaction,2-Journal Transaction',
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ledger_account`
--

CREATE TABLE `ledger_account` (
  `ledger_account_id` int(11) NOT NULL,
  `ledger_account_name` varchar(200) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ledger_sub_account`
--

CREATE TABLE `ledger_sub_account` (
  `ledger_sub_account_id` int(11) NOT NULL,
  `ledger_sub_account_name` varchar(200) NOT NULL,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `party_id` int(11) NOT NULL,
  `party_name` varchar(200) NOT NULL,
  `party_type_id` int(11) DEFAULT NULL,
  `gender` varchar(1) NOT NULL COMMENT 'M or F or O',
  `address` text NOT NULL,
  `place` varchar(20) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `alt_phone` int(11) DEFAULT NULL,
  `note` text NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Generic party can be donor or recipient';

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,0) NOT NULL,
  `longitude` decimal(10,0) NOT NULL,
  `area` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `link` int(200) NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_group`
--

CREATE TABLE `project_group` (
  `project_group_id` int(11) NOT NULL,
  `project_group_name` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_overdraft`
--

CREATE TABLE `project_overdraft` (
  `overdraft_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `overdraft_project_id` int(11) NOT NULL COMMENT 'Project from which funds are drawn.',
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `last_upate_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `insert_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `insert_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `bank_book_edit_history`
--

CREATE TABLE `bank_book_edit_history` (
  `edit_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `field_name` varchar(200) NOT NULL,
  `previous_value` varchar(500) CHARACTER SET latin1 NOT NULL,
  `new_value` varchar(500) NOT NULL,
  `edit_date_time` datetime NOT NULL,
  `edit_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `staff_id`, `last_upate_date_time`, `insert_date_time`, `insert_user_id`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '2024-02-04 05:05:52', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure for view `FY18-19`
--
DROP TABLE IF EXISTS `FY18-19`;

CREATE ALGORITHM=UNDEFINED DEFINER=`spccf`@`localhost` SQL SECURITY DEFINER VIEW `FY18-19`  AS  select `ledger`.`ledger_id` AS `ledger_id`,date_format(if((`ledger`.`ledger_reference_table` = 1),`bank_book`.`date`,`journal`.`journal_date_time`),'%d-%b-%Y') AS `t_date`,if((`ledger`.`ledger_reference_table` = 1),`bank_book`.`bank_account_id`,'Journal') AS `journal`,`ledger`.`debit_credit` AS `debit_credit`,`ledger`.`amount` AS `amount`,`ledger_account`.`account_type` AS `account_type`,`ledger_account`.`ledger_account_name` AS `account`,if((isnull(`ledger_sub_account`.`ledger_sub_account_name`) or (`ledger_sub_account`.`ledger_sub_account_name` = '')),'',`ledger_sub_account`.`ledger_sub_account_name`) AS `sub_account`,`ledger`.`narration` AS `narration`,`party`.`party_name` AS `party_name`,if((isnull(`item`.`item_name`) or (`item`.`item_name` = '')),'',`item`.`item_name`) AS `item`,if((isnull(`project`.`project_name`) or (`project`.`project_name` = '')),'',`project`.`project_name`) AS `project`,`ledger`.`donor_party_id` AS `donor_party_id` from (((((((`ledger` left join `bank_book` on((`ledger`.`transaction_id` = `bank_book`.`transaction_id`))) left join `journal` on((`ledger`.`transaction_id` = `journal`.`journal_id`))) left join `ledger_account` on((`ledger`.`ledger_account_id` = `ledger_account`.`ledger_account_id`))) left join `ledger_sub_account` on((`ledger`.`ledger_sub_account_id` = `ledger_sub_account`.`ledger_sub_account_id`))) left join `party` on((`ledger`.`payee_party_id` = `party`.`party_id`))) left join `item` on((`ledger`.`item_id` = `item`.`item_id`))) left join `project` on((`ledger`.`project_id` = `project`.`project_id`))) where (((`bank_book`.`date` >= '2018-04-01') and (`bank_book`.`date` < '2019-04-01')) or ((`journal`.`journal_date_time` >= '2018-04-01') and (`journal`.`journal_date_time` < '2019-04-01'))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`bank_account_id`),
  ADD KEY `party_id` (`party_id`);

--
-- Indexes for table `bank_book`
--
ALTER TABLE `bank_book`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `transaction_id_3` (`transaction_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `transaction_id_2` (`transaction_id`),
  ADD KEY `transaction_id_4` (`transaction_id`);

--
-- Indexes for table `cheque_book`
--
ALTER TABLE `cheque_book`
  ADD PRIMARY KEY (`cheque_book_id`);

--
-- Indexes for table `cheque_leaf`
--
ALTER TABLE `cheque_leaf`
  ADD PRIMARY KEY (`cheque_leaf_id`),
  ADD KEY `check_book_id` (`cheque_book_id`,`cheque_leaf_number`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `instrument_type`
--
ALTER TABLE `instrument_type`
  ADD PRIMARY KEY (`instrument_type_id`),
  ADD KEY `instrument_type_id` (`instrument_type_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`journal_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledger_id`);

--
-- Indexes for table `ledger_account`
--
ALTER TABLE `ledger_account`
  ADD PRIMARY KEY (`ledger_account_id`);

--
-- Indexes for table `ledger_sub_account`
--
ALTER TABLE `ledger_sub_account`
  ADD PRIMARY KEY (`ledger_sub_account_id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_group`
--
ALTER TABLE `project_group`
  ADD PRIMARY KEY (`project_group_id`);

--
-- Indexes for table `project_overdraft`
--
ALTER TABLE `project_overdraft`
  ADD PRIMARY KEY (`overdraft_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);
  
--
-- Indexes for table `bank_book_edit_history`
--
ALTER TABLE `bank_book_edit_history`
  ADD PRIMARY KEY (`edit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `bank_account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_book`
--
ALTER TABLE `bank_book`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'With respect to the account.';

--
-- AUTO_INCREMENT for table `cheque_book`
--
ALTER TABLE `cheque_book`
  MODIFY `cheque_book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheque_leaf`
--
ALTER TABLE `cheque_leaf`
  MODIFY `cheque_leaf_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instrument_type`
--
ALTER TABLE `instrument_type`
  MODIFY `instrument_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledger_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger_account`
--
ALTER TABLE `ledger_account`
  MODIFY `ledger_account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger_sub_account`
--
ALTER TABLE `ledger_sub_account`
  MODIFY `ledger_sub_account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_group`
--
ALTER TABLE `project_group`
  MODIFY `project_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_overdraft`
--
ALTER TABLE `project_overdraft`
  MODIFY `overdraft_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  
--
-- AUTO_INCREMENT for table `bank_book_edit_history`
--
ALTER TABLE `bank_book_edit_history`
  MODIFY `edit_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
