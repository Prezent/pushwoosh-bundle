# Usage
The bundle creates a service that you can get from the Service Container. After that, you can use the Pushwoosh client 
as described in the documentation of [gomoob/php-pushwoosh](http://gomoob.github.io/php-pushwoosh/)

```php
<?php
// Controller.php

public function registerBundles()
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