<?php

  class T_EMPTY
  {
    public function __call($method, $args)
    {
      if (isset($this->$method) && is_callable($this->$method)) {
        return call_user_func_array($this->$method, $args);
      }
    }
  }

  $scope = new T_EMPTY;
    // #	instantiate global scope

  $scope->config = (object) array(
    'path' => $_SERVER['DOCUMENT_ROOT']
  );

  set_include_path( $scope->config->path );

  $scope->inject = function($rsc)
  {
    global $scope;

      $rel = $scope->config->path;

    if (is_array($rsc) && count($rsc) >= 1):
      foreach ($rsc as $r):
        require_once($rel . '/source/lib/' . $r . '.php');
      endforeach;
    else:
      require_once($rel . '/source/lib/' . $rsc . '.php');
    endif;
  };
