<?php
/*
|--------------------------------------------------------------------------
| User Account Section Routes
|--------------------------------------------------------------------------
*/
//USER AUTHENTICATION
Auth::routes();

//LOGGED IN USERS ACCOUNT OPERATIONS
Route::middleware('auth')->prefix('/user')->name('user.')->group(function(){
    //Method allows to logout as user and remain logged in as admin, if logged in as admin
    Route::post('/logout', 'Auth\LoginController@userLogout')->name('logout');

    //User account 
    Route::prefix('/account')->name('account.')->group(function(){
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/edit', 'UsersController@edit')->name('edit');
        Route::put('/update', 'UsersController@update')->name('update');
    });

    //User orders
    Route::prefix('/orders')->name('orders.')->group(function(){
        Route::get('/', 'OrdersController@index')->name('index');
        Route::get('/{order}', 'OrdersController@show')->name('show');
    });

    //User product reviews
    Route::prefix('/reviews')->name('reviews.')->group(function(){
        Route::get('/', 'ReviewsController@index')->name('index');
        Route::post('/{product}', 'ReviewsController@store')->name('store');
        Route::put('/{review}', 'ReviewsController@update')->name('update');
        Route::delete('/{review}', 'ReviewsController@destroy')->name('delete');
    });

    //Users wishlist
    Route::prefix('/wishlist')->name('wishlist.')->group(function(){
        //Show wishlist
        Route::get('/', 'WishlistsController@index')->name('index');
        //Add product to wishlist
        Route::post('/{product}', 'WishlistsController@add')->name('add');
        //Remove product from wishlist
        Route::delete('/{product}', 'WishlistsController@remove')->name('remove');
        //Remove all products from wishlist
        Route::delete('/', 'WishlistsController@clear')->name('clear');
        //Move item from wishlist to cart
        Route::post('/toCart/{id}', 'CartController@moveToCart')->name('moveToCart'); 
        //Move item from cart to wishlist
        Route::post('/fromCart/{rowId}', 'CartController@moveToWishlist')->name('moveFromCart');
    });
});