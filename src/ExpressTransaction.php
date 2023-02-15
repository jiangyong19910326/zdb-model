<?php
namespace Base\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressTransaction extends Model {
	use SoftDeletes;
	protected $table = "express_transactions";
	protected $guarded = [];

	public function express() {
		return $this->hasOne('Base\Models\Express', 'id', 'express_id')->with(['shop', 'user']);
	}
	public static function get_unique_no($prefix = '', $length = 20, $channel = '') {
		$shortened = str_limit($prefix . date('ymdHis') . (md5(microtime() . $channel . mt_rand(1, 10000))), $length, '');
		$record = ExpressTransaction::where('transaction_no', '=', $shortened)->first();
		if (!empty($record)) {
			// echo $shortened;
			return static::get_unique_no();
		} else {
			return $shortened;
		}
	}
// CREATE TABLE `express_transactions` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `express_id` int(10) unsigned DEFAULT NULL COMMENT '订单',
	//   `express_payment_id` int(10) unsigned DEFAULT NULL COMMENT '订单支付',
	//   `express_action_id` int(10) unsigned DEFAULT NULL COMMENT '订单操作编号',
	//   `transaction_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流水编号',
	//   `channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流水渠道',
	//   `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流水类型',
	//   `amount` decimal(18,2) DEFAULT NULL COMMENT '流水金额，交易收入或者手续费等等',
	//   `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
	//   `state` int(11) DEFAULT NULL COMMENT '流水状态',
	//   `created_at` timestamp NULL DEFAULT NULL,
	//   `updated_at` timestamp NULL DEFAULT NULL,
	//   `deleted_at` timestamp NULL DEFAULT NULL,
	//   PRIMARY KEY (`id`)
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
}
