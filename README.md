ConfigurationBundle
===================

A bundle which allow you to easily store you application configuration.

#Install
--------

## composer.json
    {
        "require": {
            "openify/configuration-bundle": "dev-master"
        },
    }

## app/appKernel.php

```php
        $bundles = array(
            // [...]
            Openify\Bundle\ConfigurationBundle\OpenifyConfigurationBundle(),
        );
```

## app/config/config.yml

Custom table prefix:
```yaml
parameters:
    openify.configuration.table_prefix:  page_
```

#Usage
------

1. **In a controller**

    ```php
	$sitename = $this->container->get('openify.configuration')->get('site_name', 'default_value');
    ```

2. **In a view**
   
    ```twig
	{{ openify_configuration.get('site_name', 'default_value') }}
    ```

3. **Use with namespace**

    ```php
	$sitename = $this->container->get('openify.configuration')->get('site_name', 'default_value', 'namespace');
    ```

    ```twig
	{{ openify_configuration.get('site_name', 'default_value', 'namespace') }}
    ```
