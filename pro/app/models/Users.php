<?php
namespace App\models;
 ////做框架要隐藏底层细节，尽量不要去引用底层库
//use Illuminate\Database\Eloquent\Model;
use Core\lib\DBModel ;

class Users extends DBModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $connection = 'docker';
    
}