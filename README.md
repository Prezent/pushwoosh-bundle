# prezent/pushwoosh-bundle

Integrates [gomoob/php-pushwoosh](https://github.com/gomoob/php-pushwoosh) into a Symfony2 project.

## Installation
This bundle can be installed using Composer. Tell composer to install the extension:

```bash
$ php composer.phar require gomoob/php-pushwoosh
```

Then, activate the bundle in your kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Prezent\PushwooshBundle\PushwooshBundle(),
    );
}
```

## Configuration
You have to set the application id and the API key in the configuration file. Optionally, you can set the client class that will be instantiated:

```yml
prezent_pushwoosh:
  application_id: XXXXX-XXXXX
  api_key: xxxxxxxxxxxxxxxxxxxxx
  client_class: Gomoob\Pushwoosh\Client\Pushwoosh
```

## Usage
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
