# PassportLaravel

A brief description of what this project does and who it's for \
Step 1: composer require laravel/passport
\
Step 2: php artisan migrate

step 3: php artisan passport:install

step 4: php artisan make:seeder InterestSeeder if already exists then avoid

step 5: php artisan db:seed --class=InterestSeeder

step 6: in AuthServiceProvider 
use Laravel\Passport\Passport;

uncomment  protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

write in boot function Passport::routes();

step 7: in config.auth.php
   write in guards array  after web sub arrqay
      'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],

step 7: In User model : we added 
 use Laravel\Passport\HasApiTokens trait
 & used in User Model class
 Note: comment use Laravel\sanctum\HasApiTokens;

 step 8: php artisan serve 

 then use route
 1: http://127.0.0.1:8000/api/register to register user to sign up user must be 12+
 Body: {
    "first_name":"Ali",
    "last_name":"khan",
    "address":"Karachi",
    "email" : "de@mail.com",
    "dob" : "24-04-2010",
    "password":"12345678",
    "interests" : [1,2,3,90] // interest_id multiple
}

2: http://127.0.0.1:8000/api/login to login

{
     "email" : "a@mail.com",
    "password":"12345678"
}
it returns access token

3: to access protected routes use bearer token 
    in Authorization tab select bearer token
    pass access token after login other wise
    it will response as Unauthenticated

    set header Accept: application/json

