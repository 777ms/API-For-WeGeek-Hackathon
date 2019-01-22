<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 上午11:58
 */

namespace App\Http\Controllers\Api;

use App\Models\Production;
use App\Serializer\CustomSerializer;
use App\Transformers\ProductionTransformer;
use Illuminate\Http\Request;

class ProductionsController extends Controller
{
    public function index(Production $production,Request $request)
    {
        $uuid = $request->uuid;
        $openid = $request->openid;

        // 根据是否有 uuid 来判断是否添加这条数据
        $haveOrNot = Production::where('uuid',$uuid)->first();
        // 为空则说明当前商品未被绑定
        if (empty($haveOrNot)) {
            return response()->json([
                'code' => 200,
                'data' => [
                    'operation' => 'add',
                    'productInfo' => [],
                ]
            ]);
        }
        // 不为空再去验证当前请求用户是否有修改权限
        else {
            $canUpdate = $haveOrNot['user_openid'];
            if ($canUpdate == $openid) {
                // 商品归属者，可以修改当前商品
                return response()->json([
                    'code' => 200,
                    'data' => [
                        'operation' => 'update',
                        'productInfo' => $haveOrNot,
                    ]
                ]);

            }
            else {
                // 说明为买家，不能修改商品详情
                return response()->json([
                    'code' => 200,
                    'data' => [
                        'operation' => 'none',
                        'productInfo' => $haveOrNot,
                    ]
                ]);
            }
        }

    }
    public function store(Production $production, Request $request)
    {
        $production->fill($request->all());
        $production->save();

        return $this->response->item($production, new ProductionTransformer(), function ($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }

    public function update(Request $request)
    {
        $production = Production::find($request->production);
        $production->update($request->all());

        return $this->response->item($production, new ProductionTransformer(), function ($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }

    public function userIndex(Request $request, Production $production)
    {
        $openid = $_GET['openid'];
        $re = $production->query()->where('user_openid',$openid)->get();

        return $this->response->collection($re, new ProductionTransformer(), function ($resources, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }

    public function destroy(Request $request, Production $production)
    {
        $production = Production::find($request->production);
        $production->delete();

        return response()->json([
            'code' => 204,
            'msg' => '删除成功',
        ]);
    }
}