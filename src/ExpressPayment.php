<?php
namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressPayment extends Model {
	use SoftDeletes;
	protected $table = "express_payments";
	protected $guarded = [];
	public function express() {
		return $this->belongsTo('Base\Models\Express');
		// , 'express_id', 'id'
	}
	public function driver() {
		return $this->belongsTo('Base\Models\Driver');
		// , 'express_id', 'id'
	}
	public function expressTransaction() {
		return $this->hasOne('Base\Models\ExpressTransaction');
		// , 'id', 'to_station_id'
	}
// CREATE TABLE `express_payments` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
	//   `account_id` int(10) unsigned NOT NULL COMMENT '用户ID',
	//   `express_id` int(10) unsigned NOT NULL COMMENT '订单编号',
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
	//   UNIQUE KEY `express_payments_payment_no_unique` (`payment_no`),
	//   KEY `express_payments_express_id_user_id_account_id_channel_index` (`express_id`,`user_id`,`account_id`,`channel`)
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
}
