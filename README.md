DaApiServerBundle
=================

DaApiServerBundle is a Symfony2's bundle allowing to provide a REST API in a simple and secure way.

Installation
------------

Installation is a quick 2 steps process.

### Step 1: Add in composer

Add the bundle in the composer.json file:

``` js
// composer.json

"require": {
    // ...
    "da/auth-common-bundle": "dev-master",
    "da/api-server-bundle": "dev-master"
},
```

And update your vendors:

``` bash
composer update      # WIN
composer.phar update # LINUX
```

### Step 2: Declare in the kernel

Declare the bundle in your kernel:

``` php
// app/AppKernel.php

$bundles = array(
    // ...
    new Da\AuthCommonBundle\DaAuthCommonBundle(),
    new Da\ApiServerBundle\DaApiServerBundle(),
);
```

Check the client API key
------------------------

If you want to check the API token of a client of your API for a route pattern, you must specify it in your security.yml:

``` yaml
# app/config/security.yml
security:
    firewalls:
    	#...

        api:
            pattern:   ^/api
            da_api:    true
            stateless: true
```

The URLs under `/api` will authenticate a client of your API with the API token send with the request.
For the time being, the API token must be send in the HTTP header "X-API-Security-Token".

Check a given oauth token
-------------------------

If you want to check an oauth token given in the `Authorization` header of the request (Bearer token), you can specify it like this:

``` yaml
# app/config/security.yml
security:
    firewalls:
        #...

        api_user:
            pattern:   ^/api/user
            da_oauth:  true
            stateless: true
```

Remote checking
---------------

If your API is not at the same place as your SSO server (with oauth, ...), just follow these step:

Add the bundle in the composer.json file:

``` js
// composer.json

"require": {
    // ...
    "da/api-client-bundle": "dev-master"
},
```

And update your vendors:

``` bash
composer update      # WIN
composer.phar update # LINUX
```

Then, set the config:

``` yaml
# app/config/config.yml

# DaApiClient Configuration
da_api_client:
    api:
        sso_user:
            endpoint_root:  %api.sso.endpoint_root%
            security_token: %api.sso.security_token%
            client:
                service: da_api_server.user_manager.http
        sso_client:
            endpoint_root:  %api.sso.endpoint_root%
            security_token: %api.sso.security_token%
            client:
                service: da_api_server.client_manager.http

# DaApiServer Configuration
da_api_server:
    user_manager: da_api_client.api.sso_user
    client_manager: da_api_client.api.sso_client
```

Finally, set the corresponding parameters:

``` yaml
# app/config/parameters.yml and app/config/parameters.yml.dist

parameters:
    # ...
    api.sso.endpoint_root: 'http://my-domain.com/api'
    api.sso.security_token: 3jgwm1izbse884cwskk00c0o4ww8kg08gsgc4o808gsssw4
```

Documentation
-------------

This bundle have some other features that can help you to develop a REST API documented [here](https://github.com/Gnuckorg/DaApiServerBundle/blob/master/Resources/doc/index.md).

What about the API client side?
-------------------------------

Take a look at the [DaApiClientBundle](https://github.com/Gnuckorg/DaApiClientBundle)!