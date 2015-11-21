Setup:


Install php

```
#!python

sudo apt-get install php5-cli

```
Install curl
```
#!python

sudo apt-get install curl
sudo apt-get install php5-curl

```
Install Composer
To install Composer on Linux or Mac OS X, execute the following two commands:
```
#!python

$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer

```

install symfony
```
#!python

sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
sudo chmod a+x /usr/local/bin/symfony
composer update

```


Running the Symfony Application

Then, open your browser and access the http://localhost:8000 URL to see the Welcome page of Symfony
```
#!python

$ cd my_project_name/
$ php app/console server:run
```
Install FORestBundle
http://symfony.com/doc/master/bundles/FOSRestBundle/1-setting_up_the_bundle.html
and serializer
http://jmsyst.com/bundles/JMSSerializerBundle
