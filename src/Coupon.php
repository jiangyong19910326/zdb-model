<?php

namespace Base\Models;

class Coupon extends Model {
	protected $table = "coupons";

	protected $guarded = [];
	public function shop() {
		return $this->BelongsTo('Base\Models\Account', 'account_id');
	}
	public function user() {
		return $this->BelongsTo('Base\Models\User');
	}
	public static function get_unique_no($prefix = '', $length = 8, $channel = '', $strtofunc = false) {
		$shortened = str_limit($prefix . (md5(microtime() . $channel . mt_rand(1, 10000))), $length, '');
		$record = self::where('code', '=', $shortened)->first();
		if (!empty($record)) {
			// echo $shortened;
			return static::get_unique_no();
		} else {
			if ($strtofunc) {
				$shortened = call_user_func($strtofunc, $shortened);
			}
			return $shortened;
		}
	}
}
