<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 24/04/2018
 * Time: 11:35
 */

namespace maniakalen\workflow\interfaces;


use yii\base\View;

interface WorkflowManagerInterface
{
    public function processRequest(array $get, array $post = []);

    /**
     * @param array $get
     * @param View $view
     * @return string
     */
    public function renderRequest(array $get, View $view);
}