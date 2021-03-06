<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', ['as' => 'home', 'middleware' => 'env.ready', 'uses' => 'HomeController@index']);
    Route::get('/previous', ['as' => 'previous', 'middleware' => 'env.ready', 'uses' => 'HomeController@previous']);

    Route::get('/how-it-works', ['as' => 'how', 'middleware' => 'env.ready', 'uses' => 'HomeController@how']);
    Route::get('/press', ['as' => 'press', 'middleware' => 'env.ready', 'uses' => 'HomeController@press']);
    Route::get('/terms-of-use', ['as' => 'terms', 'middleware' => 'env.ready', 'uses' => 'HomeController@terms']);
    Route::get('/privacy-policy', ['as' => 'privacy', 'middleware' => 'env.ready', 'uses' => 'HomeController@privacy']);

    /*
    |--------------------------------------------------------------------------
    | Posts
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'post', 'as' => 'post::', 'middleware' => 'env.ready'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'PostController@index']);
        Route::get('/{id}', ['as' => 'detail', 'uses' => 'PostController@detail']);
    });

    /*
    |--------------------------------------------------------------------------
    | Previous projects
    |--------------------------------------------------------------------------
    */

    Route::get('/previous', ['as' => 'previous', 'middleware' => 'env.ready', 'uses' => 'HomeController@showPrevious']);

    /*
    |--------------------------------------------------------------------------
    | Backing
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'donate', 'as' => 'donate::', 'middleware' => 'env.ready'], function () {

        Route::get('/', [
            'as' => 'start',
            'uses' => 'DonationController@newDonation'
        ]);
        Route::post('/details', [
            'as' => 'details',
            'uses' => 'DonationController@continueDonation'
        ]);
        Route::post('/details/confirm', [
            'as' => 'confirm',
            'uses' => 'DonationController@confirmDonation',
        ]);
        Route::get('/confirm/{code}/{email}', [
            'as' => 'emailConfirm',
            'uses' => 'DonationController@emailConfirmation',
        ]);

        // Payment status page (Mollie redirects to this)
        Route::get('/details/{donation_id}/payment_complete', [
            'as' => 'payment_complete',
            'uses' => 'DonationController@paymentComplete',
        ]);

        // Payment status page (if case payment is cancelled, or not done yet)
        Route::get('/details/{donation_id}/payment_status', [
            'as' => 'payment_status',
            'uses' => 'DonationController@paymentStatus',
        ]);

        // Donation information page
        Route::get('/info/{code}/{email}', [
            'as' => 'info',
            'uses' => 'DonationController@donationInfoPage',
        ]);

    });

    /*
    |--------------------------------------------------------------------------
    | Setup routes
    |--------------------------------------------------------------------------
    | Routes for the application setup (on the first go).
    |
    */

    Route::group(['prefix' => 'setup', 'as' => 'setup::', 'middleware' => 'setup.restricted'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'SetupController@index']);
        Route::get('/{id}', ['as' => 'step', 'uses' => 'SetupController@showStep']);
        Route::post('/{id}', ['as' => 'handleStep', 'uses' => 'SetupController@handleStep']);
    });

    /*
    |--------------------------------------------------------------------------
    | Administrator routes
    |--------------------------------------------------------------------------
    |
    */

    // Login does not require auth middleware
    Route::get(
        '/admin/login',
        ['as' => 'admin::login', 'middleware' => 'env.ready', 'uses' => 'AdminAuthController@login']
    );
    Route::post(
        '/admin/login',
        ['as' => 'admin::login', 'middleware' => 'env.ready', 'uses' => 'AdminAuthController@doLogin']
    );

    // All other admin routes require admin middleware
    Route::group(
        [
            'prefix' => 'admin',
            'as' => 'admin::',
            'middleware' => ['auth', 'env.ready'],
        ],
        function () {
            // Dashboard
            Route::get('/', ['as' => 'index', 'uses' => 'AdminController@dashboard']);

            // Password reset
            Route::get('/password', ['as' => 'password', 'uses' => 'AdminController@password']);
            Route::post('/password', ['as' => 'password', 'uses' => 'AdminController@updatePassword']);

            // Project
            Route::get('/project', ['as' => 'project', 'uses' => 'AdminController@project']);
            Route::post('/project', ['as' => 'project', 'uses' => 'AdminController@updateProject']);

            // Organisation
            Route::get('/organisation', ['as' => 'organisation', 'uses' => 'AdminController@organisation']);
            Route::post('/organisation', ['as' => 'organisation', 'uses' => 'AdminController@updateOrganisation']);

            // Platform
            Route::get('/platform', ['as' => 'platform', 'uses' => 'AdminController@platform']);
            Route::post('/platform', ['as' => 'platform', 'uses' => 'AdminController@updatePlatform']);

            // Tiers
            Route::get('/tiers', ['as' => 'tiers', 'uses' => 'AdminTierController@index']);
            Route::get('/tiers/create', ['as' => 'createTier', 'uses' => 'AdminTierController@create']);
            Route::post('/tiers/create', ['as' => 'storeTier', 'uses' => 'AdminTierController@store']);
            Route::get('/tiers/{id}', ['as' => 'editTier', 'uses' => 'AdminTierController@edit']);
            Route::post('/tiers/{id}', ['as' => 'updateTier', 'uses' => 'AdminTierController@update']);
            Route::delete('/tiers/{id}', ['as' => 'deleteTier', 'uses' => 'AdminTierController@delete']);

            // Posts
            Route::get('/posts', ['as' => 'posts', 'uses' => 'AdminPostController@index']);
            Route::get('/posts/create', ['as' => 'createPost', 'uses' => 'AdminPostController@create']);
            Route::post('/posts/create', ['as' => 'storePost', 'uses' => 'AdminPostController@store']);
            Route::get('/posts/{id}', ['as' => 'editPost', 'uses' => 'AdminPostController@edit']);
            Route::post('/posts/{id}', ['as' => 'updatePost', 'uses' => 'AdminPostController@update']);
            Route::delete('/posts/{id}', ['as' => 'deletePost', 'uses' => 'AdminPostController@delete']);

            // Pages
            Route::get('/pages/edit/{slug}', ['as' => 'editPage', 'uses' => 'AdminPageController@edit']);
            Route::post('/pages/edit/{slug}', ['as' => 'updatePage', 'uses' => 'AdminPageController@update']);

            // Email
            Route::get('/email', ['as' => 'email', 'uses' => 'AdminController@email']);
            Route::post('/email', ['as' => 'email', 'uses' => 'AdminController@updateEmail']);

            // Goals
            Route::get('/goals', ['as' => 'goals', 'uses' => 'AdminGoalController@index']);
            Route::get('/goals/{kind}', ['as' => 'goalsDetail', 'uses' => 'AdminGoalController@kind']);

            // Weights
            Route::get('/weights', ['as' => 'goalsWeight', 'uses' => 'AdminGoalController@weights']);
            Route::post('/weights', ['as' => 'goalsWeight', 'uses' => 'AdminGoalController@saveWeights']);

            // Currency goal
            Route::get('/currency', ['as' => 'goalsCurrency', 'uses' => 'AdminGoalController@currency']);
            Route::post('/currency', ['as' => 'goalsCurrency', 'uses' => 'AdminGoalController@updateCurrency']);

            // Assets
            Route::get('/assets', ['as' => 'assets', 'uses' => 'AdminController@assets']);
            Route::get('/assets/{filename}/delete', ['as' => 'deleteAsset', 'uses' => 'AdminController@deleteAsset']);

            // Donations
            Route::get('/donations', ['as' => 'donations', 'uses' => 'AdminController@donations']);
            Route::get('/donations/{id}', ['as' => 'donations::detail', 'uses' => 'AdminController@donationDetail']);
            Route::get('/donations/delete/{id}', ['as' => 'donations::delete', 'uses' => 'AdminController@deleteDonation']);
            Route::get('/donations/undelete/{id}', ['as' => 'donations::undelete', 'uses' => 'AdminController@undeleteDonation']);


            // Create a new goal type
            Route::get(
                '/goals/{kind}/new',
                ['as' => 'goalsTypeCreate', 'uses' => 'AdminGoalController@createType']
            );
            Route::post(
                '/goals/{kind}/new',
                ['as' => 'goalsTypeCreate', 'uses' => 'AdminGoalController@storeType']
            );

            // Edit an existing goal type
            Route::get(
                '/goals/{kind}/{id}/edit',
                ['as' => 'goalsTypeEdit', 'uses' => 'AdminGoalController@editType']
            );
            Route::post(
                '/goals/{kind}/{id}/edit',
                ['as' => 'goalsTypeEdit', 'uses' => 'AdminGoalController@updateType']
            );

            // Delete an existing goal type
            Route::delete(
                '/goals/{kind}/{id}/delete',
                ['as' => 'goalsTypeDelete', 'uses' => 'AdminGoalController@deleteType']
            );

            Route::get(
                '/socialmedia',
                ['as' => 'social', 'uses' => 'AdminController@social']
            );
            Route::post(
                '/socialmedia',
                ['as' => 'social', 'uses' => 'AdminController@updateSocial']
            );

            // Export users/tiers list
            Route::get(
                '/export/users',
                ['as' => 'userExport', 'uses' => 'AdminController@exportUsers']
            );
            Route::get(
                '/export/tiers',
                ['as' => 'userExportTiers', 'uses' => 'AdminController@exportUsersPerTier']
            );

            Route::get(
                '/previous',
                ['as' => 'previous', 'uses' => 'AdminPreviousProjectsController@index']
            );

            Route::get(
                '/previous/import',
                ['as' => 'importProject', 'uses' => 'AdminPreviousProjectsController@showImportForm']
            );

            Route::post(
                '/previous/import',
                ['as' => 'importProject', 'uses' => 'AdminPreviousProjectsController@doImport']
            );

            Route::get(
                '/previous/delete/{id}',
                ['as' => 'previousDelete', 'uses' => 'AdminPreviousProjectsController@delete']
            );
        }
    );

});

/*
|--------------------------------------------------------------------------
| Simple drag and drop upload
|--------------------------------------------------------------------------
|
*/

Route::post(
    'inline-attach',
    [
        'uses' => 'UploadController@inlineAttach',
        'as' => 'postAttachment'
    ]
);

Route::get(
    'details.json',
    [
        'uses' => 'AdminController@getJson',
        'as' => 'detailjson',
    ]
);

/*
|--------------------------------------------------------------------------
| Mollie payment hook
|--------------------------------------------------------------------------
*/

Route::post(
    '/{donation_id}/validate_payment',
    [
        'uses' => 'DonationController@paymentWebhook',
        'as' => 'payment_webhook',
    ]
);
