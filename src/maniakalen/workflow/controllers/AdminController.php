<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 12/04/2018
 * Time: 15:39
 */

namespace maniakalen\workflow\controllers;



use maniakalen\widgets\ConfirmModalAsset;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'workflow-grid',
                            'workflow-steps-grid',
                            'workflow-actions-grid',
                            'workflow-restriction-groups-grid',
                            'workflow-restrictions-grid',
                            'workflow-steps-actions-grid',
                        ],
                        'allow' => true,
                        'roles' => ['maniakalen/workflow/view'],
                    ],
                    [
                        'actions' => [
                            'workflow-details',
                            'workflow-step-details',
                            'workflow-action-details',
                            'workflow-restriction-groups-details',
                            'workflow-restriction-details',
                            'workflow-step-action-details',

                            'workflow-details-edit',
                            'workflow-step-details-edit',
                            'workflow-action-details-edit',
                            'workflow-restriction-groups-details-edit',
                            'workflow-restriction-details-edit',
                            'workflow-step-action-details-edit',

                            'workflow-toggle',
                            'workflow-step-toggle',
                            'workflow-action-toggle',
                            'workflow-restriction-groups-toggle',
                            'workflow-restriction-toggle',

                            'workflow-create',
                            'workflow-step-create',
                            'workflow-action-create',
                            'workflow-restriction-groups-create',
                            'workflow-restriction-create',
                            'workflow-step-action-create',
                        ],
                        'allow' => true,
                        'roles' => ['maniakalen/workflow/edit'],
                    ],
                    [
                        'actions' => [
                            'workflow-delete',
                            'workflow-step-delete',
                            'workflow-action-delete',
                            'workflow-restriction-groups-delete',
                            'workflow-restriction-delete',
                            'workflow-step-action-delete'
                        ],
                        'allow' => true,
                        'roles' => ['maniakalen/workflow/delete'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'workflow-grid' => ['get'],
                    'workflow-steps-grid' => ['get'],
                    'workflow-actions-grid' => ['get'],
                    'workflow-restriction-groups-grid' => ['get'],
                    'workflow-restrictions-grid' => ['get'],
                    'workflow-steps-actions-grid' => ['get'],

                    'workflow-details' => ['get'],
                    'workflow-step-details' => ['get'],
                    'workflow-action-details' => ['get'],
                    'workflow-restriction-groups-details' => ['get'],
                    'workflow-restriction-details' => ['get'],
                    'workflow-step-action-details' => ['get'],

                    'workflow-details-edit' => ['post'],
                    'workflow-step-details-edit' => ['post'],
                    'workflow-action-details-edit' => ['post'],
                    'workflow-restriction-groups-details-edit' => ['post'],
                    'workflow-restriction-details-edit' => ['post'],
                    'workflow-step-action-details-edit' => ['post'],

                    'workflow-create' => ['post', 'get'],
                    'workflow-step-create' => ['post', 'get'],
                    'workflow-action-create' => ['post', 'get'],
                    'workflow-restriction-groups-create' => ['post', 'get'],
                    'workflow-restriction-create' => ['post', 'get'],
                    'workflow-step-action-create' => ['post', 'get'],

                    'workflow-toggle' => ['get'],
                    'workflow-step-toggle' => ['get'],
                    'workflow-action-toggle' => ['get'],
                    'workflow-restriction-groups-toggle' => ['get'],
                    'workflow-restriction-toggle'=> ['get'] ,

                    'workflow-delete' => ['get'],
                    'workflow-step-delete' => ['get'],
                    'workflow-action-delete' => ['get'],
                    'workflow-restriction-groups-delete' => ['get'],
                    'workflow-restriction-delete' => ['get'],
                    'workflow-step-action-delete' => ['get']
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        ConfirmModalAsset::register($this->view);
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        return ArrayHelper::merge(
            $this->gridActions(),
            $this->detailsActions(),
            $this->editActions(),
            $this->createActions(),
            $this->toggleActions(),
            $this->deleteActions()
        );
    }

    protected function gridActions()
    {
        return [
            'workflow-grid' => [
                'class' =>  'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\Workflow'
                ],
            ],
            'workflow-steps-grid' => [
                'class' => 'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-step-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowSteps'
                ],
            ],
            'workflow-actions-grid' => [
                'class' => 'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-action-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowActions'
                ],
            ],
            'workflow-restriction-groups-grid' => [
                'class' => 'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-restriction-group-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsGroups'
                ],
            ],
            'workflow-restrictions-grid' => [
                'class' => 'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-restriction-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictions'
                ],
            ],
            'workflow-steps-actions-grid' => [
                'class' => 'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-step-action-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowStepActions'
                ],
            ],
            'workflow-restrictions-relations-grid' => [
                'class' => 'maniakalen\admingui\actions\Grid',
                'createActionRoute' => ['workflow-restriction-relation-create'],
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsRelations'
                ],
            ]
        ];
    }

    protected function detailsActions()
    {
        return [
            'workflow-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\Workflow'
                ],
            ],
            'workflow-step-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowSteps'
                ],
            ],
            'workflow-action-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowActions'
                ],
            ],
            'workflow-restriction-groups-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsGroups'
                ],
            ],
            'workflow-restriction-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictions'
                ],
            ],
            'workflow-step-action-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowStepActions'
                ],
            ],
            'workflow-restriction-relation-details' => [
                'class' => 'maniakalen\admingui\actions\Details',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsRelations'
                ],
            ],
        ];
    }

    protected function editActions()
    {
        return [
            'workflow-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\Workflow'
                ],
                'redirect' => 'workflow-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
            'workflow-step-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowSteps'
                ],
                'redirect' => 'workflow-step-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
            'workflow-action-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowActions'
                ],
                'redirect' => 'workflow-action-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
            'workflow-restriction-groups-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsGroups'
                ],
                'redirect' => 'workflow-restriction-groups-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
            'workflow-restriction-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictions'
                ],
                'redirect' => 'workflow-restriction-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
            'workflow-step-action-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowStepActions'
                ],
                'redirect' => 'workflow-step-action-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
            'workflow-restriction-relation-details-edit' => [
                'class' => 'maniakalen\admingui\actions\Update',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsRelations'
                ],
                'redirect' => 'workflow-restriction-relation-details',
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record updated successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue updating record')
                ],
            ],
        ];
    }

    protected function createActions()
    {
        return [
            'workflow-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\Workflow'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-details',
            ],
            'workflow-step-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowSteps'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-step-details',
            ],
            'workflow-action-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowActions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-action-details',
            ],
            'workflow-restriction-groups-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsGroups'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-restriction-groups-details',
            ],
            'workflow-restriction-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-restriction-details',
            ],
            'workflow-step-action-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowStepActions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-step-action-details',
            ],
            'workflow-restriction-relation-create' => [
                'class' => 'maniakalen\admingui\actions\Create',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsRelations'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record created successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue saving record')
                ],
                'redirect' => 'workflow-step-action-details',
            ],
        ];
    }

    protected function toggleActions()
    {
        return [
            'workflow-toggle' => [
                'class' => 'maniakalen\admingui\actions\Toggle',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\Workflow'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record status toggled successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue toggling status')
                ],
            ],
            'workflow-step-toggle' => [
                'class' => 'maniakalen\admingui\actions\Toggle',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowSteps'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record status toggled successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue toggling status')
                ],
            ],
            'workflow-action-toggle' => [
                'class' => 'maniakalen\admingui\actions\Toggle',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowActions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record status toggled successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue toggling status')
                ],
            ],
            'workflow-restriction-groups-toggle' => [
                'class' => 'maniakalen\admingui\actions\Toggle',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsGroups'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record status toggled successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue toggling status')
                ],
            ],
            'workflow-restriction-toggle' => [
                'class' => 'maniakalen\admingui\actions\Toggle',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record status toggled successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue toggling status')
                ],
            ],
            'workflow-restriction-relation-toggle' => [
                'class' => 'maniakalen\admingui\actions\Toggle',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsRelations'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record status toggled successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue toggling status')
                ],
            ],
        ];
    }

    protected function deleteActions()
    {
        return [
            'workflow-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\Workflow'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
            'workflow-step-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowSteps'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
            'workflow-action-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowActions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
            'workflow-restriction-groups-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsGroups'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
            'workflow-restriction-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
            'workflow-step-action-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowStepActions'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
            'workflow-restrictions-relations-delete' => [
                'class' => 'maniakalen\admingui\actions\Delete',
                'manager' => [
                    'class' => 'maniakalen\admingui\components\ModelManager',
                    'model' => 'maniakalen\workflow\models\WorkflowRestrictionsRelations'
                ],
                'messages' => [
                    'success' =>  \Yii::t('workflow', 'Record deleted successfully'),
                    'danger' => \Yii::t('workflow', 'There was an issue deleting record')
                ],
            ],
        ];
    }
}