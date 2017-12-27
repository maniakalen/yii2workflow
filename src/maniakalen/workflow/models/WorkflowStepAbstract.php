<?php
/**
 * PHP Version 5.5
 *
 *  Linear workflow step abstract
 *
 * @category workflow\steps
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\workflow\models;

use maniakalen\workflow\exceptions\WorkflowException;
use maniakalen\workflow\interfaces\StepInterface;
use maniakalen\workflow\interfaces\WorkflowServiceInterface;
use yii\base\Response;
use yii\db\ActiveRecord;
use yii\web\User;

/**
 * PHP Version 5.5
 *
 *  Linear workflow step abstract
 *
 * @category workflow_steps
 * @package  maniakalen_workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
abstract class WorkflowStepAbstract extends ActiveRecord implements StepInterface
{

    public static function tableName()
    {
        return 'workflow_steps';
    }

    /**
     * Returns the next step of the workflow chain
     *
     * return StepInterface|null
     */
    public function getNextStep()
    {
        return $this->hasOne(self::className(), ['id' => 'next_id']);
    }

    /**
     * Returns the prev step of the workflow chain
     *
     * return StepInterface|null
     */
    public function getPrevStep()
    {
        return $this->hasOne(self::className(), ['next_id' => 'id']);
    }

    /**
     * Retirns an array of defined step restrictions in order to be considered satisfied and can be passed on next one
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestrictions()
    {
        return $this->hasMany(WorkflowStepRestrictionGroups::className(), ['step_id' => 'id']);
    }

    /**
     * Verifies the if the model current stats satisfies the step restrictions to be passed on next one
     *
     * @param WorkflowServiceInterface $model the component model to be manipulated inside the step
     *
     * @return mixed
     */
    public function satisfiesRestrictions(WorkflowServiceInterface $model)
    {
        foreach ($this->restrictions as $restriction)
        {
            if ($restriction instanceof WorkflowStepRestrictions && !$restriction->satisfied($model)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Executes the given step
     *
     * @param WorkflowServiceInterface $model the component model to be manipulated inside the step
     *
     * @return void
     * @throws WorkflowException
     */
    public function run(WorkflowServiceInterface $model)
    {
        throw new WorkflowException("Method run not yet implemented");
    }

    /**
     * Confirms if the provided user has permission to access given step
     *
     * @param User $user The user whose access should be verified
     *
     * @return bool
     */
    public function isAccessible(User $user)
    {
        return $user->can($this->getAccessPermission());
    }

    /**
     * Confirms if the provided user has permission to access given step
     *
     * @param User $user The user whose edit permissions should be verified
     *
     * @return bool
     */
    public function isEditable(User $user)
    {
        return $user->can($this->getAccessPermission());
    }

    /**
     * Retreives the access permission
     *
     * @return string
     */
    public function getAccessPermission()
    {
        return '';
    }
    /**
     * Retreives the edit permission
     *
     * @return string
     */
    public function getEditPermission()
    {
        return '';
    }

    /**
     * Retreives the full step status label translation
     *
     * @return string
     */
    public function getStepStatusLabel()
    {
        return '';
    }
}