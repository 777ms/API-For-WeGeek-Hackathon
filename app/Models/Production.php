<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 下午12:00
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'picture','number','name', 'price', 'introduction', 'screen_size', 'screen_resolution', 'operation', 'space', 'user_openid', 'uuid'
    ];
}