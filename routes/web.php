<?php

use App\Models\Book;
use App\Models\Role;
use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CopysController;
use App\Http\Controllers\AuthorsController;

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


//USERS:

Route::controller(UserController::class)->group(function (){

    //AUTH MIDDLEWARE:

    Route::middleware(['auth'])->group(function () {

        //Log out
        Route::post('/logout', 'logout');

        //Show all users
        Route::get('/admin/users', 'index');

        //Show single user page
        Route::get('/admin/users/{id}', 'show');

    });

    //GUEST MIDDLEWARE:

    Route::middleware(['guest'])->group(function () {

        //Show login form
        Route::get('/login', 'login');

        //Show registration form
        Route::get('/register', 'register');

        //Log in
        Route::post('/authenticate', 'authenticate');

        //Create new user
        Route::post('/users', 'store');

    });

});

//AUTHORS:

Route::controller(AuthorsController::class)->group(function (){

    //AUTH MIDDLEWARE:
    
    Route::middleware(['auth'])->group(function () {

        //Delete the author and all his books
        Route::delete('admin/authors/{id}', 'destroy');

        //Add new author to DB
        Route::post('admin/authors','store');

        //Show add new author page
        Route::get('admin/authors', 'addAuthor');

        //Show edit author page
        Route::get('/admin/authors/edit/{id}', 'edit');

        //Update author
        Route::put('admin/authors/{id}', 'update');
    
    });

    //PUBLIC ROUTES:
    
    //Show author page
    Route::get('/authors/{id}', 'show');

});


//BOOKS:

Route::controller(BooksController::class)->group(function (){

    //AUTH MIDDLEWARE:
    
    Route::middleware(['auth'])->group(function () {

        //Add new book to DB
        Route::post('books', 'store');

        //Delete the book
        Route::delete('books/{id}', 'destroy');

        //Show my books page
        Route::get('books/mybooks', 'mybooks');

        //Show add new book page
        Route::get('/admin/books/addbook', 'addBook');

        //Show edit book page
        Route::get('admin/books/edit/{id}', 'edit');

        //Update the book
        Route::put('admin/books/{id}', 'update');

    });

    //PUBLIC ROUTES:

    //Show all books (home page)
    Route::get('/', 'index')->name('home');

    //Show single book
    Route::get('/books/{id}', 'show');

});

//COPIES:

Route::controller(CopysController::class)->group(function (){

    //AUTH MIDDLEWARE:
    
    Route::middleware(['auth'])->group(function () {

        //Add new copy to DB
        Route::post('copies', 'store');

        //Return the copy:
        Route::put('admin/copies/{id}', 'return');

        //Borrow the book
        Route::put('copies/{id}', 'borrow'); 

        //Delete the book
        Route::delete('copies/{id}', 'destroy');

        //Show edit copy page
        Route::get('admin/copies/edit/{id}', 'edit');

        //Update the copy
        Route::put('admin/copies/edit/{id}', 'update');
        
    });

    //PUBLIC ROUTES:

    //Show single copy
    Route::get('/copies/{id}', 'show');
});

//LOGS:

Route::controller(LogsController::class)->group(function (){

    //AUTH MIDDLEWARE:
    Route::middleware(['auth'])->group(function () {


        Route::get('admin/logs', 'index');

    });

});


// DOCUMENTATION
// openAPI, swagger 

// TEST
// https://laravel.com/docs/9.x/testing