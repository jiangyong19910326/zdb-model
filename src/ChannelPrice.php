<?php
namespace Base\Models;

class ChannelPrice extends Model {
	protected $table = "channel_prices";
	protected $guarded = [];
	public function productprice() {
		return $this->BelongsTo('Base\Models\ProductPrice', 'product_price_id');
	}
}
