IpfsImagesClient\IpfsImagesClient
===============






* Class name: IpfsImagesClient
* Namespace: IpfsImagesClient







Methods
-------


### __construct

    mixed IpfsImagesClient\IpfsImagesClient::__construct(string $baseUrl)

Создаёт экземпляр клиента.



* Visibility: **public**


#### Arguments
* $baseUrl **string** - &lt;p&gt;Base URL сервера вложений&lt;/p&gt;



### getDownloadUrl

    string IpfsImagesClient\IpfsImagesClient::getDownloadUrl(string $hash, string $name)

Возвращает URL для скачивания файла по его хэшу и имени.



* Visibility: **public**


#### Arguments
* $hash **string** - &lt;p&gt;Хэш файла, полученный от метода загрузки.&lt;/p&gt;
* $name **string** - &lt;p&gt;(необязательно) Имя файла, по умолчанию - file&lt;/p&gt;



### getThumbnailUrl

    string IpfsImagesClient\IpfsImagesClient::getThumbnailUrl(string $hash, $name)

Возвращает URL для миниатюры (thumbnail) изображения.



* Visibility: **public**


#### Arguments
* $hash **string** - &lt;p&gt;Хэш файла, полученный от метода загрузки.&lt;/p&gt;
* $name **mixed**



### uploadFromFile

    string IpfsImagesClient\IpfsImagesClient::uploadFromFile(string $filename)

Загружает файл с диска на сервер (по имени файла).

Возвращает хэш загруженного файла.
При ошибках выбрасывается исключение.

* Visibility: **public**


#### Arguments
* $filename **string** - &lt;p&gt;Путь к файлу&lt;/p&gt;



### uploadFromMemory

    string IpfsImagesClient\IpfsImagesClient::uploadFromMemory(mixed $data, string $name)

Загружает файл из памяти на сервер.

Возвращает хэш загруженного файла.
При ошибках выбрасывается исключение.

* Visibility: **public**


#### Arguments
* $data **mixed** - &lt;p&gt;Данные для загрузки - строка (string) или поток (stream)&lt;/p&gt;
* $name **string** - &lt;p&gt;(необязательно) Имя файла, по умолчанию - file&lt;/p&gt;



### getUploadUrl

    string IpfsImagesClient\IpfsImagesClient::getUploadUrl()

Возвращает URL для заливки (upload) файла. Вынесено в отдельный
protected-метод, чтобы можно было переопределить это в субклассе,
на случай если сервер использует нестандартное название для
метода загрузки.



* Visibility: **protected**



