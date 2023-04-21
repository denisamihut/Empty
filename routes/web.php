<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CashBoxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ConceptsController;
use App\Http\Controllers\Admin\FloorsController;
use App\Http\Controllers\Admin\MenuGroupController;
use App\Http\Controllers\Admin\MenuOptionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\UnitsController;
use App\Http\Controllers\Admin\UserTypeController;
use App\Http\Controllers\Control\BillingListController;
use App\Http\Controllers\Control\BookingController;
use App\Http\Controllers\Control\CashRegisterController;
use App\Http\Controllers\Control\ManagementController;
use App\Http\Controllers\Control\SellProductController;
use App\Http\Controllers\Control\SellServiceController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/management', [ManagementController::class, 'index'])->name('management');
    Route::put('/management/update/{id}', [ManagementController::class, 'update'])->name('management.update');
    Route::get('/management/document', [ManagementController::class, 'documentNumber'])->name('management.documentNumber');
    Route::post('/management', [ManagementController::class, 'store'])->name('management.store');
    Route::get('/management/checkout', [ManagementController::class, 'checkout'])->name('management.checkout');
    Route::get('/management/create', [ManagementController::class, 'create'])->name('management.create');

    Route::get('cashregister/print', [CashRegisterController::class, 'print'])->name('cashregister.print');
    Route::get('cashregister/details', [CashRegisterController::class, 'details'])->name('cashregister.details');
    Route::get('cashregister/maintenance', [CashRegisterController::class, 'maintenance'])->name('cashregister.maintenance');
    Route::post('cashregister/search', [CashRegisterController::class, 'search'])->name('cashregister.search');
    Route::get('cashregister/delete/{id}/{listagain}', [CashRegisterController::class, 'delete'])->name('cashregister.delete');
    Route::resource('cashregister', CashRegisterController::class)->except(['show']);

    Route::post('business/search', [BusinessController::class, 'search'])->name('business.search');
    Route::get('business/delete/{id}/{listagain}', [BusinessController::class, 'delete'])->name('business.delete');
    Route::resource('business', BusinessController::class)->except(['show']);

    Route::post('branch/search', [BranchController::class, 'search'])->name('branch.search');
    Route::get('branch/delete/{id}/{listagain}', [BranchController::class, 'delete'])->name('branch.delete');
    Route::post('branch/uploadPhoto', [BranchController::class, 'uploadPhoto'])->name('branch.uploadPhoto');
    Route::get('branch/maintenance/{id}/{action}/{businessId}', [BranchController::class, 'maintenance'])->name('branch.maintenance');
    Route::resource('branch', BranchController::class)->except(['show']);

    Route::post('user/search', [UserController::class, 'search'])->name('user.search');
    Route::get('user/delete/{id}/{listagain}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('user/uploadPhoto', [UserController::class, 'uploadPhoto'])->name('user.uploadPhoto');
    Route::get('user/maintenance/{action}/{businessId}/{userId?}', [UserController::class, 'maintenance'])->name('user.maintenance');
    Route::resource('user', UserController::class)->except(['show']);

    Route::post('cashbox/search', [CashBoxController::class, 'search'])->name('cashbox.search');
    Route::get('cashbox/delete/{id}/{listagain}', [CashBoxController::class, 'delete'])->name('cashbox.delete');
    Route::get('cashbox/maintenance/{action}/{businessId}/{cashboxId?}', [CashBoxController::class, 'maintenance'])->name('cashbox.maintenance');
    Route::resource('cashbox', CashBoxController::class)->except(['show']);

    Route::post('payment/search', [PaymentController::class, 'search'])->name('payment.search');
    Route::get('payment/delete/{id}/{listagain}', [PaymentController::class, 'delete'])->name('payment.delete');
    Route::get('payment/maintenance/{action}/{businessId}/{paymentId?}', [PaymentController::class, 'maintenance'])->name('payment.maintenance');
    Route::resource('payment', PaymentController::class)->except(['show']);

    /* people routes */
    Route::get('people/createFast', [PeopleController::class, 'createFast'])->name('people.createFast');
    Route::post('people/storeFast', [PeopleController::class, 'storeFast'])->name('people.storeFast');
    Route::post('people/search', [PeopleController::class, 'search'])->name('people.search');
    Route::get('people/searchClient', [PeopleController::class, 'searchClient'])->name('people.searchClient');
    Route::get('people/delete/{id}/{listagain}', [PeopleController::class, 'delete'])->name('people.delete');
    Route::resource('people', PeopleController::class)->except(['show']);
    /* floor routes */
    Route::post('floor/search', [FloorsController::class, 'search'])->name('floor.search');
    Route::get('floor/delete/{id}/{listagain}', [FloorsController::class, 'delete'])->name('floor.delete');
    Route::resource('floor', FloorsController::class)->except(['show']);
    /* room routes */
    Route::post('room/search', [RoomsController::class, 'search'])->name('room.search');
    Route::get('room/delete/{id}/{listagain}', [RoomsController::class, 'delete'])->name('room.delete');
    Route::resource('room', RoomsController::class)->except(['show']);
    /* room types */
    Route::post('roomtype/search', [RoomTypeController::class, 'search'])->name('roomtype.search');
    Route::get('roomtype/delete/{id}/{listagain}', [RoomTypeController::class, 'delete'])->name('roomtype.delete');
    Route::resource('roomtype', RoomTypeController::class)->except(['show']);
    /* services routes */
    Route::post('service/search', [ServicesController::class, 'search'])->name('service.search');
    Route::get('service/delete/{id}/{listagain}', [ServicesController::class, 'delete'])->name('service.delete');
    Route::resource('service', ServicesController::class)->except(['show']);
    /* products routes */
    Route::post('product/search', [ProductsController::class, 'search'])->name('product.search');
    Route::get('product/delete/{id}/{listagain}', [ProductsController::class, 'delete'])->name('product.delete');
    Route::resource('product', ProductsController::class)->except(['show']);
    /* categories routes */
    Route::post('category/search', [CategoriesController::class, 'search'])->name('category.search');
    Route::get('category/delete/{id}/{listagain}', [CategoriesController::class, 'delete'])->name('category.delete');
    Route::resource('category', CategoriesController::class)->except(['show']);
    /* concepts routes */
    Route::post('concept/search', [ConceptsController::class, 'search'])->name('concept.search');
    Route::get('concept/delete/{id}/{listagain}', [ConceptsController::class, 'delete'])->name('concept.delete');
    Route::resource('concept', ConceptsController::class)->except(['show']);
    /* units routes */
    Route::post('unit/search', [UnitsController::class, 'search'])->name('unit.search');
    Route::get('unit/delete/{id}/{listagain}', [UnitsController::class, 'delete'])->name('unit.delete');
    Route::resource('unit', UnitsController::class)->except(['show']);
    /* role routes */
    Route::post('role/search', [RoleController::class, 'search'])->name('role.search');
    Route::get('role/delete/{id}/{listagain}', [RoleController::class, 'delete'])->name('role.delete');
    Route::resource('role', RoleController::class)->except(['show']);
    /* usertype routes */
    Route::post('usertype/search', [UserTypeController::class, 'search'])->name('usertype.search');
    Route::get('usertype/delete/{id}/{listagain}', [UserTypeController::class, 'delete'])->name('usertype.delete');
    Route::resource('usertype', UserTypeController::class)->except(['show']);
    /* menuoption routes */
    Route::post('menuoption/search', [MenuOptionController::class, 'search'])->name('menuoption.search');
    Route::get('menuoption/delete/{id}/{listagain}', [MenuOptionController::class, 'delete'])->name('menuoption.delete');
    Route::resource('menuoption', MenuOptionController::class)->except(['show']);
    /* menugroup routes */
    Route::post('menugroup/search', [MenuGroupController::class, 'search'])->name('menugroup.search');
    Route::get('menugroup/delete/{id}/{listagain}', [MenuGroupController::class, 'delete'])->name('menugroup.delete');
    Route::resource('menugroup', MenuGroupController::class)->except(['show']);
    /* Access Routes */
    Route::get('access', [AccessController::class, 'index'])->name('access');
    Route::post('access', [AccessController::class, 'store'])->name('access.store');
    /* Billing list Routes */
    Route::post('billinglist/search', [BillingListController::class, 'search'])->name('billinglist.search');
    Route::get('billinglist/print', [BillingListController::class, 'print'])->name('billinglist.print');
    Route::resource('billinglist', BillingListController::class)->except(['show', 'delete', 'create', 'edit', 'update', 'store']);
    /* Sell Products and Services Routes */
    Route::get('sellproduct', [SellProductController::class, 'index'])->name('sellproduct');
    Route::post('sellproduct/add/{id}', [SellProductController::class, 'addToCart'])->name('sellproduct.addToCart');
    Route::post('sellproduct/remove/{id}', [SellProductController::class, 'removeFromCart'])->name('sellproduct.removeFromCart');
    Route::post('sellproduct', [SellProductController::class, 'store'])->name('sellproduct.store');

    Route::get('sellservice', [SellServiceController::class, 'index'])->name('sellservice');
    Route::post('sellservice/add/{id}', [SellServiceController::class, 'addToCart'])->name('sellservice.addToCart');
    Route::post('sellservice/remove/{id}', [SellServiceController::class, 'removeFromCart'])->name('sellservice.removeFromCart');
    Route::post('sellservice', [SellServiceController::class, 'store'])->name('sellservice.store');

    /* Bookings Routes --- API WITH WEB CONTROLLERS */
    Route::get('booking/rooms', [BookingController::class, 'rooms'])->name('booking.rooms');
    Route::resource('booking', BookingController::class)->except(['show']);
});