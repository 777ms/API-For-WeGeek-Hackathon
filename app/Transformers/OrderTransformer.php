<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 下午3:32
 */
namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'buyer' => $order->buyer,
            'buyer_name' => $order->buyer_name,
            'buyer_address' => $order->buyer_address,
            'buyer_phone' => $order->buyer_phone,
            'seller' => $order->seller,
            'order_num' => $order->order_num,
            'order_price' => $order->order_price,
            'order_name' => $order->order_name,
            'num' => intval($order->num),
            'order_time' => $order->order_time,
            'status'=>$order->status,
            'created_at' => $order->created_at->toDateTimeString(),
            'updated_at' => $order->updated_at->toDateTimeString(),
        ];
    }
}