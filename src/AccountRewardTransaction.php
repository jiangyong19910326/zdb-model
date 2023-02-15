<?php
namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountRewardTransaction extends Model {
	use SoftDeletes;
	// use Notifiable;
	protected $table = "account_reward_transactions";
	protected $guarded = [];

	public function account() {
		return $this->BelongsTo('Base\Models\Account');
	}
	public function express() {
		return $this->BelongsTo('Base\Models\Express');
	}
	public static function get_unique_no($prefix = '', $length = 16, $channel = '') {
		$shortened = str_limit($prefix . date('Ymd') . (md5(microtime() . $channel . mt_rand(1, 10000))), $length, '');
		$record = self::where('transaction_no', '=', $shortened)->first();
		if (!empty($record)) {
			// echo $shortened;
			return static::get_unique_no();
		} else {
			return $shortened;
		}
	}
}