## Laravel5 email authentication

This is an implementation of the work of Luca Bernardino at codeanchor.net.

There are a few changes, including the refactoring he talks about for
 AuthenticatesAndRegistersUsers.php, in this tutorial:
 http://www.codeanchor.net/blog/email-activation-laravel/ .
 
I've also added a 'resend activation email' option and made use of the Lang
class, so this can easily be ported to a new language.

To get up and running, after git cloning, first do (from the app root):

composer update

chmod -R 777 storage

cp .env.example .env

then make sure to set up your database values in .env:

DB_DATABASE=homestead

DB_USERNAME=homestead

DB_PASSWORD=secret

then run:

php artisan migrate


Then make sure your variables are set up in .env:

MAIL_DRIVER=smtp

MAIL_HOST=smtp.gmail.com

MAIL_PORT=465

MAIL_USERNAME=user@gmail.com

MAIL_PASSWORD=password

This should be fine if you've set up a gmail account to run with this.


Then sign up.

Don't worry if /home doesn't work before you have a single user.  It will
work after you have at least one.

