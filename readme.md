
## For front end

views 下面分对应的模块，每个模块下面包含
- base.blade 基础布局页面
- common_script.blade 各个子模块通用脚本
- common_style.blade 各个子模块通用样式表
- header.blade 模块头部布局 
- tpl.blade（可选） 模块组件模板

模块下面的子页面，如admin模块下面的user页面，可以定义为user.blade，具体可以参考views/admin/user.blade.php

- @extends('xxx') 基础布局，引用对应的base.blade
- @section('app') 对应base.blade里面的@yield('xxx')
- @push('moduleStyles') 子页面特定所需的样式表
- @push('moduleScripts') 子页面特定所需的Js脚本


## 服务器部署
假设域名为：test.com，代码部署在/var/www/test/；

1.配置.env
APP_DEBUG=false
APP_URL=http://test.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xxx
DB_USERNAME=xxx
DB_PASSWORD=xxx

CACHE_DRIVER=redis
QUEUE_DRIVER=redis

2.用户权限
a、修改文件夹权限
chown -R www:www storage

b、修改nginx和php-fpm执行用户为www

3.nginx
server {
    listen       80;
    server_name  test.com;

    charset utf8;

    #access_log  logs/host.access.log  main;

    index index.html index.htm index.php;

    root /var/www/test/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log /var/log/nginx/jcapp-access.log;
    error_log  /var/log/nginx/jcapp-error.log error;

    sendfile off;

    client_max_body_size 100m;
    client_body_timeout  300;

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
    location ~ \.php$ {
        fastcgi_pass   unix:/run/php/php7.2-fpm.sock;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
        #include        fastcgi_params;
        include        fastcgi.conf;
    }

    # deny access to .htaccess files, if Apache's document root
    location ~ /\.git {
        deny  all;
    }
}

3.限制文件上传大小(可选)
编辑php.ini
    upload_max_filesize 100M
    post_max_size       100M
    max_execution_time  300

4.配置supervisor(可选) -- 队列
[program:freya-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/test/artisan queue:work --tries=3 --daemon --queue --timeout=300
autostart=true
autorestart=true
user=www
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/test/storage/logs/supervisor.log

5.配置定时器(可选)  crontab -e -u www
* * * * * php /var/www/test/artisan schedule:run >> /dev/null 2>&1

6.生成env的key
php artisan key:generate

7.迁移数据库
php artisan migrate

## install
composer install
php artisan migrate
php artisan tinker => User::add('freya@test.com', 'test123', RAW_STRING, 1);




