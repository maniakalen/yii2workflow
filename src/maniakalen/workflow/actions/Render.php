<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 23/04/2018
 * Time: 16:35
 */

namespace maniakalen\workflow\actions;


use maniakalen\workflow\interfaces\WorkflowManagerInterface;
use yii\base\Action;
use yii\di\Instance;
use yii\web\Response;

class Render extends Action
{
    /** @var WorkflowManagerInterface $manager */
    public $manager;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->manager = Instance::ensure($this->manager, 'maniakalen\workflow\interfaces\WorkflowManagerInterface');
    }

    public function run()
    {
        $get = \Yii::$app->request->get();
        $content = $this->manager->renderRequest($get, $this->controller->getView());
        if ($content instanceof Response) {
            return $content;
        }
        return $this->controller->renderContent($content);
    }
}