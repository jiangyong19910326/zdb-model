<?php
namespace Base\Models;

class InviteHistory extends Model {
	// use Notifiable;
	protected $table = "invite_histories";
	protected $guarded = [];
	public function user() {
		return $this->belongsTo('Base\Models\User', 'user_id');
	}
	public function invited_user() {
		return $this->belongsTo('Base\Models\User', 'invited_user_id');
	}
	public function stat() {
		return $this->hasMany('Base\Models\StatUser', 'user_id', 'invited_user_id');
	}
}