<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "workflow_step_restrictions_groups".
 *
 * @property int $id
 * @property int $step_id
 * @property int $action_id
 * @property string $title
 * @property int $status
 * @property int $target_step_id
 *
 * @property WorkflowRestrictions[] $workflowRestrictions
 */
class WorkflowRestrictionsGroups extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%m_workflow_restrictions_groups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['step_id', 'action_id', 'target_step_id'], 'integer'],
            //[['target_step_id'], 'required'],
            [['title'], 'string', 'max' => 64],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step_id' => 'Step ID',
            'action_id' => 'Action ID',
            'title' => 'Title',
            'status' => 'Status',
            'target_step_id' => 'Target Step ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowRestrictions()
    {
        return $this->hasMany(WorkflowRestrictions::class, ['group_id' => 'id']);
    }

    public function getFieldsSignature()
    {
        $rules = [
            static::SCENARIO_DEFAULT => [
                'step_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowSteps::findAll(['status' => 1]), 'id', 'name')
                ],
                'action_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowActions::findAll(['status' => 1]), 'id', 'name')
                ],

                'title' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'status' => ['type' => ActiveForm::FIELD_TYPE_CHECKBOX],
                'target_step_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowSteps::findAll(['status' => 1]), 'id', 'name')
                ],
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];
    }

    public function getCreateAction()
    {
        return Url::to(['workflow-restriction-group-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-restriction-group-details-edit', 'id' => $this->id]);
    }

    public function getFormBlocks()
    {
        return [];
    }

    public function getGridColumnsDefinition()
    {
        return [
            [
                'attribute' => 'step_id',
                'value' => function($m) {
                    $obj = WorkflowSteps::findOne($m->step_id);
                    return $obj?$obj->name:Yii::t('workflow', 'None');
                }
            ],
            [
                'attribute' => 'action_id',
                'value' => function($m) {
                    $obj = WorkflowActions::findOne($m->action_id);
                    return $obj?$obj->name:Yii::t('workflow', 'None');
                }
            ],
            'title',
            'status',
            [
                'attribute' => 'target_step_id',
                'value' => function($m) {
                    $obj = WorkflowSteps::findOne($m->target_step_id);
                    return $obj?$obj->name:Yii::t('workflow', 'None');
                }
            ],
        ];
    }
}
