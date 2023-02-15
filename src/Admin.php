<?php

namespace Base\Models;

class Admin extends Model {
	// use SoftDeletes;

	/*
		     * Role profile to get value from ntrust config file.
	*/
	protected $table = 'admins';
	protected static $roleProfile = 'user';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $guarded = [];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	public function roles() {
		return $this->belongsToMany('Base\Models\AdminRole', 'admin_role_user', 'admin_id', 'admin_role_id');
	}
	public function hasRole($role) {
		$rolesArray = $this->roles()->pluck('name')->toArray();
		// var_dump($rolesArray);
		if (is_string($role)) {
			return in_array($role, $rolesArray);
		} else {
			return array_intersect($role, $rolesArray);
		}
	}
	public function addressbooks() {
		return $this->hasMany('Base\Models\AddressBook');
	}
	public function area() {
		return $this->hasOne('Base\Models\Area');
	}
	public function areas() {
		return $this->belongsToMany('Base\Models\Area');
	}

	public function sendPasswordResetNotification($token) {
		$this->notify(new \App\Notifications\MyResetPassword($token));
	}
	public function driverAllLocations() {
		return $this->hasMany('Base\Models\Location')->orderBy('id', 'DESC');
	}

	public function driverLocations() {
		return $this->hasMany('Base\Models\Location')->whereNotNull('formatted_address')->orderBy('id', 'DESC');
	}

	public function driverlastLocations() {
		return $this->driverLocations()->first();
	}
	public function messages() {
		return $this->hasMany('Base\Models\AdminMessage');
	}
	public function menu() {
		return $this->belongsToMany('Base\Models\AdminMenus', 'admin_menu', 'admin_id', 'admin_menu_id');
	}
}
