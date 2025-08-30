# Laravel 12 Observer, Provider, Event, Listener, Job , Scheduler

# Laravel setup cmd
# composer create-project laravel/laravel laravel-12
# composer require laravel/breeze --dev
# php artisan breeze:install


# If you clone then need run cmd
# composer update
# npm install && npm run dev
# php artisan migrate
# php artisan key:generate
# php artisan storage:link


# Observer
# php artisan make:observer UserObserver --model=User
# Register in provider boot: User::observe(UserObserver::class); and create new DB with user name

# Provider
# php artisan make:provider StripeServiceProvider

# Event
# php artisan make:event UserRegistered

# Listener
# php artisan make:listener SendWelcomeEmail --event=UserRegistered
# php artisan event:cache

# Job
# In .env QUEUE_CONNECTION=database
# php artisan make:job SendWelcomeEmail
# php artisan queue:table
# php artisan queue:work



