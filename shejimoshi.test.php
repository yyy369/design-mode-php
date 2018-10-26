<?php 
    class A{
        private static $instance;
        private function __construct()
        {
            
        }
        public function __clone(){
            trigger_error("'不允许克隆对象",E_USER_ERROR);
        }
        public static function getInstance(){
            if (!isset(static::$instance)) {
                $class = __CLASS__;
                //static::$instance = new A();
                static::$instance = new $class;
            }
            return static::$instance;
        }
    }

    //$a1 = new A();
    
    $a2 = A::getInstance();
    $a3 = A::getInstance();
    // $a4 = clone $a3;
    var_dump($a2,$a3);



 ?>