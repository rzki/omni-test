
# Omni Hotelier Assessment Test

This Laravel project is intended to be assessment test for PT. Omni Hotelier Internasional.

## Installation

1. run `composer install` to install required composer package
2. run `npm install && npm run dev` to install required node_modules and run the Vite development with Hot Reload
3. copy the `.env` by running `cp .env.example .env`
4. run `php artisan key:generate` to generate `APP_KEY` in `.env`
5. create the database `omni_test` and change the username and password according to your database credentials
6. run `php artisan migrate:fresh` to migrate database
7. run `php artisan serve --port=8000` to run the project
8. done!
9. check route list by running `php artisan route:list` to test both Web & API routes

### Note
- To test the API routes, please check `api_token` field inside `users` table and copy the token to the Authorization header of the user that trying to login (don't forget to select Bearer type for the Auth token). After that you're good to go to test API routes.

- To test Email Verification, please test using the Web version of the project. After register, login using credentials you've registered before and click on `click here to request another` link. Don't forget to run `php artisan queue:work` before clicking the link.

- To test the add 100 users API request, use `POST` method on `api/add-multiple-user` endpoint.

