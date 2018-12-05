<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "m_workflow_restrictions_relations".
 *
 * @property int $id
 * @property int $restriction_id
 * @property string $relation_type
 * @property int $related_id
 */
class WorkflowRestrictionsRelations extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_workflow_restrictions_relations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restriction_id', 'related_id', 'relation_type'], 'required'],
            [['restriction_id', 'related_id'], 'integer'],
            [['relation_type'], 'string'],
            [['relation_type'], 'in', 'range' => ['step', 'action']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('petites', 'ID'),
            'restriction_id' => Yii::t('petites', 'Restriction ID'),
            'relation_type' => Yii::t('petites', 'Relation Type'),
            'related_id' => Yii::t('petites', 'Related ID'),
        ];
    }

    public function getFieldsSignature()
    {

        $rules = [
            static::SCENARIO_DEFAULT => [
                'restriction_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(WorkflowRestrictionsGroups::findAll(['status' => 1]), 'id', 'title')
                ],
                'relation_type' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ['step' => 'step', 'action' => 'action']
                ],
                'related_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::merge(
                        ['' => '-- Steps --'],
                        ArrayHelper::map(WorkflowSteps::findAll(['status' => 1]), 'id', 'name'),
                        ['' => '-- Actions --'],
                        ArrayHelper::map(WorkflowActions::findAll(['status' => 1]), 'id', 'name')),
                ],
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];

    }

    public function getCreateAction()
    {
        return Url::to(['workflow-restriction-relation-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-restriction-relation-details-edit']);
    }

    public function getFormBlocks()
    {
        return [];
    }

    public function getGridColumnsDefinition()
    {
        return [
            [
                'attribute' => 'restriction_id',
                'value' => function($m) {
                    $obj = WorkflowRestrictionsGroups::findOne($m->group_id);
                    return $obj?$obj->title:Yii::t('workflow', 'None');
                }
            ],
            [
                'attribute' => 'relation_type',
                'value' => function($m) {
                    return ucfirst($m->relation_type);
                }
            ],
            [
                'attribute' => 'related_id',
                'value' => function($m) {
                    if ($m->relation_type === 'step') {
                        $step = WorkflowSteps::findOne($m->related_id);
                        return $step?$step->name:Yii::t('workflow', 'None');
                    } else if ($m->relation_type === 'action') {
                        $step = WorkflowActions::findOne($m->related_id);
                        return $step?$step->name:Yii::t('workflow', 'None');
                    }
                    return Yii::t('workflow', 'None');
                }
            ],
        ];
    }
}
