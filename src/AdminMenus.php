<?php

namespace Base\Models;

class AdminMenus extends Model {
	protected $table = "admin_menus";

	protected $guarded = [];

	public function parent() {
		return $this->BelongsTo('Base\Models\AdminMenus', 'parent_id');
	}
}
