How to init project ...

We need a mySQL-DB for that: Create one on your server. Then modify `.env.example`: Copy to `.env` and insert mysql credentials.

Backend part:

    1. composer update
    
    2. php artisan migrate --seed
    
    3. php artisan passport:install
    
    4. php artisan key:generate
    
    5. php artisan serve (test in localhost)

Frontend part:

    1. cd resources/app
    
    2. npm install
    
    3. npm run build
    
    4. npm run dev (test in localhost)
