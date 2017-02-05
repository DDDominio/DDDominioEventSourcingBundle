DDDominioEventSourcingBundle
============================

DDDominioEventSourcingBundle integrates [DDDominio Event Sourcing](https://github.com/DDDominio/event-sourcing)
library into Symfony.

## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest development version of this bundle:

```console
$ composer require dddominio/event-sourcing-bundle "1.0@dev"
```


### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new DDDominio\EventSourcingBundle\DDDominioEventSourcingBundle(),
        );

        // ...
    }

    // ...
}
```

## Documentation

[Read the documentation](Resources/doc/index.rst)
