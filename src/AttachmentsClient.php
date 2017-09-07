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
   * Загружает файл с диска на сервер (по имени файла).
   * Возвращает ссылку на загрузку файла (с учётом baseUrl,
   * переданного в конструктор)
   * При ошибках выбрасывается исключение.
   * 
   * @param string $filename Путь к файлу
   * 
   * @return string
   */
  public function uploadFromFile ($filename) {
    $data = file_get_contents($filename);
    return $this->uploadFromMemory($data, basename($filename));    
  }

  /**
   * Загружает файл из памяти на сервер.
   * Возвращает ссылку на загрузку файла (с учётом baseUrl,
   * переданного в конструктор)
   * При ошибках выбрасывается исключение.
   * 
   * @param string $data Данные для загрузки
   * @param string $name (необязательно) Имя файла, по умолчанию - file
   * 
   * @return string
   */
  public function uploadFromMemory ($data, $name = 'file') {
    $url = $this->getFullMethodUrl('/ul');
    $result = $this->sendPostRequestWithFile ($url, $data, $name);

    $json = json_decode($result, true);
    return $this->getDownloadUrl($json['id'], $json['filename']);
  }

  // *** End of public API methods ***

  private function ensureNotEndsWithSlash ($url) {
    return rtrim($url, '/');
  }

  private function getDownloadUrl ($hash, $name) {
    return $this->baseUrl . '/dl/' . $hash . '/' . $name;
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