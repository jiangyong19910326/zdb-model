<?php
namespace Base\Models;

class Invoice extends Model {
	// use Notifiable;
	protected $table = "invoices";
	protected $guarded = [];

	protected $casts = [
		'file' => 'array',
	];
	public function user() {
		return $this->belongsTo('Base\Models\User');
	}
	public function admin() {
		return $this->belongsTo('Base\Models\Admin');
	}
	public function account() {
		return $this->belongsTo('Base\Models\Account');
	}
	public function account_payments() {
		return $this->hasMany('Base\Models\AccountPayment');
	}
}