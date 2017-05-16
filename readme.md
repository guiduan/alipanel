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

[Alipanel Demo](http://panel.31sky.net).


### License

>使用 Aliyun Panel 构建，或者基于 Aliyun Panel 源代码修改的站点 必须 在页脚加上 Powered by Aliyun Panel 字样，并且必须链接到 http://panel.31sky.net 上。必须 在页面的每一个标题上加上 Powered by Aliyun Panel 字样。

在遵守以上规则的情况下，你可以享受等同于 MIT 协议的授权。

或者你可以联系 webmaster@31sky.net 购买商业授权，商业授权允许移除页脚和标题的 Powered by Aliyun Panel 字样。
