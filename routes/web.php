<?php

use App\Kafka\Consumer;
use App\Kafka\Producer;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Console\Commands\KafkaConsumer;
use App\Kafka\Consumers\ExampleConsumer;
use Junges\Kafka\Contracts\KafkaConsumerManager;
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

//==============================================================================================
Route::get('/produce', function () {
    // return 'ddd';
    $message = new Message(
        // headers: ['header-key' => 'header-value'],
        body: ['message key' => 'message value test'],
        key: 'kafka_key_here'  
    );
    
    $producer=Kafka::publishOn('test-topic')->withMessage($message);
    $producer->send();
    echo 'Producing message to Kafka...';
    echo '<br>';
});

//==============================================================================================
Route::get('/consume2', function () {
    // Kafka::consume('test-topic', ExampleConsumer::class);

   // Create an instance of KafkaConsumer
    $kafkaConsumer = new KafkaConsumer();

    // Configure the Kafka broker connection
    $kafkaConsumer->setBroker(config('kafka.brokers'));

    // // Configure the consumer group ID
    $kafkaConsumer->setConsumerGroup(config('kafka.consumer_group_id'));

    // Subscribe to the Kafka topic
    $kafkaConsumer->subscribe('test-topic');

    // Start consuming messages
    $kafkaConsumer->consume(function (Message $message) {
        // Process the received message
        // You can access the message content using $message->getBody()
        $body = $message->getBody();
        
        // Display the message
        echo "Received message: $body\n";
    });

    // Keep the consumer running
    App::shutdown();


    return 'Consuming Kafka messages...';
});

//==============================================================================================
Route::get('/consume', function () {
    // return 'yyyyy';
    // $consumer = Kafka::createConsumer()->subscribe('test-topic');

    //===========================================================================
    $consumer = Kafka::createConsumer(['test-topic'])
    ->withHandler(function (KafkaConsumerMessage $message) {
        // event(new MovieDataReceived(json_encode($message->getBody())));
        $this->info('Received message: ' . json_encode($message->getBody()));
    })->build();

    $consumer->consume();
    return 'consumn done';
    //===========================================================================
        
    $consumer = Kafka::createConsumer()->subscribe('test-topic');
    $consumer->withHandler(function(\Junges\Kafka\Contracts\KafkaConsumerMessage $message) {
        // Handle your message
        $body = $message->getBody();
        
        // Display the message
        echo "Received message: $body\n";
    });
    return 'end messages';
    //===========================================================================
    // $consumer = Kafka::createConsumer(['test-topic'], 'group-id', 'localhost:9092')->build();
    $consumer = Kafka::createConsumer(['test-topic'])->build();
    print_r($consumer);
    // echo $consumer;
    echo '<br>-----------------------------------------<br>';
    Log::info('line 69');

    // Start consuming messages
    $consumer->consume(function (Message $message) {
        // Process the received message
        // You can access the message content using $message->getBody()
        $body = $message->getBody();
        
        // Display the message
        echo "Received message: $body\n";
        echo '<br>-----------------------------------------<br>';
    });
    //===========================================================================
    // $consumer = Kafka::createConsumer()->subscribe('test-topic');
    // $consumer = Kafka::createConsumer()->subscribe('test-topic')->build();
    // // $consumer = \Junges\Kafka\Facades\Kafka::createConsumer()->subscribe('test-topic')->build();
    // Log::info('ffff');
    // print_r($consumer);
    // echo '<br>-----------------------------------------<br>';
    // Log::info('line 79');

    // return $messages = $consumer->consume();

    // foreach ($messages as $message) {
    //     // Process the consumed message
    //     $payload = $message->payload();
    //     // ...
    // }

    return 'Consuming messages from Kafka...';
});
//==============================================================================================
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