# Installation
This bundle can be installed using Composer. Tell composer to install the extension:

```bash
$ php composer.phar require prezent/pushwoosh-bundle
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
In the configuration file, you have to set the API key and either the application ID, or the application group ID. Optionally, you can set the client class that will be instantiated, and whether or not all requests will be logged:

```yml
prezent_pushwoosh:
  application_id: XXXXX-XXXXX
  application_group_id: YYYYY-YYYYY
  api_key: xxxxxxxxxxxxxxxxxxxxx
  client_class: Gomoob\Pushwoosh\Client\Pushwoosh
  log_requests: log
```

## Logging
All requests to the API can be logged to a file, by setting the `logging` parameter to `true`. The logger will log to the `prezent_pushwoosh` channel. By default, these logs are stored in you standard log file. To have you application filter these logs to a separte file, add something like the following code configuration to your `config.yml`:

```yml
monolog:
  handlers:
    push:
        type: stream
        level: info
        path: %kernel.logs_dir%/push.log
        channels: [prezent_pushwoosh]
```