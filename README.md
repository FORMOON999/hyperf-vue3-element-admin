# hyperf-vue3-element-admin
hyperf admin

> 基于 php8.0 hyperf3.1 的后端服务

# 如何使用

## 管理台
前端 问题请移驾到 [vue3-element-admin](https://github.com/youlaitech/vue3-element-admin)

## 代码初始化
```php
    git clone https://github.com/FORMOON999/hyperf-vue3-element-admin.git
    cd server 
    composer install
    php bin/hyperf.php migrate
    php bin/hyperf.php start

    cd ../web
    pnpm install 
    npm dev
```

## 基于表 代码代码生成， 记得重启服务

```php
    bin/hyperf.php gen:code             // 所有的表
    bin/hyperf.php gen:code -t t_user  // 单表
```