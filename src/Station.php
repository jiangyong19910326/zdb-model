<?php

namespace Base\Models;

class Station extends Model {

	protected $table = "stations";

	protected $guarded = [];

	public function city() {
		return $this->BelongsTo('Base\Models\City', 'id', 'city_code');
	}
	public function area() {
		return $this->hasMany('Base\Models\Area', 'id', 'area_code');
	}
}