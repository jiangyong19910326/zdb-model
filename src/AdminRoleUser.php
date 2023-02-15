<?php

namespace Base\Models;

class AdminRoleMenu extends Model {
	protected $table = "admin_role_menu";

	protected $guarded = [];

	public function admin_role() {
		return $this->BelongsTo('Base\Models\AdminRole');
	}
	public function admin_menu() {
		return $this->BelongsTo('Base\Models\AdminMenus');
	}
}
