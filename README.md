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

resize image
- php5-gd (current)
- php5-imagick (optional)

naming convention standard:
- in layout only use the following pattern
  - <prefix>-row e.g. album-row
    - any sub-layout inside should inherit its parent prefix and could also its own prefix `<parent prefix>-<sub-layout's prefix>-row` e.g. album-control-row
  - <prefix>-col e.g. album-col
    - any sub-layout inside is same as row
  - <prefix>-container for those divs that could wrap multiple other sub-layouts such as body e.g. body-container
  - <prefix>-box for the those divs that only wrap one single element such as chat message, e.g. chat-message-box
  - technique to align div vertically or horizontally should always be unified.

translation:
  - The error responses returned by all services will be structured as following
    - error without message placeholder:
    ```
    {
        "error": "errors.denny.delete.photo",
        "code": 400
    }
    ```
    - error with message placeholder (parameter passed by front-end, in this case front-end knows what parameters have been passed in)
    ```
    {
        "error": "errors.notFound.photoId",
        "code": 400
    }
    ```
    - error with message placeholder (parameter passed by back-end services themselves, in this case front-end doesn't know what message placeholders will be so translation code will be followed by key-value pairs ):
    ```
    {
        "error": "errors.notFound.photoId|[<placeholder-name1>:<value1>[, <placeholder-name2>:<value2>]]",
        "code": 400
    }
    ```
permission:
  - uploads/media, app/cache and app/logs
  ```
  sudo setfacl -R -m u:"www-data":rwX -m u:whoami:rwX web/uploads/media app/cache app/logs
  sudo setfacl -dR -m u:"www-data":rwX -m u:'whoami':rwX web/uploads/media app/cache app/logs
  ```
plugins:
  - form-validation: https://github.com/victorjonsson/jQuery-Form-Validator
disable responsive in boostrap:
  - http://getbootstrap.com/getting-started/#disable-responsive

note:
  - the space to store images will be about 18.75% bigger than its original because of thumbnails related to it

