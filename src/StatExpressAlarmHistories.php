<?php
namespace Base\Models;

class StatExpressAlarmHistories extends Model {
	protected $guarded = [];

	protected $table = 'stat_express_alarm_histories';

	public function alarm_rule() {
		return $this->belongsTo('\Base\Models\ExpressAlarmRules', 'express_alarm_rule_id');
	}
}
