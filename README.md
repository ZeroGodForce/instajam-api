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

Firstly, clone the repo, when done.  Open up the terminal, navigate inside and type the following to install the framework.

```sh
composer install
```

Once this has finished, duplicate the `.env.example` file - renaming it `.env`.

```sh
cp .env.example .env
```

Next, to set up the database file navigate to the database directory and create a new sqlite database

```sh
cd database
touch database.sqlite
```

Inside the `.env`, set the `DB_DATABASE` path to be the absolute path to the SQLite file:

```dotenv
DB_DATABASE=/absolute/path/to/instajam-api/database/database.sqlite
```

Back in the root directory, set up Laravel's security key: 

```sh
php artisan key:generate
``` 


**NOTE: Some steps may differ from here on in if you are not using Herd or Valet.**

Start the Laravel Herd desktop application (which runs largely in the top bar - it's the big **H** icon).  In the root directory run:

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
php artisan telescope:install
php artisan migrate
php artisan storage:link
``` 

You may also need to manually create a `photos` directory inside `storage/app/public`

```sh
cd storage/app/public
mkdir photos
``` 

To verify that the server is up and running, you should be able to visit `http://instajam-api.test/telescope` in your
browser and see the telescope interface running.  If you do, you should be ready to go.

### However...
If you plan to test the app on Android, you will need to take an additional step, which is to create a tunnel
using Expose or Ngrok make the server available over the internet.  

**NOTE: THIS ONLY NEEDS TO BE SETUP IF TESTING ON ANDROID. iOS TESTING DOES NOT REQUIRE THIS**

This is because, Android is completely isolated from
the host system - meaning, the only connection it can make to the localhost server is by using the IP 10.0.2.2.  
But because the server is not running on localhost (unless you are using Laravel Sail), you will need to tunnel out, and 
use Expose/Ngrok's **HTTPS** (NOT HTTP) url as the `API_URL` in the React Native app's `.env` file.

In this instance, I used Expose.  To create the tunnel go to https://expose.dev/register and register for an account if you don't have one already.  When signed in, it will present a list of steps.  Just copy the token from Step 2, and  open up Herd's settings in the Herd topbar menu. 

In the "Expose" section, paste the token in the text input and close the settings window.

Then, take the command listed in Step 4:

```sh
expose share http://localhost --subdomain=yourusername
```

And customise it to the address you use locally e.g.

```sh
expose share http://instajam-api.test --subdomain=yourusername
```

If configured correctly it will give out public links to be used.  Copy the HTTPS one and paste it into the React Native app's `.env` file.


## Known Issues
A number of things either uncompleted or problems that may be noticable:
- Form requests.  I have not put up any guards around the authorize method on form requests - this is simply due to time constraints.
- Data sanitisation.  While there isn't much data coming in, setting up sanitisers is a nontrivial process, and would be overkill for the current featureset
- User management: Using fortify to handle this might have been a better route than rolling my own.  However, Fortify can sometimes be difficult to work with in a hurry. Any re-implementation or refactoring of user related management, I'll likely take that route
- Protected photo routes.  For speed I had to serve all uploaded photos from the public folder, which means anyone with the URL can view.  Ideally this should be restricted by user and require a token, but it is fiddly to set up.  May do so later
- Token expiry.  It would be useful to set an expiry on tokens and have the expiry date updated each time the token is recieved so that tokens don't "have" to expire, but can if they are not used for a certain amount of time (e.g. 30 days)
