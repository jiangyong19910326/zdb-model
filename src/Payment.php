<?php

namespace Base\Models;

class Payment extends Model {
	protected $table = 'payments';

	public $guarded = [];

	public function user() {
		return $this->belongsTo('Base\Models\User');
	}

	public function cancleOrder() {

	}

	public function express() {
		return $this->belongsTo('Base\Models\Express', 'order_no', 'number');
	}
}
