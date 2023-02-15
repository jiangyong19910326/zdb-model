<?php

namespace Base\Models;

class AdminMenu extends Model {
	protected $table = "admin_menu";

	protected $guarded = [];

	public function admin() {
		return $this->BelongsTo('Base\Models\Admin');
	}
	public function admin_menu() {
		return $this->BelongsTo('Base\Models\AdminMenus');
	}
}
