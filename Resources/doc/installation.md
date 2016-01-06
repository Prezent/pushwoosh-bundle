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
In the configuration file, you have to set the API key and either the application ID, or the application group ID. Optionally, you can set the client class that will be instantiated:

```yml
prezent_pushwoosh:
  application_id: XXXXX-XXXXX
  application_group_id: YYYYY-YYYYY
  api_key: xxxxxxxxxxxxxxxxxxxxx
  client_class: Gomoob\Pushwoosh\Client\Pushwoosh
```