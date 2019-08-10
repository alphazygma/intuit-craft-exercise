# intuit-craft-exercise

## Requirements

Docker is installed in your system

## To Run

To get started, run the following commands

```
docker-compose build && docker-compose up -d && docker-compose logs -f
````

Once containers are up, run the following command to install composer libraries

```
./dockerComposer install
```

## Helper Scripts

* `./dockerArtisan` executes an `artisan` command inside the webapp container
* `./dockerComposer` executes an `composer` command inside the webapp container
* `./dockerContainer` gets inside the Web Container with the app
* `./dockerDB` gets inside the MySQL container and opens a mysql client
