<?php
include "db.class.php";
class MySQLDB extends DB{
	private $error;
    private static $object;
	private function __clone{

	}
	public static function getobject(){
		if (!isset(static::$object)) {
			static::$object=new MySQLDB();
		}else{
			return static::$object;
		}

	}
	protected function initParam(Array $arr){
		if(!isset($arr[user])){
			die('必须提供MySQL服务器的用户名');
		}elseif (!isset($arr[password])) {
			die('必须提供链接MySQL服务器的用户密码');
		}elseif (!isset($arr[dbName])) {
			die('必须提供具体的数据库');
		}

    $this->host=isset($arr[host])?$arr[host]:'localhost';//如果主机名不为空则赋值传递过来的数组中的数据，如果为空默认设置为localhost
    $this->port=isset($arr[port])?$arr[port]:'3306';
    $this->user=$arr[user];
    $this->password=$arr[password];
    $this->dbName=$arr[dbName];
    $this->charset=isset($arr[charset])?$arr[charset]:'utf8';

}
//赋予conn属性
protected function getConn(){
	$conn=mysql_connect($this->host.":".$this->port,$this->user,$this->password);
	if (!$conn) {
		die('连接MySQL服务器失败，请检查服务器地址'.$this->host.":".$this->port.",用户名{$this->user},密码{$this->password}是否正确。");
	}else{
		$this->conn=$conn;
	}
}
//选择数据库
protected function selectDB(){
	$result=mysql_select_db($this->dbName,$this->conn);
	if (!$result) {
		die("数据出错，请检查配置文件的数据配置项是否存在此数据库{$this->dbName}".mysql_error());
	}
}
//选择数字编码
protected function setCharset(){
	mysql_query("set name {$this->charset}",$this->conn);
}
//运行SQL语句检测数据库是否真正加载完成
public function query($sql){
	$result=mysql_query($sql,$this->conn);
	if (!$result) {
		$this->error=mysql_error();
		return false;
	}else{
		//MySQL语句运行成功
		$rsArr=array();
        while ($row=mysql_fetch_assoc($result)) {
        	$rsArr[]=$row;//将遍历后的结果数组赋值给RSARR
        }
        return $rsArr;
	}

}
//大概作用为输入一个MySQL语句用affected检测受影响的行数，具体意义未知
public function exec($sql){
	$result=mysql_query($sql,$this->conn);
	//===是恒等于
	if ($result===true) {
		return mysql_affected_rows();
	}else{
		$this->error=mysql_error();
		return false;
	}
}
//初始化函数将$arr数组中的数据导入init初始化子程序,还有没有其他功能未知
private function __construct(Array $arr){
	$this->initParam($arr);
	$this->getConn();
	$this->selectDB();
	$this->setCharset();
}
public function getError(){
	return $this->error;
}
}




?>