<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use App\Models\Transaction;

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
    return redirect('/home');
});

Auth::routes();

// Authentication
Route::get('cas-login', function() {
    return back();
})->middleware('cas')
    ->name('cas');

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');


// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('organizations', [AdminController::class, 'organization_index']);
    Route::get('organization/{organization_id}', [AdminController::class, 'organization_detail'])->name('organization-detail');
});

// events
Route::group(['prefix' => 'event', 'as' => 'event.'], function() {
    Route::get('/', [EventController::class, 'index']);
    //add
    Route::get('add', [EventController::class, 'addevent'])->name('add');
    Route::post('addeventaction', [EventController::class, 'add_event_action']);
    // view user events
    Route::get('myevents', [EventController::class, 'view_user_events'])->name('myevents');
    //edit event page
    Route::get('edit', [EventController::class, 'edit_event'])->name('edit');
    Route::post('updateevent', [EventController::class, 'edit_event_action']);
    Route::post('delete', [EventController::class, 'delete_event']);
    Route::get('filter_userevent', [EventController::class, 'filter_user_event'])->name('filter');
});

// ticketing
Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function() {
    Route::get('add', [TicketController::class, 'add_ticket'])->name('add');
    Route::post('addticketaction', [TicketController::class, 'add_ticket_action']);
    Route::get('index', [TicketController::class, 'view_tickets'])->name('index');
    Route::get('edit', [TicketController::class, 'edit_tickets'])->name('edit');
    Route::post('editticketaction', [TicketController::class, 'edit_ticket_action']);
    Route::get('delete', [TicketController::class, 'delete_ticket'])->name('delete');
});

//Transactions
//buy tickets
Route::group(['prefix' => 'buy', 'as' => 'buy.'], function() {
    Route::post('buy-ticket', [TransactionController::class, 'buy_ticket_action'])->name('buy_ticket');
    Route::get('mycart', [TransactionController::class, 'view_cart'])->name('mycart');
    Route::post('changequantity', [TransactionController::class, 'change_ticket_quantity']);
    Route::get('deletecartitem', [TransactionController::class, 'delete_cart_item'])->name('delete_cart_item');
    Route::get('buy/cashnet', [TransactionController::class, 'view_cashnet_transaction'])->name('buy_cashnet');
});


//User
Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
    Route::get('home', [UserController::class, 'index'])->name('index');
    Route::get('transaction', [UserController::class, 'transaction_details'])->name('transaction_details');
});

//Test
Route::group(['prefix' => 'test', 'as' => 'test.'], function() {
    Route::get('buy', [TestController::class, 'test_buy'])->name('test_buy');
});
