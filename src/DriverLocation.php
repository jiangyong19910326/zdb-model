<?php

namespace Base\Models;

class DriverLocation extends Model {

	protected $table = 'driver_locations';

	protected $guarded = [];

	public function driver() {
		return $this->belongsTo('Base\Models\Driver');
	}

}