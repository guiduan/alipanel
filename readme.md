## 如何使用
1、安装composer

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

2、拉取代码

    git clone https://github.com/guiduan/alipanel.git

3、安装依赖

    cd alipanel
    composer install

4、修改目录权限

    chmod 777 -R storage 
    chmod 777 -R vendor

5、修改.env配置文件(根据实际情况修改)

    mv .env.example .env
    vim .env

6、迁移数据

    php artisan migrate

7、生产key

    php artisan key:gen
    
8、优化

    php artisan config:cache
    php artisan route:cache
    php artisan optimize

## Nginx的优雅链接配置
    location / {
    try_files $uri $uri/ /index.php?$query_string;
    }

## Demo

[Alipanel Demo](http://laravel.com/docs).


### License

The Alipanel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
