<?php

namespace Base\Models;

class AdminRoleUser extends Model {
	protected $table = "admin_role_user";

	protected $guarded = [];

	public function admin() {
		return $this->BelongsTo('Base\Models\Admin');
	}
}
