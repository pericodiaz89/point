<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: text/javascript; charset=utf-8');
date_default_timezone_set('America/Bogota');

define('command', 'command');

abstract class Service {

    function __construct() {
        $this->includeFiles();
        $response = json_encode($this->callService());
        if (isset($_REQUEST['callback'])) {
            echo $_REQUEST['callback'] . "($response)";
        } else {
            echo $response;
        }
        MysqlDBC::getInstance()->close();
    }

    /**
     * Includes all the files that are needed for the base of the
     * webservice
     */
    function includeFiles() {
        include('../dao/MysqlDBC.php');
        include('../helpers/ArrayHelper.php');
        include('../helpers/ErrorHelper.php');
        $this->includeSpecificFiles();
    }

    /**
     * Method that allows you to include the files you only need for the specific
     * service
     */
    abstract function includeSpecificFiles();

    /**
     * Method that checks the parameters needed and calls the specific service
     * @return array a PHP arrray to be encoded as a JSON Object
     */
    function callService() {
        if (checkParam(command)) {
            $command = $_REQUEST[command];
            if (is_callable(array($this, $command))) {
                return $this->$command();
            } else {
                return getErrorArray(00, "Service $command doesn't exist");
            }
        } else {
            return getErrorArray(01, "Parameter 'command' not found");
        }
    }
}

// <editor-fold defaultstate="collapsed" desc="Helper Service Methods">
function checkParams() {
    $ok = true;
    $argCount = func_num_args();
    for ($i = 0; $i < $argCount; $i++) {
        if (!checkParam(func_get_arg($i))) {
            $ok = false;
            break;
        }
    }
    return $ok;
}

function checkParam($param) {
    if (!isset($_REQUEST[$param]))
        return FALSE;
    if ($_REQUEST[$param] != '0' && empty($_REQUEST[$param]))
        return FALSE;

    return TRUE;
}

// </editor-fold>
?>
