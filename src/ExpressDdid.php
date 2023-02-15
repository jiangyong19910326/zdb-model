<?php
namespace Base\Models;

class ExpressDdid extends Model {
	protected $table = "express_ddids";
	protected $guarded = [];
	// protected $casts = [
	// 	'options' => 'array',
	// ];
	public function express() {
		return $this->hasOne('Base\Models\Expresses', 'ddid', 'ddid');
	}
	public static function getDdid($count = 1, $time = 1) {
		$time++;
		if ($time < 4) {
			// 3次机会
			mt_srand();
			$ddids = ExpressDdid::where('is_pre', 0)->where('is_active', 0)->where('ddid', '>', mt_rand(100000, 400000))->limit($count)->pluck('ddid')->toArray();
			$ready = count($ddids);
			if ($ready == $count) {
				return $ddids;
			} else {
				if ($ready == 0) {
					return [];
					// 一个都没有 可以警告了
				} else {
					$r = static::getDdid($ready - $count, $time);
					$ddids = array_unique(array_merge($ddids, $r));
					return $ddids;
				}
			}
		} else {
			// 给出了部分 但是不全 可以考虑额外补充
			$arr = \Base\Models\Express::whereRaw('length(`ddid`) <= 5')->pluck('ddid')->toArray();
			$uniqarr = [];
			while (count($uniqarr) < $count) {
				mt_srand();
				$a = str_pad(mt_rand(1, 99999), 5, 0, STR_PAD_LEFT);
				if (!in_array($a, $arr)) {
					$arr[] = $a;
					$uniqarr[] = $a;
				}
			}
			return $uniqarr;
		}
	}
}
