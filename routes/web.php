<?php
/*
|--------------------------------------------------------------------------
| Web Routes
| Defines the frontend website routes
| !!! Notice: 
| Routes for admin section and user account section are defined in custom files.
| These additional route files are registered in RouteServiceProvider 
|--------------------------------------------------------------------------
*/

//MAIN WEBSITE PAGES
Route::name('pages.')->group(function(){
    Route::get('/','LandingPageController@index')->name('landing');
    Route::get('/shop','ProductsController@index')->name('shop.index');
    Route::get('/shop/{product}','ProductsController@show')->name('shop.show');
    Route::get('/contact','ContactsController@show')->name('contact');
    Route::post('/contact','ContactsController@send')->name('contact.send');
    Route::get('/page/{slug}', 'PagesController@index')->name('page.show');
});

//CART
Route::prefix('/cart')->name('cart.')->group(function(){
    //show cart
    Route::get('/','CartController@index')->name('index');
    //add item to cart
    Route::post('/','CartController@store')->name('store');
    //update item quantity in cart
    Route::patch('/{product}', 'CartController@update')->name('update');
    //delete item from cart
    Route::delete('/{product}', 'CartController@destroy')->name('destroy');
    //emty cart
    Route::get('/clear', 'CartController@clearCart')->name('clear');
});

//DISCOUNT CODES
Route::prefix('/discount')->name('discountcode.')->group(function(){
    //Add discount code to checkout
    Route::post('/', 'DiscountCodesController@store')->name('store');
    //Remove discount code from checkout
    Route::delete('/', 'DiscountCodesController@destroy')->name('destroy');
});

//CHECKOUT
Route::prefix('/checkout')->name('checkout.')->group(function(){
    //Show check out page  - apply auth middleware to only allow registered users to access this route
    Route::get('/', 'CheckoutController@index')->name('index')->middleware('auth');
    // Checkout as guest route - no auth middleware
    Route::get('/guest', 'CheckoutController@index')->name('guest.index');
    //Process order
    Route::post('/', 'CheckoutController@store')->name('store');
    //Display thank you message
    Route::get('/confirmed/order/{orderNr}', 'CheckoutController@orderConfirmation')->name('confirmation');
    //Display order failure message
    Route::get('/failed/order', 'CheckoutController@orderFailure')->name('failure');
});




