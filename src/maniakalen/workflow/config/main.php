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
    'appComponents' => [
        'i18n' => [
            'translations' => [
                'workflow*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@maniakalen/workflow/messages',
                ],
            ],
        ],
        'callback' => [
            'class' => 'maniakalen\callback\components\CallbacksManager'
        ]
    ],
    'app' => [
        'base' => [
            'controllerMap' => [
                'migrate' => [
                    'migrationNamespaces' => [
                        //'console\migrations', // Common migrations for the whole application
                        'maniakalen\workflow\migrations', // Migrations for the specific project's module
                    ],
                ],
            ],
        ]
    ],
];