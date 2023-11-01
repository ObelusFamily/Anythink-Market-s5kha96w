<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping_mongo/', function (Request  $request) {    
    $connection = DB::connection('mongodb');
    $msg = 'MongoDB is accessible!';
    try {  
        $connection->command(['ping' => 1]);  
    } catch (Exception  $e) {  
        $msg = 'MongoDB is not accessible. Error: ' . $e->getMessage();
    }
    return ['msg' => $msg];
  });

  Route::get('/find_native/', function (Request  $request) {
    $mongodbquery = [ "title" => "One Week" ];                
    $mdb_collection = DB::connection('mongodb')->getCollection('reels');                
  
    $mdb_bsondoc= $mdb_collection->findOne( $mongodbquery );                 
  
    return ['msg' => 'executed', 'bsondoc' => $mdb_bsondoc];
  });

  Route::get('/find_drama1921/', function (Request  $request) {
    $mongodbquery = [ "genres" => "Drama", "year" => 1921 ];                
    $mdb_collection = DB::connection('mongodb')->getCollection('reels');                
  
    $mdb_bsondoc= $mdb_collection->count( $mongodbquery );                 
  
    return ['msg' => 'executed', 'bsondoc' => $mdb_bsondoc];
  });
