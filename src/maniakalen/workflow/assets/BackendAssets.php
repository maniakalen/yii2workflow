<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 29/10/2018
 * Time: 14:42
 */

namespace maniakalen\workflow\assets;


use yii\web\AssetBundle;

class BackendAssets extends AssetBundle
{
    public $sourcePath = '@maniakalen/workflow/resources';

    public $css = [
        'css/backend.css',
    ];
}