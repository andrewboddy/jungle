<?php
Route::get('/stocks/industry/{industry}', 'StocksController@industry');


Route::resource('/alltimehighs', 'AllTimeHighController@get');
Route::resource('/stocks', 'StocksController');
Route::resource('/watchitems', 'WatchItemsController');
Route::resource('/alltimehighs', 'AllTimeHighsController');
Route::resource('/indicators', 'IndicatorsController');

Route::resource('/positions', 'WatchItemsController');

Route::post('/qwert', 'WatchItemsController@reset2');

Route::get('/stocksByGrowth', 'StocksController@stocksByGrowth');
Route::get('/stocksByF1estimates', 'StocksController@stocksByF1estimates');
Route::get('/stocksBySurprise', 'StocksController@stocksBySurprise');
Route::get('/stocksByQestimates', 'StocksController@stocksByQestimates');



Route::get('/setHighWaterMark', 'WatchItemsController@setHighWaterMark');
Route::get('/setRealTimePrices', 'WatchItemsController@setRealTimePrices');
Route::get('/reset/{ticker}', 'WatchItemsController@reset');

Route::get('/stocks/showByTicker/{ticker}', 'StocksController@showByTicker');


// Administration Tasks
Route::get('/setEPSEstimates', 'StocksController@setEPSEstimates');
Route::get('/setLongDescriptions', 'StocksController@setLongDescriptions');
Route::get('/dataLoadNasdaqData', 'StocksController@dataLoadNasdaqData');


// Indicators
Route::get('/setPMIMan', 'IndicatorsController@setPMIMan');

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/getalltimehighs', function () {
    return view('alltimehighs');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



