-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `commissions`;
CREATE TABLE `commissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned DEFAULT NULL,
  `commission` double(8,2) DEFAULT '0.00',
  `to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commissions_property_id_foreign` (`property_id`),
  CONSTRAINT `commissions_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `communes`;
CREATE TABLE `communes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `district_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `commune_translations`;
CREATE TABLE `commune_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commune_id` int(10) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commune_translations_commune_id_foreign` (`commune_id`),
  CONSTRAINT `commune_translations_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double(8,2) DEFAULT '0.00',
  `commission` double(8,2) DEFAULT '0.00',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `create_on` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `staff_id` int(10) unsigned DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contracts_customer_id_foreign` (`customer_id`),
  KEY `contracts_staff_id_foreign` (`staff_id`),
  KEY `contracts_property_id_foreign` (`property_id`),
  KEY `contracts_user_id_foreign` (`user_id`),
  CONSTRAINT `contracts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `contracts_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  CONSTRAINT `contracts_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`id`),
  CONSTRAINT `contracts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_card` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `verified_code` tinyint(1) DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  `last_active` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `customer_translations`;
CREATE TABLE `customer_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `locale` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_translations_customer_id_locale_unique` (`customer_id`,`locale`),
  KEY `customer_translations_locale_index` (`locale`),
  CONSTRAINT `customer_translations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `districts`;
CREATE TABLE `districts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `district_translations`;
CREATE TABLE `district_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `district_id` int(10) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `district_translations_district_id_foreign` (`district_id`),
  CONSTRAINT `district_translations_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `fileable_id` int(11) DEFAULT NULL,
  `fileable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `offices`;
CREATE TABLE `offices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_main` tinyint(1) NOT NULL,
  `province_id` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `commune_id` int(10) unsigned DEFAULT NULL,
  `village_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(18,7) NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci COMMENT 'store json',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `owner`;
CREATE TABLE `owner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone3` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `paymenttransactions`;
CREATE TABLE `paymenttransactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double(8,2) DEFAULT '0.00',
  `updated_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `contract_id` int(10) unsigned DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `paymenttransactions_contract_id_foreign` (`contract_id`),
  KEY `paymenttransactions_property_id_foreign` (`property_id`),
  KEY `paymenttransactions_user_id_foreign` (`user_id`),
  CONSTRAINT `paymenttransactions_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `paymenttransactions_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  CONSTRAINT `paymenttransactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `properties`;
CREATE TABLE `properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `commune_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `listing_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` double(8,2) DEFAULT '0.00',
  `price` double(8,2) DEFAULT '0.00',
  `property_size` double(8,2) DEFAULT NULL,
  `floor_number` int(11) DEFAULT NULL,
  `bed_room` int(11) DEFAULT NULL,
  `bath_room` int(11) DEFAULT NULL,
  `has_parking` int(11) DEFAULT NULL,
  `front_refer_to` int(11) DEFAULT NULL COMMENT '1 = west, 2 = east, ...',
  `latitude` double(8,2) DEFAULT NULL,
  `longitude` double(8,2) DEFAULT NULL,
  `display_on_maps` tinyint(1) DEFAULT NULL,
  `year_of_renovation` int(11) DEFAULT NULL,
  `year_of_construction` int(11) DEFAULT NULL,
  `built_up_surface` double(8,2) DEFAULT NULL,
  `habitable_surface` double(8,2) DEFAULT NULL,
  `ground_surface` double(8,2) DEFAULT NULL,
  `has_swimming_pool` tinyint(1) DEFAULT NULL,
  `has_elevator` tinyint(1) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `has_basement` tinyint(1) DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `properties_user_id_foreign` (`user_id`),
  KEY `properties_type_id_foreign` (`type_id`),
  CONSTRAINT `properties_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`),
  CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `properties` (`id`, `owner_id`, `province_id`, `district_id`, `commune_id`, `village_id`, `code`, `listing_type`, `cost`, `price`, `property_size`, `floor_number`, `bed_room`, `bath_room`, `has_parking`, `front_refer_to`, `latitude`, `longitude`, `display_on_maps`, `year_of_renovation`, `year_of_construction`, `built_up_surface`, `habitable_surface`, `ground_surface`, `has_swimming_pool`, `has_elevator`, `address`, `has_basement`, `thumbnail`, `status`, `is_published`, `data`, `created_by`, `updated_by`, `user_id`, `type_id`, `created_at`, `updated_at`) VALUES
(42,	NULL,	NULL,	NULL,	NULL,	NULL,	'EQCBF6665435',	'sale',	20000.00,	140.00,	0.00,	11,	1,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	1.00,	1.00,	1.00,	1,	1,	NULL,	1,	NULL,	0,	NULL,	NULL,	1,	NULL,	1,	NULL,	'2019-07-23 13:57:41',	'2019-07-23 13:57:41'),
(43,	NULL,	NULL,	NULL,	NULL,	NULL,	'EQCBF6665435',	'sale',	20000.00,	140.00,	0.00,	11,	1,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	1.00,	1.00,	1.00,	1,	1,	NULL,	1,	NULL,	0,	NULL,	NULL,	1,	NULL,	1,	NULL,	'2019-07-23 14:05:23',	'2019-07-23 14:05:23'),
(44,	NULL,	NULL,	NULL,	NULL,	NULL,	'EQCBFTZPryt',	'sale',	20000.00,	140.00,	0.00,	2,	4,	3,	NULL,	NULL,	NULL,	NULL,	1,	2000,	2500,	23.00,	34.00,	23.00,	1,	1,	NULL,	1,	'1564078222.jpg',	0,	NULL,	NULL,	1,	NULL,	1,	NULL,	'2019-07-25 18:10:23',	'2019-07-25 18:10:23'),
(45,	NULL,	NULL,	NULL,	NULL,	NULL,	'EQCBFTZPrytadgh',	'sale',	20000.00,	140.00,	0.00,	2,	4,	3,	NULL,	NULL,	NULL,	NULL,	0,	2000,	2500,	23.00,	34.00,	23.00,	1,	1,	NULL,	1,	'1564078357.jpg',	0,	NULL,	NULL,	1,	NULL,	1,	NULL,	'2019-07-25 18:12:37',	'2019-07-25 18:12:37'),
(46,	NULL,	NULL,	NULL,	NULL,	NULL,	'EQCBFT111',	'sale',	20000.00,	140.00,	0.00,	2,	4,	3,	NULL,	NULL,	NULL,	NULL,	1,	2000,	2500,	23.00,	34.00,	23.00,	1,	1,	NULL,	1,	'1564078476.jpg',	0,	NULL,	NULL,	1,	NULL,	1,	NULL,	'2019-07-25 18:14:36',	'2019-07-25 18:14:36');

DROP TABLE IF EXISTS `property_office`;
CREATE TABLE `property_office` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `office_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `property_staff`;
CREATE TABLE `property_staff` (
  `property_id` int(10) unsigned DEFAULT NULL,
  `staff_id` int(10) unsigned DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  KEY `property_staff_property_id_foreign` (`property_id`),
  KEY `property_staff_staff_id_foreign` (`staff_id`),
  CONSTRAINT `property_staff_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  CONSTRAINT `property_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `property_translations`;
CREATE TABLE `property_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(10) unsigned NOT NULL,
  `locale` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `property_translations_property_id_locale_unique` (`property_id`,`locale`),
  KEY `property_translations_locale_index` (`locale`),
  CONSTRAINT `property_translations_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `provinces`;
CREATE TABLE `provinces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `province_translations`;
CREATE TABLE `province_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` int(10) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `province_translations_province_id_foreign` (`province_id`),
  CONSTRAINT `province_translations_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `staffs`;
CREATE TABLE `staffs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `office_id` int(10) unsigned DEFAULT NULL,
  `id_card` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staffs_user_id_foreign` (`user_id`),
  CONSTRAINT `staffs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `staff_translations`;
CREATE TABLE `staff_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `locale` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_translations_staff_id_locale_unique` (`staff_id`,`locale`),
  KEY `staff_translations_locale_index` (`locale`),
  CONSTRAINT `staff_translations_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `type_translations`;
CREATE TABLE `type_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(10) unsigned NOT NULL,
  `locale` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_translations_type_id_locale_unique` (`type_id`,`locale`),
  KEY `type_translations_locale_index` (`locale`),
  CONSTRAINT `type_translations_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(350) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `villages`;
CREATE TABLE `villages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commune_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `village_translations`;
CREATE TABLE `village_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `village_id` int(10) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `village_translations_village_id_foreign` (`village_id`),
  CONSTRAINT `village_translations_village_id_foreign` FOREIGN KEY (`village_id`) REFERENCES `villages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `visits`;
CREATE TABLE `visits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `updated_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `contract_id` int(10) unsigned DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `visit` datetime DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_contract_id_foreign` (`contract_id`),
  KEY `visits_property_id_foreign` (`property_id`),
  KEY `visits_user_id_foreign` (`user_id`),
  CONSTRAINT `visits_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `visits_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  CONSTRAINT `visits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2019-07-25 18:18:36