
CREATE DATABASE IF NOT EXISTS website_traffic_tracker
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE website_traffic_tracker;

CREATE TABLE `users` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`email` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`email_verified_at` TIMESTAMP NULL DEFAULT NULL,
`password` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`remember_token` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`created_at` TIMESTAMP NULL DEFAULT NULL,
`updated_at` TIMESTAMP NULL DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `visits` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`page_url` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`ip_address` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`country` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`region` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`city` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`isp` VARCHAR(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`visited_at` TIMESTAMP NOT NULL,
`created_at` TIMESTAMP NULL DEFAULT NULL,
`updated_at` TIMESTAMP NULL DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `logs` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
`user_name` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`user_id` VARCHAR(45) COLLATE utf8mb4_unicode_ci NOT NULL,
`status` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
`message` TEXT COLLATE utf8mb4_unicode_ci,
`created_at` TIMESTAMP NULL DEFAULT NULL,
`updated_at` TIMESTAMP NULL DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;