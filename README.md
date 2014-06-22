videome
=======

A simple web application to record videos

INSTALLATION
=======

Please make sure you run composer install/update to require all dependencies before launching web application.

Please make sure videome/app/protected/runtime is a directory writable by the Web server process.
Please make sure videome/app/protected/assets is a directory writable by the Web server process.

To run the application, please make sure the Web-accessible directory videome/app/index.php is set up in a virtual host.
sample vhost:
<VirtualHost *:80>
        DocumentRoot <path to application>/videome/app
        ServerAlias local.videome.com
        CustomLog   videome_log combined
        <Directory "<path to application>/videome/app">
                Options Indexes MultiViews FollowSymLinks
                AllowOverride All
                Order allow,deny
                Allow from all
        </Directory>
</VirtualHost>