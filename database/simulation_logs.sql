-- Database export for InfinityFree / Shared Hosting phpMyAdmin
-- Table structure for table `simulation_logs`

CREATE TABLE IF NOT EXISTS `simulation_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_token` varchar(64) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `file_selected` tinyint(1) NOT NULL DEFAULT '0',
  `file_extension` varchar(20) DEFAULT NULL,
  `file_size_kb` int unsigned DEFAULT NULL,
  `cta_login_clicked` tinyint(1) NOT NULL DEFAULT '0',
  `auth_method` varchar(30) DEFAULT NULL,
  `masked_target` varchar(100) DEFAULT NULL,
  `debrief_viewed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `simulation_logs_session_token_index` (`session_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional update if table already exists
ALTER TABLE `simulation_logs` ADD COLUMN IF NOT EXISTS `auth_method` varchar(30) DEFAULT NULL AFTER `cta_login_clicked`;
ALTER TABLE `simulation_logs` ADD COLUMN IF NOT EXISTS `masked_target` varchar(100) DEFAULT NULL AFTER `auth_method`;
