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

});
