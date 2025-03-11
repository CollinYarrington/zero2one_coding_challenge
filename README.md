
# zero2one_coding_challenge

This coding challenge required me to source movie related content from the OMDb API and create a watchlist with full CRUD capabilities.

### Tech stack:
- Laravel
- VueJs
- Inertia
## Setup Guide

#### Prerequisites:
- Node v23.0.0
- PHP v8.4
- NPM v10.9.0
---

### Step 1 - Install all dependencies:
Make sure you are in the cloned projects application root directory before continuing

- Run `npm install` (Installs all the node packages needed)
- Run `composer install` (Installs all the composer packages needed)

### Step 2 - Setup .env
Locate and copy the `.env.example` from the project root directory and paste in the same directory.  You can now rename the copied `.env.example` to `.env`. Now open `.env` and add the following:

- `OMDB_URL="http://www.omdbapi.com/"`
- `OMDB_KEY="e3e53afc"`

(You may also need to make adjustments to your database connection)

### Step 3 - Run the migration and seeders
- Run `php artisan migrate:fresh --seed`.  This will construct all the database tables needed for the project to run. The `--seed` will invoke the seeders listed in the  `DatabaseSeeder.php` to be seeded after the migration run successfully.

### Step 4 - Start the laravel application
Now we can start the application. Run the following:
- `php artisan serve` - This should serve the project on your local IP address `http://localhost:8080/`.

Now that your laravel project is running we need to compile the frontend to make use of things like TailwindCSS and VueJs. You can do this by running the following:
- `npm run dev` - This will begin compiling the code that is can be read easily by the browser.

Once you have both the frontend and backend running you can navigate to `http://localhost:8080/`.

If you are seeing a login screen you are done with the setup process 🎉🎉













## Seeded User Credentials For Testing

First test user:
- username/email address: `john@test.com`
- password: `zero2Hero@1`

Second test user:
- username/email address: `jane@test.com`
- password: `zero2Hero@1`