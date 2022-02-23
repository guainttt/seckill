<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2022/1/29
 * Time: 21:03
 */

namespace Core\annotations;
use Doctrine\Common\Annotations\Annotation\Target;
/**
 * @Annotation
 * @Target({"METHOD"})
 */
class RequestMapping
{
   public $value='';//路径 如/api/test
   public $method = [];// GET。POST
}