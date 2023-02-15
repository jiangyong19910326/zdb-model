<?php
namespace Base\Models;

class AdminExpressAlarm extends Model {
	protected $guarded = [];

	protected $table = 'admin_express_alarm';

	public function admin() {
		return $this->belongsTo('\Base\Models\Admin');
	}
	public function alarm_rule() {
		return $this->belongsTo('\Base\Models\ExpressAlarmRules', 'express_alarm_rule_id');
	}
}