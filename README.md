# Cmever Log

用于内部服务记录日志，统一收口方便管理

## 安装方法

使用 composer 包管理工具，安装包管理工具请参考 [http://www.phpcomposer.com/](http://www.phpcomposer.com/)，安装好之后，在项目根路径下(含 `composer.json` )，执行如下指令进行安装

```shell
composer require cmever/log
```

## 快速上手

在安装好依赖包之后，通过如下三个步骤步即可向 ES 发送 Log

### 第一步：引入 composer 自动加载

如果没有使用基于composer的框架，则需要自行引入 `autoload.php` 文件

```php
use cmever\Log\ESLog;
// 1. load autoload.php
require(__DIR__.'/../vendor/autoload.php');
```

### 第二步：全局配置

```php
// 2. init config
ESLog::setGlobalConfig([
    'log_url' => 'http://logserver',
    'server_name' => 'demo',
]);
```

### 第三步：记录日志

```php
// 3. use ESLog to log info
$logger = new ESLog();
$res = $logger->info('test.info', 'log info demo', [
    'key' => [
        'key1' => 'sec'
    ]
]);
```

### 完整代码

```php
<?php
use cmever\Log\ESLog;
// 1. load autoload.php
require(__DIR__.'/../vendor/autoload.php');

// 2. init config
ESLog::setGlobalConfig([
    'log_url' => 'http://logserver',
    'server_name' => 'demo',
]);

// 3. use ESLog to log info
$logger = new ESLog();
$res = $logger->info('test.info', 'log info demo', [
    'key' => [
        'key1' => 'sec'
    ]
]);

// 4. please to check es server logs
if ($res) {
    echo "Log successfully";
} else {
    echo "Log error!";
}
```

## demos

提供的内置demo，可在对应文件夹找到并在命令行执行测试，比如：

```
$ php demos/simple_es_log.php
Log successfully
```

| 文件                    | 作用              |
| ----------------------- | ----------------- |
| demos/simple_es_log.php | ES Log 的简单调用 |

## Log内置方法

### debug/info/warning/error/fatal

##### 方法类型

成员方法

##### 作用

用于记录不同等级的日志，在对应字段中有所表现

##### 参数

| 参数名称  | 是否必填 | 默认值 | 作用                                   |
| --------- | -------- | ------ | -------------------------------------- |
| event     | 是       | ""     | 事件名称，可用于标记事件类型或访问路由 |
| message   | 否       | ""     | 日志内容                               |
| extraData | 否       | []     | 自定义数据，根据具体业务场景而定       |

##### 使用样例

```php
$logger = new ESLog();
$res = $logger->info('test.info', 'log info demo', [
    'key' => [
        'key1' => 'sec'
    ]
]);
```

### setGlobalConfig

##### 方法类型

静态方法

##### 作用

覆盖全局默认配置，详细配置参数见后文

##### 使用样例

```php
ESLog::setGlobalConfig([
    'log_url' => 'http://logserver',
    'app_type' => 'demo',
]);
```

### setConfig

##### 方法类型

成员方法

##### 作用

覆盖实例配置，详细配置参数见后文

##### 使用样例

```php
$logger = new ESLog();
$logger->setConfig([
    'log_url' => 'http://logserver',
    'server_name' => 'demo',
]);
```

## ESLog可配置参数

| 参数名称    | 必填 | 默认值                  | 作用                                                         |
| ----------- | ---- | ----------------------- | ------------------------------------------------------------ |
| log_url     | 是   |                         | 日志服务器可访问路径，如 https://xxx.xxx/                    |
| server_name | 否   | none                    | 区分不同应用                                                 |
| env         | 否   | APP_ENV                 | 区分测试/正式环境                                            |
| client_ip   | 否   | $_SERVER['REMOTE_ADDR'] | 客户端IP                                                     |
| server_ip   | 否   | $_SERVER['SERVER_ADDR'] | 服务器IP，用于区分同一个服务的多个服务器，便于调试及关联日志查找 |
| timeout     | 否   | 3                       | 请求超时时间，最小设为 0.1                                   |

