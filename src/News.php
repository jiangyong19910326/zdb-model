<?php

namespace Base\Models;

class News extends Model {
	// use SoftDeletes;

	/*
		     * Role profile to get value from ntrust config file.
	*/

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $guarded = [];

	protected $dates = [
		'created_at',
		'updated_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	];

	public function city() {
		return $this->belongsTo('Base\Models\City','code','city_code');
	}
}
