# Attachments PHP client

Эта библиотека предоставляет интерфейс на PHP для загрузки файлов на
сервер вложений.

Поддерживается загрузка файлов с диска и из памяти.

## Установка

Через Composer: создайте файл composer.json со следующим содержимым:
```
{
  "require": {
    "theowl/attachments-client": "dev-master"
  },
  "repositories": [
    {
      "type": "vcs",
      "url":  "<attachments-client-repo>"
    }
  ]
}
```

`<attachments-client-repo>` нужно заменить на адрес репозитория.
После этого выполнить:
```
$ composer install
```

## API

См. [сгенерированную документацию](ApiIndex.md).

Чтобы сгенерировать документацию (нужен phpdoc):
```
$ phpdoc -d src -t docs --visibility=public,protected --template=xml
$ vendor/bin/phpdocmd docs/structure.xml
```

## Пример использования:
```
<?php

require('vendor/autoload.php');

use AttachmentsClient\AttachmentsClient;

$client = new AttachmentsClient('http://localhost:8100');
echo($client->uploadFromFile('composer.json'));

?>
```
