<?php

  require_once( '../source/inc.php' );

  $rel = $scope->config->path;

  $ct = $_GET['content'];
  if( $ct ):
    switch( $ct ):
      case 'styles': case 'css':
        $sources = (array) json_decode(file_get_contents( $rel . '/cdm/resources/styles.json', FILE_USE_INCLUDE_PATH));
          $buffer  = '';
          foreach ($sources as $name => $dist) {
            if (!$dist->enabled):
              continue;
            else:
              foreach ($dist->list as $r):
                if (!$r->enabled):
                  continue;
                else:
                  if ($dist->local):
                    $buffer .= file_get_contents($rel . $r->source, FILE_USE_INCLUDE_PATH);
                  else:
                    $buffer .= file_get_contents($r->source);
                  endif;
                endif;
              endforeach;
            endif;
          }
          header('Content-Type: text/css');
          require_once('dependencies/cssmin.php');
          $minified = CssMin::minify( $buffer );
          exit( $minified );
      break;
      case 'scripts': case 'js': case 'javascript':
        $sources = (array) json_decode(file_get_contents( $rel . '/cdm/resources/scripts.json', FILE_USE_INCLUDE_PATH));
          $buffer  = '';
          foreach ($sources as $name => $dist) {
            if (!$dist->enabled):
              continue;
            else:
              foreach ($dist->list as $r):
                if (!$r->enabled):
                  continue;
                else:
                  if ($dist->local):
                    $buffer .= file_get_contents($rel . $r->source, FILE_USE_INCLUDE_PATH);
                  else:
                    $buffer .= file_get_contents($r->source);
                  endif;
                endif;
              endforeach;
            endif;
          }
          header('Content-type: application/javascript');
          require_once('dependencies/jspacker.php');
          $packer = new JavaScriptPacker($buffer, 'Normal', true, false);
          exit($packer->pack());
          //exit( $buffer );
      break;
      default:
        $scope->inject( 'communicator' );
        $scope->communicator->error('The Content Delivery Manager Could Not Locate The Request Resource');
      break;
    endswitch;
  else:
    $scope->inject( 'communicator' );
    $scope->communicator->error('The Content Delivery Manager Could Not Locate The Request Resource');
  endif;
