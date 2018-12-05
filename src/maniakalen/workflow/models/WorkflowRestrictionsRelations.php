<?php

namespace maniakalen\workflow\models;

use Yii;

/**
 * This is the model class for table "m_workflow_restrictions_relations".
 *
 * @property int $id
 * @property int $restriction_id
 * @property string $relation_type
 * @property int $related_id
 */
class WorkflowRestrictionsRelations extends \yii\db\ActiveRecord
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
}
