<?php

namespace Base\Models;

use Base\Models\Express;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
	use SoftDeletes;

	/*
		     * Role profile to get value from ntrust config file.
	*/
	protected $table = 'users';
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
		'api_key', 'api_secret', 'password', 'remember_token',
	];
	public function roles() {
		return $this->belongsToMany('Base\Models\Role', 'role_user', 'user_id', 'role_id');
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
	public function expresses() {
		return $this->hasMany('Base\Models\Express');
	}
	public function account() {
		return $this->BelongsTo('Base\Models\Account');
	}
	public function shop() {
		return $this->BelongsTo('Base\Models\Account', 'account_id', 'id');
	}

	public function driverRoutes() {
		return $this->hasMany('Base\Models\ExpressRoute');
	}

	public function driverExps() {
		$expArray = $this->driverRoutes()->pluck('express_id')->toArray();
		return Express::whereIn('id', $expArray);
	}

	public function driverIngExps() {
		$expArray = $this->driverRoutes()->whereNull('routeend')->pluck('express_id')->toArray();
		return Express::whereIn('id', $expArray);
	}
	// 发件历史，这里有司机代发的情况
	public function send_exps() {
		return $this->hasMany('Base\Models\Express', 'user_id', 'id');
	}
	public function addressbooks() {
		return $this->hasMany('Base\Models\AddressBook');
	}
	public function addressbook() {
		return $this->hasOne('Base\Models\AddressBook')->where('is_default', 1);
	}
	public function messages() {
		return $this->hasMany('Base\Models\UserMessage');
	}
	public function stat() {
		return $this->hasMany('Base\Models\StatUser');
	}
	public function expsCount() {
		return $this->hasOne('Base\Models\Express')
			->selectRaw('user_id, count(user_id) as aggregate')
			->groupBy('user_id');

	}
	public function invites() {
		return $this->hasMany('Base\Models\InviteHistory');
	}
}
