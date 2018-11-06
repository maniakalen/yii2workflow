<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 06/11/2018
 * Time: 13:37
 */

namespace maniakalen\workflow\helpers;


use maniakalen\workflow\models\WorkflowStepActions;
use yii\helpers\ArrayHelper;

class ActionsHelper
{
    public static function fetchActions($step, $group)
    {
        return ArrayHelper::map(
            WorkflowStepActions::fetchAll(['workflow_step_id' => $step, 'display_group' => $group]),
            'id',
            'action'
        );
    }
}