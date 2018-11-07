<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 23/04/2018
 * Time: 16:35
 */

namespace maniakalen\workflow\actions;

use maniakalen\workflow\interfaces\WorkflowManagerInterface;
use Yii;
use yii\base\Action;
use yii\di\Instance;

class Process extends Action
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
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        $result = $this->manager->processRequest($get, $post);
        if (!is_bool($result)) {
            return $result;
        }
        return $this->controller->refresh();
    }
}