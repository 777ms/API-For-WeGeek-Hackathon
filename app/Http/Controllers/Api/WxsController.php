<?php

namespace App\Http\Controllers\Api;

use App\Models\Formid;
use App\Models\Production;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Association;

class WxsController extends Controller
{
    private static $appid = 'wx861c9e1042771ddb';
    private static $appsecret = '890d02048f041d283ca8d64332c25b4b';


    public function price(Production $production, Request $request)
    {
        return response()->json([
            'code' => 200,
            'data' => 1231
        ]);
        $uuid = $_GET['uuid'];
        $re = $production->query()->where('uuid',$uuid)->first();
        if ($re) {
            return response()->json([
                'code' => 200,
                'data' => $re,
                'opt' => 0
            ]);
        }
        else {
            return response()->json([
                'code' => 200,
                'data' => $re,
                'opt' => 1
            ]);
        }

    }
    public function getAccessToken()
    {
        $client = new Client();
        $response = $client->get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::$appid.'&secret='.self::$appsecret);
        $callback = json_decode($response->getBody()->getContents());

        $access_token = $callback->access_token;
        return $access_token;
    }
    public function index()
    {
        $uuid = $_GET['uuid'];
        $access_token = self::getAccessToken();
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;
        $data = [
            'body' => json_encode([
                'scene' => "uuid={$uuid}",
            ], JSON_UNESCAPED_UNICODE),
        ];
        $client = new Client();

        $response = $client->post($url, $data);

        $re = $response->getBody()->getContents();

        $ret = file_put_contents('/home/wwwroot/wx/public/'.$uuid.'.jpeg', $re, true);

        if ($ret>0){
            return response()->json([
                'code' => 200,
                'data' => 'http://wx.zsovo.com/'.$uuid.'.jpeg'
            ]);
        }
    }

    public function getAndSaveOpenid($code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.self::$appid.'&secret='.self::$appsecret.'&js_code='.$code.'&grant_type=authorization_code';

        $client = new Client();
        $response = $client->get($url);
        $callback = json_decode($response->getBody()->getContents());
        $openid = '';
        try {
            $openid = $callback->openid;
            return $openid;

        }
        catch (\Exception $e){
            return $this->response->error('code 无效', 500);
        }

    }

    public function upload(Request $request)
    {
        $re = $request->file("picture")->store('public');

        $re = substr($re,7);

        return response()->json([
            'code' => 200,
            'data' => 'https://wx.zsovo.com/storage/'.$re
        ]);
    }

    public function formid(Request $request, Formid $formid)
    {
        $formidStr = $request->formid;
        $openid = $request->openid;
        $formArr = explode(',',$formidStr);
        $count = count($formArr);
        for ($i=0;$i<$count;$i++)
        {
            Formid::create([
                'formid' => $formArr[$i],
                'openid' => $openid,
            ]);
        }

        return response()->json([
            'code' => 200,
            'msg' => '写入 formid 成功',
        ]);
    }

    public function sendFormid(Request $request, Formid $formid)
    {
        $buyerOpenid = $request->buyer;
        $sellerOpenid = $request->seller;
        @$buyerFormid = ($formid->query()->where('openid',$buyerOpenid)->get()->toArray())[0]['formid'];
        @$sellerFormid = ($formid->query()->where('openid',$sellerOpenid)->get()->toArray())[0]['formid'];

        $access_token = self::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token='.$access_token;

        $data = [
            'body' => json_encode([
                'touser' => $sellerOpenid,
                'weapp_template_msg' => [
                    'template_id' => 'emphasis_keyword',
                    'page' => '',
                    'form_id' => $sellerFormid,
                    'data' => [
                        'keyword1' => ['value', 1111],
                        'keyword2' => ['value', 1111],
                        'keyword3' => ['value', 1111],
                        'keyword4' => ['value', 1111],
                        'keyword5' => ['value', 1111],
                        'keyword6' => ['value', 1111],
                    ],
                    'emphasis_keyword' => 2222
                ]
            ], JSON_UNESCAPED_UNICODE),
        ];
        $client = new Client();

        $response = $client->post($url, $data);

        $re = $response->getBody()->getContents();

    }

}
