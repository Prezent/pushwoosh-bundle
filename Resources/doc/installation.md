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
In the configuration file, you have to set the API key and either the application ID, or the application group ID. Optionally, you can set the client class that will be instantiated.

### Logging
By default, logging is disabled. You can enable it in you `config.yml`:
```yml
prezent_pushwoosh:
  logging: ~ 
```

The logger will log to the `prezent_pushwoosh` channel. By default, these logs are stored in you standard log file. To have you application filter these logs to a separate file, add something like the following code configuration to your `config.yml`:
```yml
monolog:
  handlers:
    push:
        type: stream
        level: info
        path: %kernel.logs_dir%/push.log
        channels: [prezent_pushwoosh]
```

At the moment, only loggin the file is supported.

### A complete configuration example:

```yml
prezent_pushwoosh:
  application_id: XXXXX-XXXXX
  application_group_id: YYYYY-YYYYY
  api_key: xxxxxxxxxxxxxxxxxxxxx
  client_class: Gomoob\Pushwoosh\Client\Pushwoosh
  logging: 
    target: file
```