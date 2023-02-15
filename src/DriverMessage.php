<?php
namespace Base\Models;

class DriverMessage extends Model {
	protected $table = "driver_messages";
	protected $guarded = [];
	public function driver() {
		return $this->BelongsTo('Base\Models\Driver');
	}
}
