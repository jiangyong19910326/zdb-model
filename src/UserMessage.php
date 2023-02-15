<?php
namespace Base\Models;

class UserMessage extends Model {
	protected $table = "user_messages";
	protected $guarded = [];
	public function user() {
		return $this->BelongsTo('Base\Models\User');
	}
}
