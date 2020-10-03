<?php

use App\institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------

*/

Route::get('/',function (){
    // User role
    $role = Auth::user()->role;
    // Check user role
    switch ($role) {
        case 'سوبر':
            return redirect()->route('dashboard');
            break;
        case 'سكرتير':
            return redirect()->route('Transactions.index');
            break;
        default:
            return '/login';
            break;
    }
})->middleware('auth');
/*
|--------------------------------------------------------------------------
| SuperAdmin Routes
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix'=>'SuperAdmin','middleware'=>['auth','SuperAdmin'] ],function (){
    // dashboard route
    Route::get('/dashboard', 'DashBoardController@index')->name('dashboard');
    //employees route
    Route::get('/ManageEmployees','employeesController@index')->name('employees.index');
    Route::get('/AddEmployee','employeesController@create')->name('employees.create');
    Route::post('/StoreNewEmployee','employeesController@store')->name('employees.store');
    Route::get('/EditEmployee/{employee}','employeesController@edit')->name('employees.edit');
    Route::get('/SearchEmployee/{employeeName}','employeesController@search')->name('employees.search');
    Route::patch('/UpdateEmployee/{employee}','employeesController@update')->name('employees.update');
    Route::delete('/DeleteEmployee/{employee}','employeesController@destroy')->name('employees.destroy');
});
/*
|--------------------------------------------------------------------------
| Secretary Routes
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix'=>'Secretary','middleware'=>['auth','Secretary'] ],function (){
    /*
    |--------------------------------------------------------------------------
    | Transactions Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/Transactions', 'TransactionsController@index')->name('Transactions.index');
    Route::get('/CreateTransaction', 'TransactionsController@create')->name('Transactions.create');
    Route::post('/StoreNewTransaction/institution/{institution_id}/reviser/{reviser_id}', 'TransactionsController@store')->name('Transactions.store');

    /*
    |--------------------------------------------------------------------------
    | institution Routes
    |--------------------------------------------------------------------------
    */
    Route::post('/StoreNewInstitution','InstitutionController@store')->name('Institution.store');

    /*
    |--------------------------------------------------------------------------
    | Agent Routes
    |--------------------------------------------------------------------------
    */
    Route::post('/StoreNewAgentFor/{institution}','AgentController@store')->name('agent.store');

    /*
    |--------------------------------------------------------------------------
    | revisers Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/GetRevisers','ReviserController@index')->name('reviser.index');

    /*
    |--------------------------------------------------------------------------
    | Register Trade Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/SearchNewRegister/{TradeRegisterNumber}','TradeRegisterController@search')->name('TradeRegister.search');

    Route::post('/StoreNewRegisterTrade/{institution:id}','TradeRegisterController@store')->name('TradeRegister.store');

});
/*
|--------------------------------------------------------------------------
| Documents Routes
|--------------------------------------------------------------------------
*/
    Route::get('/Documents','DocumentsController@index')->name('documents.index');
    Route::get('/AddDocumentFor/{institution_id}','DocumentsController@AddDocument')->name('documents.AddDocument');
