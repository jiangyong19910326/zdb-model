<?php
namespace Base\Models;

class DriverCheck extends Model {
	protected $table = "driver_checks";
	protected $guarded = [];

// CREATE TABLE `express_actions` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `express_id` int(10) unsigned NOT NULL COMMENT '快件号',
	//   `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户',
	//   `admin_id` int(10) unsigned DEFAULT NULL COMMENT '操作员编号',
	//   `admin_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '操作员姓名',
	//   `state_code` int(11) DEFAULT NULL COMMENT '状态码',
	//   `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '操作类型',
	//   `amount` decimal(18,2) DEFAULT NULL COMMENT '金额，单位元',
	//   `comment` text COLLATE utf8_unicode_ci COMMENT '操作留言',
	//   `state` int(11) DEFAULT NULL COMMENT '操作状态',
	//   `created_at` timestamp NULL DEFAULT NULL,
	//   `updated_at` timestamp NULL DEFAULT NULL,
	//   `deleted_at` timestamp NULL DEFAULT NULL,
	//   PRIMARY KEY (`id`)
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
}
