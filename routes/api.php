<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 1000,
        'expires' => 1,
    ], function ($api) {
        $api->get('price', 'WxsController@price')
            ->name('api.price.price');

        // 创建用户
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // 修改用户信息
        $api->post('users/{users}', 'UsersController@update')
            ->name('api.users.update');
        // 获取 微信生成的小程序码
        $api->get('wxCode', 'WxsController@index')
            ->name('api.wxCode.index');

        // code 换取 openid
        $api->get('openid', 'WxsController@getAndSaveOpenid')
            ->name('api.openid.getOpenid');

        $api->post('relation', 'WxsController@saveAssociation')
            ->name('api.relation.saveAssociation');

        // 判断是是否要新增商品
        $api->get('productions', 'ProductionsController@index')
            ->name('api.productions.index');
        // 增加商品
        $api->post('productions', 'ProductionsController@store')
            ->name('api.productions.store');
        // 修改商品信息
        $api->post('productions/{production}', 'ProductionsController@update')
            ->name('api.productions.update');
        // 删除商品
        $api->post('delProductions/{production}', 'ProductionsController@destroy')
            ->name('api.delProductions.destroy');

        // 获取属于卖家的商品列表
        $api->get('user/has', 'ProductionsController@userIndex')
            ->name('api.user.userIndex');

        // 增加订单
        $api->post('orders', 'OrdersController@store')
            ->name('api.order.store');

        // 修改订单
        $api->post('orders/{order}', 'OrdersController@update')
            ->name('api.order.update');

        // 买家订单列表
        $api->get('buyer/orderList', 'OrdersController@buyer')
            ->name('api.order.buyer');

        // 卖家发货列表
        $api->get('seller/orderList', 'OrdersController@seller')
            ->name('api.order.seller');

        // 上传图片
        $api->post('upload', 'WxsController@upload')
            ->name('api.upload.upload');

        // 存formid
        $api->post('formid', 'WxsController@formid')
            ->name('api.formid.formid');

        // 发送 服务通知
        $api->post('sendFormid', 'WxsController@sendFormid')
            ->name('api.sendFormid.sendFormid');

    });

});