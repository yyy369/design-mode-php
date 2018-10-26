<?php
//常见外部单例实现方法。
class a{

}
class b{

}
//外部定义方法，保证单例模式的正确运行
function getinstance($class_name){
   static $instance_list=array();//使用数组可以完成多个类的同时单例
   if (!isset($instance_list[$class_name])) {
      $instance_list[$class_name]=new $class_name();//可变类方法
   }
      return $instance_list[$class_name];
}
$obj1=getinstance('a');
$obj2=getinstance('a');
$obj3=getinstance('b');
$obj4=getinstance('b');
$obj5= new b();//这就是缺点，仍然可以在外部NEW出新对象，无法保证实现真正的单例.
?>