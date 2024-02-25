<?php
namespace App\Kafka\Consumers;

use Junges\Kafka\Message\Message;
use Junges\Kafka\Contracts\Consumer;

class ExampleConsumer implements Consumer
{
    public function handle(Message $message): void
    {
        // Process the received message
        // You can access the message content using $message->getBody()
        $body = $message->getBody();
        
        // Display the message
        echo "Received message: $body\n";
    }
}