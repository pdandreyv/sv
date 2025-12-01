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

Route::group(['middleware' => ['make-statistic', 'get-statistic']], function () {

    foreach (\App\StaticPage::query()->get() as $elem){
        if(strpos($elem->alias,'/')==false)
            Route::get('/'.$elem->alias, [\App\Http\Controllers\PageController::class, 'viewPage']);
    }

    Route::post('send-contact-form', 'ModalController@contactFormPost')->name('send.contact.form');

    Route::get('contact-form', 'ModalController@contactForm')->name('contact.form');

    Route::get('r/{id}', 'ReferalController@index')->name('referal.link');

    Route::get('/', function () {
        return view('welcome');
    });

    // Аутентификация (Laravel 11 controllers)
    Route::get('login', function () { return view('auth.login'); })->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Регистрация
    Route::get('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

    // Сброс пароля
    Route::get('password/reset', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.update');

    // Верификация email: используйте встроенные контроллеры при необходимости

    Route::group(['middleware' => ['get-status']], function () {
        Route::get('profile/show/{id}', 'ProfileController@show')->name('profile.show');
    });
    Route::post('profile/access/{id}', 'ProfileController@access')->name('profile.access');

    Route::group(['middleware' => 'isAdmin'], function () {
        /* users */
    	Route::get('admin', 'admin\HomeController@index')->name('admin.home');
    	Route::get('admin/users', 'admin\UserController@index')->name('admin.users');
        Route::get('admin/users/create', 'admin\UserController@create')->name('admin.users.create');
        Route::post('admin/users/store', 'admin\UserController@store')->name('admin.users.store');
        Route::get('admin/users/update/{id}', 'admin\UserController@updateItem')->name('admin.users.update');
        Route::post('admin/users/update/{id}', 'admin\UserController@updateItemPost')->name('admin.users.update.post');
        Route::get('admin/users/delete/{id}', 'admin\UserController@delete')->name('admin.users.delete');
        Route::post('admin/change_password/{id}', 'admin\UserController@changePassword')->name('admin.users.change.password');
        Route::get('admin/generate-password/{id}', 'admin\UserController@generatePassword')->name('admin.users.generate.password');
        Route::get('admin/users/scan/{id}', 'admin\UserController@getScan')->name('admin.users.scan');

        /*documents_cat*/
        Route::get('admin/documents_cat', 'admin\DocumentCategoryController@index')->name('admin.documents_cat.index');
        Route::get('admin/documents_cat/create', 'admin\DocumentCategoryController@create')->name('admin.documents_cat.create');
        Route::post('admin/documents_cat/store', 'admin\DocumentCategoryController@store')->name('admin.documents_cat.store');
        Route::get('admin/documents_cat/edit/{id}', 'admin\DocumentCategoryController@edit')->name('admin.documents_cat.edit');
        Route::post('admin/documents_cat/update/{id}', 'admin\DocumentCategoryController@update')->name('admin.documents_cat.update');
        Route::get('admin/documents_cat/delete/{id}', 'admin\DocumentCategoryController@delete')->name('admin.documents_cat.delete');
        /*documents*/
        Route::get('admin/documents_cat/documents/{id}', 'admin\DocumentController@documents')->name('admin.documents_cat.documents.index');
        Route::get('admin/documents_cat/documents/create/{id}', 'admin\DocumentController@create')->name('admin.documents_cat.documents.create');
        Route::post('admin/documents_cat/documents/store/{id}', 'admin\DocumentController@store')->name('admin.documents_cat.documents.store');
        Route::get('admin/documents_cat/documents/edit/{id}', 'admin\DocumentController@edit')->name('admin.documents_cat.documents.edit');
        Route::post('admin/documents_cat/documents/update/{id}', 'admin\DocumentController@update')->name('admin.documents_cat.documents.update');
        Route::get('admin/documents_cat/delete/documents/{id}', 'admin\DocumentController@delete')->name('admin.documents_cat.documents.delete');


        /*roles*/
        Route::get('admin/roles', 'Admin\RoleController@index')->name('admin.roles');
        Route::get('admin/roles/create', 'Admin\RoleController@create')->name('admin.roles.create');
        Route::post('admin/roles/store', 'Admin\RoleController@store')->name('admin.roles.store');
        Route::get('admin/roles/update/{id}', 'Admin\RoleController@updateItem')->name('admin.roles.update');
        Route::post('admin/roles/update/{id}', 'Admin\RoleController@updateItemPost')->name('admin.roles.update.post');
        Route::get('admin/roles/delete/{id}', 'Admin\RoleController@delete')->name('admin.roles.delete');

        /*types*/
        Route::get('admin/user-types', 'admin\UserTypeController@index')->name('admin.user-types');
        Route::get('admin/user-types/create', 'admin\UserTypeController@create')->name('admin.user-types.create');
        Route::post('admin/user-types/store', 'admin\UserTypeController@store')->name('admin.user-types.store');
        Route::get('admin/user-types/update/{id}', 'admin\UserTypeController@updateItem')->name('admin.user-types.update');
        Route::post('admin/user-types/update/{id}', 'admin\UserTypeController@updateItemPost')->name('admin.user-types.update.post');
        Route::get('admin/user-types/delete/{id}', 'admin\UserTypeController@delete')->name('admin.user-types.delete');

        /*operations*/
        Route::get('admin/operations', 'Admin\BalanceController@index')->name('admin.operations');
        Route::get('admin/operations/choose-type', 'admin\BalanceController@chooseType')->name('admin.operations.choose-type');
        //Route::post('admin/operations/create', 'Admin\BalanceController@create')->name('admin.operations.create');
        Route::get('admin/operations/create', 'Admin\BalanceController@create')->name('admin.operations.create');
        Route::post('admin/operations/store', 'Admin\BalanceController@store')->name('admin.operations.store');
        Route::get('admin/operations/delete/{id}', 'Admin\BalanceController@delete')->name('admin.operations.delete');

        /* product categories */
        Route::get('admin/product-categories', 'admin\ProductCategoryController@index')->name('admin.product-categories');
        Route::get('admin/product-categories/create', 'admin\ProductCategoryController@create')->name('admin.product-categories.create');
        Route::post('admin/product-categories/store', 'admin\ProductCategoryController@store')->name('admin.product-categories.store');
        Route::get('admin/product-categories/create/child/{id}', 'admin\ProductCategoryController@createChild')->name('admin.product-categories.create-child');
        Route::post('admin/product-categories/store/child', 'admin\ProductCategoryController@storeChild')->name('admin.product-categories.store-child');
        Route::get('admin/product-categories/update/{id}', 'admin\ProductCategoryController@updateItem')->name('admin.product-categories.update');
        Route::post('admin/product-categories/update/{id}', 'admin\ProductCategoryController@updateItemPost')->name('admin.product-categories.update.post');
        Route::get('admin/product-categories/delete/{id}', 'admin\ProductCategoryController@delete')->name('admin.product-categories.delete');
        Route::get('admin/product-categories/childs/{id}/for_service/{for_service}', 'admin\ProductCategoryController@getChilds')->name('admin.products.get-childs');

        /* product controller */
        Route::get('admin/products', 'admin\ProductController@index')->name('admin.products');
        Route::get('admin/products/create', 'admin\ProductController@create')->name('admin.products.create');
        Route::post('admin/products/store', 'admin\ProductController@store')->name('admin.products.store');
        Route::get('admin/products/update/{id}', 'admin\ProductController@updateItem')->name('admin.products.update');
        Route::post('admin/products/update/{id}', 'admin\ProductController@updateItemPost')->name('admin.products.update.post');
        Route::get('admin/products/delete/{id}', 'admin\ProductController@delete')->name('admin.products.delete');

        // admnin posts
        Route::get('admin/posts', 'admin\PostsController@index')->name('admin.posts');
        Route::get('admin/post/edit/{post_id}', 'admin\PostsController@edit')->name('admin.post.edit');
        Route::post('admin/post/edit/{post_id}/update', 'admin\PostsController@update')->name('admin.post.update');
        Route::get('admin/post/edit/{post_id}/delete', 'admin\PostsController@delete')->name('admin.posts.delete');

        // mail-templates
        Route::get('admin/mail-templates', 'admin\MailTemplatesController@index')->name('admin.mail-templates');
        Route::post('admin/mail-templates/store', 'admin\MailTemplatesController@store')->name('admin.mail-templates.store');
        Route::get('admin/mail-templates/create', 'admin\MailTemplatesController@create')->name('admin.mail-templates.create');
        Route::get('admin/mail-templates/update/{id}', 'admin\MailTemplatesController@updateItem')->name('admin.mail-templates.update');
        Route::post('admin/mail-templates/update/{id}', 'admin\MailTemplatesController@updateItemPost')->name('admin.mail-templates.update.post');
        Route::get('admin/mail-templates/delete/{id}', 'admin\MailTemplatesController@delete')->name('admin.mail-templates.delete');

        //mailing
        Route::get('admin/mailing', 'admin\MailingController@index')->name('admin.mailing');
        Route::post('admin/mailing/send', 'admin\MailingController@send')->name('admin.mailing.send');

        /* order statuses */
        Route::get('admin/order-statuses', 'admin\OrderStatusController@index')->name('admin.order-statuses');
        Route::get('admin/order-statuses/create', 'admin\OrderStatusController@create')->name('admin.order-statuses.create');
        Route::post('admin/order-statuses/store', 'admin\OrderStatusController@store')->name('admin.order-statuses.store');
        Route::get('admin/order-statuses/update/{id}', 'admin\OrderStatusController@updateItem')->name('admin.order-statuses.update');
        Route::post('admin/order-statuses/update/{id}', 'admin\OrderStatusController@updateItemPost')->name('admin.order-statuses.update.post');
        Route::get('admin/order-statuses/delete/{id}', 'admin\OrderStatusController@delete')->name('admin.order-statuses.delete');

        /* orders */
        Route::get('admin/orders', 'admin\OrderController@index')->name('admin.orders');
        Route::get('admin/orders/update/{id}', 'admin\OrderController@updateItem')->name('admin.orders.update');
        Route::post('admin/orders/update/{id}', 'admin\OrderController@updateItemPost')->name('admin.orders.update.post');
        Route::get('admin/orders/apply/{id}', 'admin\OrderController@applyOrder')->name('admin.orders.apply');
        Route::get('admin/orders/unapply/{id}', 'admin\OrderController@unapplyOrder')->name('admin.orders.unapply');
        /* order items */
        Route::post('/order-items/remove', 'admin\OrderController@itemRemove')->name('order-items.remove');
        Route::post('/order-items/quantity/update', 'admin\OrderController@itemQuantityUpdate')->name('order-items.quantity.update');
        Route::get('admin/order-items/{orderId}/add-item/{productId}', 'admin\OrderController@itemAdd')->name('admin.order-items.add-item');
        /* order product dropdown */
        Route::get('admin/orders/product-drop-down/{productName}', 'admin\OrderController@productDropDown')->name('admin.order.product.dropdown');
        Route::get('admin/orders/create', 'admin\OrderController@createOrder')->name('admin.orders.create');
        Route::get('admin/orders/user-addresses/{id}', 'admin\OrderController@getUserAddresses')->name('admin.orders.user.addresses');
        Route::post('admin/orders/store', 'admin\OrderController@storeOrder')->name('admin.orders.store');
        Route::get('admin/orders/delete/{id}', 'admin\OrderController@delete')->name('admin.orders.delete');

        // FAQ questions list
        Route::get('admin/faq', 'admin\FaqController@index')
            ->name('admin.faq');
        // FAQ question edit
        Route::get('admin/faq/edit/{faq_id}', 'admin\FaqController@edit')
            ->name('admin.faq.edit');
        // FAQ question save edited
        Route::post('admin/faq/edit/{faq_id}/update', 'admin\FaqController@update')
            ->name('admin.faq.update');
        // FAQ question delete
        Route::get('admin/faq/edit/{faq_id}/delete', 'admin\FaqController@delete')
            ->name('admin.faq.delete');
        // FAQ question add new
        Route::get('admin/faq/add', 'admin\FaqController@add')
            ->name('admin.faq.add');
        // FAQ question save new
        Route::post('admin/faq/create', 'admin\FaqController@create')
            ->name('admin.faq.create');


        Route::get('admin/page', 'admin\PageController@index')
            ->name('admin.page');
        // FAQ question edit
        Route::get('admin/page/edit/{page_id}', 'admin\PageController@edit')
            ->name('admin.page.edit');
        // FAQ question save edited
        Route::post('admin/page/edit/{page_id}/update', 'admin\PageController@update')
            ->name('admin.page.update');
        // FAQ question delete
        Route::get('admin/page/edit/{page_id}/delete', 'admin\PageController@delete')
            ->name('admin.page.delete');
        // FAQ question add new
        Route::get('admin/page/add', 'admin\PageController@add')
            ->name('admin.page.add');
        // FAQ question save new
        Route::post('admin/page/create', 'admin\PageController@create')
            ->name('admin.page.create');


        /* network (ups)*/
        Route::get('admin/network', 'admin\NetworkController@index')->name('admin.network');
        Route::get('admin/network/node/create', 'admin\NetworkController@create')->name('admin.network.node.create');
        Route::get('admin/network/users-drop-down/{userName}/user-type/{userType}', 'admin\NetworkController@usersDropDown')->name('admin.network.users.dropdown');
        Route::get('admin/network/users-find/{userName}/user-type/{userType}', 'admin\NetworkController@usersFind')->name('admin.network.users.find');
        Route::get('admin/network/ups1-get-parent-nodes/{userId}', 'admin\NetworkController@ups1GetParentNodes')->name('admin.network.users.ups1-get-parent-nodes');
        Route::post('admin/network/node/store', 'admin\NetworkController@store')->name('admin.network.node.store');
        /*Route::get('admin/roles/update/{id}', 'Admin\RoleController@updateItem')->name('admin.roles.update');
        Route::post('admin/roles/update/{id}', 'Admin\RoleController@updateItemPost')->name('admin.roles.update.post');*/
        Route::get('admin/network/node/delete/{id}', 'admin\NetworkController@delete')->name('admin.network.node.delete');
        /* funds */
        Route::get('admin/funds', 'admin\FundController@index')->name('admin.funds');

        /*Admin resources*/
        // Resources list
        Route::get('admin/resources', 'admin\ResourcesController@index')
            ->name('admin.resources.index');
        // Resource edit
        Route::get('admin/resources/edit/{id}', 'admin\ResourcesController@edit')
            ->name('admin.resources.edit');
        // Resource save edited
        Route::post('admin/resources/update/{id}', 'admin\ResourcesController@update')
            ->name('admin.resources.update');
        // Resource delete
        Route::get('admin/resources/delete/{id}', 'admin\ResourcesController@delete')
            ->name('admin.resources.delete');
        // Resource add new
        Route::get('admin/resources/add', 'admin\ResourcesController@add')
            ->name('admin.resources.add');
        // Resource save new
        Route::post('admin/resources/create', 'admin\ResourcesController@create')
            ->name('admin.resources.create');
        /*User resources*/
        // Resources list
        Route::post('admin/resources/add-to-user/', 'admin\ResourcesUsersController@index')
            ->name('admin.resources.add-to-user');
        // Resources save ajax
        Route::post('admin/resources/save', 'admin\ResourcesUsersController@save')
            ->name('admin.resources.save');

        /*Admin units*/
        // Units list
        Route::get('admin/units', 'admin\UnitsController@index')
            ->name('admin.units.index');
        // Units edit
        Route::get('admin/units/edit/{id}', 'admin\UnitsController@edit')
            ->name('admin.units.edit');
        // Units save edited
        Route::post('admin/units/update/{id}', 'admin\UnitsController@update')
            ->name('admin.units.update');
        // Units delete
        Route::get('admin/units/delete/{id}', 'admin\UnitsController@delete')
            ->name('admin.units.delete');
        // Units add new
        Route::get('admin/units/add', 'admin\UnitsController@add')
            ->name('admin.units.add');
        // Units save new
        Route::post('admin/units/create', 'admin\UnitsController@create')
            ->name('admin.units.create');

        /* Questionnaire Admin */
        Route::get('admin/questionnaire', 'admin\QuestionnaireController@index')->name('admin.questionnaire.index');
        Route::get('admin/questionnaire/create', 'admin\QuestionnaireController@create')->name('admin.questionnaire.create');
        Route::post('admin/questionnaire/store', 'admin\QuestionnaireController@store')->name('admin.questionnaire.store');
        Route::get('admin/questionnaire/edit/{id}', 'admin\QuestionnaireController@edit')->name('admin.questionnaire.edit');
        Route::post('admin/questionnaire/update/{id}', 'admin\QuestionnaireController@update')->name('admin.questionnaire.update');
        Route::get('admin/questionnaire/delete/{id}', 'admin\QuestionnaireController@delete')->name('admin.questionnaire.delete');

    });

    Route::group(['middleware' => ['get-status']], function () {

        Route::get('goods', 'GoodsController@indexGoods')->name('products.goods');
        Route::get('services', 'GoodsController@indexServices')->name('products.services');
        Route::get('category/{category_id}', 'GoodsController@categoryView')->name('products.category');
        Route::get('product/{product_id}', 'GoodsController@productView')->name('products.product');
        Route::get('/cart/add-cart/product-id/{product_id}/quantity/{quantity}', 'CartController@cartAdd')->name('cart.add');
        Route::get('faq', 'FaqController@index')->name('faq');

        Route::group(['middleware' => ['auth']], function () {
            Route::post('admin/products/ajaxUpload', 'admin\ProductController@ajaxUpload')->name('admin.products.ajax-upload');
            Route::post('admin/products/fileRemove', 'admin\ProductController@fileRemove')->name('admin.products.file-remove');
            Route::post('users/change_password/{id}', 'ProfileController@changePassword')->name('users.change.password');
            Route::get('profile/update/{id}', 'ProfileController@update')->name('profile.update');
            Route::post('profile/update/{id}', 'ProfileController@updatePost')->name('profile.update');
            Route::get('request', 'ProfileController@request')->name('cooperation.request');
            Route::post('request', 'ProfileController@requestPost')->name('cooperation.request');
            Route::get('replanish-balance', 'BalanceController@replenishBalance')->name('replenish.balance');
            Route::get('replanish-balance/back-page/{page}', 'BalanceController@replenishBalance')->name('replenish.balance.back-page');
            Route::post('replanish-balance', 'BalanceController@replanishBalancePost')->name('replenish.balance.post');
            Route::post('replanish-balance-responce', 'BalanceController@replanishBalanceResponce')->name('replenish.balance.responce');

            Route::get('money-transfer', 'BalanceController@moneyTransfer')->name('money.transfer');
            Route::post('money-transfer', 'BalanceController@moneyTransferPost')->name('money.transfer.post');

            Route::get('profile/{id?}', 'ProfileController@my_page')->name('profile.my-page');
            Route::post('profile/{id}', 'PostsController@create')->name('profile.my-page');
            Route::get('post/{post_id}', 'PostsController@view')->name('posts.post');
            Route::get('post/edit/{post_id}', 'PostsController@edit')->name('posts.edit');
            Route::post('post/update/{post_id}', 'PostsController@update')->name('posts.update');
            Route::get('post/edit/{post_id}/delete', 'PostsController@delete')->name('posts.delete');
            Route::get('news', 'PostsController@news')->name('news');
            Route::get('newsAjax/{offset}', 'PostsController@newsAjax')->name('news.ajax');

            /*search*/
            Route::get('search', 'SearchController@index')->name('search');

            /* user dropdown */
            Route::get('user/users-drop-down/{userName}', 'UserController@usersDropDown')->name('messanger.users.dropdown');
            Route::get('user/users-find/{userName}', 'UserController@usersFind')->name('messanger.users.find');

            Route::group(['middleware' => 'is-cooperative'], function () {
                Route::get('users', 'UserController@index')->name('users.list');

                /* Messanger */
                Route::get('messanger/chats', 'MessangerController@chats')->name('messanger.chats.list');
                Route::get('messanger/message/{user_to_id?}', 'MessangerController@newMessage')->name('messanger.message');
                Route::post('messanger/message/store', 'MessangerController@storeMessage')->name('messanger.message.store');
                Route::get('messanger/dialog/{id}', 'MessangerController@showDialog')->name('messanger.dialog');
                Route::get('messanger/dialog/{id}/delete', 'MessangerController@delete')->name('messanger.delete');
                /* chat */
                Route::get('chat/chats', 'ChatController@index')->name('chat.chats.list');
                Route::get('chat/message/{user_to_id?}', 'ChatController@newMessage')->name('chat.message');
                Route::post('chat/message/store', 'ChatController@storeMessage')->name('chat.message.store');
                Route::get('chat/dialog/{id}', 'ChatController@showDialog')->name('chat.dialog');
                Route::post('chat/message/store-answer', 'ChatController@storeAnswerMessage')->name('chat.message.store-answer');
                Route::post('chat/add-members', 'ChatController@addMembers')->name('chat.add-members');
                Route::post('chat/change-name', 'ChatController@changeName')->name('chat.change-name');
                Route::get('chat/message/update/{id}', 'ChatController@updateMessage')->name('chat.message.update');
                Route::get('chat/message/delete/{id}', 'ChatController@deleteMessage')->name('chat.message.delete');
                Route::post('chat/message/update/{id}', 'ChatController@updateMessagePost')->name('chat.message.update.post');
                Route::get('chat/settings', 'ChatController@settings')->name('chat.settings');
                Route::post('chat/settingsStore', 'ChatController@storeSettings')->name('chat.store.settings');

                /* products management */
                Route::get('products', 'ProductController@index')->name('products');
                Route::get('products/create', 'ProductController@create')->name('products.create');
                Route::post('products/store', 'ProductController@store')->name('products.store');
                Route::get('products/update/{id}', 'ProductController@updateItem')->name('products.update');
                Route::post('products/update/{id}', 'ProductController@updateItemPost')->name('products.update.post');
                Route::get('products/delete/{id}', 'ProductController@delete')->name('products.delete');

                /* service management */
                Route::get('service-products', 'ServiceProductController@index')->name('service-products');
                Route::get('service-products/create', 'ServiceProductController@create')->name('service-products.create');
                Route::post('service-products/store', 'ServiceProductController@store')->name('service-products.store');
                Route::get('service-products/update/{id}', 'ServiceProductController@updateItem')->name('service-products.update');
                Route::post('service-products/update/{id}', 'ServiceProductController@updateItemPost')->name('service-products.update.post');
                Route::get('service-products/delete/{id}', 'ServiceProductController@delete')->name('service-products.delete');

                /* cart */
                Route::get('/cart', 'CartController@index')->name('cart');
                Route::post('/cart/remove', 'CartController@remove')->name('cart.remove');
                Route::post('/cart/quantity/update', 'CartController@quantityUpdate')->name('cart.quantity.update');
                Route::get('/cart/check-balance-sum', 'CartController@checkBalanceSum')->name('cart.check.balance.sum');

                /* order */
                Route::get('/order/checkout', 'OrderController@checkout')->name('order.checkout');
                Route::post('/order/place', 'OrderController@placeOrder')->name('order.place');

                /*subscribers*/
                Route::get('subscribe/{id}', 'SubscribeController@subscribe')->name('subscribe');
                Route::get('unsubscribe/{id}', 'SubscribeController@unsubscribe')->name('unsubscribe');

                /*User resources*/
                // Resources list
                Route::get('resources', 'ResourcesUsersController@index')
                    ->name('resources.index');
                // Resources save ajax
                Route::post('resources/save', 'ResourcesUsersController@ajaxResourceCrud')
                    ->name('resources.save');

            });

            /* Questionnaire User - доступно всем аутентифицированным пользователям */
            Route::get('questionnaire', 'QuestionnaireController@index')->name('questionnaire.index');
            Route::post('questionnaire', 'QuestionnaireController@store')->name('questionnaire.store');

            /* API для подкатегорий */
            Route::get('api/categories/{id}/subcategories', 'ProductController@getSubcategories');

            /* Тестовый маршрут для проверки категорий */
            Route::get('test-categories', function() {
                $mainCategories = \App\ProductCategory::whereNull('parent_id')->where('for_service', 0)->get();
                $subcategories = \App\ProductCategory::whereNotNull('parent_id')->where('for_service', 0)->get();
                return response()->json([
                    'main_categories' => $mainCategories,
                    'subcategories' => $subcategories
                ]);
            });

            Route::get('my-network', 'ReferalController@myNetwork')->name('my.network');

        });
    });
});


