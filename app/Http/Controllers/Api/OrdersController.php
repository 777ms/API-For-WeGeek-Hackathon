<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 下午3:04
 */

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Serializer\CustomSerializer;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function store(Order $order, Request $request)
    {
//        $request->request->add();
//        $request->merge();
        $order_num = date('YmdHis', time()).rand(10,99);
        $request->request->set('order_num',$order_num);
        $order->fill($request->all());
        $order->save();
        return $this->response->item($order, new OrderTransformer(), function($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }

    public function update(Request $request)
    {
        $order = Order::find($request->order);
        $order->update($request->all());

        return $this->response->item($order, new OrderTransformer(), function($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });

    }

    public function buyer(Order $order,Request $request)
    {
        $openid = $request->openid;
        $re = $order->query()->where('buyer',$openid)->get();

        return $this->response->collection($re, new OrderTransformer(), function($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }


    public function seller(Order $order,Request $request)
    {
        $openid = $request->openid;
        $re = $order->query()->where('seller',$openid)->get();

        return $this->response->collection($re, new OrderTransformer(), function($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }
}