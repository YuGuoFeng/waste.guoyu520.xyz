<?php

namespace fast;

use Exception;

class Myexception extends Exception
{

    
    public $_msg = '';

    public function __construct($msg){
        $this->_msg = $msg;
    }

    //自定义的异常处理方法
     public function getMsg(){
         return  $this->_msg;
     }

}
