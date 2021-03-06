<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 05/11/2018
 * Time: 14:52
 */

namespace maniakalen\workflow\widgets;


use maniakalen\workflow\exceptions\WorkflowException;
use maniakalen\workflow\models\WorkflowStepActions;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Actions extends Widget
{
    /** @var WorkflowStepActions[] $actions */
    public $actions;
    public $translationCategory = 'workflow';
    public function run()
    {
        echo Html::ul($this->actions, ['item' => function($item, $k) {
            if (!\Yii::$app->user->can($item->auth_item_name)) {
                return '';
            }
            $action = $item->action;
            if (!$action->status) {
                return '';
            }
            $tag = $action->type;
            $options = json_decode($action->styles, JSON_UNESCAPED_UNICODE);
            $options['action_id'] = $item->id;
            $name = $item->name?:$action->name;

            return $this->$tag($name, $options);
        }]);
    }

    /**
     * @param $name
     * @param $options
     * @return string
     * @throws WorkflowException
     */
    protected function a($name, $options)
    {
        $url = ArrayHelper::remove($options, 'url', '#');
        if ($url !== '#') {
            $url = Url::to($url);
        }
        return Html::a(\Yii::t($this->translationCategory, $name), $url, $options);
    }

    protected function input($name, $options)
    {
        $type = ArrayHelper::remove($options, 'type', 'submit');
        $id = ArrayHelper::remove($options, 'action_id', 0);
        $valueTemplate = ArrayHelper::remove($options, 'valueTemp', '[value]');
        $value = str_replace('[value]', \Yii::t($this->translationCategory, $name), $valueTemplate);
        return Html::input($type, "action[$id]", $value, $options);
    }
    protected function button($name, $options)
    {
        $id = ArrayHelper::remove($options, 'action_id', 0);
        $valueTemplate = ArrayHelper::remove($options, 'valueTemp', '[value]');
        $value = str_replace('[value]', \Yii::t($this->translationCategory, $name), $valueTemplate);
        $options['name'] = "action[$id]";
        return Html::button($value, $options);
    }
}