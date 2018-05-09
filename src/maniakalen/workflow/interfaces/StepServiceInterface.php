<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 19/04/2018
 * Time: 13:33
 */

namespace maniakalen\workflow\interfaces;


use yii\base\View;
use yii\base\ViewContextInterface;

interface StepServiceInterface extends ViewContextInterface
{
    public function setGetRequestParams(array $params);
    public function setPostRequestParams(array $params);

    public function getStep();
    public function setStep($step);

    /**
     * @param array $get
     * @return
     */
    public function render(View $view);
}