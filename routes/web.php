<?php

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
//class ABC
//{
//    public $a;
//    public function __construct()
//    {
//         $this->a = 1;
//    }
//
//    public  function abc(...$args)
//    {
//        print_r($args);
//        exit;
//        return "hi";
////        return 3;
//    }
//}

//$abc = new ABC();
//echo $abc->abc(2,4,6);
//exit;
//echo ABC::abc();
//exit;

//class Test {
//
//    protected static function myProtected($test) {
//        var_dump(__METHOD__, $test);
//    }
//
//    public static function __callStatic($method, $args) {
//        switch($method) {
//            case 'foo' :
//                echo 'You have called foo()';
//                var_dump($args);
//                break;
//
//            case 'helloWorld':
//                echo 'Hello ' . $args[0];
//                break;
//
//            case 'myProtected':
//                return call_user_func_array(
//                    array(get_called_class(), 'myProtected'),
//                    $args
//                );
//                break;
//        }
//    }
//}

// these ones does not *really* exist
//Test::foo('bar');
//Test::helloWorld('hek2mgl');

// this one wouldn't be accessible
//Test::myProtected('foo');
//exit;


//class MethodTest
//{
////    public function __call($name, $arguments)
////    {
////        // Note: value of $name is case sensitive.
////        echo "Calling object method '$name' "
////            . implode(', ', $arguments). "\n";
////    }
//
//    /**  As of PHP 5.3.0  */
//    public static function __callStatic($name, $arguments)
//    {
//        // Note: value of $name is case sensitive.
//        echo "Calling static method '$name' "
//            . implode(', ', $arguments). "\n";
//    }
//
//    public static function runTest()
//    {
//        return "hi";
//    }
//}
//
////$obj = new MethodTest;
//////$obj->runTest('in object context');
//
//echo MethodTest::runTest('in static context');  // As of PHP 5.3.0
//
//exit;
//
//
//class Game
//{
//    public static function __callStatic($name, $arguments)
//    {
//        // Note: value of $name is case sensitive.
//        echo "Calling static method '$name' "
//            . implode(', ', $arguments). "\n";
//    }
//
////    public function test()
////    {
////        return "wow";
////    }
//}
//
//$game = new Game();
//echo Game::test();
//exit;

//dd(resolve('Game')->test());

use \Illuminate\Support\Facades\Redis;
Route::get('redis-test', function () {
//    $visits = \Illuminate\Support\Facades\Redis::incr('visits');

    $visits = Redis::incr('visits');

    return $visits;
//    return \Illuminate\Support\Facades\Redirect::route('register');
});


//Route::get('/onboard', function () {
//
//    return view('layouts.onboard');
//});

