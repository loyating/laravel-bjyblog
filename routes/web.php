<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home 模块
Route::group(['namespace' => 'Home'], function () {
    // 首页
    Route::get('/', 'IndexController@index');
    // 分类
    Route::get('category/{id}', 'IndexController@category');
    // 标签
    Route::get('tag/{id}', 'IndexController@tag');
    // 随言碎语
    Route::get('chat', 'IndexController@chat');
    // 开源项目
    Route::get('git', 'IndexController@git');
    // 文章详情
    Route::get('article/{id}', 'IndexController@article');
    // 文章评论
    Route::post('comment', 'IndexController@comment');
    // 检测是否登录
    Route::get('checkLogin', 'IndexController@checkLogin');
    // 搜索文章
    Route::get('search', 'IndexController@search');
});

// Home模块下 三级模式
Route::group(['namespace' => 'Home', 'prefix' => 'home'], function () {
    // 迁移数据
    Route::group(['prefix' => 'migration'], function () {
        // 从旧系统迁移数据
        Route::get('index', 'MigrationController@index');

        // 只迁移第三方用户和评论数据
        Route::get('oauthUserAndcomment', 'MigrationController@oauthUserAndcomment');
        // 从文件中迁移文章
        Route::get('getDataFromFile', 'MigrationController@getDataFromFile');
    });
});


// auth
Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    // 第三方登录
    Route::group(['prefix' => 'oauth'], function () {
        // 重定向
        Route::get('redirectToProvider/{service}', 'OAuthController@redirectToProvider');
        // 获取用户资料并登录
        Route::get('handleProviderCallback/{service}', 'OAuthController@handleProviderCallback');
        // 退出登录
        Route::get('logout', 'OAuthController@logout');
    });

    // 后台登录
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', 'AdminController@login');
    });
});

// 后台登录页面
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'login'], function () {
        // 登录页面
        Route::get('index', 'LoginController@index');
        // 退出
        Route::get('logout', 'LoginController@logout');
    });

});


// Admin 模块
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin.auth'], function () {
    // 首页控制器
    Route::group(['prefix' => 'index'], function () {
        // 后台首页
        Route::get('index', 'IndexController@index');

    });

    // 文章管理
    Route::group(['prefix' => 'article'], function () {
        // 文章列表
        Route::get('index', 'ArticleController@index');

        // 发布文章
        Route::get('create', 'ArticleController@create');
        Route::post('store', 'ArticleController@store');

        // 编辑文章
        Route::get('edit/{id}', 'ArticleController@edit');
        Route::post('update/{id}', 'ArticleController@update');

        // 上传图片
        Route::post('upload_image', 'ArticleController@upload_image');
    });

    // 评论管理
    Route::group(['prefix' => 'comment'], function () {
        // 评论列表
        Route::get('index', 'CommentController@index');
        // 删除评论
        Route::get('destroy/{id}', 'CommentController@destroy');
    });

    // 管理员
    Route::group(['prefix' => 'user'], function () {
        // 管理员列表
        Route::get('index', 'UserController@index');
        // 编辑管理员
        Route::get('edit/{id}', 'UserController@edit');
        Route::post('update/{id}', 'UserController@update');
    });

    // 第三方用户管理
    Route::group(['prefix' => 'oauthUser'], function () {
        // 用户列表
        Route::get('index', 'OauthUserController@index');
        // 编辑管理员
        Route::get('edit/{id}', 'OauthUserController@edit');
        Route::post('update/{id}', 'OauthUserController@update');
    });

    // 友情链接管理
    Route::group(['prefix' => 'friendshipLink'], function () {
        // 友情链接列表
        Route::get('index', 'FriendshipLinkController@index');
        // 添加友情链接
        Route::get('create', 'FriendshipLinkController@create');
        Route::post('store', 'FriendshipLinkController@store');
        // 编辑友情链接
        Route::get('edit/{id}', 'FriendshipLinkController@edit');
        Route::post('update/{id}', 'FriendshipLinkController@update');
        // 排序
        Route::post('sort', 'FriendshipLinkController@sort');
    });

    // 随言碎语管理
    Route::group(['prefix' => 'chat'], function () {
        // 随言碎语列表
        Route::get('index', 'ChatController@index');
        // 添加随言碎语
        Route::get('create', 'ChatController@create');
        Route::post('store', 'ChatController@store');
        // 编辑随言碎语
        Route::get('edit/{id}', 'ChatController@edit');
        Route::post('update/{id}', 'ChatController@update');
        // 删除随言碎语
        Route::get('destroy/{id}', 'ChatController@destroy');
    });
});

/**
 * 各种钩子
 */
Route::group(['prefix' => 'hook', 'namespace' => 'Hook'], function () {
    // 开源中国
    Route::group(['prefix' => 'oschina'], function () {
        Route::post('push', 'OschinaController@push');
    });
});