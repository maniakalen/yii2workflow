<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 23/04/2018
 * Time: 16:01
 */

namespace maniakalen\workflow\controllers;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WorkflowController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'render',
                        ],
                        'allow' => true,
                        'roles' => ['maniakalen\workflow\view'],
                    ],
                    [
                        'actions' => [
                            'process',
                        ],
                        'allow' => true,
                        'roles' => ['maniakalen\workflow\edit'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'render' => ['get'],
                    'process' => ['post']
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'render' => [
                'class' =>  'maniakalen\workflow\actions\Render',
                'manager' => [
                    'class' => 'maniakalen\workflow\components\WorkflowManager'
                ]
            ],
            'process' => [
                'class' =>  'maniakalen\workflow\actions\Process',
                'manager' => [
                    'class' => 'maniakalen\workflow\components\WorkflowManager'
                ]
            ]
        ];
    }
}