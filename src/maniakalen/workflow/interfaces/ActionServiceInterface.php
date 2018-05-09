<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 24/04/2018
 * Time: 14:56
 */

namespace maniakalen\workflow\interfaces;


interface ActionServiceInterface
{
    public function setCallback($callback);
    public function process(StepServiceInterface $step);
}