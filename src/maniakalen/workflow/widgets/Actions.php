<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 05/11/2018
 * Time: 14:52
 */

namespace maniakalen\workflow\widgets;


use maniakalen\workflow\exceptions\WorkflowException;
use maniakalen\workflow\models\WorkflowActions;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Actions extends Widget
{
    /** @var WorkflowActions[] $actions */
    public $actions;

    public function run()
    {
        echo Html::ul($this->actions, ['item' => function($item, $k) {
            $tag = $item->type;
            $options = json_decode($item->styles, JSON_UNESCAPED_UNICODE);
            $name = $item->name;

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
        return Html::a(\Yii::t('workflow', $name), $url, $options);
    }

    protected function input($name, $options)
    {
        $type = ArrayHelper::remove($options, 'type', 'submit');
        $options = ArrayHelper::merge(['value' => \Yii::t('workflow', $name)], $options);
        return Html::input($type, "action[$name]", $options);
    }
}