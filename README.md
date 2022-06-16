## Supadusers - HTTP API/Frontend

This project is built in Laravel/Vue/Tailwind and assumes a general understanding of these.

For ease, a working version of the site is hosted here:

-   [http://supadusers.broakenmedia.co.uk](http://supadusers.broakenmedia.co.uk)

I have provided a basic Vue frontend which calls the most relevant endpoints. Documentation for calling the API routes directly can be found in the Postman collection found in this repo.

## Routes

    Route::get('/users', [UserController::class, 'index'])->name('users.index'); //Get all users

    Route::post('/users', [UserController::class, 'store'])->name('users.store'); //Create new user

    Route::get('/users/{userId}', [UserController::class, 'show'])->name('users.show'); //Get user

    Route::post('/users/{userId}', [UserController::class, 'update'])->name('users.update'); //Update user

    Route::delete('/users/{userId}', [UserController::class, 'destroy'])->name('users.destroy'); //Delete user

## Areas of interest

Here are some of the most interesting files/folders to help you hit the ground running:

    /routes/api.php
    /app/Http/Requests/
    /app/Http/Controllers/Api/V1/UserController.php
    /app/Models/User.php
    /app/Providers/ApiResponseProvider.php
    /tests/Feature/
    /resources/js/components/

## Useful commands

If you choose to host the project in your environment the following commands may be useful:

Run tests:

      php artisan test

Empty and re-seed database with 20 test users:

      php artisan db:seed
