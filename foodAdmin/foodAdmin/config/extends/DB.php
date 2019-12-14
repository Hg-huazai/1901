<?php

class DB
{
  private $host; //主机名
  private $username; //用户名
  private $password; //密码
  private $dbname; //数据库名
  public $dbprefix = "pre_"; //前缀
  private $charset = "UTF8"; //编码
  private $link;   //链接标识符
  private $sql; //sql语句

  //构造函数 当类被实例化的时候，立刻被调用的方法 实例化传参的时候给到的其实就是类里面的构造函数
  //public 公共访问修饰符
  public function __construct($host,$username,$password,$dbname,$dbprefix="pre_")
  {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->dbname = $dbname;
    $this->dbprefix = $dbprefix;

    $this->link = mysqli_connect($this->host,$this->username,$this->password) or die("数据库连接失败");

    //选择数据库
    mysqli_select_db($this->link,$this->dbname);

    //设置编码
    mysqli_query($this->link,"SET NAMES ".$this->charset);
  }

  public function select($field="*")
  {
    $this->sql = "SELECT $field ";
    return $this;
  }

  public function from($table)
  {
    $this->sql .= "FROM {$this->dbprefix}$table AS $table ";
    return $this;
  }

  public function join($table,$on,$by="LEFT")
  {
    $this->sql .= "$by JOIN {$this->dbprefix}$table AS $table ON $on ";
    return $this;
  }

  public function groupBy($field)
  {
    $this->sql .= "GROUP BY $field ";
    return $this;
  }

  public function where($where = 1)
  {
    $this->sql .= "WHERE $where ";
    return $this;
  }

  public function orderBy($field,$by = "ASC")
  {
    $this->sql .= "ORDER BY $field $by ";
    return $this;
  }

  public function limit($limit)
  {
    $this->sql .= "LIMIT $limit ";
    return $this;
  }

  //查询一条数据
  public function find()
  {
    $res = mysqli_query($this->link,$this->sql);

    if(!$res)
    {
      $this->error();
      return false;
    }

    return mysqli_fetch_assoc($res);
  }


  //查询多条数据
  public function all()
  {
    $res = mysqli_query($this->link,$this->sql);

    if(!$res)
    {
      $this->error();
      return false;
    }

    $data = [];

    while($row = mysqli_fetch_assoc($res))
    {
      $data[] = $row;
    }

    return $data;
  }

  //插入数据库方法
  function add($table,$data)
  {
    $fields = "`".implode("`,`",array_keys($data))."`";
    $value = "'".implode("','",$data)."'";
    $sql = "INSERT INTO {$this->dbprefix}$table($fields)VALUES($value)";
    $res = mysqli_query($this->link,$sql);

    if(!$res)
    {
      $this->error();
      return false;
    }
    
    //返回插入id
    return mysqli_insert_id($this->link);
  }

  //一次性插入多条数据
  function addAll($table,$data)
  {
    $first = $data[0];
    $fields = "`".implode("`,`",array_keys($first))."`";
    $value = "";
    foreach($data as $item)
    {
      $value .= "('".implode("','",$item)."'),";
    }

    //删除最后一个,
    $value = trim($value,",");
    
    $sql = "INSERT INTO {$this->dbprefix}$table($fields)VALUES{$value}";
    $res = mysqli_query($this->link,$sql);

    if(!$res)
    {
      $this->error();
      return false;
    }
    
    //返回插入id
    return mysqli_insert_id($this->link);
  }

  //编辑数据
  function update($table,$data,$where)
  {
    $str = "";
    foreach($data as $key=>$item)
    {
      $str .= "`$key`='$item',";
    }

    $str = trim($str,",");

    $this->sql = "UPDATE {$this->dbprefix}$table SET $str WHERE $where";
    $res = mysqli_query($this->link,$this->sql);
    if(!$res)
    {
      $this->error();
      return false;
    }
    return mysqli_affected_rows($this->link);
  }


  public function delete($table,$where = 1)
  {
    $this->sql = "DELETE FROM {$this->dbprefix}$table WHERE $where";
    $res = mysqli_query($this->link,$this->sql);
    if(!$res)
    {
      $this->error();
      return false;
    }

    return mysqli_affected_rows($this->link);
  }


  //查看sql语句方法
  public function getSQL()
  {
    return $this->sql;
  }


  public function error()
  {
    $error =  mysqli_error($this->link);
    //写到错误日志
    // /www/ask/config/extends/db.php __FILE__
    // /www/ask/config/extends/ dirname
    // /www/ask/config/extends/mysql.log $path
    $path = str_replace("\\",'/',dirname(__FILE__))."/mysql.log";
    if(!is_file($path))
    {
      $fn = fopen($path,"w");
      fclose($fn);
    }

    //组装信息并写入
    //[2019-10-10 11:11:11] Unknown column 'aaa' in 'field list' \r\n
    $date = date("Y-m-d H:i:s");
    $msg = "[$date] $error \r\n";
    file_put_contents($path,$msg,FILE_APPEND);
    echo "[mysql]:SQL语句执行失败，请查看日志文件";
    exit;
  }


  //析构函数 在调用完成后自动执行的函数

  public function query($sql)
  {
    $this->sql = $sql;

    $res = mysqli_query($this->link,$this->sql);

    if(!$res)
    {
      $this->error();
      return false;
    }

    $data = [];
    while($row = mysqli_fetch_assoc($res))
    {
      $data[] = $row;
    }

    return $data;
  }

  public function transaction($sql)
  {
    $this->sql = $sql;

    $res = mysqli_query($this->link,$this->sql);

    if(!$res)
    {
      $this->error();
      return false;
    }

    return $res;
  }
}


?>