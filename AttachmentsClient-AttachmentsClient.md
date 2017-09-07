AttachmentsClient\AttachmentsClient
===============






* Class name: AttachmentsClient
* Namespace: AttachmentsClient







Methods
-------


### __construct

    mixed AttachmentsClient\AttachmentsClient::__construct(string $baseUrl)

Создаёт экземпляр клиента.



* Visibility: **public**


#### Arguments
* $baseUrl **string** - &lt;p&gt;Base URL сервера вложений&lt;/p&gt;



### uploadFromFile

    string AttachmentsClient\AttachmentsClient::uploadFromFile(string $filename)

Загружает файл с диска на сервер (по имени файла).

Возвращает ссылку на загрузку файла (с учётом baseUrl,
переданного в конструктор)
При ошибках выбрасывается исключение.

* Visibility: **public**


#### Arguments
* $filename **string** - &lt;p&gt;Путь к файлу&lt;/p&gt;



### uploadFromMemory

    string AttachmentsClient\AttachmentsClient::uploadFromMemory(string $data, string $name)

Загружает файл из памяти на сервер.

Возвращает ссылку на загрузку файла (с учётом baseUrl,
переданного в конструктор)
При ошибках выбрасывается исключение.

* Visibility: **public**


#### Arguments
* $data **string** - &lt;p&gt;Данные для загрузки&lt;/p&gt;
* $name **string** - &lt;p&gt;(необязательно) Имя файла, по умолчанию - file&lt;/p&gt;


