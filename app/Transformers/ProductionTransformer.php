<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 下午2:19
 */
namespace App\Transformers;

use App\Models\Production;
use League\Fractal\TransformerAbstract;

class ProductionTransformer extends TransformerAbstract
{
    public function transform(Production $production)
    {
        return [
            'id' => $production->id,
            'name' => $production->name,
            'price' => intval($production->price),
            'introduction' =>$production->introduction,
            'screen_size' => $production->screen_size,
            'screen_resolution' => $production->screen_resolution,
            'operation' => $production->operation,
            'space' => $production->space,
            'uuid' => $production->uuid,
            'user_openid' => $production->user_openid,
            'created_at' => $production->created_at->toDateTimeString(),
            'updated_at' => $production->updated_at->toDateTimeString(),
        ];
    }
}