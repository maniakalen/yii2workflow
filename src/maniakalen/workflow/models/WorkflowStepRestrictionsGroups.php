<?php

namespace maniakalen\workflow\models;

use Yii;

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
 * @property WorkflowStepRestrictions[] $workflowStepRestrictions
 */
class WorkflowStepRestrictionsGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow_step_restrictions_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['step_id', 'action_id', 'target_step_id'], 'integer'],
            [['target_step_id'], 'required'],
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
    public function getWorkflowStepRestrictions()
    {
        return $this->hasMany(WorkflowStepRestrictions::class, ['group_id' => 'id']);
    }
}
