<?php
namespace Base\Models;

class ExpressAddPickup extends Model {
	protected $guarded = [];

	protected $table = 'express_add_pickups';

	public function express() {
		return $this->belongsTo('\Base\Models\Express');
	}
}
