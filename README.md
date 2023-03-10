<h1> Laravel Back End Interview Manual</h1>
## Guidelines to do the project's
There are several prerequisite apps/packages before making this project, such as: <br>
1. PHP                  : version that is used on this project is PHP 7.4.14 <br>
2. Composer (Laravel)   : version that is used on this project is Laravel Framework 8.35.1<br>
3. PostgreSQL           : version that is used on this project is postgres (PostgreSQL) 13.1 <br>

Next steps are:

1. Composer install or update
2. Open the project with a text editor Identify 
    .env.example on the root directory Copy .env.example and copy it to .env 
    Change the following fields in the .env 
    file:   DB_DATABASE=dbname 
            DB_USERNAME=dbuser 
            DB_PASSWORD=dbpassword
3. php artisan key:generate

Tasks to be done are:
1. Identify and fix the problems that exist in the project (Hint: Started from migration until seeder) <br>
    Note: You are not allowed to make a new migration/seeder file for the user / user type <br>
            ,the password in seeder is bcrypted goes by "dummydummy" <br>
            You must only use api.php for the "routing" <br>

2. Create Model for Customer and Controllers that support following features:
    - Login                                                                         *done
    - Logout                                                                        *done
    - Message to other Customer(s)                                                  *done
    - View own chat history                                                         *done
    - Can report other Customer(s) or own feedback/bug to Staff                     *done

3. Create Model for Staff and Controllers that support following features:
    - Login                                                                         *done
    - Logout                                                                        *done
    - View all chat history                                                         *done
    - View all Customer + deleted Customer                                          *done
    - Message to other Staff(s)                                                     *done
    - Message to other Customer(s)                                                  *done
    - Delete Customer(s)                                                            *done

4. Auth on each page or feature

5. You can create own Model and controllers to support point no 2 & 3, for example Model "Messages" to support Customer and Staff. <br>
    You must not use any other packages / vendors, only from the composer or auth related are allowed which means only Laravel, Passport and JWT only.

6. You are only tasked to work on the back-end side, so view is not important. Use postman for the documentation as for the testing you are allowed to use phpunittest or any php/Laravel testing.