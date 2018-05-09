<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "workflow_step_actions".
 *
 * @property int $workflow_step_id
 * @property int $workflow_action_id
 * @property string $auth_item_name
 * @property string $callback
 * @property int $display_group
 * @property WorkflowActions $action
 */
class WorkflowStepActions
    extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow_step_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_step_id', 'workflow_action_id'], 'required'],
            [['workflow_step_id', 'workflow_action_id', 'display_group'], 'integer'],
            [['callback'], 'string'],
            [['auth_item_name'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 255],
            [['workflow_step_id', 'workflow_action_id'], 'unique', 'targetAttribute' => ['workflow_step_id', 'workflow_action_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'workflow_step_id' => 'Workflow Step ID',
            'workflow_action_id' => 'Workflow Action ID',
            'auth_item_name' => 'Auth Item Name',
            'callback' => 'Callback',
            'display_group' => 'Display Group',
        ];
    }

    public function getFieldsSignature()
    {
        $rules = [
            static::SCENARIO_DEFAULT => [
                'workflow_step_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowSteps::findAll(['status' => 1]), 'id', 'name')
                ],
                'workflow_action_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowActions::findAll(['status' => 1]), 'id', 'name')
                ],
                'name' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'auth_item_name' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 64]],
                'callback' => ['type' => ActiveForm::FIELD_TYPE_TEXTAREA],
                'display_group' => ['type' => ActiveForm::FIELD_TYPE_TEXT]
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];
    }

    public function getAction()
    {
        return $this->hasOne(WorkflowActions::class, ['id' => 'workflow_action_id']);
    }

    public function getStep()
    {
        return $this->hasOne(WorkflowSteps::class, ['id' => 'workflow_step_id']);
    }

    public function getCreateAction()
    {
        return Url::to(['workflow-step-action-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-step-action-edit', 'id' => $this->id]);
    }

    public function getFormBlocks()
    {
        return [];
    }

    public function getActionName()
    {
        return $this->name?:$this->action->name;
    }

    public function getActionServiceClass()
    {
        return $this->action->service_class;
    }

    public function getActionStyles()
    {
        return $this->action->styles;
    }

    public function getActionType()
    {
        return $this->action->type;
    }

    public function getGridColumnsDefinition()
    {
        return [
            [
                'attribute' => 'workflow_step_id',
                'value' => function($m) {
                    $obj = WorkflowSteps::findOne($m->workflow_step_id);
                    return $obj?$obj->name:Yii::t('workflow', 'None');
                }
            ],
            [
                'attribute' => 'workflow_action_id',
                'value' => function($m) {
                    $obj = WorkflowActions::findOne($m->workflow_action_id);
                    return $obj?$obj->name:Yii::t('workflow', 'None');
                }
            ],
            'auth_item_name',
            'display_group',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'actionIcons'],/* add class to <td> of action icons */
                'template' => '<div class="icoBox">{workflow-step-action-details} {workflow-step-action-delete}</div>',
                'buttons' => [
                    'workflow-step-details' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step action details'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step details'),
                            'id' => 'workflow_step_action_details_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'workflow-step-delete' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step action delete'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step action delete'),
                            'id' => 'workflow_step_action_details_' . $model->id,
                            'onclick' => 'confirmModal({"id":"confirm_modal"}).done(function() { 
                                window.redirect = $(this).attr("href"); 
                            }); return false;'
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    }
                ]
            ]
        ];
    }
}
