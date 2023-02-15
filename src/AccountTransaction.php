<?php
namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTransaction extends Model {
	use SoftDeletes;
	protected $table = "account_transactions";
	protected $guarded = [];
	public function shop() {
		return $this->BelongsTo('Base\Models\Account', 'account_id');
	}
	public function user() {
		return $this->BelongsTo('Base\Models\User');
	}

// CREATE TABLE `account_transactions` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `account_id` int(10) unsigned NOT NULL COMMENT '账户ID',
	//   `invoice_id` int(10) unsigned DEFAULT NULL COMMENT '账单编号',
	//   `account_payment_id` int(10) unsigned DEFAULT NULL COMMENT '订单支付',
	//   `account_action_id` int(10) unsigned DEFAULT NULL COMMENT '订单操作编号',
	//   `transaction_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流水编号',
	//   `channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流水渠道',
	//   `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流水类型',
	//   `amount` decimal(18,2) DEFAULT NULL COMMENT '流水金额',
	//   `balance` decimal(18,2) DEFAULT NULL COMMENT '账户余额',
	//   `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
	//   `state` int(11) DEFAULT NULL COMMENT '流水状态',
	//   `created_at` timestamp NULL DEFAULT NULL,
	//   `updated_at` timestamp NULL DEFAULT NULL,
	//   `deleted_at` timestamp NULL DEFAULT NULL,
	//   PRIMARY KEY (`id`)
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
}
