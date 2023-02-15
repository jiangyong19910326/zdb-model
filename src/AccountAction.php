<?php
namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountAction extends Model {
	use SoftDeletes;
	protected $table = "account_actions";
	protected $guarded = [];
	public function shop() {
		return $this->BelongsTo('Base\Models\Account', 'account_id');
	}
// CREATE TABLE `account_actions` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `account_id` int(10) unsigned NOT NULL COMMENT '账户ID',
	//   `admin_id` int(10) unsigned DEFAULT NULL COMMENT '操作员编号',
	//   `admin_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '操作员姓名',
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
