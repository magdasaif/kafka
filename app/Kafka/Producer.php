<?php

namespace App\Kafka;

use RdKafka\Conf;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use RdKafka\Producer as KafkaProducer;

class Producer
{
    private $producer;

    // public function __construct()
    // {
    //     $conf = new Conf();
    //     $conf->set('bootstrap.servers', env('KAFKA_BOOTSTRAP_SERVERS'));

    //     $this->producer = new KafkaProducer($conf);
    // }

    // public function produce($message)
    // {
    //     $topic = $this->producer->newTopic('my-topic');

    //     $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
    //     $this->producer->flush(1000);
    // }

    public function produce(){

        $message = new Message(
            headers: ['header-key' => 'header-value'],
            body: ['message key' => 'message value test'],
            key: 'kafka_key_here'  
        );
        
        $producer=Kafka::publishOn('test-topic')->withMessage($message);
        $producer->send();

    }
}