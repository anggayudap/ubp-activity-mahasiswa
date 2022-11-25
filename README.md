# SIMKATMAWA UBP KARAWANG

## Installation
 

Clone the repository

    git clone https://github.com/anggayudap/ubp-activity-mahasiswa.git

Switch to the repo folder

    cd ubp-activity-mahasiswa

Install all the dependencies using composer

    composer install

Install all the JS dependencies using npm

    npm install

Then compile it

    npm run dev

Copy the example env file and make the required configuration changes in the .env file. Then setup your DB configuration inside.

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

--------====================== DONE ======================--------
