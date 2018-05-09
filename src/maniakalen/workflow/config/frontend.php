<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 13/04/2018
 * Time: 8:57
 */

return [
    'routes' => [
        'GET <module:([module])>/process' => '<module>/workflow/render',
        'POST <module:([module])>/process' => '<module>/workflow/process',
    ]
];