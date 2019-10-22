<?php
use Gloudemans\Shoppingcart\Facades\Cart;
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

//MAIN WEBSITE PAGES
Route::get('/','LandingPageController@index')->name('landingpage');
Route::get('/pages/{page}', 'PagesController@index')->name('page.show');
Route::get('/shop','ShopController@index')->name('shop.index');
Route::get('/shop/{product}','ShopController@show')->name('shop.show');
Route::get('/contact','ContactsController@show')->name('contact.show');
Route::post('/contact/send','ContactsController@send')->name('contact.send');

//CART
//show cart 
Route::get('/cart','CartController@index')->name('cart.index');

//add item to cart
Route::post('/cart','CartController@store')->name('cart.store');

//update item quantity in cart
Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');

//delete item from cart
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');

//emty cart
Route::get('/clearCart', 'CartController@clearCart')->name('cart.clear');

//move items from cart to users wishlist and from wishlist to the cart (authenticated users only) 
Route::middleware('auth')->group(function(){
    Route::post('/moveToCart/{id}', 'CartController@moveToCart')->name('cart.moveToCart');
    Route::post('/moveToWishlist/{rowId}', 'CartController@moveToWishlist')->name('cart.moveToWishlist');
});

 //COUPONS
 Route::post('/coupon', 'CouponsController@store')->name('coupon.store');
 Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');

//CHECKOUT
//show check out page  - apply auth middleware to only allow registered users to access this route
Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
// Checkout as guest route - no auth middleware
Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');

//process order
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');

//display thank you message
Route::get('thankyou', 'ConfirmationController@index')->name('confirmation.index');

//USER AUTHENTICATION

Auth::routes();
//This method allows to logout as user and remain logged in as admin, if logged in as admin
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

//Logged in users account
Route::middleware('auth')->group(function(){
    //user data
    Route::get('/userAccount', 'UsersController@index')->name('userAccount.index');
    Route::get('/userAccount/edit', 'UsersController@edit')->name('userAccount.edit');
    Route::put('/userAccount/update', 'UsersController@update')->name('userAccount.update');

    //user orders
    Route::get('/userAccount/orders', 'OrdersController@index')->name('user.orders');
    Route::get('/userAccount/orders/{order}', 'OrdersController@show')->name('user.showOrder');

    //user product reviews
    Route::get('/userAccount/reviews', 'ReviewsController@index')->name('user.reviews');
    Route::post('/userAccount/reviews/{product}', 'ReviewsController@store')->name('user.reviews.store');
    Route::get('/userAccount/reviews/{review}/product/{product}', 'ReviewsController@edit')->name('user.reviews.edit');
    Route::put('/userAccount/reviews/{review}/product/{product}', 'ReviewsController@update')->name('user.reviews.update');
    Route::delete('/userAccount/reviews/{review}', 'ReviewsController@destroy')->name('user.reviews.delete');

    //users wishlist
    Route::get('/userAccount/wishlist', 'WishlistsController@index')->name('user.wishlist');
    Route::post('/userAccount/wishlist/{product}', 'WishlistsController@add')->name('user.wishlist.add');
    Route::delete('/userAccount/wishlist/{product}', 'WishlistsController@remove')->name('user.wishlist.remove');
    Route::delete('/userAccount/wishlist', 'WishlistsController@clear')->name('user.wishlist.clear');
});

//ADMIN AUTHENTICATION
Route::prefix('admin')->group(function(){
    //Admin login routes
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    //Password reset routes
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');

    //Categories
    Route::get('/categories/list', 'Admin\CategoriesController@categoryList');
    Route::resource('categories','Admin\CategoriesController');

    //Brands
    Route::get('/brands/list', 'Admin\BrandsController@brandList');
    Route::resource('brands','Admin\BrandsController');

    //Products
    Route::get('products/deleted','Admin\ProductsController@deleted')->name('admin.products.deleted');
    Route::get('products/restore/{id}','Admin\ProductsController@restore')->name('admin.product.restore');
    Route::delete('products/finalDelete/{id}','Admin\ProductsController@finalDelete')->name('admin.product.finaldelete');
    Route::get('products/featured/{id}', 'Admin\ProductsController@featured');
    Route::resource('products','Admin\ProductsController');

    //Update product quantity via ajax
    Route::post('/product/updateQuantity/{id}', 'Admin\ProductsController@updateQuantity');

    //Product Images
    Route::delete('/product/deleteimage/{image}', 'Admin\ProductsController@deleteImage');
    Route::post('/product/updateimages', 'Admin\ProductsController@updateImages');
    
    //Discount Coupons
    Route::resource('coupons','Admin\CouponsController');

    //Orders
    Route::get('/orders', 'Admin\OrdersController@index')->name('admin.orders.index');
    Route::get('orders/statuses', 'Admin\OrdersController@orderSatuses');
    Route::get('/orders/{order}', 'Admin\OrdersController@show')->name('admin.orders.show');
    Route::get('/orders/{order}/edit', 'Admin\OrdersController@edit')->name('admin.orders.edit');
    Route::put('/orders/{order}', 'Admin\OrdersController@update')->name('admin.orders.update');

    //Pages
    Route::post('/pages/deletePageImage', 'Admin\PagesController@deletePageImage');
    Route::resource('pages','Admin\PagesController');
    
    //Settings
    Route::get('/settings', 'Admin\SettingsController@edit')->name('admin.settings.edit')->middleware('can:isSuperadmin');
    Route::put('/settings', 'Admin\SettingsController@update')->name('admin.settings.update')->middleware('can:isSuperadmin');

    //Administrators
    Route::resource('administrators','Admin\AdministratorsController')->middleware('can:isSuperadmin');

    //Admin Reviews
    Route::get('reviews/deleted','Admin\ReviewsController@deleted')->name('admin.reviews.deleted');
    Route::get('reviews/restore/{id}','Admin\ReviewsController@restore')->name('admin.review.restore');
    Route::delete('reviews/finalDelete/{id}','Admin\ReviewsController@finalDelete')->name('admin.review.finaldelete');
    Route::delete('/reviews/delete/{id}', 'Admin\ReviewsController@destroy')->name('admin.review.delete');
    Route::get('/reviews', 'Admin\ReviewsController@index')->name('admin.reviews');
    Route::get('/reviews/{id}', 'Admin\ReviewsController@show')->name('admin.reviews.show');
});
