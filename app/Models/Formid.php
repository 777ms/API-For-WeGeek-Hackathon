<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/16
 * Time: 上午11:05
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formid extends Model
{
    protected $table = 'formid';

    protected $fillable = [
        'formid', 'openid'
    ];
}