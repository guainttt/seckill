<?php

namespace Core\annotations;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 *            属性注解
 */
class DB
{
    public $source =  'default';
}