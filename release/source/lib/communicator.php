<?php

  global $scope;
    $scope->communicator = new T_EMPTY;

  $scope->communicator->error = function($msg)
  {
    $error = json_encode(array(
      'error' => $msg
    ));
    exit($error);
  };

  $scope->communicator->result = function($data)
  {
    exit(json_encode($data));
    /**
     * assume passed array of data

     $data = array(
     'time' => time()
     );

     =

     { 'data': DateTime }

     */
  };
