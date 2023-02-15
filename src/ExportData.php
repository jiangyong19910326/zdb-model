<?php
namespace Base\Models;

class ExportData extends Model {
	protected $table = "exportdata";
	protected $guarded = [];
	protected $casts = [
		'options' => 'array',
	];
	public function admin() {
		return $this->BelongsTo('Base\Models\Admin');
	}
}
