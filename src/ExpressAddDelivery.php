<?php
namespace Base\Models;

class ExpressAddDelivery extends Model {
	protected $guarded = [];

	protected $table = 'express_add_deliveries';

	public function express() {
		return $this->belongsTo('\Base\Models\Express');
	}
}