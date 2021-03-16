<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\LoginController;



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

// Authentication
Route::get('cas-login', function() {
    return back();
})->middleware('cas')
    ->name('cas');

Route::post('logout', [LoginController::class, 'logout']);


// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/addorganization', [AdminController::class, 'add_organization']);
Route::post('/admin/addorganizationaction', [AdminController::class, 'add_organization_action']);
Route::post('/admin/editorganization', [AdminController::class, 'edit_organization_action']);
Route::get('/admin/organization', [AdminController::class, 'organization_detail'])->name('/admin/organization');
Route::post('/admin/deleteorganizer', [AdminController::class, 'delete_organizer']);
Route::post('/admin/addorganizer', [AdminController::class, 'add_organizer_action']);
Route::post('/admin/editorganizer', [AdminController::class, 'edit_organizer_action']);

// events
Route::get('/events', [EventController::class, 'index']);
// add
Route::get('/addevent', [EventController::class, 'addview'])->name('addevent');
Route::post('/addeventaction', [EventController::class, 'add_event_action']);
// view user events
Route::get('/myevents', [EventController::class, 'view_user_events'])->name('myevents');
// details page
Route::get('/eventdetails', [EventController::class, 'event_details'])->name('eventdetails');
Route::post('/updateevent', [EventController::class, 'edit_event_action']);
Route::post('/delete', [EventController::class, 'delete_event']);

// ticketing
Route::get('/ticket-add', [TicketController::class, 'add_ticket'])->name('ticket-add');
Route::post('/addticketaction', [TicketController::class, 'add_ticket_action']);
Route::get('/viewtickets', [TicketController::class, 'view_tickets'])->name('viewtickets');
Route::get('/edittickets', [TicketController::class, 'edit_tickets'])->name('edittickets');
Route::post('/editticketaction', [TicketController::class, 'edit_ticket_action']);
