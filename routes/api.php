<?php

use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CheckOutController;
use App\Http\Controllers\Api\CoveredAreasController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewsController;
use App\Http\Controllers\Api\SubscriptionPackagesController;
use App\Http\Controllers\Api\supplier\EquipmentController;
use App\Http\Controllers\Api\supplier\PortfolioController;
use App\Http\Controllers\Api\UserSubscriptionsController;
use App\Http\Controllers\Api\supplier\ServiceController;
use App\Http\Controllers\Api\WithdrawsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('api')->as('api.')->group(function () {
    Route::as('auth.')->group(function () {
        Route::post('register', [UsersController::class, 'register'])->name('register');
        Route::post('login', [UsersController::class, 'login'])->name('login');
        Route::post('forgot-password', [UsersController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('reset-password', [UsersController::class, 'resetPassword'])->name('reset-password');
        Route::post('logout', [UsersController::class, 'logout'])->name('logout');
        route::post('/city/area/submit', [IndexController::class, 'userArea'])->name('city.area.submit');

        Route::middleware(['jwt.verify'])->group(function () {
            Route::post('verify-email', [UsersController::class, 'verifyEmail'])->name('verify-email');
            Route::get('city-areas', [CoveredAreasController::class, 'cityAreas'])->name('city-areas');
            route::get('/covered-areas/{id}', [CoveredAreasController::class, 'deleteCoveredArea'])->name('covered.areas.delete');
            Route::post('submit-areas', [CoveredAreasController::class, 'submitCoveredAreas'])->name('submit-areas');
            Route::get('resend-verification-code', [UsersController::class, 'resendVerificationCode'])->name('resend-verification-code');
            Route::post('change-password', [UsersController::class, 'changePassword'])->name('change-password');
            Route::get('profile/data', [UsersController::class, 'editProfile'])->name('get.profile');
            Route::post('update/profile', [UsersController::class, 'updateProfile'])->name('update.profile');

            Route::get('subscription/packages', [SubscriptionPackagesController::class, 'index'])->name('subscription-package');
            Route::get('subscription/payment', [UserSubscriptionsController::class, 'paymentResponse'])->name('subscription.payment-response');
            // get featured packages 
            Route::get('/subscription-featured-packages', [SubscriptionPackagesController::class, 'getFeatured'])->name('featured-packages.index');
            Route::get('active-featured-packages', [SubscriptionPackagesController::class, 'getActiveFeaturedPackages'])->name('active-featured-packages.index');
            // service management
            route::get('/service/all', [ServiceController::class, 'all'])->name('service.all');
            Route::post('service-save', [ServiceController::class, 'save'])->name('service.save');
            Route::get('subcategories', [ServiceController::class, 'getSubcategories'])->name('subcategories');
            route::get('/service-edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
            route::get('/service-delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
            //equipment mangement
            route::get('/equipment/all', [EquipmentController::class, 'all'])->name('equipment.all');
            Route::post('equipment-save', [EquipmentController::class, 'save'])->name('equipment.save');
            route::get('/equipment-edit/{id}', [EquipmentController::class, 'edit'])->name('equipment.edit');
            route::get('/equipment-delete/{id}', [EquipmentController::class, 'delete'])->name('equipment.delete');
            //project mangement
            route::get('/portfolio/all', [PortfolioController::class, 'all'])->name('portfolio.all');
            Route::post('portfolio-save', [PortfolioController::class, 'save'])->name('portfolio.save');
            route::get('/portfolio-edit/{id}', [PortfolioController::class, 'edit'])->name('portfolio.edit');
            route::get('/portfolio-delete/{id}', [PortfolioController::class, 'delete'])->name('portfolio.delete');
            //address management
            route::get('addresses', [AddressController::class, 'index'])->name('address.index');
            route::post('add-address', [AddressController::class, 'store'])->name('address.store');
            route::get('city/{id}', [AddressController::class, 'city'])->name('city');
            route::post('make-default', [AddressController::class, 'makeDefault'])->name('address.make-default');
            route::get('delete-address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
            route::get('edit-address/{id}', [AddressController::class, 'edit'])->name('address.index');

            route::get('getaddresses', [AddressController::class, 'getAddresses'])->name('address.index');


            Route::get('delete/profile', [UsersController::class, 'destroy'])->name('delete.profile');

            // route::get('/address/all', [AddressController::class, 'all'])->name('address.all');
            // route::post('/address-save', [AddressController::class, 'save'])->name('address.save');
            // route::get('/address-edit/{id}', [AddressController::class, 'edit'])->name('address.edit');
            // route::get('/address-delete/{id}', [AddressController::class, 'delete'])->name('address.delete');
            // route::post('/make-default', [AddressController::class, 'makeDefault'])->name('address.delete');
            //order
            route::get('/equipments/{id}', [IndexController::class, 'getEquipments'])->name('service.equipments');
            Route::post('add-cart', [CartController::class, 'save'])->name('add.cart');
            Route::post('cart-data', [CartController::class, 'cartData'])->name('cart.data');
            Route::get('checkout', [CheckOutController::class, 'index'])->name('cart.checkout');
            Route::post('check-out', [CheckOutController::class, 'save'])->name('checkout.cart');
            //Quotation Management
            route::get('/quotations/{status?}', [OrderController::class, 'quotationIndex'])->name('quotations.index');
            route::get('/quotation/{id}/detail', [OrderController::class, 'quotationDetail'])->name('quotation.detail');
            route::post('order-visited', [OrderController::class, 'visit'])->name('quotation.visit');
            route::post('order-rejected', [OrderController::class, 'reject'])->name('quotation.reject');
            route::post('order-quoted', [OrderController::class, 'quote'])->name('quotation.quote');
            Route::get('service-checkout/{id}', [OrderController::class, 'checkoutContent'])->name('service.checkout');

            //Manage Orders
            route::get('/orders/{status?}', [OrderController::class, 'ordersIndex'])->name('orders.index');
            route::get('/order/{id}/detail', [OrderController::class, 'orderDetail'])->name('order.detail');
            route::post('order-cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
            route::post('order/in-progress', [OrderController::class, 'inProgress'])->name('order.in-progress');
            route::post('order-complete', [OrderController::class, 'complete'])->name('order.complete');

            Route::get('print/invoice/{id}', [OrderController::class, 'printInvoice'])->name('quotation.invoice');
            Route::get('send/invoice/{id}', [OrderController::class, 'sendInvoice'])->name('send.invoice');

            Route::get('notifications', [NotificationController::class, 'notifications'])->name('notification.all');
            Route::get('notifications-count', [NotificationController::class, 'notificationCount'])->name('notification.count');
            Route::get('notification-seen', [NotificationController::class, 'isSeen'])->name('notification.seen');
            Route::get('notification-view/{notificationId}', [NotificationController::class, 'isViewed'])->name('notification.viewed');
            Route::post('notification-delete', [NotificationController::class, 'deleteNotification'])->name('notification.delete');

            Route::get('set/user/settings', [IndexController::class, 'setUserSettings'])->name('set.user.settings');
            //reviews
            Route::post('review/save', [ReviewsController::class, 'save'])->name('reviews.save');

            /*Chat Controller*/
            Route::get('conversations', [ChatController::class, 'getConversations'])->name('chat.get-conversations');
            Route::post('messages', [ChatController::class, 'getMessages'])->name('chat.get-messages');
            Route::post('start-conversation', [ChatController::class, 'startConversation'])->name('chat.start-conversation');
            Route::post('send-message', [ChatController::class, 'sendMessage'])->name('chat.message-send');
            Route::get('delete-message/{id}', [ChatController::class, 'deleteMessage'])->name('chat.message-delete');
            Route::get('delete-conversation/{id}', [ChatController::class, 'conversationDelete'])->name('chat.message-conversation');
            Route::get('delete-all-conversation', [ChatController::class,'deleteAll'])->name('all.conversation');
            //payment profile
            route::get('payment-profile', [WithdrawsController::class, 'paymentProfile'])->name('updatePaymentProfile');
            route::post('updatePaymentProfile', [WithdrawsController::class, 'updatePaymentProfile'])->name('updatePaymentProfile');
            route::post('withdrawPayment', [WithdrawsController::class, 'withdrawPayment'])->name('withdrawPayment');
             // coupon
            route::post('/add/coupon', [IndexController::class, 'couponValidate']);
            route::get('remove-coupon',[CheckoutController::class, 'removeCoupon'])->name('checkout.remove.coupon');
   
      
        

        });
    });
    Route::get('/langauges',  [IndexController::class, 'getLangauges'])->name('langauges');
    Route::get('/areas/{id}',  [IndexController::class, 'getAreas'])->name('get.areas');
    Route::get('/pages/{slug}', [IndexController::class, 'pages'])->name('pages');
    Route::get('/articles', [IndexController::class, 'articles'])->name('articles');
    Route::get('article/{slug}', [IndexController::class, 'articleDetail'])->name('article.detail');
    Route::get('/faqs', [IndexController::class, 'faqs'])->name('faqs');
    Route::get('gallery', [IndexController::class, 'gallery'])->name('gallery');
    Route::post('contact-us', [IndexController::class, 'contactEmail'])->name('contactUs.email');
    Route::get('sub-categories/{id}', [CategoriesController::class, 'subCategories'])->name('sub-categories');
    Route::get('get-sub-categories/{id}', [CategoriesController::class, 'getSubCategories'])->name('get-sub-categories');
    Route::get('suppliers', [IndexController::class, 'suppliers'])->name('suppliers');
    Route::get('services', [IndexController::class, 'services'])->name('services');
    Route::get('reviews', [ReviewsController::class, 'index'])->name('reviews');

    Route::get('service-services', [IndexController::class, 'services'])->name('featured.services');

    Route::get('mission-vision', [IndexController::class, 'missionandvision'])->name('mission-vision');

    Route::middleware(['jwt.verify'])->group(function () {
        Route::get('supplier/detail/{id}', [IndexController::class, 'supplierDetail'])->name('supplier-detail');
        Route::get('service/{slug}/detail', [IndexController::class, 'serviceDetail'])->name('service.detail');
    });
    Route::post('portfolio', [IndexController::class, 'supplierPortfolio'])->name('supplier-portfolio');
    Route::get('project-detail/{id}', [IndexController::class, 'projectDetail'])->name('project-detail');

    Route::get('settings', [SettingController::class, 'settings'])->name('settings');
    Route::get('cities', [CitiesController::class, 'cities'])->name('get.cities');
    Route::get('categories', [CategoriesController::class, 'categories'])->name('get.categories');


    Route::post('remove-image', [IndexController::class, 'removeImage'])->name('remove-image');
    Route::post('upload-image', [IndexController::class, 'uploadImage'])->name('upload-image');
    Route::post('upload-multi-image', [IndexController::class, 'multiImageUpload'])->name('multi.image.uploader');
});
