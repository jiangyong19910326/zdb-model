<?php

namespace Base\Models;

class Account extends Model {
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

	public function sendPasswordResetNotification($token) {
		$this->notify(new \App\Notifications\MyResetPassword($token));
	}

	public function driverRoutes() {
		return $this->hasMany('Base\Models\ExpRoute');
	}

	public function driverExps() {
		$expArray = $this->driverRoutes()->pluck('express_id')->toArray();
		return Express::whereIn('id', $expArray);
	}

	public function driverIngExps() {
		$expArray = $this->driverRoutes()->whereNull('routeend')->pluck('express_id')->toArray();
		return Express::whereIn('id', $expArray);
	}

	//弃用，等待删除
	public function driverExpIDs() {
		$expArray = $this->driverRoutes()->pluck('express_id')->toArray();
		return Express::whereIn('id', $expArray);
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

	public function payment() {
		return $this->hasMany('Base\Models\Payment');
	}

	// 发件历史，这里有司机代发的情况
	public function send_exps() {
		return $this->hasMany('Base\Models\Express', 'user_id', 'id');
	}
	// 送达用户
	public function done_exps() {
		return $this->hasMany('Base\Models\Express', 'exdone_by', 'id');
	}

	public function addressbooks() {
		return $this->hasMany('Base\Models\AddressBook', 'account_id', 'id');
	}
	public function scopeDefaultAddress() {
		return $this->addressbooks->where('is_default', 1);
	}

	public function user() {
		return $this->BelongsTo('Base\Models\User', 'id', 'account_id');
	}

	public function getBalanceAttribute($value) {
		if($this->user and $this->user->is_migrated == 1){
			return '请关注公众号 “大马鹿” 查看';
		}else{
			return $value;
		}
    }
}
