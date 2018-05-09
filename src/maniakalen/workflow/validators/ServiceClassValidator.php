<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 19/04/2018
 * Time: 13:28
 */

namespace maniakalen\workflow\validators;


use maniakalen\workflow\interfaces\StepServiceInterface;
use yii\validators\Validator;

class ServiceClassValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = \Yii::t('workflow', 'Service class not found');
    }

    public function validateValue($value)
    {
        try {
            $valueDecoded = (array)json_decode($value) or $valueDecoded = $value;
            $object = \Yii::createObject($valueDecoded);
            if ($object instanceof StepServiceInterface) {
                return null;
            }
        } catch (\Exception $ex) {
            \Yii::error("Failed to validate value", "workflow");
        }

        return [$this->message, []];
    }
}