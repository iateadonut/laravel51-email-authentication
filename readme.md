## Laravel5 email authentication

This is an implementation of the work of Luca Bernardino at codeanchor.net.

There are just a few tiny changes, including the refactoring he talks about for AuthenticatesAndRegistersUsers.php, in this tutorial: http://www.codeanchor.net/blog/email-activation-laravel/ .

To get up and running, first, of course, do:
composer update

Then make sure your variables are set up in .env:
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=user@gmail.com
MAIL_PASSWORD=password
This should be fine if you've set up a gmail account to run with this.

Update your database values, too, of course.

