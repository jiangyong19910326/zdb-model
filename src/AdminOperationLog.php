<?php

namespace Base\Models;

class AdminOperationLog extends Model {
	protected $table = "admin_operation_logs";

	protected $guarded = [];

	public function admin() {
		return $this->BelongsTo('Base\Models\Admin');
	}
}
