### Installation

``` 
    git clone https://github.com/grandblue1/demoblog.git
    cd demoblog
    
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    
   ./vendor/bin/sail up -d
   ./vendor/bin/sail root-shell
```
# Configuration
### Specify permissions for storage folder : ``` chmod o+w -R storage ``` 
#### Generate Api Key : ``` php artisan  key:generate ```
###  Install dependencies : ```composer install && composer update && npm i ``` 
#### Change Host Your Database to  ```  mysql  ```
### Run Migration ``` php artisan migrate  ```
