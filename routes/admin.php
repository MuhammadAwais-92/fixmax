<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\GalleriesController;
use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\AdministratorsController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CoveredAreasController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\OfferBannerController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\QuotationsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\WithdrawsController;

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

Route::as('admin.')->group(function () {

    Route::group(['as' => 'auth.', 'namespace' => 'Auth'], function () {
        Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.show-login-form');
        Route::post('login', [LoginController::class, 'attemptLogin'])->name('login');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout.post');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout.get');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot-password.send-reset-link-email');
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password.show-link-request-form');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('forgot-password.show-reset-form');
        Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('forgot-password.reset');
    });

    Route::middleware('auth:admin')->as('dashboard.')->group(function () {
        Route::resources([
            'cities' => CityController::class,
            'cities.areas' => AreaController::class,
            'articles' => ArticlesController::class,
            'users' => UsersController::class,
            'categories' => CategoryController::class,
            'categories.sub-categories' => SubCategoryController::class,
            'suppliers' => SuppliersController::class,
            'subscriptions' => SubscriptionController::class,
            'pages' => PagesController::class,
            'offers' => OfferBannerController::class,
            'site-settings' => SiteSettingsController::class,
            'administrators' => AdministratorsController::class,
            'services' => ServiceController::class,
            'equipments' => EquipmentController::class,
            'quotations' => QuotationsController::class,
            'orders' => OrdersController::class,
            'coupons'  => CouponController::class,
            'projects' => PortfolioController::class,
            'faqs' => FaqsController::class,
            'galleries' => GalleriesController::class,
            'withdraw'      => WithdrawsController::class,
        ]);
        Route::get('reviews/{id}', [SuppliersController::class, 'reviews'])->name('suppliers.reviews');
        Route::post('reviews-destroy/{id}', [SuppliersController::class, 'reviewsDelete'])->name('suppliers.reviews.destroy');
        Route::prefix('list/')->group(function () {
            Route::post('users', [UsersController::class, 'all'])->name('users.ajax.list');
            Route::post('subscription_packages', [SubscriptionController::class, 'all'])->name('subscription_packages.ajax.list');
            Route::post('pages', [PagesController::class, 'all'])->name('pages.ajax.list');
            Route::post('offers', [OfferBannerController::class, 'all'])->name('offers.ajax.list');
            Route::post('suppliers', [SuppliersController::class, 'all'])->name('suppliers.ajax.list');
            Route::post('site-settings', [SiteSettingsController::class, 'all'])->name('site-settings.ajax.list');
            Route::post('services', [ServiceController::class, 'all'])->name('services.ajax.list');
            Route::post('equipments', [EquipmentController::class, 'all'])->name('equipments.ajax.list');
            Route::post('administrators', [AdministratorsController::class, 'all'])->name('administrators.ajax.list');
            Route::post('projects', [PortfolioController::class, 'all'])->name('projects.ajax.list');
            Route::post('articles', [ArticlesController::class, 'all'])->name('articles.ajax.list');
            Route::post('faqs', [FaqsController::class, 'all'])->name('faqs.ajax.list');
            Route::post('galleries', [GalleriesController::class, 'all'])->name('galleries.ajax.list');
            Route::post('quotations', [QuotationsController::class, 'all'])->name('quotations.ajax.list');
            Route::post('orders', [OrdersController::class, 'all'])->name('orders.ajax.list');
            Route::post('coupons', [CouponController::class, 'all'])->name('coupons.ajax.list');
            Route::post('withdraws', [WithdrawsController::class, 'all'])->name('withdraw.ajax.list');

        });
        Route::put('coupons/update/{id}', [CouponController::class, 'update'])->name('coupons.update');

        Route::get('withdraws/payWithPayPal/{id}', [WithdrawsController::class, 'payWithPayPal'])->name('withdraw.pay-with-paypal');
        Route::get('withdraws/paypalPaymentProcessed/{id}', [WithdrawsController::class, 'paypalPaymentProcessed'])->name('withdraw.paypal-payment-processed');
        Route::get('withdraws/paypalPaymentCanceled', [WithdrawsController::class, 'paypalPaymentCanceled'])->name('withdraws.paypal-payment-canceled');
       
        Route::get('service-on/{id}', [ServiceController::class, 'active'])->name('service.on');
        Route::get('service-off/{id}', [ServiceController::class, 'deActive'])->name('service.off');
        //Quotations
        Route::get('quotation-cancel/{id}', [QuotationsController::class, 'reject'])->name('quotation.cancel');
        Route::get('quotation-detail/{id}', [QuotationsController::class, 'detail'])->name('quotation.detail');

        //Orders
        Route::get('order-cancel/{id}', [OrdersController::class, 'cancel'])->name('order.cancel');
        Route::get('order-detail/{id}', [OrdersController::class, 'detail'])->name('order.detail');

        Route::get('equipment-on/{id}', [EquipmentController::class, 'active'])->name('equipment.on');
        Route::get('equipment-off/{id}', [EquipmentController::class, 'deActive'])->name('equipment.off');

        Route::get('project-on/{id}', [PortfolioController::class, 'active'])->name('project.on');
        Route::get('project-off/{id}', [PortfolioController::class, 'deActive'])->name('project.off');

        Route::get('home', [DashboardController::class, 'index'])->name('index');
        Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('edit-profile');
        Route::get('get-areas/{id?}/{userid?}', [CoveredAreasController::class, 'getAreas'])->name('get-areas');
        route::get('/covered-areas/{id}/{userId}', [CoveredAreasController::class, 'deleteCoveredArea'])->name('covered.areas.delete');
        Route::put('update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
        Route::post('save-image', [DashboardController::class, 'saveImage'])->name('save-image');
        Route::get('id-card-verify/{id}', [SuppliersController::class, 'idCardVerify'])->name('id.card.verify');
        Route::get('site-settings/table/values', [SiteSettingsController::class, 'tableValues'])->name('site-settings.table.values');
        Route::put('toggle-status/administrators/{id}', [AdministratorsController::class, 'toggleStatus'])->name('administrators.toggle-status');
    });

    Route::post('upload-image', [DashboardController::class, 'uploadImage'])->name('upload-image');
    Route::post('upload-multi-image', [DashboardController::class, 'multiImageUpload'])->name('upload-image.multi');
});
