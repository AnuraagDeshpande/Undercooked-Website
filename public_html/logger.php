<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // For debugging only; set to 0 in production
ini_set('log_errors', 1); // Ensure PHP logs errors internally
  //
  function logData($type, $data) {
    $file = $type === 'error' ? 'error.json' : 'request.json';
    //__DIR__ locks the filepath to the current file
    $filePath = __DIR__ . '/' . $file;

    $handle = fopen($filePath, 'a');

    if ($handle) {
      //Writes till end of line and encodes to json// EOL -> End Of Line
      fwrite($handle, json_encode($data) . PHP_EOL);
      fclose($handle);
    }
  }

  //Grabs user data upon request
  function logRequest (){
    $data = [
      'ip' => $_SERVER ['REMOTE_ADDR'] ?? 'N/A',
      'user' => $_SESSION ['user_id'] ?? 'notLoggedIn',
      'time' => date('Y-m-d H:i:s'),
      'browser' => $_SERVER ['HTTP_USER_AGENT'] ?? 'N/A',
      'page' => $_SERVER['REQUEST_URI'] ?? 'N/A'
    ];
    logData ('request', $data);
  }
  //grabs user data and error message upon error
  function logError ($errorMessage) {
    $data = [
      'ip' => $_SERVER ['REMOTE_ADDR'] ?? 'N/A',
      'user' => $_SESSION ['name'] ?? 'notLoggedIn',
      'time' => date('Y-m-d H:i:s'),
      'browser' => $_SERVER ['HTTP_USER_AGENT'] ?? 'N/A',
      'error' => $errorMessage,
      'page' => $_SERVER['REQUEST_URI'] ?? 'N/A'
    ];
    logData('error', $data);
  }
  //describes the custom way we handle errors (put them in a text file)
  function errorHandler ($errno, $errString, $errFile, $errLine) {
    $errMessage = "Error [$errno] $errString in $errFile on line $errLine";
    logError($errMessage);
  }
  function exceptionHandler($exception) {
    $errMessage = "Uncaught Exception: " . $exception->getMessage() .
                  " in " . $exception->getFile() .
                  " on line " . $exception->getLine();
    logError($errMessage);
}
  //invokes the errorHandler when an error is found
  set_error_handler ('errorHandler');
  set_exception_handler('exceptionHandler');

  logRequest();