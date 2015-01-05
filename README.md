ubuntu:
 - sudo a2enmod rewrite
 - sudo service apache2 reload
 - sudo service apache2 restart
 - get rid of app.php|app_dev.php
 ```
   <VirtualHost *:80>
       ServerName my-repository
       DocumentRoot /home/jerry/Project/MyRepository/web/

       <Directory /home/jerry/Project/MyRepository/web/>
          DirectoryIndex app_dev.php
          #DirectoryIndex app.php

          AllowOverride None
          Require all granted

          <IfModule mod_rewrite.c>
              RewriteEngine On
              RewriteCond %{REQUEST_FILENAME} !-f
              # Replace END flag with L flag if apache version is less than 2.4
              RewriteRule ^(.*)$ app_dev.php [QSA,END]
              #RewriteRule ^(.*)$ app.php [QSA,END]
          </IfModule>
       </Directory>
   </VirtualHost>
```
elasticsearch requires:
 - php5-curl

