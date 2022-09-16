<?php
namespace Core\init;
use Core\annotations\Bean;
use Illuminate\Database\Capsule\Manager as lvDB;

/**
 * Class MyDB
 *
 * @package Core\init
 * @method \Illuminate\Database\Query\Builder table(string  $table,string|null  $as=null,string|null  $connection=null)
 * @method \Illuminate\Database\Query\Builder connection(string|null  $connection=null)
 *          
 */
class MyDB
{
   private  $lvDB;
   private  $dbSource;
    
    /**
     * @return mixed
     */
    public function getDbSource()
    {
        return $this->dbSource;
    }
    
    /**
     * @param mixed $dbSource
     */
    public function setDbSource($dbSource): void
    {
        $this->dbSource = $dbSource;
        return;
    }
   public function __construct()
   {
       //PHP默认定义了一些“超级全局（Superglobals）”变量，这些变量自动全局化，而且能够在程序的任何地方中调用，比如$_GET和$ _REQUEST等等。它们通常都来自数据或者其他外部数据，使用这些变量通常是不会产生问题的，因为他们基本上是不可写的。
       //
       //但是你可以使用你自己的全局变量。
       //
       //使用关键字“global”你就可以把全局数据导入到一个函数的局部范围内。
       global $GLOBAL_CONFIGD;
       //default 为默认数据源
       if (isset($GLOBAL_CONFIGD['db'])){
           $configs = $GLOBAL_CONFIGD['db'];
           $this->lvDB = new  LvDb();
           //创建连接
           foreach ($configs as $key =>$config){
               $this->lvDB->addConnection($config,$key);
           }
           //设置全局静态访问
           $this->lvDB->setAsGlobal();
           //启动Eloquent
           $this->lvDB->bootEloquent();
       }
   }
   
   //__call()，这个方法用来监视一个对象中的其它方法。
    ////如果你试着调用一个对象中不存在或被权限控制中的方法，
    //__call 方法将会被自动调用。
   public  function __call($methodName, $arguments)
   {
       // TODO: Implement __call() method.
       //用。。。解构数组

       //return $this->lvDB::$methodName(...$arguments);
       return $this->lvDB::connection($this->dbSource)->$methodName(...$arguments);
       
   }
}