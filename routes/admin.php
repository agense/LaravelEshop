<?php
/*
|-----------------------------------------------------------------------------------------------------------
| Admin Section Routes
|-----------------------------------------------------------------------------------------------------------
*/
//ADMIN AUTHENTICATION
Route::prefix('admin')->namespace('Auth\\')->name('admin.')->group(function(){
    //Admin login routes
    Route::get('/login', 'AdminLoginController@showLoginForm')->name('login');
    Route::post('/login', 'AdminLoginController@login')->name('login.submit');
    Route::post('/logout', 'AdminLoginController@logout')->name('logout');

    //Password reset routes
    Route::prefix('password')->name('password.')->group(function(){
        Route::get('/reset', 'AdminForgotPasswordController@showLinkRequestForm')->name('request');
        Route::post('/email', 'AdminForgotPasswordController@sendResetLinkEmail')->name('email');
        Route::get('/reset/{token}', 'AdminResetPasswordController@showResetForm')->name('reset');
        Route::post('/reset', 'AdminResetPasswordController@reset');
    });
});

//ADMIN SECTION ROUTES
Route::middleware('auth:admin')->prefix('admin')->namespace('Admin\\')->name('admin.')->group(function(){
    //Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Categories
    Route::resource('categories','CategoriesController')->except(['create', 'show']);

    //Brands
    Route::resource('brands','BrandsController')->except(['create', 'show']);

    //Products
    Route::prefix('/products')->name('products.')->group(function(){
        Route::get('/deleted','ProductsController@deleted')->name('deleted');
        Route::get('/restore/{id}','ProductsController@restore')->name('restore');
        Route::delete('/finalDelete/{id}','ProductsController@finalDelete')->name('delete.final');
        Route::get('/featured/{id}', 'ProductsController@featured')->name('featured');
        //Update product quantity via ajax
        Route::post('/quantity/update/{id}', 'ProductsController@updateQuantity')->name('quantity');
        //Manage Product Images
        Route::delete('/images/delete/{image}', 'ProductsController@deleteImage')->name('images.delete');
        Route::post('/images/update', 'ProductsController@updateImages')->name('images.update');
    });   
    Route::resource('/products','ProductsController'); 

    //Features
    Route::prefix('/features')->name('features.options.')->group(function(){
        Route::put('/{feature}/options/add', 'FeaturesController@addOption')->name('add');
        Route::delete('/{feature}/options/delete', 'FeaturesController@deleteOption')->name('delete');
    });
    Route::resource('features', 'FeaturesController')->except(['create', 'show']);

    //DiscountCodes
    Route::prefix('/discounts/codes')->name('codes.')->group(function(){
        Route::get('/access/{id}', 'DiscountCodesController@toggeAccess')->name('access');
        Route::get('/expired','DiscountCodesController@expired')->name('expired');
        Route::get('/deactivated','DiscountCodesController@deactivated')->name('deactivated');
        Route::get('/restore/{id}','DiscountCodesController@restore')->name('restore');
        Route::delete('/inactive/delete/{id}','DiscountCodesController@deleteInactive')->name('delete.final');
    });
    Route::resource('/discounts/codes','DiscountCodesController')->except(['create', 'show']);
    
    //Orders
    Route::prefix('/orders')->name('orders.')->group(function(){
        Route::get('/', 'OrdersController@index')->name('index');
        Route::get('/complete', 'OrdersController@completeOrders')->name('complete');
        Route::get('/{order}', 'OrdersController@show')->name('show');
    
        Route::name('process.')->group(function(){
            Route::get('/{order}/process', 'OrderProcessingController@edit')->name('show');
            Route::put('/{order}/status', 'OrderProcessingController@processStatus')->name('status');
            Route::put('/{order}/delivery', 'OrderProcessingController@processDelivery')->name('delivery');
        });
        //Payment Processing via admin
        Route::put('/{order}/payment', 'OrderProcessingController@processPayment')->name('payment');
    });

    //Pages
    Route::post('/pages/deletePageImage', 'PagesController@deletePageImage')->name('images.delete');
    Route::resource('pages','PagesController');
    
    //Settings
    Route::prefix('/settings')->name('settings.')->middleware('can:isSuperadmin')->group(function(){
        Route::get('/', 'SettingsController@edit')->name('edit');
        Route::put('/general', 'SettingsController@updateGeneralSettings')->name('update.general');
        Route::put('/company', 'SettingsController@updateCompanySettings')->name('update.company');
        Route::put('/logo', 'SettingsController@uploadLogo')->name('logo');
        Route::resource('/slides', 'SliderController')->except(['create']);
    });

    //Administrators
    Route::resource('administrators','AdministratorsController')->except(['create', 'show'])->middleware('can:isSuperadmin');

    //Admin Reviews
    Route::prefix('/reviews')->name('reviews.')->group(function(){
        Route::get('/deleted','ReviewsController@deleted')->name('deleted');
        Route::get('/restore/{id}','ReviewsController@restore')->name('restore');
        Route::delete('/finalDelete/{id}','ReviewsController@finalDelete')->name('delete.final');
        Route::delete('/delete/{review}', 'ReviewsController@destroy')->name('delete');
        Route::get('/', 'ReviewsController@index')->name('index');
        Route::get('/{id}', 'ReviewsController@show')->name('show');
    });
});
