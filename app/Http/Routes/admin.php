<?php
$router->group(
    ['prefix' => 'admin'],
    function ($router) {
        $router->group(
            ['middleware' => 'admin.auth'],
            function ($router) {
                $router->any('/', ['as' => 'admin.home', 'uses' => 'Backend\BackendController@getIndex']);
                $router->any('/home', 'Backend\BackendController@getIndex');

                // users
                $router->post(
                    'user/{id}/ajax_field',
                    array (
                        'middleware' => ['ajax'],
                        'as'         => 'admin.user.ajax_field',
                        'uses'       => 'Backend\UserController@ajaxFieldChange',
                    )
                );
                $router->get(
                    'user/new_password/{id}',
                    ['as' => 'admin.user.new_password.get', 'uses' => 'Backend\UserController@getNewPassword']
                );
                $router->post(
                    'user/new_password/{id}',
                    ['as' => 'admin.user.new_password.post', 'uses' => 'Backend\UserController@postNewPassword']
                );
                $router->resource('user', 'Backend\UserController');

                // groups
                $router->resource('group', 'Backend\GroupController');

                // pages
                $router->post(
                    'page/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.page.ajax_field',
                        'uses'       => 'Backend\PageController@ajaxFieldChange',
                    ]
                );
                $router->resource('page', 'Backend\PageController');

                //categories
                $router->post(
                    'category/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.category.ajax_field',
                        'uses'       => 'Backend\CategoryController@ajaxFieldChange',
                    ]
                );
                $router->resource('category', 'Backend\CategoryController');

                //products
                $router->post(
                    'product/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.product.ajax_field',
                        'uses'       => 'Backend\ProductController@ajaxFieldChange',
                    ]
                );
                $router->resource('product', 'Backend\ProductController');

                //orders
                $router->post(
                    'order/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.order.ajax_field',
                        'uses'       => 'Backend\OrderController@ajaxFieldChange',
                    ]
                );
                $router->resource('order', 'Backend\OrderController');

                $router->get('order_find_products','Backend\OrderController@find_products');
                $router->get('add_current_product','Backend\OrderController@add_product');

                //partner
                $router->post(
                    'partner/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.partner.ajax_field',
                        'uses'       => 'Backend\PartnerController@ajaxFieldChange',
                    ]
                );
                $router->resource('partner', 'Backend\PartnerController');

                //done
                $router->post(
                    'done/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.done.ajax_field',
                        'uses'       => 'Backend\DoneController@ajaxFieldChange',
                    ]
                );
                $router->resource('done', 'Backend\DoneController');

                // tag
                $router->post(
                    'tag/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.tag.ajax_field',
                        'uses'       => 'Backend\TagController@ajaxFieldChange',
                    ]
                );
                $router->resource('tag', 'Backend\TagController');

                // news
                $router->post(
                    'news/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.news.ajax_field',
                        'uses'       => 'Backend\NewsController@ajaxFieldChange',
                    ]
                );
                $router->resource('news', 'Backend\NewsController');

                // articles
                /*$router->post(
                    'article/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.article.ajax_field',
                        'uses'       => 'Backend\ArticleController@ajaxFieldChange',
                    ]
                );
                $router->resource(
                    'article',
                    'Backend\ArticleController',
                    ['only' => ['index', 'edit', 'update', 'destroy']]
                );*/

                // comments
                $router->post(
                    'comment/{id}/ajax_field',
                    array (
                        'middleware' => ['ajax'],
                        'as'         => 'admin.comment.ajax_field',
                        'uses'       => 'Backend\CommentController@ajaxFieldChange',
                    )
                );
                $router->resource(
                    'comment',
                    'Backend\CommentController',
                    ['only' => ['index', 'edit', 'update', 'destroy']]
                );

                // questions
                $router->post(
                    'question/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.question.ajax_field',
                        'uses'       => 'Backend\QuestionController@ajaxFieldChange',
                    ]
                );
                $router->resource('question', 'Backend\QuestionController');

                // menus
                $router->post(
                    'menu/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.menu.ajax_field',
                        'uses'       => 'Backend\MenuController@ajaxFieldChange',
                    ]
                );
                $router->resource('menu', 'Backend\MenuController');

                // banners
                $router->post(
                    'banner/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.banner.ajax_field',
                        'uses'       => 'Backend\BannerController@ajaxFieldChange',
                    ]
                );
                $router->resource('banner', 'Backend\BannerController');

                // text_widgets
                $router->post(
                    'text_widget/{id}/ajax_field',
                    [
                        'middleware' => ['ajax'],
                        'as'         => 'admin.text_widget.ajax_field',
                        'uses'       => 'Backend\TextWidgetController@ajaxFieldChange',
                    ]
                );
                $router->resource('text_widget', 'Backend\TextWidgetController');

                // variables
                $router->post(
                    'variable/{id}/ajax_field',
                    array (
                        'middleware' => ['ajax'],
                        'as'         => 'admin.variable.ajax_field',
                        'uses'       => 'Backend\VariableController@ajaxFieldChange',
                    )
                );
                $router->get(
                    'variable/value/index',
                    ['as' => 'admin.variable.value.index', 'uses' => 'Backend\VariableController@indexValues']
                );
                $router->post(
                    'variable/value/update',
                    [
                        'middleware' => ['ajax'],
                        'as' => 'admin.variable.value.update',
                        'uses' => 'Backend\VariableController@updateValue'
                    ]
                );
                $router->resource('variable', 'Backend\VariableController');

                // translations
                $router->get(
                    'translation/{group}',
                    ['as' => 'admin.translation.index', 'uses' => 'Backend\TranslationController@index']
                );
                $router->post(
                    'translation/{group}',
                    ['as' => 'admin.translation.update', 'uses' => 'Backend\TranslationController@update']
                );
            }
        );

        $router->group(
            ['prefix' => 'auth'],
            function ($router) {
                $router->get('login', ['as' => 'admin.login', 'uses' => 'Backend\AuthController@getLogin']);
                $router->post('login', ['as' => 'admin.login.post', 'uses' => 'Backend\AuthController@postLogin']);
                $router->get('logout', ['as' => 'admin.logout', 'uses' => 'Backend\AuthController@getLogout']);
            }
        );
    }
);
