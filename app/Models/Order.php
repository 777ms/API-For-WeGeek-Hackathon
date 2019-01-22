<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 下午3:05
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
      'buyer', 'seller', 'order_num', 'order_price', 'order_name', 'num', 'order_time','status',
        'buyer_name', 'buyer_address', 'buyer_phone'

    ];
}