<?php

namespace Base\Models;

class City extends Model {
	protected $table = "cities";

	protected $guarded = [];

	public function stations() {
		return $this->hasMany('Base\Models\Station');
	}

	public function expresses() {
		return $this->hasMany('Base\Models\Express');
	}

	public function shops() {
		return $this->hasMany('Base\Models\Account');
	}

	public function news() {
		return $this->hasMany('Base\Models\News','city_code','code');
	}
}
