<?php
namespace Base\Models;

class ExpressGuoan extends Model {
	protected $table = 'express_guoan';
	protected $guarded = [];

	public function express() {
		return $this->belongsTo('Base\Models\Express');
	}
}