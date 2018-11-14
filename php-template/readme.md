
### 全局函数
```php

/**
 * $name 为空则加载目录下的header.php
 * 有值则加载目录下的header-$name.php
 * **/
get_header($name);
get_footer($name);

/**
 * bloginfo打印当前项目路径，不含文件名
 * get_bloginfo返回当前项目路径，不含文件名
 * **/
bloginfo('template_url');
get_bloginfo('template_url');

/**
 * 封装的require函数，引入文件时需使用load_temp函数
 * **/
load_temp('components/share.php');
```

### 配置
```
route_mode
路由模式，参数有'pretty'和'ugly'，服务器支持伪静态的情况下可以使用pretty模式，不支持时需改为ugly模式。

```

### 使用须知

1. 引入php模板必须使用load_temp函数加载
2. a标签写链接时必须使用bloginfo('template_url')，不可使用 './'或'/'


