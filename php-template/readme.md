
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

/**
 * 钩子函数
 * 
 * do_action 创建一个钩子，将执行对应key的所有函数
 * add_action 往key上挂载一个函数
 * remove_action 卸载key对应的函数，若不添加Function参数，将卸载对应key的所有函数
 * **/
do_action('key', ...args);
add_action('key', Function);
remove_action('key', Function);
```

### 配置
```php
$config = array(
    'route-mode' => 'pretty',   // pretty | ugly  不支持伪静态时，需修改为ugly，他会自动替你转换a标签的href
    'build-css'  => 1,          // 自动生成css，开发时如需要可以打开，上传FTP时需关闭
);
```

### 使用须知

1. 引入php模板必须使用load_tmpl函数加载
2. a标签写站内链接时不可使用 './'或'/'，应使用@符号或bloginfo('template_url')
```html
<a href="@/home.php"></a>
or
<a href="<?php bloginfo('template_url') ?>/home.php"></a>
```


