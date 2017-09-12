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

## Пример использования
Создайте PHP-скрипт (например, `index.php`):
```
<?php

require('vendor/autoload.php');

use AttachmentsClient\AttachmentsClient;

$client = new AttachmentsClient('http://img.azbyka.ru');
echo "Trying file upload:\n";
echo $client->uploadFromFile(__FILE__);
echo "\n\n";

$file = file_get_contents(__FILE__);
echo "Trying memory upload:\n";
$hash = $client->uploadFromMemory($file);
echo $hash . "\n\n";

$url = $client->getDownloadUrl($hash, basename(__FILE__));
echo "Download URL: $url\n";
?>
```

Этот скрипт загружает в хранилище сам себя двумя способами:
из файла потоком и из памяти, после чего выводит URL для скачивания.
Запустить его можно в командной строке:
```
$ php index.php
```

Для изображений сервер создаёт миниатюры, их URL можно получить так:
```
$thumbUrl = $client->getThumbnailUrl(
  $hash, // хэш изображения, полученные от метода заливки
  128    // желаемый размер миниатюры
);
```
