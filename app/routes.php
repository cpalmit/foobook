<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



// Homepage
Route::get('/', function(){
	return View::make('index');
});


// list all books / search
Route::get('/list/{query?}', function($query) 
{
	return View::make('list');
});


// display form for new book
Route::get('/add', function (){
	
});


// process form for new book
Route::post('/add', function() {


});

// display form to edit a book
Route::get('/edit/{title}', function(){   //why doesn't this have $title as a parameter?

});

// process form to edit a book
Route::post('/edit/', function(){

});


Route::get('/data', function() {

    // Get the file
    $books = File::get(app_path().'/database/books.json');

    // Convert to an array
    $books = json_decode($books,true);
	
    // Return the file
    echo Pre::render($books);


});
