<?php

namespace Base\Models;

class AdminArea extends Model {
	protected $table = "admin_area";

	protected $guarded = [];

	public function admin() {
		return $this->BelongsTo('Base\Models\Admin');
	}
	public function area() {
		return $this->BelongsTo('Base\Models\Area');
	}
}
