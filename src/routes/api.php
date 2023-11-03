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

  Route::get('/testwithphp/', function (Request  $request) {
    $mongodbquery = [ "title" => "The Shawshank Redemption" ];                
    $mdb_collection = DB::connection('mongodb')->getCollection('reels');                
  
    $mdb_bsondoc= $mdb_collection->findOne( $mongodbquery );
    
    $output = $mdb_bsondoc['title'] . "<br>" . $mdb_bsondoc['directors'][0];
    $testArray = ['msg' => 'executed', 'bsondoc' => $output];
    // return ['msg' => 'executed', 'bsondoc' => $mdb_bsondoc];
    // return $output;
    foreach ($mdb_bsondoc as $key => $value) {
      if (gettype($value) === "string" || gettype($value) === "integer" ) {
        echo "[" . $key . "] => " . $value . "<br>";
      } else if(gettype($value) === "object") {
        echo "[" . $key . "]<br>";
        foreach ($value as $object => $i) {
          if (gettype($i) === "string" || gettype($i) === "integer" ) {
          echo "[~" . $object . "~] => " . $i . "<br>";
          } else {
            echo "[" . $object . "] => " . gettype($i) . "<br>";
          }
        }
      }
    }


    return $testArray['msg'];
  });