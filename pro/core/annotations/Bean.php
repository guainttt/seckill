<?php

namespace Core\annotations;
use Doctrine\Common\Annotations\Annotation\Target;
/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Bean
{
    //别名
    public $name ="";
}