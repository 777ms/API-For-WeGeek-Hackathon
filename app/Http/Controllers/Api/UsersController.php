<?php
/**
 * Created by PhpStorm.
 * User: zs
 * Date: 2018/12/15
 * Time: 上午10:11
 */
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Serializer\CustomSerializer;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Api\WxsController;

class UsersController extends Controller
{
    public function store(Request $request, User $user)
    {
        $code = $request->code;
        // 创建用户，只有一个code。先拿code 去换 openid
        $wxs = new WxsController();
        $openid = $wxs->getAndSaveOpenid($code);
        $re = $user->query()->where('openid',$openid)->get();
        if ($re->toArray()) {
            return $this->response->item($re[0], new UserTransformer(), function ($resource, $fractal) {
                $fractal->setSerializer(new CustomSerializer());
            });
        }
        else {
            $user = User::create([
                'name' => '游客'.time().rand(10,99),
                'identity' => 0,
                'openid' => $openid
            ]);

            return $this->response->item($user, new UserTransformer(), function ($resource, $fractal) {
                $fractal->setSerializer(new CustomSerializer());
            });
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return $this->response->item($user, new UserTransformer(), function ($resource, $fractal) {
            $fractal->setSerializer(new CustomSerializer());
        });
    }


}