<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 18/12/15
 * Time: 10:38
 */

namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;


class CustomSerializer extends ArraySerializer
{
    /**
     * 重新封装Dingo API返回的data，加入status_code和message
     *
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return [
            'msg' => '操作成功',
            'code' => 200,
            'data' => $data
        ];
    }

    public function item($resourceKey, array $data)
    {
        return [
            'msg' => '操作成功',
            'code' => 200,
            'data' => $data
        ];
    }
}
