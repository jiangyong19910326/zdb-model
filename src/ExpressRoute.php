<?php

namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressRoute extends Model {
	use SoftDeletes;
	protected $table = "express_routes";

	protected $guarded = [];

	protected $dates = ['start_at', 'end_at'];
	protected $casts = [
		'courier_info' => 'array',
	];
	public function toDriver() {
		return $this->hasOne('Base\Models\Driver', 'id', 'to_driver_id')->select('id', 'name', 'mobile', 'is_active', 'is_online', 'push_id', 'last_lng', 'last_lat', 'last_position', 'last_refresh_at');
	}
	public function fromDriver() {
		return $this->hasOne('Base\Models\Driver', 'id', 'from_driver_id')->select('id', 'name', 'mobile', 'is_active', 'is_online', 'push_id', 'last_lng', 'last_lat', 'last_position', 'last_refresh_at');
	}

	public function fromStation() {
		return $this->hasOne('Base\Models\Station', 'id', 'from_station_id')->select('id', 'name', 'lng', 'lat', 'area_code', 'city_code');
	}

	public function toStation() {
		return $this->hasOne('Base\Models\Station', 'id', 'to_station_id')->select('id', 'name', 'lng', 'lat', 'area_code', 'city_code');
	}
	public function fromArea() {
		return $this->belongsTo('Base\Models\Area', 'from_area_code', 'code')->select('id', 'code', 'name');
	}
	public function toArea() {
		return $this->belongsTo('Base\Models\Area', 'to_area_code', 'code')->select('id', 'code', 'name');
	}
	public function express() {
		return $this->belongsTo('Base\Models\Express');
	}
// CREATE TABLE `express_routes` (
	//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	//   `express_id` int(10) unsigned NOT NULL,
	//   `from_driver_id` int(10) unsigned DEFAULT NULL,
	//   `to_driver_id` int(10) unsigned NOT NULL,
	//   `from_area_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '起始区域',
	//   `to_area_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '到达区域',
	//   `station_id` int(11) DEFAULT NULL COMMENT '中转点',
	//   `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '路由名称',
	//   `start_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '路由发生的位置',
	//   `start_at` datetime DEFAULT NULL,
	//   `end_at` datetime DEFAULT NULL COMMENT '结束时间，可以不存',
	//   `op_type` int(11) DEFAULT NULL COMMENT '操作码',
	//   `state` int(11) NOT NULL DEFAULT '0' COMMENT '路由状态',
	//   `time_pressure` decimal(6,2) DEFAULT NULL COMMENT '时间压力',
	//   `created_at` timestamp NULL DEFAULT NULL,
	//   `updated_at` timestamp NULL DEFAULT NULL,
	//   `deleted_at` timestamp NULL DEFAULT NULL,
	//   PRIMARY KEY (`id`),
	//   KEY `express_routes_express_id_foreign` (`express_id`),
	//   CONSTRAINT `express_routes_express_id_foreign` FOREIGN KEY (`express_id`) REFERENCES `expresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

}