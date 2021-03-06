<?php namespace ZN\Tests;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

use ZN\Controller\UnitTest;

class Buffering extends UnitTest
{
    const unit =
    [
        'class'   => 'ZN\Buffering',
        'methods' => 
        [
            'code' => ['echo 1'],
            'file' => ['robots.txt']
        ]
    ];
}
