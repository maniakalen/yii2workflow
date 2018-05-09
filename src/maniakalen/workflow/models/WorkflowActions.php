<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use maniakalen\workflow\validators\ServiceClassValidator;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "workflow_actions".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $styles
 * @property string $service_class
 * @property int $status
 */
class WorkflowActions
    extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'service_class'], 'required'],
            [['type', 'styles'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['service_class'], 'string', 'max' => 255],
            [['service_class'], ServiceClassValidator::class],
            [['status'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'styles' => 'Styles',
            'service_class' => 'Service Class',
            'status' => 'Status',
        ];
    }

    public function getGridColumnsDefinition()
    {
        return [
            'name',
            'service_class',
            'type',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'actionIcons'],/* add class to <td> of action icons */
                'template' => '<div class="icoBox">{workflow-action-details} {workflow-action-toggle} {workflow-action-delete}</div>',
                'buttons' => [
                    'workflow-action-details' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step details'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step details'),
                            'id' => 'workflow_action_details_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'workflow-action-toggle' => function($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step toggle status'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step toggle status'),
                            'id' => 'workflow_action_details_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-' . ($model->status === 1?'ok':'remove') . '"></span>', $url, $options);
                    },
                    'workflow-action-delete' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step delete'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step delete'),
                            'id' => 'workflow_action_details_' . $model->id,
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

    public function getFieldsSignature()
    {
        $rules = [
            static::SCENARIO_DEFAULT => [
                'name' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'type' => ['type' => ActiveForm::FIELD_TYPE_DROPDOWN, 'items' => ['a' => 'link', 'input' => 'button']],
                'service_class' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'status' => ['type' => ActiveForm::FIELD_TYPE_CHECKBOX, 'label' => Yii::t('workflow', 'active')]
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];
    }

    public function getCreateAction()
    {
        return Url::to(['workflow-action-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-action-details-edit', 'id' => $this->id]);
    }

    public function getFormBlocks()
    {
        return [];
    }
}
