<?php

namespace AttachmentsClient;

require('vendor/autoload.php');

use GuzzleHttp\Client;

class AttachmentsClient {
  private $baseUrl;
  private $client;

  function __construct ($baseUrl) {
    $this->baseUrl = $this->ensureNotEndsWithSlash($baseUrl);
    $this->client = new Client();
  }

  // *** Public API methods ***

  /**
   * Uploads a file from filesystem to attachments server.
   * 
   * @param string $filename Path to file to be uploaded
   * 
   * @return string Hash of uploaded file
   */
  public function uploadFromFile ($filename) {
    $data = file_get_contents($filename);
    return $this->uploadFromMemory($data, basename($filename));    
  }

  /**
   * Uploads data from memory to attachments server.
   * 
   * @param string $file File data to be uploaded, stored in memory
   * @param string $name (optional) Name of file to be passed to server
   * 
   * @return string Hash of uploaded file
   */
  public function uploadFromMemory ($data, $name = 'file') {
    $url = $this->getFullMethodUrl('/ul');
    $result = $this->sendPostRequestWithFile ($url, $data, $name);

    $json = json_decode($result, true);
    return $json['id'];
  }

  // *** End of public API methods ***

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

    echo $response->getBody();

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