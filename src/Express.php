<?php

namespace Base\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Express extends Model {
    use SoftDeletes;
    // use SoftDeletes;
    /*
             * Role profile to get value from ntrust config file.
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const hairyMaxWeight = 10; //大闸蟹首重
    const hairyweight = 10; //大闸蟹上限重量
    const normalMaxWeight = 10; //其它产品首重
    const maxWeight = 20; //最大重量上限
    const basePrice = 2; //每公斤价格
    const BeijingWeight = 15; //北京首重
    const BeijingPrice = 1; //北京价格
    const BeijingWeightMax = 30;

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'e_receipt' => 'array',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function sendPasswordResetNotification($token) {
        $this->notify(new \App\Notifications\MyResetPassword($token));
    }

    public function shop() {
        return $this->BelongsTo('Base\Models\Account', 'account_id', 'id');
    }
    public function user() {
        return $this->BelongsTo('Base\Models\User');
    }
    public function expressLatest() {
        return $this->hasOne('Base\Models\ExpressRoute')->latest();
    }
    public function expressOneRoute() {
        return $this->hasOne('Base\Models\ExpressRoute');
    }
    public function expressRoutes() {
        return $this->hasMany('Base\Models\ExpressRoute');
    }
    public function expressWithRoutes() {
        return $this->expressRoutes()->select('express_id', 'id', 'name', 'state', 'driver_state', 'method', 'courier_info', 'op_type', 'start_at', 'end_at', 'created_at');
    }
    public function expressWithPayments() {
        return $this->expressTransactions()->select('express_id', 'type', 'channel', 'amount', 'state', 'remark', 'created_at');
    }
    public function expressPayment() {
        return $this->hasOne('Base\Models\ExpressPayment');
    }
    public function expressRoutesWithDriver() {
        return $this->hasMany('Base\Models\ExpressRoute')->with('toDriver', 'fromDriver');
    }
    public function expressRoutesWithArea() {
        return $this->hasMany('Base\Models\ExpressRoute')->with('toDriver', 'fromDriver', 'fromArea', 'toArea');
    }
    public function expressRoutesWithAll() {
        return $this->hasMany('Base\Models\ExpressRoute')->selectRAW('*,(case when op_type = 11 then "取送" when op_type = 12 then "取转" when op_type = 22 then "中转" when op_type = 21 then "派送" end) as op_string')->with('toDriver', 'fromDriver', 'fromStation', 'toStation', 'fromArea', 'toArea');
    }
    public function fromArea() {
        return $this->belongsTo('Base\Models\Area', 'est_send_area', 'code');
    }
    public function toArea() {
        return $this->belongsTo('Base\Models\Area', 'est_rec_area', 'code');
    }
    public function expressTransactions() {
        return $this->hasMany('Base\Models\ExpressTransaction');
    }
    public function expressNopayTransaction() {
        return $this->hasOne('Base\Models\ExpressTransaction')->where('state', 0)->where('type', 'pay');
    }
    public function expressAction() {
        return $this->hasMany('Base\Models\ExpressAction');
    }
    public function expressCancle() {
        return $this->hasOne('Base\Models\ExpressAction')->where('type', 'cancle')->orderBy('id', 'DESC');
    }
    public function product() {
        return $this->BelongsTo('Base\Models\Product', 'product_id')->select("id", "name", "city_code");
    }
    public function add_delivery() {
        return $this->hasOne('Base\Models\ExpressAddDelivery');
    }
    public function add_pickup() {
        return $this->hasOne('Base\Models\ExpressAddPickup');
    }
    public function insuresOne() {
        return $this->hasOne('Base\Models\ExpressInsurance','express_id','id')->select(['id','express_id','is_insure','declared_value','pay_amount']);
    }
    public function insures()
    {
        return $this->hasMany('Base\Models\ExpressInsurance');
    }
    public function coupon() {
        return $this->belongsTo('Base\Models\Coupon','coupon_id','id');
    }

    //订单跟续重的一对一关联
    public function expressTransactionOfWeight()
    {
        return $this->hasOne('Base\Models\ExpressTransaction')->select('amount')->where('channel','shop');
    }

    // 判断大闸蟹和普通产品
    static public function returnInsurance($city_code,$product_id)
    {
        //上海城市code 021 大闸蟹产品4
        if($city_code == '021' && $product_id == 4)
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 商户端续重保价的策略
     */
    static public function returnWeightPrice($weight,$city_code,$product_id,$continuousWeightConfig)
    {
        $price = 0;
        $weight = $weight * 1;
        if($continuousWeightConfig)
        {
            if($city_code == '010')
            {
                $firstWeight = $continuousWeightConfig['firstWeight'] ?? Express::BeijingWeight;
                $weightMax = $continuousWeightConfig['weightMax'] ?? Express::BeijingWeightMax;
                $weightPrice = $continuousWeightConfig['weightPrice'] ?? Express::BeijingPrice;
            } else {
                $firstWeight = $continuousWeightConfig['firstWeight'] ?? Express::hairyMaxWeight;
                $weightMax = $continuousWeightConfig['firstWeight'] ?? Express::maxWeight;
                $weightPrice = $continuousWeightConfig['weightPrice'] ?? Express::basePrice;
            }
        }
        //上海的续重价格策略
        if (Express::returnInsurance($city_code, $product_id)) {
            //大闸蟹的续重价格
            if ($weight > Express::hairyMaxWeight && $weight <= Express::hairyweight) {
                $price = ($weight - (Express::hairyMaxWeight)) * (Express::basePrice);
            } elseif ($weight > 0 && $weight <= Express::hairyMaxWeight) {
                $price = 0;
            } else {
                return false;
            }
        } elseif ($city_code == '010') {
            if ($weight > $firstWeight && $weight <= $weightMax) {
                $price = ($weight - $firstWeight) * $weightPrice;
            } elseif ($weight > 0 && $weight <= $firstWeight) {
                $price = 0;
            } else {
                return false;
            }
        } else {
            //其它产品的续重价格
            if ($weight > $firstWeight && $weight <= $weightMax) {
                $price = ($weight - $firstWeight) * $weightPrice;
            } elseif ($weight > 0 && $weight <= $firstWeight) {
                $price = 0;
            } else {
                return false;
            }
            return $price;
        }
    }
}
