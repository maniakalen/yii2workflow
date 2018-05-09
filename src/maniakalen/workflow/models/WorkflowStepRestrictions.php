<?php

namespace maniakalen\workflow\models;

use Yii;

/**
 * This is the model class for table "workflow_step_restrictions".
 *
 * @property int $id
 * @property int $group_id
 * @property string $restriction_type
 * @property string $restriction
 * @property string $comparison
 * @property string $value
 *
 * @property WorkflowStepRestrictionsGroups $group
 */
class WorkflowStepRestrictions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow_step_restrictions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id'], 'required'],
            [['group_id'], 'integer'],
            [['restriction_type', 'restriction', 'comparison'], 'string'],
            [['value'], 'string', 'max' => 255],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkflowStepRestrictionsGroups::class, 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'restriction_type' => 'Restriction Type',
            'restriction' => 'Restriction',
            'comparison' => 'Comparison',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(WorkflowStepRestrictionsGroups::class, ['id' => 'group_id']);
    }
}
