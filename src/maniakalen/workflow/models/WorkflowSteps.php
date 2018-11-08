<?php

namespace maniakalen\workflow\models;

use maniakalen\admingui\interfaces\GridModelInterface;
use maniakalen\widgets\ActiveForm;
use maniakalen\widgets\interfaces\ActiveFormModel;
use maniakalen\workflow\validators\ServiceClassValidator;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "workflow_steps".
 *
 * @property int $id
 * @property int $workflow_id
 * @property int $parent_id
 * @property string $url_route
 * @property string $service_class
 * @property string $name
 * @property int $order_index
 * @property int $status
 * @property int $prev_step_id
 *
 * @property WorkflowSteps $parent
 * @property WorkflowSteps[] $workflowSteps
 * @property Workflow $workflow
 * @property WorkflowSteps $nextStep
 * @property WorkflowSteps $prevStep
 */
class WorkflowSteps
    extends \yii\db\ActiveRecord
    implements GridModelInterface, ActiveFormModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%m_workflow_steps}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_id', 'url_route', 'service_class'], 'required'],
            [['workflow_id', 'parent_id', 'prev_step_id'], 'integer'],
            [['parent_id'], 'validateParent'],
            [['url_route'], 'string', 'max' => 45],
            [['auth_item_name'], 'string', 'max' => 64],
            [['service_class', 'name'], 'string', 'max' => 255],
            [['service_class'], ServiceClassValidator::class, 'interface' => 'maniakalen\workflow\interfaces\StepServiceInterface'],
            [['status'], 'boolean'],
            //[['workflow_id', 'parent_id', 'order_index'], 'unique', 'targetAttribute' => ['workflow_id', 'parent_id', 'order_index']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkflowSteps::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['workflow_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workflow::class, 'targetAttribute' => ['workflow_id' => 'id']],
            [['prev_step_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkflowSteps::class, 'targetAttribute' => ['prev_step_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workflow_id' => 'Workflow ID',
            'parent_id' => 'Parent ID',
            'url_route' => 'Url Route',
            'service_class' => 'Service Class',
            'name' => 'Name',
            'prev_step_id' => 'Previous Step',
            'status' => 'Status',
            'auth_item_name' => 'Access permission'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(WorkflowSteps::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowSteps()
    {
        return $this->hasMany(WorkflowSteps::class, ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::class, ['id' => 'workflow_id']);
    }

    public function getFieldsSignature()
    {
        $rules = [
            static::SCENARIO_DEFAULT => [
                'workflow_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'items' => ArrayHelper::map(Workflow::findAll(['status' => 1]), 'id', 'name')
                ],
                'parent_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'options' => ['prompt' => Yii::t('workflow', '-- Root --')],
                    'items' => ArrayHelper::map(static::find()
                        ->where(['status' => 1])
                        ->andWhere(['!=', 'id', $this->id?:0])
                        ->all(), 'id', 'name')
                ],
                'prev_step_id' => [
                    'type' => ActiveForm::FIELD_TYPE_DROPDOWN,
                    'options' => ['prompt' => Yii::t('workflow', '-- First --')],
                    'items' => ArrayHelper::map(static::find()
                        ->where(['status' => 1])
                        ->andWhere(['!=', 'id', $this->id?:0])
                        ->all(), 'id', 'name')
                ],
                'url_route' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 45]],
                'auth_item_name' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 64]],
                'name' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'service_class' => ['type' => ActiveForm::FIELD_TYPE_TEXT, 'options' => ['max' => 255]],
                'status' => ['type' => ActiveForm::FIELD_TYPE_CHECKBOX, 'label' => Yii::t('workflow', 'active')]
            ],
        ];
        $scenario = $this->getScenario();
        return isset($rules[$scenario])?$rules[$scenario]:[];
    }
    public function validateParent($attribute, $params)
    {
        $parent = static::findOne($this->$attribute);
        while ($parent->$attribute) {
            if ($parent->parent_id == $this->id) {
                $this->addError($attribute, Yii::t('workflow', 'Invalid use of parent.'));
                break;
            }
            $parent = $parent->parent;
        }
    }
    public function getCreateAction()
    {
        return Url::to(['workflow-step-create']);
    }

    public function getUpdateAction()
    {
        return Url::to(['workflow-step-details-edit', 'id' => $this->id]);
    }

    public function getFormBlocks()
    {
        return [];
    }

    public function getNextStep()
    {
        return $this->hasOne(WorkflowSteps::class, ['prev_step_id' => 'id']);
    }

    public function getPrevStep()
    {
        return $this->hasOne(WorkflowSteps::class, ['id' => 'prev_step_id']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->prev_step_id) {
            $prevStep = static::findOne($this->prev_step_id);
            if ($prevStep) {
                $prevNextStep = $prevStep->nextStep;
            }
        }
        if (parent::save($runValidation, $attributeNames)) {
            if (isset($prevNextStep)) {
                $prevNextStep->prev_step_id = $this->id;
                if (!$prevNextStep->save(false)) {
                    \Yii::error("Fail to reset prev_step_id for " . $prevNextStep->id . " to " . $this->id, "workflow");
                }
            }
            return true;
        }
        return false;
    }

    public function getGridColumnsDefinition()
    {
        return [
            'name',
            'service_class',
            [
                'attribute' => 'workflow_id',
                'value' => function($m) {
                    $wf = Workflow::findOne($m->workflow_id);
                    return $wf?$wf->name:Yii::t('workflow', 'None');
                }
            ],
            [
                'attribute' => 'parent_id',
                'value' => function($m) {
                    $wfs = static::findOne($m->parent_id);
                    return $wfs?$wfs->name:Yii::t('workflow', 'None');
                }
            ],
            'url_route',
            'auth_item_name',
            [
                'attribute' => 'prev_step_id',
                'value' => function($m) {
                    $wfs = $m->prevStep;
                    return $wfs?$wfs->name:Yii::t('workflow', 'None');
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'actionIcons'],/* add class to <td> of action icons */
                'template' => '<div class="icoBox">{workflow-step-details} {workflow-step-toggle} {workflow-step-delete}</div>',
                'buttons' => [
                    'workflow-step-details' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step details'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step details'),
                            'id' => 'workflow_step_details_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'workflow-step-toggle' => function($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step toggle status'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step toggle status'),
                            'id' => 'workflow_step_details_' . $model->id,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-' . ($model->status === 1?'ok':'remove') . '"></span>', $url, $options);
                    },
                    'workflow-step-delete' => function ($url, $model) {
                        $options = [
                            'class' => 'col-md-4',
                            'title' => \Yii::t('workflow', 'Workflow step delete'),
                            'aria-label' => \Yii::t('workflow', 'Workflow step delete'),
                            'id' => 'workflow_step_details_' . $model->id,
                            'onclick' => 'confirmModal({"id":"confirm_modal"}).done(function() { 
                                window.location = $(this).attr("href"); 
                            }); return false;'
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    }
                ]
            ]
        ];
    }
}
