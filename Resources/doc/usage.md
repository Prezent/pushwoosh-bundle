# Usage

## Using the manager
The bundle comes with a manager that allows for easy sending of push messages. You can get this manager as a service 
from the Service Container. 

You always have to supply the content of the message. Optionally you can enter an array of extra data, 
and an array of specific pushtokens to send the message to.

```php
<?php
// Controller.php

public function sendPushMessage()
{
    $pushwooshManager = $this->getContainer()->get('prezent_pushwoosh.pushwoosh_manager');
    $success = $pushwooshManager->send('Hello Jean !', [], []);

    // Check if its ok
    if ($success) {
        print 'Great, my message has been sent !';
    } else {
        print 'Oups, the sent failed :-('; 
        print 'Status code : ' . $pushwooshManager->getErrorCode();
        print 'Status message : ' . $pushwooshManager->getErrorMessage();
    }
}
```

You can also send a batch of push notifications in one request:
```php
public function sendPushMessageBatch()
{
    $pushwooshManager = $this->getContainer()->get('prezent_pushwoosh.pushwoosh_manager');
    $success = $pushwooshManager->sendBatch(
        [
            [
                'content' => 'Hello Jean!',
                'data' => [],
                'devices' => []
            ],
            [
                'content' => 'Hello Rene!',
                'data' => [],
                'devices' => []
            ],
        ]
    );

    // Check if its ok
    if ($success) {
        print 'Great, my messages have been sent !';
    } else {
        print 'Oups, the sent failed :-(';
        print 'Status code : ' . $pushwooshManager->getErrorCode();
        print 'Status message : ' . $pushwooshManager->getErrorMessage();
    }
}
```

## Using the Pushwoosh client directly
The bundle also creates a service for the actual Pushwoosh client, that you can get from the Service Container. 
Using this client, you get more flexibility in sending push messages. You can use the Pushwoosh client 
as described in the documentation of [gomoob/php-pushwoosh](http://gomoob.github.io/php-pushwoosh/)

```php
<?php
// Controller.php

public function sendPushMessage()
{
    $pushwoosh = $this->get('pushwoosh');
    
    // Create a request for the '/createMessage' Web Service
    $request = CreateMessageRequest::create()
        ->addNotification(Notification::create()->setContent('Hello Jean !'));
    
    // Call the REST Web Service
    $response = $pushwoosh->createMessage($request);
    
    // Check if its ok
    if($response->isOk()) {
        print 'Great, my message has been sent !';
    } else {
        print 'Oups, the sent failed :-('; 
        print 'Status code : ' . $response->getStatusCode();
        print 'Status message : ' . $response->getStatusMessage();
    }
}
```