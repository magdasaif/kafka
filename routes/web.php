<?php

use App\Kafka\Consumer;
use App\Kafka\Producer;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Facades\Route;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/consume', function (Consumer $consumer) {
//     $consumer->consume();
//     return 'Consuming messages from Kafka...';
// });

// Route::get('/produce', function (Producer $producer) {
//     $producer->produce('Hello Kafka!');
//     return 'Producing message to Kafka...';

// });

Route::get('/produce', function () {

    $message = new Message(
        // headers: ['header-key' => 'header-value'],
        body: ['message key' => 'message value test'],
        key: 'kafka_key_here'  
    );
    
    $producer=Kafka::publishOn('test-topic')->withMessage($message);
    $producer->send();
    return 'Producing message to Kafka...';
});

Route::get('/consume', function () {
    return 'yyyyy';
    //===========================================================================
    // $consumer = Kafka::createConsumer(['movies'])
    //         /*->withHandler(function (KafkaConsumerMessage $message) {
    //             // event(new MovieDataReceived(json_encode($message->getBody())));
    //             $this->info('Received message: ' . json_encode($message->getBody()));
    //         })*/->build();

    // $consumer->consume();
    // return 'consumn done';
    //===========================================================================
        
    $consumer = Kafka::createConsumer(['test-topic'], 'group-id', 'localhost:9092')->build();
    // $consumer = Kafka::createConsumer()->subscribe('test-topic');
    // $consumer = \Junges\Kafka\Facades\Kafka::createConsumer()->build();

    return $messages = $consumer->consume();

    // foreach ($messages as $message) {
    //     // Process the consumed message
    //     $payload = $message->payload();
    //     // ...
    // }

    return 'Consuming messages from Kafka...';
});

Route::get('/check_broker', function () {

    try {
        $brokers = Kafka::brokers();
        
        // The broker connection was successful
        // You can assume the Kafka broker is running
        echo "Kafka broker is running.";
    } catch (\Exception $e) {
        echo $e->getMessage();
        echo '<br>';
        // An error occurred while connecting to the broker
        // The Kafka broker is not running or not accessible
        echo "Kafka broker is not running or not accessible.";
    }
});