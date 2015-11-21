<h1>Setup:</h1>


<h3>Install php</h3>

```
#!python

sudo apt-get install php5-cli

```
<h3>Install curl</h3>
```
#!python

sudo apt-get install curl
sudo apt-get install php5-curl

```
<h3>Install Composer</h3>
To install Composer on Linux or Mac OS X, execute the following two commands:
```
#!python

$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer

```

<h3>nstall symfony</h3>
```
#!python

sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
sudo chmod a+x /usr/local/bin/symfony
composer update

```


<h1>Running the Symfony Application</h1>

Then, open your browser and access the http://localhost:8000 URL to see the Welcome page of Symfony
```
#!python

$ cd my_project_name/
$ php app/console server:run
```
