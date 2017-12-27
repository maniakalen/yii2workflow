<?php
/**
 * PHP Version 5.5
 *
 *  Module config file
 *
 * @category linear\workflow
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

return [
    'components' => [

    ],
    'container' => [
        'definitions' => [
            'yii\console\controllers\MigrateController' => [
                'class' => 'yii\console\controllers\MigrateController',
                'migrationPath' => [
                    '@workflow/migrations'
                ]
            ]
        ]
    ]
];