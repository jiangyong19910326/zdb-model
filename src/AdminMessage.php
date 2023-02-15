<?php
namespace Base\Models;

class AdminMessage extends Model {
	protected $table = "admin_messages";
	protected $guarded = [];
	public function admin() {
		return $this->BelongsTo('Base\Models\Admin');
	}
}
