<?php

namespace Base\Models;

class AdminRole extends Model {
	protected $table = "admin_roles";

	protected $guarded = [];

	public function admins() {
		return $this->belongsToMany('Base\Models\Admin', 'admin_role_user');
	}
	public function menu() {
		return $this->belongsToMany('Base\Models\AdminMenus', 'admin_role_menu', 'admin_role_id', 'admin_menu_id');
	}
	public function scopeByRole($query, $roleName) {
		$users = $query->where('name', $roleName)->with('admins')->first();
		if ($users && $users->admins) {
			return $users->admins;
		} else {
			return null;
		}
	}
}
