<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
 * @property WorkflowRestrictionsGroups $group
 */
class WorkflowRestrictions extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%m_workflow_restrictions}}';
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
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkflowRestrictionsGroups::class, 'targetAttribute' => ['group_id' => 'id']],
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
        return $this->hasOne(WorkflowRestrictionsGroups::class, ['id' => 'group_id']);
    }

    public function getFieldsSignature()
    {
        $rules = [
            static::SCENARIO_DEFAULT => [
                'group_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowRestrictionsGroups::findAll(['status' => 1]), 'id', 'title')
                ],
                'restriction_type' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ['field' => 'Field', 'callback' => 'Calback'],
                ],

                'restriction' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'comparison' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ['>', '<', '=', '!='],
                ],
                'value' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];
    }

    public function getCreateAction()
    {
        return Url::to(['workflow-restriction-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-restriction-details-edit']);
    }

    public function getFormBlocks()
    {
        return [];
    }

    public function getGridColumnsDefinition()
    {
        return [
            [
                'attribute' => 'group_id',
                'value' => function($m) {
                    $obj = WorkflowRestrictionsGroups::findOne($m->group_id);
                    return $obj?$obj->name:Yii::t('workflow', 'None');
                }
            ],
            [
                'attribute' => 'restriction_type',
                'value' => function($m) {
                    return ucfirst($m->restriction_type);
                }
            ],
            'restriction',
            'comparison',
            'value'
        ];
    }
}
