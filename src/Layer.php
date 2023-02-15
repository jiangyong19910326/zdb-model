<?php

namespace Base\Models;

class Layer extends Model {
	protected $table = "layers";

	protected $guarded = [];

	public function city() {
		return $this->belongsTo('Base\Models\City', 'city_code', 'code');
	}
	public function rollback() {
		return $this->hasOne(self::class, 'rollback_layer_id');
	}
}
