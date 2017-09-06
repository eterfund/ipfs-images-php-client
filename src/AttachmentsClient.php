<?php
namespace AttachmentsClient;


class AttachmentsClient {
  private $baseUrl;

  function __construct ($baseUrl) {
    $this->baseUrl = $this->ensureNotEndsWithSlash($baseUrl);
  }

  // *** Public API methods ***

  /**
   * Uploads a file to attachments server.
   * 
   * @param string $filename Path to file to be uploaded
   * 
   * @return string Hash of uploaded file
   */
  public function uploadFromFile ($filename) {
    $data = new \CurlFile($filename);
    return $this->uploadFromMemory($data);    
  }

  /**
   * Uploads data from memory to attachments server.
   * 
   * @param string $file File data to be uploaded, stored in memory
   * 
   * @return string Hash of uploaded file
   */
  public function uploadFromMemory ($data) {
    $url = $this->getFullMethodUrl('/ul');
    $result = $this->sendPostRequest($url, $data);

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

  private function sendPostRequest ($url, $data) {
    $fields = array(
      'file' => $data
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }
}

?>