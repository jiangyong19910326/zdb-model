<?php
namespace Base\Models;

class ExpressInsurance extends Model {
    protected $guarded = [];

    protected $table = 'express_insurances';
    const normalInsuranceRate = 0.004;  //普通产品保率
    const hairyCrabInsuranceRate = 0.002; //大闸蟹保率
    const normalMaxAmount = 5000; //普通产品保价上限
    const hairyCrabMaxAmount = 2000; //大闸蟹产品保价上限

    public function express() {
        return $this->belongsTo('\Base\Models\Express');
    }
    /**
     * @param $pay_amount
     * 默认保价判断
     */
    static public function returnPayAmount($pay_amount)
    {
        if($pay_amount < 1)
        {
            return 1;
        } else {
            return $pay_amount;
        }
    }

    /**
     * @param $express
     * @param $shopModel
     * @param array $insure
     * 生成保单的方法
     */
    static public function createInsure($express, $shopModel, $insure = []) {
        if (isset($insure['is_insure']) && ($insure['is_insure'])) {
            $ei = ExpressInsurance::firstOrCreate(['express_id' => $express->id, 'type' => 'insurance', 'state' => 1]);
            $insure['insurance_rate'] = $insure['insurance_rate'] ?? 0.002;
            $insure['pay_amount'] = $insure['insurance_rate'] * $insure['declared_value'];
            $insure['pay_amount'] = ExpressInsurance::returnPayAmount($insure['pay_amount']);
            // 默认保价成功
            $et = \App\HttpController\Api\ExpressTransaction::payment($express->id, -$insure['pay_amount'], 'insurance', $express->pay_method);
            $insure['express_transaction_id'] = $et->id;
            \App\HttpController\Api\AccountTransaction::payWithExpId($express->id, $shopModel->id, -$insure['pay_amount'], $shopModel->balance, 'insurance');
            $ei->fill($insure);
            $ei->save();
//            $shopModel->balance -= $insure['pay_amount']; //
            $shopModel->save();
        }
    }

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

}
