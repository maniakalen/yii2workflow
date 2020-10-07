<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 23/04/2018
 * Time: 16:42
 */

namespace maniakalen\workflow\components;


use maniakalen\workflow\interfaces\ActionServiceInterface;
use maniakalen\workflow\interfaces\StepServiceInterface;
use maniakalen\workflow\interfaces\WorkflowManagerInterface;
use maniakalen\workflow\models\Workflow;
use maniakalen\workflow\models\WorkflowStepActions;
use maniakalen\workflow\models\WorkflowSteps;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\View;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class WorkflowManager
    extends Component
    implements WorkflowManagerInterface
{
    /**
     * @param array $get
     * @param array $post
     * @return bool
     * @throws BadRequestHttpException
     */
    public function processRequest(array $get, array $post = [])
    {
        try {
            $stepService = $this->getRequestStepService($get);
            $stepService->setPostRequestParams($post);
            $action = $this->getRequestAction($post);
            return $action->process($stepService);
        } catch (NotFoundHttpException $ex) {
            \Yii::warning("Workflow request without step component", "workflow");
        } catch (InvalidConfigException $e) {
            \Yii::warning("Service configuration not found", "workflow");
        }
        return false;
    }

    public function renderRequest(array $get, View $view)
    {
        try {
            $stepService = $this->getRequestStepService($get);
            return $stepService->render($view);
        } catch (\Exception $ex) {
            \Yii::error($ex->getMessage(), "workflow");
            return false;
        }
    }
    public function getWorkflowById($id)
    {
        return Workflow::findOne($id);
    }

    public function getWorkflowStepById($id)
    {
        return WorkflowSteps::findOne($id);
    }

    public function getWorkflowByUrl($urlPart)
    {
        return Workflow::findOne(['url_route' => $urlPart]);
    }

    public function getWorkflowStepByUrl($urlPart)
    {
        return WorkflowSteps::findOne(['url_route' => $urlPart]);
    }

    /**
     * @param $get
     * @return StepServiceInterface
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function getRequestStepService($get)
    {
        $step = $this->getWorkflowStepFromRequest($get);
        /** @var StepServiceInterface $service */
        $stepService = (array)json_decode($step->service_class) or $stepService = $step->service_class;
        $service = \Yii::createObject($stepService);
        $service->setStep($step);
        $service->setGetRequestParams($get);
        return $service;
    }

    protected function validateWorkflowRequest($get)
    {
        return isset($get['wf_url']) || isset($get['wf_id']);
    }
    protected function validateWorkflowStepRequest($get)
    {
        return isset($get['step_url']) || isset($get['step_id']);
    }

    /**
     * @param array $get
     * @return Workflow|null
     * @throws NotFoundHttpException
     */
    protected function getWorkflowFromRequest($get)
    {
        if (!$this->validateWorkflowRequest($get)) {
            throw new NotFoundHttpException("Workflow url component missing");
        }
        return isset($get['wf_id'])?$this->getWorkflowById($get['wf_id']):$this->getWorkflowByUrl($get['wf_url']);
    }

    /**
     * @param array $get
     * @return WorkflowSteps|null
     * @throws NotFoundHttpException
     */
    protected function getWorkflowStepFromRequest($get)
    {
        if (!$this->validateWorkflowStepRequest($get)) {
            throw new NotFoundHttpException("Workflow url component missing");
        }
        return isset($get['step_id'])?$this->getWorkflowStepById($get['step_id']):$this->getWorkflowStepByUrl($get['step_url']);
    }

    /**
     * @param array $post
     * @return ActionServiceInterface
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    protected function getRequestAction(array $post)
    {
        if (!isset($post['action'])) {
            throw new BadRequestHttpException("No action provided in post");
        }
        $keys = $post['action'];
        $actionId = reset($keys);
        $stepAction = WorkflowStepActions::findOne($actionId);
        if (!$stepAction) {
            throw new BadRequestHttpException("No action found with id provided");
        }

        $action = $stepAction->action;
        /**
         * @var ActionServiceInterface $actionService
         */
        $actionService = (array)json_decode($action->service_class) or $actionService = $action->service_class;
        $actionService = \Yii::createObject($actionService);
        if ($stepAction->callback) {
            $actionService->setCallback($stepAction->callback);
        }
        return $actionService;
    }

    public function getWorkflowSteps(Workflow $workflow, $level)
    {
        $steps = $workflow->workflowSteps;
        while (($level--) > 1) {
            $parents = $steps;
            $steps = [];
            foreach ($parents as $step) {
                $steps = ArrayHelper::merge($steps, $this->getStepChildren($step));
            }
        }
        return $steps;
    }

    protected function getStepChildren(WorkflowSteps $step)
    {
        return $step->workflowSteps;
    }

    /**
     * @param array $get
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function getWorkflowLayout(array $get)
    {
        $workflow = $this->getWorkflowFromRequest($get);
        return $workflow->layout;
    }
}