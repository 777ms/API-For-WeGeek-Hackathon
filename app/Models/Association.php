<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 上午9:05
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    protected $table = 'association';

    protected $fillable = [
        'openid', 'device_id'
    ];
}

