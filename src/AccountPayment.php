<?php
namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPayment extends Model {
	use SoftDeletes;
	protected $table = "account_payments";
	protected $guarded = [];
	public function shop() {
		return $this->BelongsTo('Base\Models\Account', 'account_id');
	}
	public function user() {
		return $this->BelongsTo('Base\Models\User');
	}
	public function invoice() {
		return $this->belongsTo('Base\Models\Invoice');
	}
// CREATE TABLE `account_payments` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户ID',
	//   `account_id` int(10) unsigned NOT NULL COMMENT '账户ID',
	//   `mini2_prepayid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '商户小程序的预支付编号',
	//   `payment_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单支付编号，每次不一样',
	//   `amount` decimal(18,2) DEFAULT NULL COMMENT '金额，单位元',
	//   `channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '支付手段',
	//   `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '支付标题',
	//   `detail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '支付描述',
	//   `paid_at` datetime DEFAULT NULL COMMENT '支付时间',
	//   `state` int(11) DEFAULT NULL COMMENT '支付状态',
	//   `callback` text COLLATE utf8_unicode_ci COMMENT '回调信息',
	//   `created_at` timestamp NULL DEFAULT NULL,
	//   `updated_at` timestamp NULL DEFAULT NULL,
	//   `deleted_at` timestamp NULL DEFAULT NULL,
	//   PRIMARY KEY (`id`),
	//   UNIQUE KEY `account_payments_payment_no_unique` (`payment_no`),
	//   KEY `account_payments_user_id_account_id_channel_index` (`user_id`,`account_id`,`channel`)
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
}
