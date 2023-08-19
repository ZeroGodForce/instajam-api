# InstaJAM API

## Introduction
This is a backend API for a demo app that (more or less) is Instagram from scratch.

It's built using Laravel.  There are very few frontend views.  Visiting the webroot will just show Laravel's default
front page.  However, Laravel Telescope is installed and can be visited at `/telescope`.  Authentication is handled using
Sanctum to manage tokens, and some basic user registration boilerplate inspired by Laravel Breeze's source code. 
Note that this API must be up and running before attempting to run the mobile app as it's expecting to be able to talk 
to the server

The basic functional overview consists of:
- User registration and login
- Image upload and metadata storage
- Data stored in SQLite database (located in `/database/database.sqlite`)

## Installation
The quickest way to get this API running (on a Mac at least) is to download and install (Laravel Herd)[https://herd.laravel.com]
However if you would prefer to use Valet or Sail that should be fine too (though note that I have not tested either 
directly) as there are no special modifications to be made to allow the application to run.

If you're on Linux, you'll probably know what to do.  If you're on Windows, Sail is your best bet as I hear docker is 
pretty decent on Windows these days.  Haven't tried it directly.

Firstly, clone the repo, when done.  Open up the terminal, navigate inside and type the following

```sh
composer install
```

To install the framework, Once this has finished, duplicate the `.env.example` file - renaming it `.env`.
Next, to set up the database file navigate to the database directory and create a new sqlite database

```sh
cd database
touch database.sqlite
```

Inside the `.env`, set the `DB_DATABASE` path to be the absolute path to the SQLite file:

```dotenv
DB_DATABASE=/absolute/path/to/instajam-api/database/database.sqlite
```

Next run: 

```sh
php artisan key:generate
``` 

to ensure the Laravel security key is set.

NOTE: Some steps may differ from here on in if you are not using Herd or Valet.

```sh
herd link # OR valet link if you're using Valet
``` 
This will allow the server to be served up at the local url `http://instajam-api.test`. (or something
similar based on the folder name chosen when cloning the repo).  You should add this to your `.env` file

```dotenv
APP_URL=http://instajam-api.test
```

Finally you can run:
```sh
php artisan migrate
php artisan telescope:install
php artisan storage:link
``` 
You may also need to manually create a `photos` directory inside `/storage/app/public`
```sh
cd /storage/app/public
mkdir photos
``` 

To verify that the server is up and running, you should be able to visit `http://instajam-api.test/telescope` in your
browser and see the telescope interface running.  If you do, you should be ready to go.

### However...
If you plan to test the app on android, you will need to take an additional step, which is to create a tunnel
using Expose or Ngrok make the server available over the internet.  This is because, android is completely isolated from
the host system - meaning, the only connection it can make to the localhost server is by using the IP 10.0.2.2.  
But because the server is not running on localhost (unless you are using Sail), you will need to tunnel out, and 
use Expose/Ngrok's HTTPS (NOT HTTP) url as the API_URL in the React Native app's `.env` file. 


## Known Issues
A number of things either uncompleted or problems that may be noticable:
- Form requests.  I have not put up any guards around the authorize method on form requests - this is simply due to time constraints.
- Data sanitisation.  While there isn't much data coming in, setting up sanitisers is a nontrivial process, and would be overkill for the current featureset
- 
- 
