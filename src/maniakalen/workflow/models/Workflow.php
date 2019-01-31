<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\admingui\interfaces\ModelManagerInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "workflow".
 *
 * @property int $id
 * @property string $url_route
 * @property string $name
 * @property string $description
 * @property int $status
 * @property int $auto_transit
 *
 * @property WorkflowSteps[] $workflowSteps
 */
class Workflow
    extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%m_workflow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_route'], 'required'],
            [['url_route'], 'required', 'skipOnEmpty' => true, 'on' => ModelManagerInterface::MODEL_SCENARIO_SEARCH],
            [['description'], 'string'],
            [['url_route'], 'string', 'max' => 45],
            [['name', 'layout'], 'string', 'max' => 255],
            [['status', 'auto_transit'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_route' => 'Url Route',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'auto_transit' => 'Auto Transit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowSteps()
    {
        return $this->hasMany(WorkflowSteps::class, ['workflow_id' => 'id']);
    }

    public function getGridColumnsDefinition()
    {
        return [
            'name',
            'description',
            'url_route',
            'layout',
            [
                'attribute' => 'auto_transit',
                'value' => function ($model) {
                    return Html::tag('div',null,['class' => 'glyphicon glyphicon-' . ($model->auto_transit?'ok':'remove')]);
                },
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'actionIcons'],/* add class to <td> of action icons */
                'template' => '<div class="icoBox">{workflow-details} {workflow-toggle} {workflow-delete}</div>',
                'buttons' => [
                    'workflow-details' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('app', 'Workflow details'),
                            'aria-label' => \Yii::t('app', 'Workflow details'),
                            'id' => 'workflow_details_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'workflow-toggle' => function($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('app', 'Workflow toggle status'),
                            'aria-label' => \Yii::t('app', 'Workflow toggle status'),
                            'id' => 'workflow_toggle_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-' . ($model->status === 1?'ok':'remove') . '"></span>', $url, $options);
                    },
                    'workflow-delete' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('app', 'Workflow delete'),
                            'aria-label' => \Yii::t('app', 'Workflow delete'),
                            'id' => 'workflow_delete_' . $model->id,
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
                'url_route' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 45]],
                'name' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'layout' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'description' => ['type' => ActiveForm::FIELD_TYPE_TEXTAREA],
                'status' => ['type' => ActiveForm::FIELD_TYPE_CHECKBOX],
                'auto_transit' => ['type' => ActiveForm::FIELD_TYPE_CHECKBOX],
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];
    }

    public function getCreateAction()
    {
        return Url::to(['workflow-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-details-edit', 'id' => $this->id]);
    }

    public function getFormBlocks()
    {
        return [];
    }
}
