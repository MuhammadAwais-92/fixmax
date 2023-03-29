<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Front\Auth\ResetPasswordController;
use App\Http\Controllers\Front\Auth\VerifyEmailController;
use App\Http\Controllers\Front\Dashboard\ProfileController;
use App\Http\Controllers\Front\Dashboard\PortfolioController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\Dashboard\ServicesController;
use App\Http\Controllers\Front\Dashboard\EquipmentsController;
use App\Http\Controllers\Front\Auth\LoginController;
use App\Http\Controllers\Front\Auth\RegisterController;
use App\Http\Controllers\Front\Auth\ForgotPasswordController;
use App\Http\Controllers\Front\Auth\SocialLoginController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CategoriesController as FrontCategoriesController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\Front\Dashboard\AddressesController;
use App\Http\Controllers\Front\Dashboard\ChatController;
use App\Http\Controllers\Front\Dashboard\SubscriptionController;
use App\Http\Controllers\Front\Dashboard\UserSubscriptionController;
use App\Http\Controllers\Front\Dashboard\CoveredAreaController;
use App\Http\Controllers\Front\Dashboard\NotificationController;
use App\Http\Controllers\Front\Dashboard\OrdersController;
use App\Http\Controllers\Front\Dashboard\ReviewController;

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

Route::namespace('Front')->as('front.')->group(function () {

    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/404', [IndexController::class, 'error404'])->name('404');
    Route::get('/pages/{slug?}', [IndexController::class, 'pages'])->name('pages');
    Route::get('/articles', [IndexController::class, 'articles'])->name('articles');
    Route::get('article/{slug}', [IndexController::class, 'articleDetail'])->name('article.detail');
    Route::get('/faqs', [IndexController::class, 'faqs'])->name('faqs');
    Route::get('gallery', [IndexController::class, 'gallery'])->name('gallery');
    Route::post('contact-us', [IndexController::class, 'contactEmail'])->name('contactUs.email');
    Route::get('categories', [FrontCategoriesController::class, 'categories'])->name('categories');
    Route::get('sub-categories/{id}', [FrontCategoriesController::class, 'subCategories'])->name('sub-categories');
    Route::get('suppliers', [IndexController::class, 'suppliers'])->name('suppliers');
    Route::get('services', [IndexController::class, 'services'])->name('services');
    Route::get('supplier/detail/{id}', [IndexController::class, 'supplierDetail'])->name('supplier-detail');
    Route::get('project/detail/{id}', [IndexController::class, 'projectDetail'])->name('project-detail');
    Route::get('service-services', [IndexController::class, 'services'])->name('featured.services');
    Route::get('offer-services', [IndexController::class, 'services'])->name('offer.services');
    Route::get('service/{slug}/detail', [IndexController::class, 'serviceDetail'])->name('service.detail');
    Route::get('save-user-data',[IndexController::class, 'SaveUserData'])->name('save.userData');
    Route::get('equipments', [IndexController::class, 'getEquipments'])->name('get.equipments');
    Route::post('save-area', [IndexController::class, 'SaveArea'])->name('area.save');
    route::group(['middleware' => ['auth', 'email_verified']], function () {
        Route::post('add-cart',[CartController::class, 'save'])->name('add.cart');
        Route::post('check-out',[CheckOutController::class, 'save'])->name('checkout.cart');
        Route::get('checkout',[CheckOutController::class, 'index'])->name('cart.checkout');
        Route::get('addresses/{id}',[CheckOutController::class, 'getAddresses'])->name('cart.addresses');
        Route::post('get-adddress',[CheckOutController::class, 'getAddressAjax'])->name('cart.address.ajax');
        Route::post('save-adddress',[CheckOutController::class, 'saveAddress'])->name('cart.save.address');
        route::post('/user/coupon', [IndexController::class, 'couponValidate'])->name('user.coupon');
        route::get('remove-coupon',[CheckoutController::class, 'removeCoupon'])->name('remove.coupon');

    });


    Route::namespace('Auth')->as('auth.')->group(function () {
        route::get('/registration', [RegisterController::class, 'showRegistrationPage'])->name('registration');
        route::get('/register/{type}', [RegisterController::class, 'showRegistrationForm'])->name('register.form');

        route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        route::post('/login', [LoginController::class, 'login'])->name('login.submit');
        route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
        route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/redirect/{service}', [SocialLoginController::class, 'redirect'])->name('login.social');
        Route::get('/callback/{service}', [SocialLoginController::class, 'callback'])->name('login.social.callback');

        route::get('/covered-areas', [CoveredAreaController::class, 'coveredAreasForm'])->name('covered.areas');
        route::post('/covered-areas', [CoveredAreaController::class, 'submitCoveredAreas'])->name('covered.areas');
        route::get('delete/covered-areas/{id}', [CoveredAreaController::class, 'deleteCoveredArea'])->name('covered.areas.delete');

        route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password');
        route::post('/forgot-password-resend', [ForgotPasswordController::class, 'forgotPasswordResend'])->name('forgot-password.code.resend');
        route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password.submit');

        route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('show.reset.form');
        route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset.submit');



        Route::middleware(['check_covered_area'])->group(function () {
        route::get('/verification', [VerifyEmailController::class, 'emailVerificationForm'])->name('verification');
        route::get('/verification-resend', [VerifyEmailController::class, 'emailVerificationResend'])->name('verification.code.resend');
        route::post('/verification', [VerifyEmailController::class, 'emailVerificationPost'])->name('verification.submit');
        });
    });

    Route::namespace('Dashboard')->as('dashboard.')->prefix('dashboard')->middleware(['auth','check_covered_area', 'email_verified'])->group(function () {
        Route::middleware(['check_subscription'])->group(function () {
            route::get('/', [ProfileController::class, 'index'])->name('index');
            route::get('/edit/profile', [ProfileController::class, 'edit'])->name('edit.profile');
            route::post('/update/profile', [ProfileController::class, 'update'])->name('update.profile');
            route::get('/edit/password', [ProfileController::class, 'editPassword'])->name('edit.password');
            route::post('/update/password', [ProfileController::class, 'updatePassword'])->name('update.password');
        });
        // Manage Services
        route::get('/services/all', [ServicesController::class, 'index'])->name('services.index');
        route::get('/services/create', [ServicesController::class, 'create'])->name('service.create');
        route::post('/services/save/{id}', [ServicesController::class, 'save'])->name('service.save');
        route::get('/service-edit/{id}', [ServicesController::class, 'edit'])->name('service.edit');
        route::get('/service-delete/{id}', [ServicesController::class, 'delete'])->name('service.delete');

        //Fetured Services list
        route::get('featured/services/all', [ServicEquipmentsControlleresController::class, 'featuredServices'])->name('services.featured.index');
        //Manage Equipment
        route::get('/equipments/all', [EquipmentsController::class, 'index'])->name('equipments.index');
        route::get('/equipments/create', [EquipmentsController::class, 'create'])->name('equipment.create');
        route::post('/equipments/save/{id}', [EquipmentsController::class, 'save'])->name('equipment.save');
        route::get('/equipment-edit/{id}', [EquipmentsController::class, 'edit'])->name('equipment.edit');
        route::get('/equipment-delete/{id}', [EquipmentsController::class, 'delete'])->name('equipment.delete');
        // Manage User Addresses
        route::get('/addresses/all', [AddressesController::class, 'index'])->name('addresses.index');
        route::post('add-address', [AddressesController::class, 'store'])->name('address.store');
        route::get('city/{id}', [AddressesController::class, 'city'])->name('city');
        route::get('area/{id}', [AddressesController::class, 'area'])->name('area');
        route::get('delete-address/{id}', [AddressesController::class, 'destroy'])->name('address.destroy');
        route::get('get-address/{id}', [AddressesController::class, 'get'])->name('address.get');

        route::get('/addresses/create', [AddressesController::class, 'create'])->name('address.create');
        route::post('/addresses/save/{id}', [AddressesController::class, 'save'])->name('address.save');
        route::get('/address-edit/{id}', [AddressesController::class, 'edit'])->name('address.edit');
        route::post('make-default', [AddressesController::class, 'makeDefault'])->name('address.make-default');
        //Manage Portfolio
        route::get('/projects/all', [PortfolioController::class, 'index'])->name('projects.index');
        route::get('/projects/create', [PortfolioController::class, 'create'])->name('project.create');
        route::post('/projects/save/{id}', [PortfolioController::class, 'save'])->name('project.save');
        route::get('/project-edit/{id}', [PortfolioController::class, 'edit'])->name('project.edit');
        route::get('/project-delete/{id}', [PortfolioController::class, 'delete'])->name('project.delete');
        route::get('/project-detail/{id}', [PortfolioController::class, 'detail'])->name('project.detail');

        route::get('/subscription-featured-packages', [SubscriptionController::class, 'getFeatured'])->name('featured-packages.index');
        route::get('/subscription-packages', [SubscriptionController::class, 'index'])->name('packages.index');
        route::post('subscription/payment', [UserSubscriptionController::class, 'subscribe'])->name('subscription.payment');
        route::get('/subscription-payment-response', [UserSubscriptionController::class, 'paymentResponse'])->name('subscription.payment-response');
        //Manage Quotations
        route::get('/quotations/{status?}', [OrdersController::class, 'quotationIndex'])->name('quotations.index');
        route::get('/quotation/{id}/detail', [OrdersController::class, 'quotationDetail'])->name('quotation.detail');
        route::post('order-visited', [OrdersController::class, 'visit'])->name('quotation.visit');
        route::post('order-rejected', [OrdersController::class, 'reject'])->name('quotation.reject');
        route::post('order-quoted', [OrdersController::class, 'quote'])->name('quotation.quote');
        Route::get('service-checkout/{id}',[OrdersController::class, 'checkoutContent'])->name('service.checkout');
        //Manage Orders
        route::get('/orders/{status?}', [OrdersController::class, 'ordersIndex'])->name('orders.index');
        route::get('/order/{id}/detail', [OrdersController::class, 'orderDetail'])->name('order.detail');
        route::post('order-cancel', [OrdersController::class, 'cancelOrder'])->name('order.cancel');
        route::post('order/in-progress', [OrdersController::class, 'inProgress'])->name('order.in-progress');
        route::post('order-complete', [OrdersController::class, 'complete'])->name('order.complete');
        //notifications
        route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
        route::get('/notification-alldelete', [NotificationController::class, 'deleteAll'])->name('notification.deleteAll');
        route::get('/notification-delete/{id}', [NotificationController::class, 'destroy'])->name('notification.detele');
        //review
        route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

           /*Chat  Routes */
           route::get('/conversations', [ChatController::class, 'index'])->name('conversations.index');
           route::get('conversations/{service_id}/{supplier_id}', [ChatController::class, 'createOrGet'])->name('conversation.start');
           route::get('conversation/{id}', [ChatController::class, 'conversation'])->name('conversation.messages');
           route::get('conversation/{id}/delete', [ChatController::class, 'conversationDelete'])->name('conversation.delete');
        //    payment profile
        route::get('payment',[ProfileController::class, 'payment'])->name('payment');
        route::get('/payment/detail', [ProfileController::class, 'payment'])->name('payment.detail');
        route::post('/payment/update', [ProfileController::class, 'paymentUpdate'])->name('payment.update');
        route::post('/withdraw/payment', [ProfileController::class, 'withdraw'])->name('withdraw.payment');


    });

    Route::get('command', function () {
        Artisan::call('clear:all');
        dd("Done");
    });



});
Route::get('test/sockets/{id}', function ($id) {
    $notification = new stdClass();
    $notification->receiver_id = $id;
    sendNotification([ // send to user
        'sender_id' =>auth()->id(),
        'receiver_id' => 24,
        'extras->quotation_id' => '$order->id',
        'extras->service_id' => '$order->service_id',
        'extras->service_name' => '$order->service_name',
        'extras->image' => '$order->image',
        'title->en' => '<h3 class="order-name text-truncate"> .</h3>',
        'title->ar' => '<h3 class="order-name text-truncate"> Quotation#<span></h3>',
        'description->en' => '<p class="p-text">   Quotation (<span>Order#</p>',
        'description->ar' => '<p class="p-text">   Quotation (<span>Order#', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
        'action' => 'QUOTATION'
    ]);
    event(new \App\Events\NewNotifications($notification));
    dd("Done");
});
