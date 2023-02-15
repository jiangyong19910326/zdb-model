<?php

namespace Base\Models;

class BarcodePool extends Model {
	protected $table = "barcode_pools";
	protected $guarded = [];
	protected $primaryKey = 'uuid';
	public $timestamps = false;
	public function express() {
		return $this->hasOne('Base\Models\Express', 'barcode', 'uuid');
	}
}
