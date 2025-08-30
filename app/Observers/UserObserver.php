<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
         // Fire the event after user is created
        event(new UserRegistered($user));

        // Example: after user registration
        SendWelcomeEmail::dispatch($user);


        $database = 'db_'.$user->name;
        
        DB::statement("CREATE DATABASE IF NOT EXISTS ".$database);

        // dd($database);

        Config::set('database.connections.myMysql',
        [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $database,//env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            // 'options' => extension_loaded('pdo_mysql') ? array_filter([
            //     PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            // ]) : [],
            'options' => [
                \PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            ],
        ]);

        if(!Schema::connection('myMysql')->hasTable("users")){

            Schema::connection('myMysql')->create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });

        }

        
        DB::connection('myMysql')->table('users')->insert([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);

        /*$file = "G:\\xampp\\htdocs\\demo\\sample.csv";

        DB::connection('myMysql')->statement("
            LOAD DATA LOCAL INFILE '" . addslashes($file) . "'
            INTO TABLE users
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (id, name, email)
        ");*/
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
