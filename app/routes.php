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



Route::get('/practice-creating', function() {

    # Instantiate a new Book model class
    $book = new Book(); 

    # Set 
    $book->title = 'Cat in the Hat';
    $book->author = 'Dr. Suess';
    $book->published = 1960;
    
    # This is where the Eloquent ORM magic happens
    $book->save();

    return 'A new book has been added! Check your database to see...';

});


Route::get('/practice-reading', function() {

    # The all() method will fetch all the rows from a Model/table
    $books = Book::all();

    # Make sure we have results before trying to print them...
    if($books->isEmpty() != TRUE) {

        # Typically we'd pass $books to a View, but for quick and dirty demonstration, let's just output here...
        foreach($books as $book) {
            echo $book->title.'<br>';
        }
    }
    else {
        return 'No books found';
    }

});


Route::get('/practice-reading-one-book', function() {

    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    if($book) {
        return $book->title;
    }
    else {
        return 'Book not found.';
    }

});


Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Pre::render($results);

});


// list all books / search
Route::get('/list/{format?}', function($format='html') 
{


	//$query = $_GET['query']; //(old PHP way)
	
	$query = Input::get('query');
	
	$library = new Library();
	$library->setPath(app_path().'/database/books.json');
	$books = $library->getBooks();
	
	if($query){
		$books=$library->search($query);
	}	


	if($format=='json'){
		return 'Jsonversion';
	}
	elseif($format=='pdf'){
		return 'pdfversion';
	}
	else {
		return View::make('list')
		->with('name','List tester')
		->with('books',$books)
		->with('query', $query);
	}
	
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
    //$books = File::get(app_path().'/database/books.json');

    // Convert to an array
    //$books = json_decode($books,true);
	
	$library = new Library();
	$library->setPath(app_path().'/database/books.json');
	$books = $library->getBooks();
    // Return the file
    echo Pre::render($books);


});




# /app/routes.php
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    } 
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});
