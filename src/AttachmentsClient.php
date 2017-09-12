<?php

namespace AttachmentsClient;

require('vendor/autoload.php');

use GuzzleHttp\Client;

class AttachmentsClient {
  private $baseUrl;
  private $client;

  /**
   * Создаёт экземпляр клиента.
   * 
   * @param string $baseUrl Base URL сервера вложений
   */
  function __construct ($baseUrl) {
    $this->baseUrl = $this->ensureNotEndsWithSlash($baseUrl);
    $this->client = new Client();
  }

  // *** Public API methods ***

  /**
   * Возвращает URL для скачивания файла по его хэшу и имени.
   * 
   * @param string $hash Хэш файла, полученный от метода загрузки.
   * @param string $name (необязательно) Имя файла, по умолчанию - file
   * 
   * @return string
   */
  public function getDownloadUrl ($hash, $name) {
    return $this->baseUrl . '/dl/' . $hash . '/' . $name;
  }

  /**
   * Загружает файл с диска на сервер (по имени файла).
   * Возвращает хэш загруженного файла.
   * При ошибках выбрасывается исключение.
   * 
   * @param string $filename Путь к файлу
   * 
   * @return string
   */
  public function uploadFromFile ($filename) {
    $stream = fopen($filename, 'rb');
    if (!$stream) {
      throw new Exception("Failed to open $filename");
    }
    return $this->uploadFromMemory($stream, basename($filename));
  }

  /**
   * Загружает файл из памяти на сервер.
   * Возвращает хэш загруженного файла.
   * При ошибках выбрасывается исключение.
   * 
   * @param mixed $data Данные для загрузки - строка (string) или поток (stream)
   * @param string $name (необязательно) Имя файла, по умолчанию - file
   * 
   * @return string
   */
  public function uploadFromMemory ($data, $name = 'file') {
    $url = $this->getUploadUrl();
    $result = $this->sendPostRequestWithFile ($url, $data, $name);

    $json = json_decode($result, true);
    return $json['id'];
  }

  // *** End of public API methods ***

  /**
   * Возвращает URL для заливки (upload) файла. Вынесено в отдельный
   * protected-метод, чтобы можно было переопределить это в субклассе,
   * на случай если сервер использует нестандартное название для
   * метода загрузки.
   * 
   * @return string
   */
  protected function getUploadUrl () {
    return $this->getFullMethodUrl('/ul');
  }

  private function ensureNotEndsWithSlash ($url) {
    return rtrim($url, '/');
  }

  private function getFullMethodUrl ($method) {
    return $this->baseUrl . $method;
  }

  private function sendPostRequestWithFile ($url, $file, $name) {
    $response = $this->client->request('POST', $url, [
      'multipart' => [
        [
          'name'     => 'file',
          'contents' => $file,
          'filename' => $name
        ]
      ]
    ]);

    if ($response->getStatusCode() !== 200) {
      $message =
        'File uploading failed: server returned ' . 
        $response->getStatusCode() .
        ' and body: ' .
        $response->getBody();
      throw new Exception($message);
    }

    return $response->getBody();
  }
}

?>