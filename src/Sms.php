<?php

namespace Base\Models;
use Illuminate\Database\Capsule\Manager as DB;

class Sms extends Model {
	protected $table = 'laravel_sms';

	public $guarded = [];

	public static function send_tpl($express, $driver, $tpl, $add = NULL) {
		try {
			// \Log::info('try sms');
			\Toplan\PhpSms\Sms::config(config('sms.config'));
			$cansend = true;
			switch ($tpl) {
			case 'takeover_to_customer':
				$to = $express->rec_mobile;
				$cargo = ($express->cargo == null or $express->cargo == '其他') ? '商品' : $express->cargo;
				$content = "【叮咚传送】您好，您预定的 " . $cargo . " 将由叮咚传送员 " . $driver->name . " 派送，请保持手机畅通，有关配送的相关事宜，请及时联系传送员 " . $driver->mobile . "，接收时请开箱验货以确认货品完整。";
				break;
			case 'takeover_to_shop':
				$cansend = !!$express->is_sms;

				$to = $express->send_mobile ?? '';
				$url = 'https://ddchuansong.com/' . $express->ddid;
				$content = "【叮咚传送】您好，您的订单 " . $express->number . " 由叮咚传送员 " . $driver->name . " " . $driver->mobile . " 进行派送，有关派送的事宜请及时联系，可点击 " . $url . " 查看运送状态。";
				break;
			case '60_to_driver':
				$to = $driver->mobile;
				$m = $add !== null ? $add : '*';
				$content = "【叮咚传送】传送员 " . $driver->name . "，您正在派送中的订单收货人 " . $express->rec_name . " 电话 " . $express->rec_mobile . " 地址 " . $express->rec_address . "，派送时间剩余 " . $m . " 分钟，请及时与收货人联系，告知送达时间。 ";
				break;
			case 'timeout_to_driver':
				$to = $driver->mobile;
				$m = $add !== null ? $add : '*';
				$content = "【叮咚传送】您派送至地址 " . $express->rec_address . " 的订单已超时 " . $m . " 分钟，请立即与收货人联系，如情况特殊请及时联系商家并向区域负责人报备。";
				break;
			case 'done_to_customer':
				$to = $express->rec_mobile;
				$cargo = ($express->cargo == null or $express->cargo == '其他') ? '商品' : $express->cargo;
				$content = "【叮咚传送】您好，您预定的 " . $cargo . " 已送达并确认完好，如有后续问题请及时联系叮咚传送员 " . $driver->name . " 电话 " . $driver->mobile . "。";
				\Toplan\PhpSms\Sms::config(config('sms.extconfig'));
				$smscontent = '【叮咚传送】购物后还在刷物流信息？叮咚3小时解除您焦虑(^o^)微信《搜索小程序》“叮咚传送”，体验五环内25元/单（不分远近只收25元）五环至六环35元/单！首次充值100元，享受认证商户惊喜价！邀请好友感受更大惊喜！更多惊喜尽在《微信小程序》“叮咚传送”！回T退订';
				$result = \Toplan\PhpSms\Sms::make()->to($to)->content($smscontent)->send();
				// \Log::info($result);
				break;
			case 'done_to_shop':
				if ($express->shop and $express->shop->sms == false) {
					$cansend = false;
				}
				$to = $express->shop ? $express->shop->sendmobile : '';
				$content = "【叮咚传送】您好，您的订单“电话 " . $express->rec_mobile . "，地址 " . $express->rec_address . "”已由传送员 " . $driver->name . " " . $driver->mobile . " 送达。";
				break;
			case 'url_to_customer':
				if ($express->ddid) {
					$to = $express->rec_mobile;
					$send_name = $express->send_name ? $express->send_name : ($express->shop ? $express->shop->shopname : '商户');
					$url = 'https://ddchuansong.com/' . $express->ddid;
					// $content = "【叮咚传送】您在 ".$shopname." 预定的商品正在由叮咚传送员 ".$driver->name." 派送，可点击 ".$url." 查看运送状态。";
					$content = "【叮咚传送】您有一票来自<" . $send_name . ">的快件正在派送，可点击 " . $url . " 查看运送状态。";
				} else {
					$to = "";
				}
				break;
			default:
				$to = "";
				$content = "";
				break;
			}

			$now = \Carbon\Carbon::now();
			// \Log::info($cansend);
			if ($now->hour >= 9 and $now->hour < 21 and $express->delivery_at->format('Y-m-d') == $now->format('Y-m-d') and $to != "" and $cansend) {
				// 30分钟是否已经发送过短信
				$check30 = \Base\Models\Sms::select(DB::raw('*,ROUND(TIME_TO_SEC(TIMEDIFF("' . $now . '",created_at))/60) as minute'))
					->where('to', $to)
					->havingRaw('minute <= 30')
					->first();
				if ($check30) {
					return false;
				}

				$result = \Toplan\PhpSms\Sms::make()->to($to)->content($content)->send();
				$success = $result['success'] ?? false;
				if ($success) {
					$res = true;
				} else {
					$res = false;
				}
				return $res;
			} else {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}

	}
}
