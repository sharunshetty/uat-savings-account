-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for digital_sb_account
CREATE DATABASE IF NOT EXISTS `digital_sb_account` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `digital_sb_account`;

-- Dumping structure for table digital_sb_account.app_api_templates
CREATE TABLE IF NOT EXISTS `app_api_templates` (
  `API_CHANNEL_CODE` varchar(30) NOT NULL,
  `API_SERVICE_CODE` varchar(30) NOT NULL,
  `API_DESC` varchar(250) DEFAULT NULL,
  `API_FORMAT` varchar(30) DEFAULT NULL,
  `API_REQ_METHOD` varchar(30) DEFAULT NULL,
  `API_ENDPOINT_URL` varchar(500) DEFAULT NULL,
  `API_DATA_REPLACE_FLG` char(1) DEFAULT NULL,
  `API_DATA_TEMPLATE` text DEFAULT NULL,
  `API_ADD_PARAMS` text DEFAULT NULL,
  `ENCRYPTION_REQ_FLG` char(1) DEFAULT NULL,
  `ENCRYPTION_METHOD` varchar(30) DEFAULT NULL,
  `BEARER_TOKEN_REQ_FLG` char(1) DEFAULT NULL,
  `BEARER_TOKEN_SCOPE` varchar(30) DEFAULT NULL,
  `BEARER_TOKEN_URL` varchar(500) DEFAULT NULL,
  `CR_BY` varchar(32) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(32) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  `TBA_KEY` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`API_CHANNEL_CODE`,`API_SERVICE_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.app_api_templates: ~0 rows (approximately)
/*!40000 ALTER TABLE `app_api_templates` DISABLE KEYS */;
INSERT INTO `app_api_templates` (`API_CHANNEL_CODE`, `API_SERVICE_CODE`, `API_DESC`, `API_FORMAT`, `API_REQ_METHOD`, `API_ENDPOINT_URL`, `API_DATA_REPLACE_FLG`, `API_DATA_TEMPLATE`, `API_ADD_PARAMS`, `ENCRYPTION_REQ_FLG`, `ENCRYPTION_METHOD`, `BEARER_TOKEN_REQ_FLG`, `BEARER_TOKEN_SCOPE`, `BEARER_TOKEN_URL`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `TBA_KEY`) VALUES
	('CBSAPIGW', 'CustInquiry', 'Customer-Inquiry', 'XML', 'POST', 'https://apiuat.ktkbank.com:8443/non-production/development/cbs-custinquiry/custinquiry', 'Y', '<FIXML xsi:schemaLocation="http://www.finacle.com/fixml AcctTrnInq.xsd" xmlns="http://www.finacle.com/fixml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">\r\n<Header>\r\n<RequestHeader>\r\n<MessageKey>\r\n<RequestUUID>Req_1351845867265</RequestUUID>\r\n<ServiceRequestId>CustInq</ServiceRequestId>\r\n<ServiceRequestVersion>10.2</ServiceRequestVersion>\r\n<ChannelId>CRM</ChannelId>\r\n</MessageKey>\r\n<RequestMessageInfo>\r\n<BankId>01</BankId>\r\n<TimeZone></TimeZone>\r\n<EntityId></EntityId>\r\n<EntityType></EntityType>\r\n<ArmCorrelationId></ArmCorrelationId>\r\n<MessageDateTime>2012-10-02T14:14:27.262</MessageDateTime>\r\n</RequestMessageInfo>\r\n<Security>\r\n<Token>\r\n<PasswordToken>\r\n<UserId></UserId>\r\n<Password></Password>\r\n</PasswordToken>\r\n</Token>\r\n<FICertToken></FICertToken>\r\n<RealUserLoginSessionId></RealUserLoginSessionId>\r\n<RealUser></RealUser>\r\n<RealUserPwd></RealUserPwd>\r\n<SSOTransferToken></SSOTransferToken>\r\n</Security>\r\n</RequestHeader>\r\n</Header>\r\n<Body>\r\n<CustInqRequest>\r\n<CustInqRq>\r\n<CustId>@@CustomerID@@</CustId>\r\n</CustInqRq>\r\n<CustInq_CustomData/>\r\n</CustInqRequest>\r\n</Body>\r\n</FIXML>', NULL, 'Y', 'XMLSecLibs', 'Y', 'Custinquiry', 'https://apiuat.ktkbank.com:8443/non-production/development/custinquiry-oauth/oauth2/token', 'SHIVA', '2021-12-27 12:44:49', NULL, NULL, NULL);
/*!40000 ALTER TABLE `app_api_templates` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.app_data_settings
CREATE TABLE IF NOT EXISTS `app_data_settings` (
  `OPTION_NAME` varchar(80) NOT NULL,
  `OPTION_VALUE` varchar(255) DEFAULT NULL,
  `OPTION_STATUS` char(1) DEFAULT NULL,
  `CR_BY` varchar(12) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(12) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  `AU_BY` varchar(12) DEFAULT NULL,
  `AU_ON` datetime DEFAULT NULL,
  `TBA_KEY` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`OPTION_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.app_data_settings: ~33 rows (approximately)
/*!40000 ALTER TABLE `app_data_settings` DISABLE KEYS */;
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('ADMIN_EMAIL', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('ADMIN_MOBILE', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('APP_NAME', 'Digital Savings Account', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('APP_SHORT_NAME', 'Digital Savings Account', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('BRAND_NAME', 'UCO Bank', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('BRAND_SHORT_NAME', 'UCO Bank', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('COPYRIGHT_BY', 'UCO Bank', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('CURRENCY_PREFIX', 'Rs. ', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('CURRENCY_SUFFIX', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('CUST_MAX_SMS', '10', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('DATETIME_FORMAT', 'd/m/Y h:ia', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('DATE_FORMAT', 'd/m/Y', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('DEVELOPER', 'Shivananda Shenoy (Madhukar)', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_AUTH_REQ', 'true', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_ENABLE', 'YES', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_FROM', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_FROM_NAME', 'UCO Bank Digital', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_HOST', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_PASSWORD', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_PORT', '587', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_SECURE', 'tls', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('EMAIL_USERNAME', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('MAINTENANCE_ADMIN', 'OFF', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('MAINTENANCE_CLIENT', 'OFF', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('OTP_EXPIRY_TIME', '300', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('OTP_RESEND_COUNT', '2', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('OTP_RSND_BTN_TIME', '60', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('POWERED_BY', 'LCode Technologies Pvt. Ltd.', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('SMS_CLIENT_LINK', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('SMS_ENABLE', 'NO', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('SQL_DATE_FORMAT', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('SUPPORT_EMAIL', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `app_data_settings` (`OPTION_NAME`, `OPTION_VALUE`, `OPTION_STATUS`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('SUPPORT_PHONE', '', '1', 'SYSTEM', '2020-07-31 17:43:35', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `app_data_settings` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.app_sms_templates
CREATE TABLE IF NOT EXISTS `app_sms_templates` (
  `SMSTPL_CODE` varchar(20) NOT NULL,
  `SMSTPL_NAME` varchar(30) DEFAULT NULL,
  `SMSTPL_STATUS_CODE` char(3) DEFAULT NULL,
  `SMSTPL_TEXT` varchar(500) DEFAULT NULL,
  `SMSTPL_ENABLE` char(1) DEFAULT NULL,
  `CR_BY` varchar(12) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(12) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`SMSTPL_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.app_sms_templates: ~2 rows (approximately)
/*!40000 ALTER TABLE `app_sms_templates` DISABLE KEYS */;
INSERT INTO `app_sms_templates` (`SMSTPL_CODE`, `SMSTPL_NAME`, `SMSTPL_STATUS_CODE`, `SMSTPL_TEXT`, `SMSTPL_ENABLE`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('OTP-EMAIL', 'EMAIL OTP', '2', 'Dear Customer, @@OTPCODE@@ is your verification OTP for Online Account Openning.', '1', 'SHIVA', '2022-01-11 14:14:41', NULL, NULL);
INSERT INTO `app_sms_templates` (`SMSTPL_CODE`, `SMSTPL_NAME`, `SMSTPL_STATUS_CODE`, `SMSTPL_TEXT`, `SMSTPL_ENABLE`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('OTP-SMS', 'SMS OTP', '1', 'Dear Customer, @@OTPCODE@@ is your verification OTP for Online Account Openning.', '1', 'SHIVA', '2022-01-11 14:14:41', NULL, NULL);
/*!40000 ALTER TABLE `app_sms_templates` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.log_extapi_sent
CREATE TABLE IF NOT EXISTS `log_extapi_sent` (
  `REQ_NUM` varchar(30) NOT NULL,
  `REQ_CHANNEL_CODE` varchar(30) DEFAULT NULL,
  `REQ_SERVICE_CODE` varchar(60) DEFAULT NULL,
  `REQ_RAW_DATA` text DEFAULT NULL,
  `REQ_DATA` text DEFAULT NULL,
  `RESP_RAW_DATA` text DEFAULT NULL,
  `RESP_DATA` text DEFAULT NULL,
  `CR_BY` varchar(30) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(30) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  `AU_BY` varchar(30) DEFAULT NULL,
  `AU_ON` datetime DEFAULT NULL,
  `TBA_KEY` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`REQ_NUM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.log_extapi_sent: ~29 rows (approximately)
/*!40000 ALTER TABLE `log_extapi_sent` DISABLE KEYS */;
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022032910000001', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8088862520"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"KEWw\\/zVf6I9oDepM20rxAqYRY8Huv4wXr\\/BP4mmDKdMN0xHLsb4ukTPXUad3dAu27ZQeCcLkuEBG4zVJDcwlPXblAjnVcyWUU9f3hCilwKw=","ENC_KEY":"JjyBXsH5dVxB\\/g2CJe54vroJZidld4Q\\/FOlQW6Avt2FZMqTj3A0l51ptE52vkvNbDkmZOC+ycnLOEc0U0rydnrwLku3Q5kGc6kEnB46DXwR8ooSui9EfKAfAP0ZfrNEjEAHxvMBdWIRsrnf7JeRiYs8W8\\/HRRGlqQEUxLe3AXFAb6JXZOKFozw6lJYEikTZnp0Qf\\/24qGrJZCYxFrEUTMpgJdezi46WT2yQJZOoYxVOtTIp41Pbh22+vfw\\/2ev5hAzWLPGkGowccE4t8lJFlxblbBHDP5TwvFJmRO0lFT8EI2\\/utXN8y0l4R3BDLmnbgLG\\/VRcg5MUO0CyOeLfxazA=="}', '{"ENC_DATA":"zs2xebdTOxAN0cNZKJrGIMx3b5YhoatRwrT0j3UU3LB1e/vEWW8Gv949G7RQHjL+hkyeme176zr5axtAF9fJjD7DSUMKHzfYEn8ua9YJuob+WK3NBjqiaA0oTURiEPMq","CHANNEL_ID":"UCOWEB","ENC_KEY":"YFoT96DVvMcOi+piyp+ZJqO6yu+2iZd97gsc6nIIzZC55vZ552NSPK1TluzabhZgmeeROohNP8JPBzo8xiDVaErbPOiB0qLl4MdSLF0Re3lRYHfJodXA11gcSLaxGdm+peUnVJWUu9sT5In2kWwlM4R82ECAx5gxePdRqGGFfbYDbxEcTzfZm9icbAIUPlzM+oF1tne5euxFCED31tkYeh2AQA61MDA96CmyfoNIIsXkOECHnL1wYRlCZoushude8WW3YhB11rY8DP/JWemHdQu7xwpiHSd8uD55aEFDqbc+jNd2xvU1vkg8U15ReT2jK2cGsfYUjq93gAU+BJvvrg=="}', 'Array', NULL, '2022-03-29 19:48:46', NULL, '2022-03-29 19:48:47', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022032910000002', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8088862520"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"KEWw\\/zVf6I9oDepM20rxAqYRY8Huv4wXr\\/BP4mmDKdMN0xHLsb4ukTPXUad3dAu27ZQeCcLkuEBG4zVJDcwlPXblAjnVcyWUU9f3hCilwKw=","ENC_KEY":"h4U8kLxs\\/YT+ebcKwyWk1Ujtj0FylNYqDcwnCIoETBPJouTJ0NzQ6NsuTD0RRUBuvYbhVFqHtDkEv1ej1vLXUzxVEV7Tecyd1qkxGV3Ih1psd\\/3MEIXz7WbbtLZP5MqvjXcZSnoC1BIgVLApBCN1YVw1X\\/me08auAWWV6j92WXJ6DPeGlkxK7Sdp3JNGdAm8bXuVFXWgWYR\\/cu5LlU\\/y5TEmaNd6JmO6ELRrCdA41edYH7hMtMBAW8spWHNmr2VcqxA1Qr0\\/+Zgj2HhoLfg\\/5VkuGQYO2x7V6DZftEgMxUITmoP9D2Hwo+wOhSneVebSLtaWLszkSNT7n4ERuStWOA=="}', '{"ENC_DATA":"cr6B82U2TbsUNjWrMmICagGdXGAxS1ht3Ca1A23jJPbtxTQ1DraLzRaia4dWdeJrwGpcZ9CqD5qNMDtMzPUUVJ1mSnT0xbP0peczsd91I7+bz7kJVxFAYaAb4nqToU3l","CHANNEL_ID":"UCOWEB","ENC_KEY":"jRaZtC6tDGUNsf4AiZOkx3H0OHl1noEJwNXjbe7j/xgrzSBk2j9rheehOucAMN63ZMAwWeL1xwaylypyPTOndSWkpZSwzJ3AumO9/YdHnu8vJ32f4g39wEpteNjUuJUFU+/dLfB3SJS00yC7w8HCvUHl1dY3XF/690SfoQrrzeRAJ2o5JYv421Fken7gLe73D8S+Y0M9+Epla4TJbQ1T/YxZtFWrgEuYLZiLrWk+eB2vkpxuVpQy6jNS4zNuYAvuwMIV4asnWtKm1I1I14yuJ9YrSNQ2XQtTRIqLytTEFB2t6v3Xtsff8C98iUneSmkEcG/h1ZNv2D5bUznhEGv9Tg=="}', '{"errorMessage":"Customer already exist for given mobile no","responseCode":"F"}', NULL, '2022-03-29 19:51:04', NULL, '2022-03-29 19:51:05', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022032910000003', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8088862520"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"KEWw\\/zVf6I9oDepM20rxAqYRY8Huv4wXr\\/BP4mmDKdMN0xHLsb4ukTPXUad3dAu27ZQeCcLkuEBG4zVJDcwlPXblAjnVcyWUU9f3hCilwKw=","ENC_KEY":"GHFs7CWKQTFnLj8XopNXmz6AnCl1BhDuR+EbyNz9AnDKT0zqmNdtH4JQgmTvaFCoPGE3y77n3mi262oxaCxzhH+na\\/atUcVhBasEyrKEtqhlm7au\\/r4UNcfCyjSgeTaXCutBB4wK57MobP+aEaXN9fo2tY5B0iqzswBHxKxOIqWtfkk+dmqI7crZRCnvL8A27NcrRHMga+EHZe9LtfOg\\/QQ401ke6J\\/aiysQLJryPQ98hbAVL4kuST8imjvDd1oSKqKlGTrGgXi2YX7Ny7ptaB9JnGdPYnYtx9iUhSUBGOL4sWXxf6jZloNQTINyms4ee8YL0SZX5hNHRCPQyx3tFQ=="}', '{"ENC_DATA":"pouzKPp0//N/f08qm6ZOy95KZLtHQJs9hyK6OBuloIJg6B3UomYpQxXNhxK/RPg9RV/RVNfITREKqGxBJXRiaqLw7lLQfisvkhKpLnJTBHIhVFn42tgEP5JhTEtC1bri","CHANNEL_ID":"UCOWEB","ENC_KEY":"oX5NHnbdAX17stUpRIrt8mJQK/spke+ZeQrPSwsafcqz+PX+8X3rIWGqQDj1w92yP3CY1hUeLJzGUnSAR8CcTnR0WtWj+W6Eu+gDzNc3YI/0vvkaoZSLM/E+0Jb+4/c/AI70NUh54NrPl+qDj8fgK3IxdKogEp6ATa2zcFCYEgSflxfgvq0+okY7KFRmQIHrGE+WBnigD9NryA/zI0NS6bJ9dk22p8m3MGjFQeLX0Pu+6SAseh1RLfTyzww8mQlZU4qiSnqQTPB//0mLMA3kZd2uXhdvQ8CfswlGvLkK/H/sjimEYS68ysUj+ZiUj9OSck11QZJE0vlcenJyMXWnwg=="}', '{"errorMessage":"Customer already exist for given mobile no","responseCode":"F"}', NULL, '2022-03-29 19:52:58', NULL, '2022-03-29 19:52:59', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022032910000004', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8088862520"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"KEWw\\/zVf6I9oDepM20rxAqYRY8Huv4wXr\\/BP4mmDKdMN0xHLsb4ukTPXUad3dAu27ZQeCcLkuEBG4zVJDcwlPXblAjnVcyWUU9f3hCilwKw=","ENC_KEY":"reorbSYl+ywQ3lkkvd2iRYpDfvQicCkFhewQxEeMQIgb1xQlWnVNBVuNQXLVew6668ZE1TKiYNfgRcQJlLdZAZ075cRhMRe9Fn+q6DvBFdKPKnZhmvWUbgnhxVlWrqZwwcZ9TemLyk02kqC\\/W9ma5kPHrH\\/LLA4lC5uOEzLmQdy3tD0lfIGHzwOrCmCp4Y4ZACJ\\/q8+2+92JkYZt0V5ZsQxmmOc612q1QJ3eYCiUCStuoPxsvnxgAtFhKxNFKzuBGfi++eh6QvDr2uK1q9jN+QojN49V2xudNIc8A3zkAuIoRabLLNRug7LZF+dq8ItsWDYkKJwxo0f7v9vLgja6mg=="}', '{"ENC_DATA":"s9OgsZ3eeUdhD9ntjgKTxXiOAbSXv8pzQSlwJTOHX3lB8kRdeHRsZfxpmFoWxcnXEDgZqCI9Y08AXyA7PkWiiIdyIwZNpmFdqHosw2NLxtKbS1XjlusGKZYaDhCDDwfi","CHANNEL_ID":"UCOWEB","ENC_KEY":"HSzglsjMZ/JGh7oCsvZR9036l6kp1Jb3swkmZU81aaKq+FBJYoei/h0oiCv3ulRi08EBUn0wCnIU/4991JNB4nvhN1JVA6Ggt3vldU+DJdqfVu1CugOQgqksMeGwu4J6qoSsCVwNhHMeP7FA/P2Qq548Aoa6PcKEQzV5vyNOtg1T5P5R1EwNrK4HFhARlONHcmzC4zFfh292kX1nJm4sS3JSpERQTcYCKf3G+f94yXFPWLqZnMssVilAFBnTJQzo5Hfjk2KXMkH5vSA/A36UcZyH09OsAl6zSPwRcdQF6zkAPui2ONwv9K5w4RxrEhf5e01+kZXDI/fCKhhey4CDpw=="}', '{"errorMessage":"Customer already exist for given mobile no","responseCode":"F"}', NULL, '2022-03-29 20:01:33', NULL, '2022-03-29 20:01:33', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022032910000005', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8660677277"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"KEWw\\/zVf6I9oDepM20rxAqYRY8Huv4wXr\\/BP4mmDKdMN0xHLsb4ukTPXUad3dAu2qG\\/U8BHQKBtOHXAe2KQ\\/zmIRiP1XvjYpMH3T8EuPjNU=","ENC_KEY":"FdvCH0a9eyJfBjJcxAVC8d9eQXCeuzCzFA9dxu4GddJ0qClWL6sa36LWwaKwQaKcGfrg3ZhIuVSn5aoPs5\\/eDyTlQWFG9+8uyVfqFXFwpenjhn4h3YEXjAg9c1lnLLjrTZRvy8a0v+yQCLrlIHHRG3QJS8oLP9Szt9jWMWIRg61i5Zy\\/85keRkqDgIJd0XiMAPZLEnDzSMTXd5hQIFMv7geZJyFNQzfzLlvCeyJyLuuOAb2hs8UZl\\/qwhkwE4D1AF5cUlXpGGRAsRkivOG1+C5VV95XmkO0N\\/U73HQXAVCdhD9U6c7VW4pVGtogiC+FabtWzgZ3gtSC5KxjNdzV02A=="}', '', NULL, NULL, '2022-03-29 20:01:53', NULL, '2022-03-29 20:02:03', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022032910000006', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8660677277"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"KEWw\\/zVf6I9oDepM20rxAqYRY8Huv4wXr\\/BP4mmDKdMN0xHLsb4ukTPXUad3dAu2qG\\/U8BHQKBtOHXAe2KQ\\/zmIRiP1XvjYpMH3T8EuPjNU=","ENC_KEY":"nbgsQsldR2v\\/n\\/es+Q36UP2FqX6qBL3OxyLFmdGeDPeMsedIhKy3U+Il7LHW\\/nv\\/43qsAfaxOyn1vQOX7KnggwuV7zprwDhrozVyhKBTLcGh2NrCqjEimHW1fjJCUYwO6idDFlqTaP3nJlN+5mZ\\/v0YiQQxuzNisKVak1SjYI+fPDLfkDBbDotQLyHSO3YkXGwgAMWfw4srGNKGOQA5hhElW7dA0j8pYgZVkPOy7Ba9g5cj\\/PiMNxDyaaOAHzFXR6v8nhnt+mdJbf+rcR81yaa1L5s85wkOE48rjsKfdk\\/ezIGpCthfmLqR7FtZvv+qJT77rHZhT4vvvOjqzGHSMpw=="}', '{"ENC_DATA":"KIFyNuWOUSjgJUqVg5xBCdXLxzJVY0VLYcgyFC50QyU2n3MLeT3fspKQL1BI2n9IeBmDxQnHteVsFmQP5ZjKGw==","CHANNEL_ID":"UCOWEB","ENC_KEY":"QSwcKm/Xn4271NpVudr1ytAkVvddfQ/kPMXAFF6fHG5YeayUPsTs7d4M/ZaSXV4PHmC/2DJnl7liXhEYIaPQxsgaxabNzPLLZU0erMufYf0Uaj0f2wOcj6boHS5GbBABPWTZiReh8AOkWsLtNGjIoXOoXxIjwjYxRe6kTOfoA3ik2K03EKimtDEVhpTreM6s2219w3rLsAWvtOhcqi1ITWVbMopHiNkUSLUDoSxqVxGnd8oUjUPGxDosEIt0rFGMX9io70KQgCBzdD8pSglJK4BtKQDrQRlROFhcAueEZf/GJoFFA8x/BYojRc1sqX04Rxtt311a9GZQ39bDU1SERg=="}', '{"responseCode":"S","allowAcntOpen":"Y","vkycApplyFlg":"N"}', NULL, '2022-03-29 20:02:12', NULL, '2022-03-29 20:02:13', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033010000007', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"9844098440"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"7JgB3sT9AFGxp3lnzG48YEmlwGce2AdpWiozJvSMEY4P\\/CCSUf8p5DE0jj78GrwafjSHm\\/iII\\/VVohdEB5duAicJMTVvCakf38K+AOqnjvk=","ENC_KEY":"RoA+3lLGdtTU4ko1uzoS1YUiMA11HK3+VizzSt7WCziK0a0o3p1QxgW8k+1U\\/3F1Vteh5eipZVkZ8cFqqThtqhspxrlaSUB5lKaEBMzVzEyeP4QUhUpYmQnnXswxUdLl9w\\/o5kWCZeK4\\/j5Qu\\/tri31n47lkt53pqAPDy4ZMOEMjUW5Hce5jcrCjPl9xULQTtC0XSHLgeW3ByLGivkDLH4svZQh\\/CS\\/0qKZ9U+HBlzwDTAGQFn65Im+fBzTpgXucfH9aPx1pmpFhnE8LbUVIln4HsNWg2L5VaV24rlrrDnNXud+LtaDW3NrnPxh\\/2a9wh1BqoaAcpalGxmgeHIBkoQ=="}', '{"ENC_DATA":"4Qg/6GqXgVpA2vgoSYC439L0QkbmzfibSIFNO4L8j7Qhf6BZ7bjvTqj2D4B0mwFkszVF+vCtGcHt1FSAlj1zpg==","CHANNEL_ID":"UCOWEB","ENC_KEY":"ua5iTgnxeCZPKSXaRY5aSgZj234q3ppqfCUCTaN9L9IJkDg9Dyfsi8XeRZBkkv5/eBIstufzAHN/nzG+jvrIp2neNfVoeTMFo0utBkjDUCorFQKpso8uRkxhqxsYq3HLLbuhaxfl9gL6FGfFAMXZGqrXpXlcsU95T0fEyjzopcKKUQzMY7u/IOWG+t/1wbUGhnWBwuZz0vMomm3dFUGSI3wNS5Q7VblluJmn1c7DO6QwZDPRuT9GvGXThsesiXF1SnR1UeacIjCOZvjerqLV2NF/cD8WzL9aRfLKl/6QJa3W+sDT6WbdRrvJKu9AYA9/gpn2RSNatl7JVxNpWtKgHg=="}', '{"responseCode":"S","allowAcntOpen":"Y","vkycApplyFlg":"N"}', NULL, '2022-03-30 14:41:49', NULL, '2022-03-30 14:41:50', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033010000008', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"9844098440"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"pdSuLQYxZ7PkyP7Gleubd2PWjrnjrW3i8p5g2kDWqL7PoeLZLwdYPjapZHRuET4MWdR3i4um5SpJiDErA\\/hFbU\\/+4YJS8tdWQ9LV2GmrdXo=","ENC_KEY":"n3ZMEKCG+uP\\/A9yygu7eHGRjHARx4yOjOrfyE83fecVRu0eG7kHY4rMSl\\/Ul9+6tZOoQp+0gE0XNrHMMTg53jbQOnM6crqaRPoOLgziz5OZVOwZsAfzuObcwEm8c1p2Y0GSh1K7UqxOSaA77Sa3Y53v6g5YhqXf5WUdK7SFv03mqLHVToMU5J6AoZy9xwlrexMOjfH7A4zBx5SUGYkHEeZunHhcOVuQxwYxaijWlilg5C\\/0AWd\\/9BguOEm\\/i1gbqZpxwAbrWUwynGoafS8izarzGILr+TL1zTIOtQl+E4rXNEjyuqRUjeTnKkUN\\/ulZBkx6Zk2ZoYTuhZp3p2uU7nQ=="}', '', NULL, NULL, '2022-03-30 15:02:04', NULL, '2022-03-30 15:02:11', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033010000009', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"9844098440"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"pdSuLQYxZ7PkyP7Gleubd2PWjrnjrW3i8p5g2kDWqL7PoeLZLwdYPjapZHRuET4MWdR3i4um5SpJiDErA\\/hFbU\\/+4YJS8tdWQ9LV2GmrdXo=","ENC_KEY":"Rmu47C7F1pPJzIQo\\/fu42ZGIBKBYrmdAYiEGl8QY4lTsq5j07hXOFKVDokciJZE99QTGGlb4X9pSd9Guuw+5lszCgVP3MTHyqtJVFFJYOXGSlcrKnSRi3sHddXTBat8wz5hPJ8vFZef5j7\\/RPWveNjQbAwtp6Djv+oddp0AwlBZ7bepqgrlW4KVcjkdCzigFWPyMWwVU7gPPWac6sDClyL33oiqq8bKtMQHsLFQBFVXDrDhvhVNCvqcRbyjSGZ7c+z+dtORLgLrxITTBKQHlrm30Brq+ApWvQhC8bncS+4Ww9dl2HWQjAf0RR9\\/9IgLjRmbddDdkSouOan3TnL9N8Q=="}', '', NULL, NULL, '2022-03-30 15:02:28', NULL, '2022-03-30 15:02:40', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033010000011', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8088862520"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"pdSuLQYxZ7PkyP7Gleubd2PWjrnjrW3i8p5g2kDWqL7PoeLZLwdYPjapZHRuET4MGUsh+2\\/6BDLklrtpdndJAbEeLPemDVKlnPS4lKqFZ0w=","ENC_KEY":"vtaTia8AoInIzyGRyZAv3KM5TYtDvH\\/4HhEYMPXWd3nlCubesE0rC7GrXCPVZqFUl9eAeQHT\\/Me+FUSG71JYghdm8nvTmovuMAAG2D7iqFtXL9nHaLrIKpNwNIIsvD1Y2uq6uzNoT4cR3YR6Ou2T\\/3Hb1dbXxvIUOVc3VBytjVXaXJW8reBriy3SUlUs225+3bT\\/ctXJh2s10IuGKEZF23NAxz4\\/gjRtuC72U14M4aMhJqrhX+zRHDH8FWcLNvU733w\\/Hp87WGQ4kmJ8oHLxB6EXmvhgi\\/L2uaWsTL2QnIi78\\/gdhwXStMoTYQV3sPYzBMzqLrH5woRfAx32AoghxQ=="}', '{"ENC_DATA":"1QZC6UqvVD4nAzaxHKSZJVeYWgetJVyskyPdSoo8zjlM7GG8+HZaUE7qeMRRMXfKhHWdUXMwEfeLBVzj7z87xmFTofMW0Uu0zhG2cCcads0ZZcm1lCzTRI/orgomA4WJ","CHANNEL_ID":"UCOWEB","ENC_KEY":"AcbLP0ICN4wzhREyabU1Nh/KGPwX6pWN1/k9QSf0I2uOU7LxLoKklj02yqMJTLFI5xLsRdAbwOkAyQss8UiF2zTWodNNLNzDNoh5rSYIqO+oCbMx5134PgzB3HwfkZ/IX8R0rOLVmX23s5HlmYpZZX3hRI27riyS0pe1Mm1YWvCOcnhm2gtZOw4QpuIoMNLaIY2GyZUgFLJilUtEZjGJ7vjxFUprOlYLA1JLOfN//QhzbuOi9eJ3C/yzfRSaIZox+2bPL36zlg+ax1DQtX1VRRtQg7Ev/Fd4zJcQa1DHmEiVlMSgenlyG66dpE80mQG0f1ipedTHCiBaQpODx+KXUA=="}', '{"errorMessage":"Customer already exist for given mobile no","responseCode":"F"}', NULL, '2022-03-30 17:07:21', NULL, '2022-03-30 17:07:21', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033010000012', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8660677277"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"pdSuLQYxZ7PkyP7Gleubd2PWjrnjrW3i8p5g2kDWqL7PoeLZLwdYPjapZHRuET4M0EcXxS9lU0gAp3JPkKtX3o44PrG\\/dUeosXjF46Puglw=","ENC_KEY":"Ss9T\\/zBLuiY3uEKJEngv2mACrhduI0LdyzkF1Mb2gaTPGI8HgcHR0HxXy1AbnSt4O6rNSeu5nBDLu\\/iVMX8ZFHuWzow+itw+NtxrGS12W\\/\\/LMDV5464vdHP3jrcWmWNQ81tlgH3fKxPhaUtgkPG1hoqRFGVZl\\/UPdO8jzz3Vbgp+iUUGME\\/jSOiCZikbKyLBDi\\/za4ohcbnzlc3cA71vuk7bsdZ\\/7xU9K6+p71XcD6nQN33AZ2cGRrrDRdbvc9+SXmwZcTjI6jaLck0Um2wiSeNiSQO3ZfqIP0lO0bWSRSZOUaFbXEcmANnfkKC\\/niQ5TPticavHfzPwULmxANiT2w=="}', '{"ENC_DATA":"s968+tizh0XHLJXrA7QsF8HHNllGLEtHzlAHmK/6zT1XfKddAslO33SNX687I39ITaQjI4k42nvB+hoUWcetPw==","CHANNEL_ID":"UCOWEB","ENC_KEY":"oOmZTGMpLcC4P++vfxllQOAvWxPQwCGs/45u9rHNDvIiAOCf7MePY4t2HS5vhDNzz1bgc37OvX+dsxxLj+hLwXNAxTKAH6ALpEfLeD5cf9hBzIOnUrLqLF0jRdLT7LgxPf+zeXRxGMsZvPzakjK5c9ZVrq1ZRYwm17/cYDdgSB26gyJyDrfL+KnbIJGpgBTod/4Jn9936bhHBOazvqwOyDbT3uMEnmehnQ4T2MCHCz4nqub5e/xA09R5C31yNc2llwydvq/a5OZwijOBoY9MuRRnVpnBCdQUk2o72kYxoVFFvIPBVeOV8KfZfBFkidDX8/BvTGaVpQnuJ6fU56sfUg=="}', '{"responseCode":"S","allowAcntOpen":"Y","vkycApplyFlg":"N"}', NULL, '2022-03-30 17:07:39', NULL, '2022-03-30 17:07:39', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000013', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TAq4RlYb8QxC+c5enGRRWovUB2ftC5+64hkcBJ3iC9OUMOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"uIIVkvw0xmJvDdmcgv6CM5eTlBCjzuY18nI0S0Qn4ptqGfqeR3seWQ+yOEfflKfeoNg5kenOGckUmOseku6ABruGFtJPKuZm7tQYIOL9myWsZseQyellN5fBuTS6fhS6GvSFGY95nPi1uB6SU+u32rOr1PO8B2plbJJCzPWeTKt9nLYtKPZfnjzHEbjiKZCIA7auXP09EWvp+omIP\\/1nPwWB86AZeuifdXgXdzhLGw2iqI8GBdNTHFDQzMOz5FAvpveQrvFDnYyy4zZbVAQ6rFVRvKpm2Fd40OA18Wi+D5LLVmjUlZ6lUCuWcEC64\\/za\\/T7H65NMlv4PJ7NXZxEt5g=="}', '{"ENC_DATA":"A9Wqfevp3eOETBlWNjdZlUYqgmA2S6QCYUJUMeLOT+aweMlpI+idzWxa7NeMwvl8+fHZKijDuTWTGYH91kDDNcmvY6MKZFn2d+PFNq7DzTX2Uj6gkwi9D5X4uuIwEJ6S6k7HuMofrm7sfLWEOHHC52ZGLV5IDYtrxEDO+Ipytk+qACKEADfm1dd76jXY7Sd6OefxPk8eAF+2kIuc52cmxw==","CHANNEL_ID":"UCOWEB","ENC_KEY":"Bg0uluywkgqUAbpGDuaM5OKK5GGC0G6FkWrTt4v5zQwrr7VNq223ZwAHCwuHWqZ4BAClP3OcCo+0siLBbayqbBr4y1pB9GazWWKul+S/dg+GXV9954wE+o/FFMGhw21G+f2I1dCShB99Cep0FpdWX6xDHsD3+h8VXy3HRVImL3Go4Au7a6UQJqyMrtkcUEOXYfURop3t0aDynVZaOl+toYBqQOw90IiIthr/pFEaR+oQSQTzF2pBOc5zQMewzgo6I0hqP9KUTPEdnEn08MCvUoL6LYeRc5m+u0AbqN+TOh96/yIDqgNgkwWmOK3j8dSZcS/pD1Mr/EOEQdvsjtNH3w=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 15:40:03', NULL, '2022-03-31 15:40:04', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000014', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TAq4RlYb8QxC+c5enGRRWovUB2ftC5+64hkcBJ3iC9OUMOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"P8ypZLljAlRZVn1rLEs7Z2b+E3mHHgMvz80zDrDoxvskJ6YlV64FKof5vC1EC7o9ox6IuMEOwQiQnY3Lz93hYHJZa7\\/NSWY6SWG+EO2H4ZoqLfTUcX1NsGTup\\/JhuZGVQ5XsRXrJjK9W9l4OPKM52QQ1LChZEHtglXdyg+pnnaZwv2rJJHhmF7XmNsevdf+UyVsqk0G+FuSXs24oXkvHK0kcEvLld31HDzr1DP2Xn1SQ5mOhbRjmd0b+YEu6aCxG7Ow\\/23HJaBiBzZ7xoMfLxey0mKUzONj82li3dua43+vni4vpFEKEPePsqKZn22qAJcHf4rjFQbF2C+6AElb0GA=="}', '{"ENC_DATA":"XLNq4HBdI/QG4SUS9IQX8H6rlx43JuDEpw0KSPch1o21MAhl50SB1HWnZOgICoNLBrZUaQtVY5EwvtKVFa03n6tT71DjGDsHCXOJV64N8DR8gbIykYwznrAWFkkS70J8stQOMqNxr0i7OPg72T266D0vK+sYqHiUGfEZeW8+1jG5bzeWkoseM+JZtg0M6vDH7D/Ku7Xkhj+8+a0fjbRjOg==","CHANNEL_ID":"UCOWEB","ENC_KEY":"u/CqYUBovCQ4/CM2r7CaZGRx9bdSC3sU3dv69DBK+ML1xwDzkZBRA7RB0J7y+vqU7DQunkBnhBevYdhvqtyu+jkNJVcPhMdiF5cA72FZAud+hM/YjyI9t9MKdfMK4lA09yqc4HpnJgTmqJ7KseHRSax3Wf+cK2/FlDjm7tXmlkh7zRMe1idKLI3mduKH0HQPukw+Iy6tFnekUZldi6iC0V0IK37VnWhnBGhBjuf11GMYfH2OzCM0R+BKZE7ZV6lH8wn/AkqryMX5wAP4Ch7ln3IeuAzkn/e7mYAlaXsJf/xet0iOF8fCor4UPD8hIiBXTf584/no/2LHn20SMz/fNQ=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 15:41:03', NULL, '2022-03-31 15:41:03', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000015', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TAq4RlYb8QxC+c5enGRRWovUB2ftC5+64hkcBJ3iC9OUMOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"eMNn0qqiqKrG77GEXYjgc8\\/nm+TVOPKpp4J5USwhh\\/dR7Lopr0niluwMeTAvSW1+7eLi9nVzp6bgYinhmwEGVhye3hS79K2eGPOBPv+2Fgs6SwVy3J4BqAaeAVmIoFNITOiOqI5bRahb+RVH2lg8Uodr5+8\\/efIWNS+0Afq23N5zsD3ypwR8Cp7tCP4CaBf3EvUNqExDxuTv93uDt8TvfCOUG\\/xLqGExZ2HdMvzpkFokzlVwA7MtE78zQKSvN+Ipbmn7WNo6FeCuxmiD+cn+8PalA1yyIgLJNCzZFQZRE7yyAHAm8+V6SEaEAbIkU51Sy\\/8qdkCto8zpRiHduKqteg=="}', '{"ENC_DATA":"zbwAc8SpoRZn0ioHdbrxU6PTlF5+s9DpdrhtWfVT+zFyncPCUbYFpl4XrsSdFHiPgIEo/wSqyLP+QllGiQsb3Vs8oprCDP4KpGh/ZpT/IwNutF0tWw+2ruG3zslIoN9JF7oLJ+b13vCyuBirA++nOfzKoxpq79SpLTotVHxQk5/s9nwz5LP9eox4e7fi8HJYuAKO3kZ2KkzyB1H1g9O5VA==","CHANNEL_ID":"UCOWEB","ENC_KEY":"R8Usc2t9TcB/MWw16cuVfSoB+wLWaahsvVGoc9Z8pwFY5VyL/9MSp7+F2mvgJKHpMWjFND8ct4xX4nvUwZGf1KLQIjTCqLe48g4pVNwsfBgxBsthWPae3T0xlVI5BwK+B7AC+kVUtc3U5G7+rz3yYhbKb1Z36Wk7p09EeTbD5gYfFeUZii0lsvD9cVOC0qNYJ5D99nNzPvOXd1LKO5yaAoJZNg5k5oO8byii98m6yLHL4CBkvgO+SN/XrXFAEjgj3qUPT2igW9X5HTG8YsxWq/XhEaY+HTYo1MaXN35hDfys3V4+fI+QrMwXhBhgTzXyCUs6CPKZM8/wUXtM1qh5sQ=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 15:41:15', NULL, '2022-03-31 15:41:15', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000016', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TAq4RlYb8QxC+c5enGRRWovUB2ftC5+64hkcBJ3iC9OUMOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"iIdhTU5bowTf0p6AfZrMFhk94lToHINVV11qxAnWxH13mFZXDoc8Vysd945WRuoxPIbRKoZIkZ3QD51AmQZFUSapBUY79IOQFspMSaDaCOvrvp7g+CnvD09aLcrExNIUBZzl5qwZdXprc3MTG9KrJL+nyyWtBjUE5tv9GusD5TbRamXAGkfRnHX2bAq2XQKwTX8xLV4xblSVUAxxMf10hUhsAqF677PEbMFrt2X5OjKhfZJBazo\\/nEsJd7PuB40DzU1McpwejUKR34qPNDPmr5Trsp0jXmkLt4GKMVBHIMTzFezrasZoIEY\\/eFTge49mykvaBE9jboWAhKz1iB0ELQ=="}', '{"ENC_DATA":"AS6nA8myipEW4/aSHHzpdViNHwMbt6uvPPm54n2Gaa0NfaN1cUVrc1/2+QzbbLhf+UtdywVcpLNyo6zG2/FdK0YeDz/6q8rqA/Cz5oerA10dMTUm5Z/ymBJGYLq1EgnIe1swxXJ58j+U1MzQl0qhiXSxRlTgMl+WQhWukks5EC4lzZ1zz1MgQQuP1hq6/EnuS+LBqVWex0ysc+NjwJSEHQ==","CHANNEL_ID":"UCOWEB","ENC_KEY":"JhKMwbLXq58vP52SmhVnmbjVb4zUA459WXWv1bzQLadXOiTEMrkP8BpS0AiFFh4sAyT0TUnaVlAh2gN8oTfVNcex5dCEhrUnBOUyYgI6Gjcw7dS59bWndoFs+elW34zyr9sC3E/PaIp9JNlvdcFa9F3Y+4t359El/gaxJDrohdqRvuaCk8Fym2Y5nFAT9qD2vUDulBg2EomaFq7vFMORqZ+Snr2vqg4KArwcbxW4ia4/mAL12LaAkOq3dsvTkhuUW8Qx2QMtcBRwl1uFKBZydDUthBk3NKqzl8QRTu3+kvmw6O5poUQ/qLnnV8wFis33HAmxdCwQ0X9oMJfYMVy3Jw=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 16:19:11', NULL, '2022-03-31 16:19:12', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000017', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TAq4RlYb8QxC+c5enGRRWovUB2ftC5+64hkcBJ3iC9OUMOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"hrGNKHZaLqFHj6dEbdHf0lIG\\/dh3NJ3ImBiDSow2CYveV7iQohvCB3DTyxLGdZl4tP6+DZEwGB79dLSfu4HZ9o00eI0jz682jgSZdX9z2JHHlzCub7wnvcE65jNIBLnt\\/TE9LL+lnvG2k1ODSOo9zg3jQLldUnHh+rckvLvgXbRRRFGLg3zSHhBRFvxonpabyOUPpk4KxR2WLUmA8s7XnDwVZGNh0b8gL9ScDqgLfnKfw4vyu1WM3oPHDhmQG7wYLltHWjW6ceaFSa5F7ZYQCeSbzXYNKuDKZ78K72FfQ2uOoo4m4Vowjw346HsgSU60RoBEXnq2+tDq1k4sMlL4yA=="}', '{"ENC_DATA":"7m6Qeh5eBBIU291cIOPMyTtJiXfnhpoT38iKCW6hJLrpEk+SUcfYBozGao95CL84prgY66uySmcbNE0Mbf/zxritpKhPcHDvcsdpRlh1wzkJl4Y70PVEkt0NhdcgexJIqg7SEVnaGLPqMq5D3T/YX4m6kBO7XFnDEkNTbdFbz3YlmwWndegVMlmstwdVZZMBBS+vXCWqDCSOURseNswdbA==","CHANNEL_ID":"UCOWEB","ENC_KEY":"PXD/5lKj6Bc425lNLvyvT0iqE7o3SUdZ4Ej6F/CUMpngGYD533B9wXqBFI4rWye9Zf48B5ARbOp7aFL6l5pAC6PN6NQlNs+3mYCuuJYaa9ERKgcm1Dng/VhA2iwoHLePHGyBzAa6ZLXFP7TPoLt3DRmOQdHMAlkAbp+opovCU2EvMTJ3JSCoyUaLciTq4NnWML1G/WTV9PruuXF6hG1V44W1OnzkP3arHwaBlNAK+zeM2kq3duK8VYs/sjpnEIjO47t0z1bwKkcopbPOXi1mVcRcRgzFamwLonNFoRtnc35hFlld6rc9g9SZVUHGX2Gl0iotRkoj13+dpSVVVU8wyA=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 16:19:25', NULL, '2022-03-31 16:19:26', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000018', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123456123456","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TCAnj2ToBftki5kxYv3+k63PWJTt1ZTIP1EODly1Vjuv8Oofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"l2vx23X6spUk4sGJbIeysIBR4gipQno8aFpU+pFjOfjhgqtbY1pUi4wHj5Jae+D79uMVnbyfkruMX8RLi4UhWdbYOaCgJ\\/dFQB5nlU1fb8URsIUpQV0aEHAHxvK3EBCMaxlOqu8dky2uDZn1pHHQR21+4hjCt9Szfucic4KZ9zREItYFk+c5r+OI5f15D0XxyREYLzU\\/hyZrP4XLvCgU2qdINf1wMwTn2ihnn\\/mmtaG0JRdEUJs\\/Bx7Xq7HK70scMfVEpAgjxGnvONrV0Cay4Z+qxRpnJEcHEvFX6o\\/7r3sxRpSmJWGsX530hIsYwqezqK\\/bFnxXKT3hXhIVqvob0A=="}', '{"ENC_DATA":"+mi1Rdbq4K+v3GCqyjDWfq9av+g3BlhjQJ9C5GBPeQj8jHedZkgXuZ+Xv5HXMGtvI63ShGKxFCITgW1W9kI+ud9Ciy6mDnqfGwV/fPtc7ZMsz6Z9+FJFbPGpYVsHJe94Hgxyn5YUWTI8CMj8EumCPUlaXp96A/Dq5ucWFUtrexU=","CHANNEL_ID":"UCOWEB","ENC_KEY":"rg3kZAsEIoZ5EQ/sh9rdrN4YC865Dq90XBV2QftV90yDe3UrxPcN9yj6ugb2Z11HRu7CCGsROPrdznBC89+Ret6L4U55MlWPjTfAcuc/M5xGfQVfUU+t3T+H5M4uSoZq4PrCvTE5T5sIcYA2AvaoS/6tbJz+++TppN/vvCKcev3qpOSweD3aStFXC2PMdCcCYOJA5tkRUVafnXQLd5U4qsEpf6nGFknu+UoVHLk9U+D/k9m3oesNqSXy3oMN3PRyOG/7ZTflOafWgAXvVgqUwC0AFYIAOj22srb2UBWy8lqbA/PqbA4GI6Kee4PCXUgyqaExv2Sz8hfluWFkXWaczQ=="}', '{"errorMessage":"OTP failed, Error Code: E-12, Error Message : Invalid \'uid\' attribute value","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 16:40:09', NULL, '2022-03-31 16:40:10', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000019', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"111111111111","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TCEiX6+7asW6vRKxwRN7WQ7Uj3SAZdT8O1gwFfb8yKqrsOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"W3PaA1pbSECaggzdkOByJsLeFDcv2\\/ussnNyTwFitHEBLn0JS\\/0MOrRAZzmIaSHe0D4DFymj0460clSu8CMvZxOi+puAhlHmWkI7ugMO7rKaY85n\\/yj+CjWxAdmNsOXY2sDwTCc\\/NufXsnEQ\\/lK2EgclIGZzn9yMDyw4td7isqj+1R69W1RTrEgWnNiJwXYkD13cTINfSdNzouEIRXhE2bwGxYPPgrC9gI3zw8oYJrP3tSbZy6Zcj8O6bDDWCGXbOIK2cJPw4eNJM9d62LinKEHmOLarO7hYt\\/KFUxMRiTRURgmVCE+Ym2biQ144\\/Ek3F9GCICR0gYNHT8elHI91UA=="}', '{"ENC_DATA":"ibrCAAzbTH132HMObWtTauRTRRCxbhCx2Ar8LwUPvamAeXci6AAZnwbANX0Zm8JDOuAymK+N1Cahoe26mkZh5Fhb0Cua4+jRPDWaqIQmNdebAcrsxfePLCMt3tywf0tJoxoCc10x0Pr+tiMVmqrZULSX81BMl8sRWVG8CTKL9OM=","CHANNEL_ID":"UCOWEB","ENC_KEY":"EbU/uMpCTDfushgs1iMo4t4+hWtUQMJBd8e6PCvQQZohvww63Dl9pamsd0kTnwJOQrB/HaOq5sND/nviDyRHsDeeVJCerdYn96BJQ3kSinG66WEiT3WlWnkZeuLlU67keltAw3LyBv+6Az0dtzoFP96LvZoZAhRuSi+VSLqZip0XekDbq78hE1hyNHR6DEAUCK9Rjn8EiPeiIRm29tBsg6Alo55E+xWxTqhwSKfig0Fm0Eh+zFjDAs413FASy4Y0Zc/Lrxi7GPZzac252NPrMsRuiKtbf96h0VDDsXjH3DG923o2kQlQWes9S8csw07Utie32nEsOSPmSh49ObVaBA=="}', '{"errorMessage":"OTP failed, Error Code: E-12, Error Message : Invalid \'uid\' attribute value","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 16:46:55', NULL, '2022-03-31 16:46:55', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022033110000020', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"111111111111","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"av6dQurlh5rSE9IFQ8\\/tlJMMEfmKkaldo4sK7PE+bPT7k9tPeNLYpptdi4Y3D\\/q\\/Chzn7RlGdhThsWJepizbjAw10A1u4U87mgMacnpP6TCEiX6+7asW6vRKxwRN7WQ7Uj3SAZdT8O1gwFfb8yKqrsOofulj2nmEAx6l5MRhLg3ANXIELEzVFYW68mzmBq+YQMW\\/KWbUkAVp6mrBvxA6og==","ENC_KEY":"GX9VDZ74kgZMkkft75wRudeCyYwohwxwJivMpktA\\/jhN9Xy+LLYE\\/Ig78ZXgoYMycrD53h9fByyiohPxN9PmOFWpLaD7NT026C2iJBxzADQEzT9dehVLIYtAAEllK9K+xunoeLb+1GblWJnqmdQc1q9ovTRx97zD+rz5DFICPy8BaOzkksx\\/gS+1cwtUD2AEZHI63xyLecZ86nH6U0Q7GiFKvxAhMYS7l11o5N78cNoKD0i6Z4fJ6MhB9iKCr\\/ehFYUiXbz7twaLt\\/G4dMKQwsgtwzM+LJ9E8qt\\/TAe\\/I1yL97ymuSaE4W8ZjqoU5ey4IXFwO53TJdZjAq94AHxwPw=="}', '{"ENC_DATA":"Z7XERHHE8vp7YmxOUqZtOBA+oXXe7YNc3CU/z0AXmm0/lmoHfXxk4TNb63WQwRIBnqXRqRO6lJw6SxmlbDZ8iKi36fSAmib8DJR15pdVV4TLB8vcP9P+vF9aJKQd3No0lcdvjEG3a1bIUMwdjjFlAaAuFFy9fYRgGA1bbBbBNeA=","CHANNEL_ID":"UCOWEB","ENC_KEY":"RDaZVLdqS5APrrSqNUlTzuW03pATy5r6yC+keMibDtZz6zmHa1xdVKLTjm9THfVZjsKRIfJFCqhH/+59W3gRVcCU6NDYjI66jN2hsj0u4zREWbPWwY7SvPWZsDwMRQhlcQH2TdIPAtMdUFf1BW0n/zjdT5UIWKYHgCUcSoFadwBEKGn+H21qqcje6A6vKTi1N0Y/tADPFXqAqxrqzdRrjWxOaxLHwLR59QNdxYG3fIyRJlzOOCPWxB6YnWuTNLzr7KnohZx94KjtFDYC8Il0reiphNpdbzInZPavg6wIbj3OPz0SMwU2dB0ujdcdtsJbKreBDd6UYa22CYbEWpHCeg=="}', '{"errorMessage":"OTP failed, Error Code: E-12, Error Message : Invalid \'uid\' attribute value","responseCode":"F"}', 'ARN202203301000004', '2022-03-31 16:47:03', NULL, '2022-03-31 16:47:03', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000021', 'UCOWEB', 'validateInstAcntStatus', '{"METHOD_NAME":"validateInstAcntStatus","MOBILE_NUMBER":"8660677277"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"nICfbA1fX778uGZDD8Y7hLsbmLJALI1uj5WphmUTb5qNCeCM7qJHe7w\\/pr+3qDwBJNuDpwZzyd6D4vkfxpFcxOlPLPcSFGm14Y4oQ5uiPlc=","ENC_KEY":"LoJhlUTUnAU1WU6meyGwh7F9kWJzAsJ\\/b75io1i0dS6+43E\\/P5GECBvVY5YltSBtmvIIaHccH92Iu6HXXuhGBnWaPgWdv2bM3OsbhsmJKDM9ydXb7Xd0P6aJpM1K9MSk9cJae8ImAEnUMVMlvgzbvW39Vgk8pBlH1\\/H12v34rEQYjfTfQdmuWcwTXzFeNWVUkFpijqnM7UmKrxFA4dud\\/O2xYUUfBkBXLgSxNL0rfewhaM5rmj30uwVr77qrg8bDLLypsDf1OsfwhTrKnqHjUqnG1KKxPqlkX1h5uRyw+gl+Zd2wXFdNhYEi+xQfgV2ZvAKwowVFrmo6Bs9ANIVz4Q=="}', '{"ENC_DATA":"4hKwUkfatb9/OCumd8Y+rGVzYvFoDXNtXabRqszVL0HJxA5ExuSx4qQunOw+qbbm0k8ex1sVnzzHbEGF9Hbtqg==","CHANNEL_ID":"UCOWEB","ENC_KEY":"nR5WC2hkxFH0BV3zJfH5asNGGRStNEmT1oF2q5RHX2FyXm0i38CaBwsgB2k4U42QR9kdaXl1dCz9aWy0P6jbmn1GkUF7V1mwOclnuiajoSfrrgLjd0/ABnWVwhN2ZTrxUYVG0626O8oDd19vOJf6hk6IEQnWQ4VuUw6QrdmzwA0RRAhytWD4xD4uz++gEcOGQ2pXNI2I1elv/+7E9ETU19/A2kvqkbBVRTAM2ZfuANVethBPuKp48vbuJC162dDzE9rH6pz66JwIx2cLvIhf/5O6FEGpcrpUE+V2RGwZgxIMu97985Z4osi4DpVa74Fq3wEk6lIIzCglBwu5Y64Dqg=="}', '{"responseCode":"S","allowAcntOpen":"Y","vkycApplyFlg":"N"}', NULL, '2022-04-01 12:11:46', NULL, '2022-04-01 12:11:47', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000022', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdOztqCVnoGdhfHxlbZsHx\\/MQBmeLPX7\\/zfJ2yEJPxmPCPU4MvMO2wIy3yQtFEJI5A0sLQTDhXuPEUd++03h661SGxSUsR0nTPEKHrpu4O2Tu2GcaSzsoN5Zv19lewKD4BE+tl7AOmkO6KJYHjY9xSQamnEodGpLOcrT+gf1oki8FG9ZHL\\/J9rm7cIHNJDtBcLmQ==","ENC_KEY":"qL3y4CkpqYaq5J1wRXerzwrMv087uZl2mCRkeT3zrQVIkA\\/r3B2xUs73EHahR+dBVKPJLAnfS1jNaoEey1npnwR4nYVPE2UZmvErXPjCWxMO9k8xta3vuDwlRkpjuOCWP7dEKeJNeZpQaYMhdF2CKBOR4DuCwNwMDlOP\\/6i2\\/iNv4BuLPDnJObh66IUX2jDyD3IId+NumxTe0+68c9RtFYcuGwePTLUCAAIUfOY1QZ9wO3E1+nmBKY03SUrtggY\\/DcXhQe92GxH4VJBuHdfpwbJ232kIQjriAtLgOpM0GWPLXakgzTkxt2o+MG5FNjHOk5LZjuSRdfxGmqLN3kUnXg=="}', '{"ENC_DATA":"HazSHKoVfUmIGlJENm8aEQ2atnMkn0ME2fQsEf1102RzWPx5sWy/j3Gur1FNF+izToAfQ5LA2Xn8aGeu8ToFarkBDhnwEvfbDTF0RtpIvSPZqSCrc9o++KPgVClhREcCPRpMnBVq9dZmMqAJPjw7GIBYbVVi9/rYzErura/e8SchUrstPqX8guG4ckmzL5ZgWFQ2/DNC4XKJ0UKS/xt06A==","CHANNEL_ID":"UCOWEB","ENC_KEY":"qr0hn7Xl3eEKcqRaWKWmjVo/UEZgPmb/Q0nkMItpJdTAmoFkoYWw66XZMvydl51AmW95CjwG964UsZoLmXLS/A3JEzoXjperJL3ere/ptkS/n2jbng6NzrlFT5qzBcsi82FFKZvWlkp8qUr6+AfkjJq718PuyZuz8U6QHGOEQ+kBS8+KSfMfOexyOmMh5XTIKCJ6IxzUYaguQbodQV0FgHn3ULiEQGYjrLqp2EqOBnCpov62hsdlq1SSC1Y7/o9fNtciINNADRoBw4UHRFSDYc37RtnZVn4q0M5vGJAR4uq6yVw9C5M5ol2QGAu9241Y9uJD4aS7wmnvMqu4Z1ysZg=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:12:09', NULL, '2022-04-01 12:12:11', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000023', 'UCOWEB', 'validateAadhaarOtp', '{"METHOD_NAME":"validateAadhaarOtp","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","REF_NUMBER":"2203301901385162","OTP_REF_NUMBER":"2203301901385162","OTP":"123123","AADHAAR_CONSENT":"Y","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdO5bjRw4uoVmf7PlPV4yw9W14tBYTcEx2b314yg\\/UzqdyrzwdFiEnF5pNx1IFLluvoeeOvzaLF7y+7Ay+UlPuled9NWeG03Xxii71\\/ZKQDKWDc3x6ZVugcuyMC1m5b6gBrhmRax5+oL5+WBPneSho+KrE7qnzA\\/QzwuxXQzBAEGvKKfjtA4OgYT+0EDkSbviGNXrBBn270VLe7h62riUxquz6FFJurcFvZ2zEzhd2SxR6fsd9OE8RTQ+pPCkxckgQYyO4\\/X6mts2rGkVilekPtGjCcSUWy6xvqzcGh6gzP2LFUQ8CBlcDPjVQpscqqm9uUg==","ENC_KEY":"eUSeG2lbRtQIuzo1atlRbwvrCNMxedMS\\/UZ8yzv39iKUDrm1xLcYy+DJMn4J0\\/x0T43VRCmi6UTroQfl4Qk\\/n0lnTYOKgOLmGe0SaHt0du4N1d852iJO25tc5dSEiKo2Hm6b2XtDc5oyNhVQ8tEQlp17xp2Pz0JZM\\/M9rAmMdKyMZ0BryA+k2a2NmI4yLkmFH3JAb57ZKqY0442YnBhbDsq8PURCDy6jDlo4BoaO0KqVMYLrjTOuz5YqMAPSTQ6UsVeaDkzZNEGlY9k4ckGkbZ\\/am8iChCge0m43B4lpX2IQYDJdVkAObMHDTFq\\/RpZbAHFT2mMvCzbgM3mxwKZ5iw=="}', '{"ENC_DATA":"1L/uQJ/Kp27wgmCRjscqItD6hl2Y3KRTh+LfiT8P8r0NLTxeuTNU+PBVv0Fe43s6btcX1Ny/+ViZYHiCEGM8Tg==","CHANNEL_ID":"UCOWEB","ENC_KEY":"pu1w00eKi0V67/9eSUMQeB8okbaGUVEtHzm2c5CR6TOUdjQZSRenc16UzK5MhUd44unkiA2zIM/h44lLUBK/68slBPnbuclWcE/gL+wDaVo/jBnHGP34n1if46s3+wZw/2KeP6kRoyX3hxkoslYuD/HK7Qf7VHxcgnj2/n2uGTEzNdeKW7/sN1OErQq55D7t6Oe66sHGbstDI/kkvfXP+h1BmEQOQJugFLatDKhL1Fq1Ge1Y9E75U1kwqARBECnkfey6rfHdDABBaz69R5T5B6Eh+skJZxHu5WJBGyTxYoGvUT326E39GIh/ha9YXlU4FZq6JHqYZHCvjGk/3acVTw=="}', '{"errorMessage":"Un Expected Error","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:12:17', NULL, '2022-04-01 12:12:18', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000024', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdOztqCVnoGdhfHxlbZsHx\\/MQBmeLPX7\\/zfJ2yEJPxmPCPU4MvMO2wIy3yQtFEJI5A0sLQTDhXuPEUd++03h661SGxSUsR0nTPEKHrpu4O2Tu2GcaSzsoN5Zv19lewKD4BE+tl7AOmkO6KJYHjY9xSQamnEodGpLOcrT+gf1oki8FG9ZHL\\/J9rm7cIHNJDtBcLmQ==","ENC_KEY":"K2Ud2moINKiDIDu7WrZ5EQVPB861kaP0cdXUZ7V7lkLOEFBvJJ+zz+R4IULlDnWazM9DWq1Oil+jyVpmr1tODnoLtjsbDYQneZZuGpvXEca+Ad1wm2bK+u3BcJiMK27\\/aRd9Z7OYjslgi\\/U3awgSzKTMIia9tshiACV+C9AzeyGdgJAYVyF+rNCiL4bNQZsPjfid0yEjzPupL8nTKYwOApDNrUZebIsAPZucooRy1fZYdrR8wMdKChRs2VUqOB+BMr95NQV7UwyQFn7W9w81s8BEVPRbPnp0QERsvcCOMaQp33rxI+XChWaDAnYjC\\/OLa\\/Ob3gP4GS+4rzm\\/woYLcA=="}', '{"ENC_DATA":"SpszgXJj9b2q7AIaVQIqjtEn2cJp0/udyzspRcY2WY1Udl4BeZmr26uMBETRBBPTYRKkg3lD39m1LzTRRM9txQ==","CHANNEL_ID":"UCOWEB","ENC_KEY":"Lgfi4rgcIRKwWxuS2IeGdpJe1CTLQ21Lsh8sphRJvG8nPNQg0j9NY3++CDbTvTUdAEvGJfJZRM1a0V+kdvP8vBozYKy6Yluy4NP6ko9oKqA7J3fMhQDidzHfpTaUtpxMzDZkEEQLpRUww3I0TCksXQYL8mHsoSNYAXjzVOdaCQWDGurkBXHTjer2ppo18D4PzJPug7lZnGMQ5hGR+eVvRZnciNoCPEp6iXh7D8jutvNEnQPJScZVhrXXgZaAZxyXhw8I/MJI3nwNoInfr0cyvIXtbJdrFJ/obDxBdUgmm/MjIvOuRH/BA/O1UwsRy3F0RY1jmfDgEJP32ZMxZNZhjA=="}', '{"errorMessage":"Un Expected Error","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:13:11', NULL, '2022-04-01 12:13:11', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000025', 'UCOWEB', 'validateAadhaarOtp', '{"METHOD_NAME":"validateAadhaarOtp","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","REF_NUMBER":"2203301901385162","OTP_REF_NUMBER":"2203301901385162","OTP":"123123","AADHAAR_CONSENT":"Y","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdO5bjRw4uoVmf7PlPV4yw9W14tBYTcEx2b314yg\\/UzqdyrzwdFiEnF5pNx1IFLluvoeeOvzaLF7y+7Ay+UlPuled9NWeG03Xxii71\\/ZKQDKWDc3x6ZVugcuyMC1m5b6gBrhmRax5+oL5+WBPneSho+KrE7qnzA\\/QzwuxXQzBAEGvKKfjtA4OgYT+0EDkSbviGNXrBBn270VLe7h62riUxquz6FFJurcFvZ2zEzhd2SxR6fsd9OE8RTQ+pPCkxckgQYyO4\\/X6mts2rGkVilekPtGjCcSUWy6xvqzcGh6gzP2LFUQ8CBlcDPjVQpscqqm9uUg==","ENC_KEY":"IbYxR32OqnRnISNzqKG75FHvdPIvxA6bX5yGP8M6N0zsF\\/zmn7\\/GUDsffWT7+gx2UnhDPVPzhCrFneSGUAWJs5BKgDQqqTCSGu344dbumVkaptIcarWK3TnHM40EPkHRLYi3oMD7jVlNRXVkea+WRLB2QRvbAV1Ozb+McXZuFljfdd8baseVe0oKBsZsqEkhJEEYbNryGN8CPBRI5SMXvr7DsFAQlpHp0m0y607yoVOnU4HlDwujxNIgVCdPgpr3ENdh1uHLE5kcmu\\/5RUES0mhq3Q18uuGSkIo7xHa9\\/+s+toPvHm113gxDZoZ7R5Zi8xaA7\\/bhjCmuC9\\/peqz5gw=="}', '{"ENC_DATA":"GuyMcRODcP85BD4geUO5CLHxc14RouV+S01ydoECmD510pTXMpRfmHZ4Mt/r5Hxrx1c3G3zfLsfQPb+W6DyA+zQ6eIvZ1kDvcscXCTO9+T9gYLkTVJHqfHjFWYTKFywYpESLsqJTU1lijO4EADhj7Q==","CHANNEL_ID":"UCOWEB","ENC_KEY":"Yf/VhlHTt9dMNb93xmoYMC1Hkrg7eGNKOqxg0SyKhu5cNzbv5EGKITpOZHDpkl5VTa8xpjYkUZmMMXnukEBLc4q9Vws4HiwZbRN46X0R+SVAUXaZsxSiAMPWBw2XLui50y/dBkJxgY5WOniRTaKdXDjiBAi5JwHG8am49AAM8mi22D85BOt1vKpkN2iGXFqthg2vbaaOcylKc78Ga/6Uc1eVTFEh0JhSgVMTkQBk0P8f6UMV6NwhlUewvlsyXYYYGYZjCtyEeTN0jIba+hO9XhgZ8xYHToFyRPeaIJHgpHnSSntUIE+GM7FssxzvgPkFE9Jj0+G3Z3RwrUYI4dSh4w=="}', '{"errorMessage":"The attribute \'uid\' of tag \'auth\' is not a valid aadhaar number[14]","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:13:16', NULL, '2022-04-01 12:13:17', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000026', 'UCOWEB', 'validateAadhaarOtp', '{"METHOD_NAME":"validateAadhaarOtp","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","REF_NUMBER":"2203301901385162","OTP_REF_NUMBER":"2203301901385162","OTP":"123123","AADHAAR_CONSENT":"Y","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdO5bjRw4uoVmf7PlPV4yw9W14tBYTcEx2b314yg\\/UzqdyrzwdFiEnF5pNx1IFLluvoeeOvzaLF7y+7Ay+UlPuled9NWeG03Xxii71\\/ZKQDKWDc3x6ZVugcuyMC1m5b6gBrhmRax5+oL5+WBPneSho+KrE7qnzA\\/QzwuxXQzBAEGvKKfjtA4OgYT+0EDkSbviGNXrBBn270VLe7h62riUxquz6FFJurcFvZ2zEzhd2SxR6fsd9OE8RTQ+pPCkxckgQYyO4\\/X6mts2rGkVilekPtGjCcSUWy6xvqzcGh6gzP2LFUQ8CBlcDPjVQpscqqm9uUg==","ENC_KEY":"KMt3\\/mov434oEgS9mr\\/WhHdmXhebgLjF+\\/XWDLdXcqK6L0Zt7c2jHm\\/iBFmkznsOYXmXkFFs2d8OaEzMgEroLulpCu7p1SGqTavY8k4o72BZlcnCEeRmT4\\/4Oz9ao1sTxvih7ZliQJ0R924Hh8TojRwE+DoofwoDIXpEQeBb9u8kuK7Cv0H5GUZAaUFP5zKJkE+6SJ63SlLpouFH3WyoBWFu6g+COkN1K0m\\/aHeCVFB2PKLhYxKAeu5bTXVFFjRd9M6h1HTz\\/6KAgGUT0Es4CnumVcvtxTY4j6sae2y7QDD7XwC407mTxAkxZnLRRcHhCPLRfOrwqvHmtnV+hLMDFQ=="}', '{"ENC_DATA":"h6fbbfTKwr+oNWAsGK+cit16TX0HkrmsuRnVOOcxL8v2lNclZNLm5sVQ+A7RTMLUZ1kWERiS3/N/pTbxI/2E8O5QoFJoeXL4C1+zQPW+G7gE8D6BbYHPSHhDOTuuz9nOy5XAibIOdsT/k4qibGuyPA==","CHANNEL_ID":"UCOWEB","ENC_KEY":"ts8a/MbDF0+15+hflr7Kv3jlLKSAGSH/48PpyeOcz66xXb9RmUeh35Hm59mF960ZczZX8syzVbP2yUYZt98pLh4e1DpSp0Ip0jWJri8kzRT8bIV/6S0RoiQYwypB2BkvY66uWCGINQm9arjoMgfOfWvD5HcxqhqsotlNXLq38VK0rSJU5fkUurk/seQi/kRY/oPs+Z37BE08a86Y/JtqozKm7lnhfbiLsSffDh9ZJz2oInMremLg9cEc0m+d50yQXhlUpg822zgAS4IXqZ+dgrMPF2pGNY7G7uKkJ/3PIYQ+4ntuCOJj1QE1XteLJ5AIW1K65t263JPmHAX2qqStUQ=="}', '{"errorMessage":"The attribute \'uid\' of tag \'auth\' is not a valid aadhaar number[14]","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:13:50', NULL, '2022-04-01 12:13:52', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000027', 'UCOWEB', 'validateAadhaarOtp', '{"METHOD_NAME":"validateAadhaarOtp","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","REF_NUMBER":"2203301901385162","OTP_REF_NUMBER":"2203301901385162","OTP":"123123","AADHAAR_CONSENT":"Y","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdO5bjRw4uoVmf7PlPV4yw9W14tBYTcEx2b314yg\\/UzqdyrzwdFiEnF5pNx1IFLluvoeeOvzaLF7y+7Ay+UlPuled9NWeG03Xxii71\\/ZKQDKWDc3x6ZVugcuyMC1m5b6gBrhmRax5+oL5+WBPneSho+KrE7qnzA\\/QzwuxXQzBAEGvKKfjtA4OgYT+0EDkSbviGNXrBBn270VLe7h62riUxquz6FFJurcFvZ2zEzhd2SxR6fsd9OE8RTQ+pPCkxckgQYyO4\\/X6mts2rGkVilekPtGjCcSUWy6xvqzcGh6gzP2LFUQ8CBlcDPjVQpscqqm9uUg==","ENC_KEY":"nT9fjNNEbTZKsFgz2H0C4jQKh\\/fZBGZp3aI\\/r+W42TC7xRM0XB8Ob+L9JrxzlmMb2bMaSDzR6m6GaNCxcsq1+EOxpouvcmeMIbJMfVHbsP2LDqsKhblkvoTAHWSlmsO++So+vP+O4kxOZ9bblMOcSu54xBmzyQVABOP84buaDgBhM0WIecIgNaIAEHPQ\\/Sp0tV\\/HYO2nQcRjTAFp6sYgTWE\\/0X196E8SuXIypb124LbLwCbXHK4U4aLhTdGv+IcyEWYJNlWxh92Oh\\/ZTrNrx6Wqv16ZK3VLD4hrhxuehIpHa+14mNVB5tY6GLIf\\/azBgmRYoaWi0nI37IuAbxmMa\\/g=="}', '{"ENC_DATA":"0pI0oyDvXPmrf6MaPq5XL7r9kYKthkczhq7T+5GL/4+qIcM8y0O0wo2N86dJDPqfZIs/Zrrogk1VzNpZ27ke7g==","CHANNEL_ID":"UCOWEB","ENC_KEY":"ep00R82gzEsorPRsZJgNVLuTs19wufZ6LDHK5pL62CTTqijPYbIkohk88f20o+pe/h1toRI8cK1UN3Hzxq+bl36rypK62eUpPGv21HCpDD8GxgKvQEvypRE5UntYuq/4o/9YvsHXqmwEsZhp7Y8F3f38SYZ9uRPAP0sQVtZTxl7OPzugGILA6i0lL9k49kg2EBDBKCmyFmYKjcMMw/nnjliFqWaILWZDXL4nWCuwm7o90ltL+4nbm/WbsFWDalbw0h+90XFjbyp2ZkwWYFvkjb+wU1hoK7EQlNLOnmIlHodeK3Bs/HHj9816bBv6eaiaXAABPYe71Xg5YHUbPmkRig=="}', '{"errorMessage":"Un Expected Error","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:15:44', NULL, '2022-04-01 12:15:45', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000028', 'UCOWEB', 'validateAadhaarOtp', '{"METHOD_NAME":"validateAadhaarOtp","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","REF_NUMBER":"2203301901385162","OTP_REF_NUMBER":"2203301901385162","OTP":"123123","AADHAAR_CONSENT":"Y","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdO5bjRw4uoVmf7PlPV4yw9W14tBYTcEx2b314yg\\/UzqdyrzwdFiEnF5pNx1IFLluvoeeOvzaLF7y+7Ay+UlPuled9NWeG03Xxii71\\/ZKQDKWDc3x6ZVugcuyMC1m5b6gBrhmRax5+oL5+WBPneSho+KrE7qnzA\\/QzwuxXQzBAEGvKKfjtA4OgYT+0EDkSbviGNXrBBn270VLe7h62riUxquz6FFJurcFvZ2zEzhd2SxR6fsd9OE8RTQ+pPCkxckgQYyO4\\/X6mts2rGkVilekPtGjCcSUWy6xvqzcGh6gzP2LFUQ8CBlcDPjVQpscqqm9uUg==","ENC_KEY":"I8t+e9GZkqsbni21ubO1xlDYobH96PshsxaUW2Tl4OoAGx2bxbmxBw\\/o2NCqCuI40EpCyHNXzpjdOvL5CCIr6flcCjm7i+xIDjtOmZRcXVP7RTxPfqDgt47aw5hocFvltrrFYAGO3tqXkuNpf5omvrr77jM1lf7EAS6sqefREul0n\\/LR7Klz6r\\/PFXhNyTaMXTRCoT+r\\/w1qL6mJ1FU0irDIcOeWG9QBQnYbJVBeDnjnP47RLzCA7BmK5owgzjcXulQMqyLJIg4g32O90pZl7rws3V2mehHWR4g+H5G3Xu2TPbePAFX2YXI4ja79ulLd7xH6onB8jYqbGHllHP78AQ=="}', '{"ENC_DATA":"n94TvsrNopcH9jw0uwhTujm02adO/uaKg0Ql5GgJk3smVdJsXXXYvg0jN8+LmoI3jXfFKDbNw1rq/cfZ9uqm/ON1a/+7lbq7FugDXWDS1dUQ0OhCozXzfcq/G/r4GzeSSqipGuPoFR6RyV0iHNiHnw==","CHANNEL_ID":"UCOWEB","ENC_KEY":"ltTIYeyFTyXM5e2WndsG8rHqQniUmYwuYefGqupkJAM6p8mXidw9e85X8WLkAW43kWZuGFKZa7w0rHBMtgA+Yg5jNWUKdSkX4r+WMbR8ZXEhQypQU1TJNA9zPQvMuNJSIy9qmPKCgqnQkHTg4mk+bBnxYut4Duth1Posf0lN/lBsTrA58qc3x7k82OX6gx1c0FYvBn5FOZUffCzNmO1SHvh5f29Rj/pbCIUGWS7eISX5UxSecjoIe2FZIociMpshUky6KyO9lbJ6K7rt8KQtkTlak+bFzlSPVISg46r1MDU4hKhl4j1Xsm9nbz4CjPY2hHSXb3xd3pwXWGspy7FMYQ=="}', '{"errorMessage":"The attribute \'uid\' of tag \'auth\' is not a valid aadhaar number[14]","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:16:51', NULL, '2022-04-01 12:16:53', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000029', 'UCOWEB', 'aadhaarNumValidation', '{"METHOD_NAME":"aadhaarNumValidation","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdOztqCVnoGdhfHxlbZsHx\\/MQBmeLPX7\\/zfJ2yEJPxmPCPU4MvMO2wIy3yQtFEJI5A0sLQTDhXuPEUd++03h661SGxSUsR0nTPEKHrpu4O2Tu2GcaSzsoN5Zv19lewKD4BE+tl7AOmkO6KJYHjY9xSQamnEodGpLOcrT+gf1oki8FG9ZHL\\/J9rm7cIHNJDtBcLmQ==","ENC_KEY":"eqN1TPMmgE0FALyrBNJrWXbIYAZnZ\\/zdmvbWMPRXxbJ7aMZurckbJxXtzZmIQsOW4Rjh0WuRCSHNavCvflbvBesI0qplEnvJTbhMccpF8ncZCFi7r9222zsnts+Q+OASmQVSWTE0+Cq38CpxCaaiJipTqzSSDN1Sz59o1GddhMJelnihANjHGqvHyZEndA4C7HAXk584fkWESAKtd0796Tss2r2+eY3xr2oa8IiwJn0MUGIu37mEWou5eXtqPQ8uvw3fiVyBt0dv2QbCasagKL64s4FSZfhvF90bDQJW6WrHv5ibCKztnNifYduQWonL\\/t5JPUPLnFiBBNCqXvtSNQ=="}', '{"ENC_DATA":"SXOuBe3lLcB0geOEHoB+Obw9FADfvBcOGdRzIqWlQSTdgZCyOJSsKxbqvLj773tdzX8Clzo7pZW+iWwcrTvzEN3Jy0RocCA3vaGHxP93pLDE/IQgNpWEXf+MoOdmdMqrHAW7ML1i4qEMqOwFwvx2Z8AF7hC6PK6aT6RERWAiRzamnqxe4eJDZq2G9oXYYRazY00Mc1n735lGNTn2hcdyeQ==","CHANNEL_ID":"UCOWEB","ENC_KEY":"Ob2kN/9QeoVMTHezrTXG8Wk5xC90s+3huUlL0ZznVQeIkrZbbexXht3PXjj+zZH35Zz4voduWEOv949acS48TVSxjdej+kSMrRxERU9YTUG0+UDkPLcRfb+TgvNH8m/AgOD/qlHx5dLVjqMe6oAVVgvRp/t9vOmoaaGRiOk5SDUE1xiLaauuVFwSdTgWgO64Wcy8uAvQz1cLFTRAuMi5dPSXhHM/nOgZ8F7oJu33i7cmUnQu3nqFuWYgwPohZ9pn/x3Y1pbbYPygDtX4XAt94RGACmvzxXMWwYs6gNS062/NSiOgcptf03gegZuxymF/56dlcMrD/YFk0zf1jU2qvA=="}', '{"errorMessage":"OTP failed, Error Code: 14, Error Message : The attribute \'uid\' of tag \'otp\' is not a valid aadhaar number","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:17:44', NULL, '2022-04-01 12:17:45', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000030', 'UCOWEB', 'validateAadhaarOtp', '{"METHOD_NAME":"validateAadhaarOtp","MOBILE_NUMBER":"8660677277","AADHAAR_NUMBER":"123412341234","REF_NUMBER":"2203301901385162","OTP_REF_NUMBER":"2203301901385162","OTP":"123123","AADHAAR_CONSENT":"Y","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"EIecPqpkdGXbLwipQXQdO5bjRw4uoVmf7PlPV4yw9W14tBYTcEx2b314yg\\/UzqdyrzwdFiEnF5pNx1IFLluvoeeOvzaLF7y+7Ay+UlPuled9NWeG03Xxii71\\/ZKQDKWDc3x6ZVugcuyMC1m5b6gBrhmRax5+oL5+WBPneSho+KrE7qnzA\\/QzwuxXQzBAEGvKKfjtA4OgYT+0EDkSbviGNXrBBn270VLe7h62riUxquz6FFJurcFvZ2zEzhd2SxR6fsd9OE8RTQ+pPCkxckgQYyO4\\/X6mts2rGkVilekPtGjCcSUWy6xvqzcGh6gzP2LFUQ8CBlcDPjVQpscqqm9uUg==","ENC_KEY":"ZAZPk+pPtTS6M6HkwIAywzoMRgsVSZcJ41jLDxTgKgiqgW+2cZBUYGPBlcs8kp83TbUUYCCVBiQzPECK5+fcEswJ4F1dAeEJCl1MuJbNOyoPfzruvJ5C+cpKnj6kggMSlc8boWzlR3+nmoOwY5FBt32684ahftzDJ00eAWhBg44Sh+Cw0dN2ic3sBd5WNEBP5l3SRX9LkDCMOW9VjWZg5xbLlAHxVUzhyWf51sDwLJQTg19bR4+Na04pIjeIPqgOSRINkC9DwrBdl+b3ukGUvO+wAxM5+b2sZ0XJz6VGL220itWLWdqCLTC5lqaLvMmq7vx8Kln\\/UsdJZcfDGijXRw=="}', '{"ENC_DATA":"TUgBCzcSaCYtlKzsyFQZ8dlCwOCxqHPz0DXuQcZxXVtRT0kwr46Fjn6VbsvCFoD3TsyhtaeXj2mWB9kzxQLz7sgMidsFnLUmpkUU0o+AgeBhhUXQYYd9tEcTmJajyDkrLH97WioONo+VeymrJOYXrQ==","CHANNEL_ID":"UCOWEB","ENC_KEY":"ovCyHp53x6II8Epra57mezkAl3tU0U7IsOF0Cj5NooaOXomSVAgvNjpBFdvfEapl8xfbW+K6N42dvV6eRJSXKV2iJnXOohUe3fw2Kd0pqi+0kP+l8PYj8mrHhderhH5F5RzOKsxLJgh+Haxjp19r6WZeCS/fj5Zhj64c2iKtGtbl3nCPlcWZ6KAODYWLx/Y43TTL7++p+qCXFReX1rfNKnl8kO92/hYvZGEWPXKSP0bRE7i7kjfKNpHUBdOHGeYDJmBiX4SSDd0LhjXHoadfoiHrS3RNetnk/WRio+wI1frLd7T6hvuK6NlrfgM6vlBO34ACGf73ieMCNe5nVTvDag=="}', '{"errorMessage":"The attribute \'uid\' of tag \'auth\' is not a valid aadhaar number[14]","responseCode":"F"}', 'ARN202204011000005', '2022-04-01 12:17:50', NULL, '2022-04-01 12:17:51', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000031', 'UCOWEB', 'panValidation', '{"METHOD_NAME":"panValidation","MOBILE_NUMBER":"8660677277","REF_NUMBER":"2203301901385162","PAN_NUMBER":"DXVPS0667G","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"m4mVwius69qcUatJCzGze3C2\\/SF8p5iMLp48ZGAR2Bkc2a41iM\\/2PNzFwgk4uqNtM1K51B+x19ypm47jFzab1IMvFaVmtuKuDqxaaUmRbY16yXXLr9weeXXGb6Opz7YtZlq3NCQ1ZlXQNDM3ADqH5u7wwIOWq+Mlptv+PuG5GASXZ6SwR2UcvVqVLufBSoO+Cw13iAE+MnLqzo50hKuXpG8opvBzvKu3oEoyKmACMyk=","ENC_KEY":"EEy8CA8NSNOBLDFEPrLinLYFYsfyaKAP7jj7Ty8NpyHoImrvMNlz4m3r3roVx9Lk\\/fSL9oujqfpsAT7i1ydUbQaoGRzTgrYpAIazsgN8CkHHP7mRP69f2kYKNVJ0ucTKKFy+q3Hodwr1hHwnUu3ErxiOFrX48EDQQzLC70QYVQgSLPWfZBj+d9L4u22Ah0B7nSJmfTeooLoNsd9kHqY\\/00fsSoJepAmiQlZVCOCdDTClOkrgyyb1U4wN+n5KPKxTdsGYkQTh1p6iSQ+sQXwC1i1vp+1UtYpEzi6bWutETJnmsNM55iSRp+ghn\\/2gMvpOwdHJrJXfu6rJFV2uKgjbag=="}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><META HTTP-EQUIV="CONTENT-TYPE" CONTENT="TEXT/HTML; CHARSET=utf-8"/><title>Error</title></head><body><H2>Error</H2><table summary="Error" border="0" bgcolor="#FEEE7A" cellpadding="0" cellspacing="0" width="400"><tr><td><table summary="Error" border="0" cellpadding="3" cellspacing="1"><tr valign="top" bgcolor="#FBFFDF" align="lef', NULL, 'ARN202204011000005', '2022-04-01 18:23:41', NULL, '2022-04-01 18:23:42', NULL, NULL, NULL);
INSERT INTO `log_extapi_sent` (`REQ_NUM`, `REQ_CHANNEL_CODE`, `REQ_SERVICE_CODE`, `REQ_RAW_DATA`, `REQ_DATA`, `RESP_RAW_DATA`, `RESP_DATA`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('2022040110000032', 'UCOWEB', 'panValidation', '{"METHOD_NAME":"panValidation","MOBILE_NUMBER":"8660677277","REF_NUMBER":"2203301901385162","PAN_NUMBER":"DXVPS0667G","CHANNEL_CODE":"UCOWEB","USER_AGENT":"Chrome"}', '{"CHANNEL_ID":"UCOWEB","ENC_DATA":"m4mVwius69qcUatJCzGze3C2\\/SF8p5iMLp48ZGAR2Bkc2a41iM\\/2PNzFwgk4uqNtM1K51B+x19ypm47jFzab1IMvFaVmtuKuDqxaaUmRbY16yXXLr9weeXXGb6Opz7YtZlq3NCQ1ZlXQNDM3ADqH5u7wwIOWq+Mlptv+PuG5GASXZ6SwR2UcvVqVLufBSoO+Cw13iAE+MnLqzo50hKuXpG8opvBzvKu3oEoyKmACMyk=","ENC_KEY":"qwhVMZV0kypEGgdnV07r1M\\/RwE6LQH9hmjGPDt6JjsojkpAj9zcAT8ER\\/0knqDshLPKCRH2Sc6O0mY1bmuTIA5twcByq3CMNZcRIVOsYktnNJODTu40teLpsZwbS\\/yWlAVgIhAOd4C52tZeWMzvPOdft\\/mQCTjuNGV\\/oqyYdxxxJh8nm6vcZf27iB8LajdJcm9lekShhlZ8EkbiNla191IMihM\\/1tvwF9q89VB0HJdwpvu4AE3qrcRHf3blKfe+qVFY7pLYgYKOeKlUyzrDV60XkI+YaCaK0qsK2dl7+0nwgKAQEWLTdux7I\\/XzDlfCXMq5C0rPP8IxP\\/6UtxQ01qA=="}', '{"ENC_DATA":"mpALFyTDxzAsClACUQ9LL+VKMzruWKWoGRfGStSBQeQWto0nzeRYQXdQfWruIKZH/g6i/b9dAdAJSkkr6AflKVcixbrQMqKm6Z5Mxn6csQw=","CHANNEL_ID":"UCOWEB","ENC_KEY":"CFR1FSOxvadoX/aFE+XYH/ecC2oSvYMkgSwztRPLKfdt89IqV9LcZejwAUdR/G3+uZBWu2GjfXITzMI3748Ythg6JSum5LOZvN/FgHIG/nMmhPb1dDVR04skUN2OOkLWt5CISA8bfhF0By3wSVfZLFKN7RZfHyRcteVgK5YoOp3Po1RyOdzQPcUu8k9T5/lhGuNw2d3nLim/QeosMIRo1jQ8OWxzc6v8DUoz3YALSdSpjmREOAcXhcNi8HRAYOleJPNPydMpQ/MVtAF7qgT9Aaw9yg1ieW8kSypAfoQsCiBfK+Y5Q46s3RTGBVBqREqsmTRhFqLnrGqiL/RFA9Ffqw=="}', '{"responseCode":"S","panRefNum":"UCOWP2204011815431002823682535"}', 'ARN202204011000005', '2022-04-01 18:23:45', NULL, '2022-04-01 18:23:45', NULL, NULL, NULL);
/*!40000 ALTER TABLE `log_extapi_sent` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.log_extapi_sent_seq
CREATE TABLE IF NOT EXISTS `log_extapi_sent_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) unsigned NOT NULL,
  `cycle_option` tinyint(1) unsigned NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB SEQUENCE=1;

-- Dumping data for table digital_sb_account.log_extapi_sent_seq: ~1 rows (approximately)
/*!40000 ALTER TABLE `log_extapi_sent_seq` DISABLE KEYS */;
INSERT INTO `log_extapi_sent_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
	(10000101, 1, 99999999, 10000001, 1, 100, 1, 0);
/*!40000 ALTER TABLE `log_extapi_sent_seq` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.log_otpreq
CREATE TABLE IF NOT EXISTS `log_otpreq` (
  `OTP_REQ_ID` varchar(30) NOT NULL,
  `OTP_PGMCODE` varchar(12) DEFAULT NULL,
  `OTP_MOBILE_NUM` varchar(15) DEFAULT NULL,
  `OTP_EMAIL_ID` varchar(120) DEFAULT NULL,
  `SMS_VERIFIED_FLAG` char(1) DEFAULT NULL,
  `SMS_VERIFIED_ON` datetime DEFAULT NULL,
  `SMS_RESENT_COUNT` int(3) DEFAULT NULL,
  `SMS_SENT_RESP` varchar(255) DEFAULT NULL,
  `EMAIL_VERIFIED_FLAG` char(1) DEFAULT NULL,
  `EMAIL_VERIFIED_ON` datetime DEFAULT NULL,
  `EMAIL_RESENT_COUNT` int(3) DEFAULT NULL,
  `EMAIL_SENT_RESP` varchar(255) DEFAULT NULL,
  `REQ_DATA` text DEFAULT NULL,
  `GEN_PLATFORM` varchar(60) DEFAULT NULL,
  `GEN_BROWSER_NAME` varchar(60) DEFAULT NULL,
  `GEN_BROWSER_VER` varchar(60) DEFAULT NULL,
  `GEN_IP_ADDRESS` varchar(255) DEFAULT NULL,
  `CR_BY` varchar(30) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`OTP_REQ_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.log_otpreq: ~16 rows (approximately)
/*!40000 ALTER TABLE `log_otpreq` DISABLE KEYS */;
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203291000169', 'N', '8088862520', 'madhukar.bantwal@gmail.com', 'S', '2022-03-29 14:06:15', NULL, 'MTIzMTIz', 'S', '2022-03-29 14:06:52', NULL, 'MTIzMTIz', '{"ReqType":"N","RegCustTitle":"MR","RegName":"SHIVANANDA","RegEmail":"madhukar.bantwal@gmail.com","RegMob":"8088862520","RegReferral":"ABCD1234"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-29 14:05:56');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203291000170', 'N', '8088862520', 'madhukar.bantwal@gmail.com', 'S', '2022-03-29 17:36:13', NULL, 'MTIzMTIz', 'S', '2022-03-29 17:36:19', NULL, 'MTIzMTIz', '{"ReqType":"N","RegCustTitle":"MR","RegName":"SHIVANANDA","RegEmail":"madhukar.bantwal@gmail.com","RegMob":"8088862520","RegReferral":""}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-29 17:36:05');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203291000171', 'N', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-29 20:02:43', NULL, 'MTIzMTIz', 'S', '2022-03-29 20:02:48', NULL, 'MTIzMTIz', '{"ReqType":"N","RegCustTitle":"MR","RegName":"SHIVANANDA","RegEmail":"madhukar.bantwal@gmail.com","RegMob":"8660677277","RegReferral":""}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-29 20:02:13');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203301000172', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'P', NULL, NULL, 'MTIzMTIz', NULL, NULL, NULL, NULL, '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"202203291000003"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-30 10:29:00');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203301000173', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-30 10:29:42', NULL, 'MTIzMTIz', 'S', '2022-03-30 10:33:42', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"202203291000003"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-30 10:29:36');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203301000174', 'N', '9844098440', 'madhukar@gmail.com', 'P', NULL, NULL, 'MTIzMTIz', NULL, NULL, NULL, NULL, '{"ReqType":"N","RegCustTitle":"MR","RegName":"SHIVA","RegEmail":"madhukar@gmail.com","RegMob":"9844098440","RegReferral":""}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-30 14:41:58');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203301000175', 'N', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-30 17:07:59', NULL, 'MTIzMTIz', 'S', '2022-03-30 17:08:11', NULL, 'MTIzMTIz', '{"ReqType":"N","RegCustTitle":"MR","RegName":"SHIVANANDA","RegEmail":"madhukar.bantwal@gmail.com","RegMob":"8660677277","RegReferral":"","RegDbt":"Y"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-30 17:07:39');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203301000176', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-30 19:10:54', NULL, 'MTIzMTIz', 'S', '2022-03-30 19:11:02', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202203301000004"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-30 19:10:48');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203311000177', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-31 11:02:43', NULL, 'MTIzMTIz', 'S', '2022-03-31 11:04:51', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202203301000004"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-31 11:02:34');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203311000178', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-31 12:19:35', NULL, 'MTIzMTIz', 'S', '2022-03-31 12:19:41', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202203301000004"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-31 12:19:16');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203311000179', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-31 14:43:18', NULL, 'MTIzMTIz', 'S', '2022-03-31 14:43:32', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202203301000004"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-31 14:43:11');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202203311000180', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-03-31 15:39:40', NULL, 'MTIzMTIz', 'S', '2022-03-31 15:39:52', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202203301000004"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-03-31 15:39:26');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202204011000181', 'N', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-04-01 12:11:53', NULL, 'MTIzMTIz', 'S', '2022-04-01 12:11:59', NULL, 'MTIzMTIz', '{"ReqType":"N","RegCustTitle":"MR","RegName":"SHIVA","RegEmail":"madhukar.bantwal@gmail.com","RegMob":"8660677277","RegReferral":"","RegDbt":"Y"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-04-01 12:11:47');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202204011000182', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-04-01 13:52:36', NULL, 'MTIzMTIz', 'S', '2022-04-01 13:52:40', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202204011000005"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-04-01 13:52:29');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202204011000183', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-04-01 18:22:15', NULL, 'MTIzMTIz', 'S', '2022-04-01 18:22:27', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202204011000005"}', 'Windows', 'Chrome', '99.0.4844.82', '::1', NULL, '2022-04-01 18:22:09');
INSERT INTO `log_otpreq` (`OTP_REQ_ID`, `OTP_PGMCODE`, `OTP_MOBILE_NUM`, `OTP_EMAIL_ID`, `SMS_VERIFIED_FLAG`, `SMS_VERIFIED_ON`, `SMS_RESENT_COUNT`, `SMS_SENT_RESP`, `EMAIL_VERIFIED_FLAG`, `EMAIL_VERIFIED_ON`, `EMAIL_RESENT_COUNT`, `EMAIL_SENT_RESP`, `REQ_DATA`, `GEN_PLATFORM`, `GEN_BROWSER_NAME`, `GEN_BROWSER_VER`, `GEN_IP_ADDRESS`, `CR_BY`, `CR_ON`) VALUES
	('OTP202204061000201', 'E', '8660677277', 'madhukar.bantwal@gmail.com', 'S', '2022-04-06 18:51:54', NULL, 'MTIzMTIz', 'S', '2022-04-06 18:51:59', NULL, 'MTIzMTIz', '{"ReqType":"E","LoginMob":"8660677277","LoginEmail":"madhukar.bantwal@gmail.com","LoginAppId":"ARN202204011000005"}', 'Windows', 'Chrome', '100.0.4896.60', '::1', NULL, '2022-04-06 18:51:49');
/*!40000 ALTER TABLE `log_otpreq` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.log_otpreq_seq
CREATE TABLE IF NOT EXISTS `log_otpreq_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) unsigned NOT NULL,
  `cycle_option` tinyint(1) unsigned NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB SEQUENCE=1;

-- Dumping data for table digital_sb_account.log_otpreq_seq: ~1 rows (approximately)
/*!40000 ALTER TABLE `log_otpreq_seq` DISABLE KEYS */;
INSERT INTO `log_otpreq_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
	(1000251, 1, 9999999, 1000001, 1, 50, 1, 0);
/*!40000 ALTER TABLE `log_otpreq_seq` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.sbreq_ekyc_data
CREATE TABLE IF NOT EXISTS `sbreq_ekyc_data` (
  `SBREQ_APP_NUM` varchar(30) NOT NULL,
  `EKYC_SL` int(3) NOT NULL,
  `SBREQ_MOBILE_NUM` varchar(15) DEFAULT NULL,
  `EKYC_REF_NUM` varchar(50) DEFAULT NULL,
  `EKYC_NAME` varchar(150) DEFAULT NULL,
  `EKYC_DOB` varchar(150) DEFAULT NULL,
  `EKYC_GENDER` varchar(60) DEFAULT NULL,
  `EKYC_CARE_OF_NAME` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_1` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_2` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_3` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_4` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_5` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_6` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_7` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_8` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_9` varchar(150) DEFAULT NULL,
  `EKYC_ADDR_10` varchar(150) DEFAULT NULL,
  `EKYC_PINCODE` varchar(10) DEFAULT NULL,
  `EKYC_UID` varchar(500) DEFAULT NULL,
  `EKYC_CUST_IMG` text DEFAULT NULL,
  `CR_BY` varchar(30) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`SBREQ_APP_NUM`,`EKYC_SL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.sbreq_ekyc_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `sbreq_ekyc_data` DISABLE KEYS */;
INSERT INTO `sbreq_ekyc_data` (`SBREQ_APP_NUM`, `EKYC_SL`, `SBREQ_MOBILE_NUM`, `EKYC_REF_NUM`, `EKYC_NAME`, `EKYC_DOB`, `EKYC_GENDER`, `EKYC_CARE_OF_NAME`, `EKYC_ADDR_1`, `EKYC_ADDR_2`, `EKYC_ADDR_3`, `EKYC_ADDR_4`, `EKYC_ADDR_5`, `EKYC_ADDR_6`, `EKYC_ADDR_7`, `EKYC_ADDR_8`, `EKYC_ADDR_9`, `EKYC_ADDR_10`, `EKYC_PINCODE`, `EKYC_UID`, `EKYC_CUST_IMG`, `CR_BY`, `CR_ON`) VALUES
	('ARN202204011000005', 1, '8660677277', '2203301901385162', 'Harshitha K', '09-03-1998', 'Female', '', 'D/O K POOVAPPA GOWDA', '', 'HALENERENKI', 'Haleneranki', 'Dakshina Kannada', 'Karnataka', '574241', '', '', '', NULL, 'VEpleTRBaFBsamNZN3pNZXZOL2RqZz09', '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', NULL, '2022-04-01 12:17:51');
/*!40000 ALTER TABLE `sbreq_ekyc_data` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.sbreq_master
CREATE TABLE IF NOT EXISTS `sbreq_master` (
  `SBREQ_APP_NUM` varchar(30) NOT NULL,
  `SBREQ_MOBILE_NUM` varchar(15) DEFAULT NULL,
  `SBREQ_EMAIL_ID` varchar(255) DEFAULT NULL,
  `SBREQ_APP_STATUS` char(3) DEFAULT NULL,
  `SBREQ_VKYC_STATUS` char(3) DEFAULT NULL,
  `SBREQ_CUST_TITLE` varchar(12) DEFAULT NULL,
  `SBREQ_CUST_NAME` varchar(150) DEFAULT NULL,
  `SBREQ_CUST_DOB` date DEFAULT NULL,
  `SBREQ_DBT_CHOICE` char(1) DEFAULT NULL,
  `SBREQ_EKYC_FLAG` char(1) DEFAULT NULL,
  `SBREQ_EKYC_REF_NUM` varchar(50) DEFAULT NULL,
  `SBREQ_EKYC_NAME` varchar(150) DEFAULT NULL,
  `SBREQ_PAN_FLAG` char(1) DEFAULT NULL,
  `SBREQ_PAN_REF_NUM` varchar(50) DEFAULT NULL,
  `SBREQ_PAN_CARD` varchar(500) DEFAULT NULL,
  `SBREQ_PAN_NAME` varchar(150) DEFAULT NULL,
  `REFERRAL_CODE` varchar(120) DEFAULT NULL,
  `CR_BY` varchar(30) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(30) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  `AU_BY` varchar(30) DEFAULT NULL,
  `AU_ON` datetime DEFAULT NULL,
  `TBA_KEY` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`SBREQ_APP_NUM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.sbreq_master: ~0 rows (approximately)
/*!40000 ALTER TABLE `sbreq_master` DISABLE KEYS */;
INSERT INTO `sbreq_master` (`SBREQ_APP_NUM`, `SBREQ_MOBILE_NUM`, `SBREQ_EMAIL_ID`, `SBREQ_APP_STATUS`, `SBREQ_VKYC_STATUS`, `SBREQ_CUST_TITLE`, `SBREQ_CUST_NAME`, `SBREQ_CUST_DOB`, `SBREQ_DBT_CHOICE`, `SBREQ_EKYC_FLAG`, `SBREQ_EKYC_REF_NUM`, `SBREQ_EKYC_NAME`, `SBREQ_PAN_FLAG`, `SBREQ_PAN_REF_NUM`, `SBREQ_PAN_CARD`, `SBREQ_PAN_NAME`, `REFERRAL_CODE`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`, `AU_BY`, `AU_ON`, `TBA_KEY`) VALUES
	('ARN202204011000005', '8660677277', 'madhukar.bantwal@gmail.com', 'P', NULL, 'MR', 'SHIVA', NULL, 'Y', 'Y', '2203301901385162', 'Harshitha K', 'Y', 'UCOWP2204011815431002823682535', 'TVhMRlFoSWtsZldScm9URE5vNE9pUT09', NULL, NULL, 'OTP202204011000181', '2022-04-01 12:11:59', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `sbreq_master` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.sbreq_master_seq
CREATE TABLE IF NOT EXISTS `sbreq_master_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NUseq
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) unsigned NOT NULL,
  `cycle_option` tinyint(1) unsigned NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB SEQUENCE=1;

-- Dumping data for table digital_sb_account.sbreq_master_seq: ~1 rows (approximately)
/*!40000 ALTER TABLE `sbreq_master_seq` DISABLE KEYS */;
INSERT INTO `sbreq_master_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
	(1000051, 1, 9999999, 1000001, 1, 50, 1, 0);
/*!40000 ALTER TABLE `sbreq_master_seq` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.send_alert
CREATE TABLE IF NOT EXISTS `send_alert` (
  `ALERT_REQ_ID` varchar(30) NOT NULL,
  `ALERT_TYPE` varchar(30) DEFAULT NULL,
  `ALERT_TO_ADD` varchar(255) DEFAULT NULL,
  `ALERT_SUBJECT` varchar(255) DEFAULT NULL,
  `ALERT_BODY` text DEFAULT NULL,
  `ALERT_TPL_CODE` varchar(30) DEFAULT NULL,
  `ALERT_PRIORITY` int(3) DEFAULT NULL,
  `ALERT_SENT_LOG` varchar(255) DEFAULT NULL,
  `ALERT_TXN_ID` varchar(30) DEFAULT NULL,
  `CR_BY` varchar(32) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(32) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`ALERT_REQ_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.send_alert: ~12 rows (approximately)
/*!40000 ALTER TABLE `send_alert` DISABLE KEYS */;
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022032910000051', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203291000169', NULL, '2022-03-29 14:06:15', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022032910000052', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203291000170', NULL, '2022-03-29 17:36:13', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022032910000053', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203291000171', NULL, '2022-03-29 20:02:43', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033010000054', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203301000173', NULL, '2022-03-30 10:29:42', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033010000055', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203301000175', NULL, '2022-03-30 17:07:59', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033010000056', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203301000176', NULL, '2022-03-30 19:10:54', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000057', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203311000177', NULL, '2022-03-31 11:02:43', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000058', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203311000178', NULL, '2022-03-31 12:19:35', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000059', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203311000179', NULL, '2022-03-31 14:43:18', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000060', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202203311000180', NULL, '2022-03-31 15:39:40', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040110000061', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202204011000181', NULL, '2022-04-01 12:11:53', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040110000062', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202204011000182', NULL, '2022-04-01 13:52:36', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040110000063', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202204011000183', NULL, '2022-04-01 18:22:15', NULL, NULL);
INSERT INTO `send_alert` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_TO_ADD`, `ALERT_SUBJECT`, `ALERT_BODY`, `ALERT_TPL_CODE`, `ALERT_PRIORITY`, `ALERT_SENT_LOG`, `ALERT_TXN_ID`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040610000101', 'EMAIL', 'madhukar.bantwal@gmail.com', NULL, 'Dear Customer, 123123 is your verification OTP for Online Account Openning.', 'OTP-EMAIL', 5, NULL, 'OTP202204061000201', NULL, '2022-04-06 18:51:54', NULL, NULL);
/*!40000 ALTER TABLE `send_alert` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.send_alert_queue
CREATE TABLE IF NOT EXISTS `send_alert_queue` (
  `ALERT_REQ_ID` varchar(30) NOT NULL,
  `ALERT_TYPE` varchar(30) DEFAULT NULL,
  `ALERT_PRIORITY` int(3) DEFAULT NULL,
  `PROCESS_LOCK_FLG` char(1) DEFAULT NULL,
  `CR_BY` varchar(32) DEFAULT NULL,
  `CR_ON` datetime DEFAULT NULL,
  `MO_BY` varchar(32) DEFAULT NULL,
  `MO_ON` datetime DEFAULT NULL,
  PRIMARY KEY (`ALERT_REQ_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table digital_sb_account.send_alert_queue: ~12 rows (approximately)
/*!40000 ALTER TABLE `send_alert_queue` DISABLE KEYS */;
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022032910000051', 'EMAIL', 5, 'P', NULL, '2022-03-29 14:06:15', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022032910000052', 'EMAIL', 5, 'P', NULL, '2022-03-29 17:36:13', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022032910000053', 'EMAIL', 5, 'P', NULL, '2022-03-29 20:02:43', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033010000054', 'EMAIL', 5, 'P', NULL, '2022-03-30 10:29:42', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033010000055', 'EMAIL', 5, 'P', NULL, '2022-03-30 17:07:59', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033010000056', 'EMAIL', 5, 'P', NULL, '2022-03-30 19:10:54', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000057', 'EMAIL', 5, 'P', NULL, '2022-03-31 11:02:43', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000058', 'EMAIL', 5, 'P', NULL, '2022-03-31 12:19:35', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000059', 'EMAIL', 5, 'P', NULL, '2022-03-31 14:43:18', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022033110000060', 'EMAIL', 5, 'P', NULL, '2022-03-31 15:39:40', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040110000061', 'EMAIL', 5, 'P', NULL, '2022-04-01 12:11:53', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040110000062', 'EMAIL', 5, 'P', NULL, '2022-04-01 13:52:36', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040110000063', 'EMAIL', 5, 'P', NULL, '2022-04-01 18:22:15', NULL, NULL);
INSERT INTO `send_alert_queue` (`ALERT_REQ_ID`, `ALERT_TYPE`, `ALERT_PRIORITY`, `PROCESS_LOCK_FLG`, `CR_BY`, `CR_ON`, `MO_BY`, `MO_ON`) VALUES
	('SA2022040610000101', 'EMAIL', 5, 'P', NULL, '2022-04-06 18:51:54', NULL, NULL);
/*!40000 ALTER TABLE `send_alert_queue` ENABLE KEYS */;

-- Dumping structure for table digital_sb_account.send_alert_seq
CREATE TABLE IF NOT EXISTS `send_alert_seq` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) unsigned NOT NULL,
  `cycle_option` tinyint(1) unsigned NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB SEQUENCE=1;

-- Dumping data for table digital_sb_account.send_alert_seq: ~1 rows (approximately)
/*!40000 ALTER TABLE `send_alert_seq` DISABLE KEYS */;
INSERT INTO `send_alert_seq` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
	(10000151, 1, 99999999, 10000001, 1, 50, 1, 0);
/*!40000 ALTER TABLE `send_alert_seq` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
