<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;



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
    return redirect('/events');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', [AdminController::class, 'index']);

// events
Route::get('/events', [EventController::class, 'index']);
// add
Route::get('/addevent', [EventController::class, 'addview'])->name('addevent');
Route::post('/addeventaction', [EventController::class, 'addeventaction']);
// view user events
Route::get('/myevents', [EventController::class, 'view_user_events'])->name('myevents');
// details page
Route::get('/eventdetails', [EventController::class, 'event_details'])->name('eventdetails');
Route::post('/updateevent', [EventController::class, 'update_event']);
Route::post('/delete', [EventController::class, 'delete_event']);

// ticketing
Route::get('/ticket-add', [TicketController::class, 'add_ticket'])->name('ticket-add');
Route::post('/addticketaction', [TicketController::class, 'addticketaction']);
Route::get('/viewtickets', [TicketController::class, 'view_tickets'])->name('viewtickets');