<?php
/**
 * PHP Version 5.5
 *
 *  Linear workflow step interface
 *
 * @category workflow\steps
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\workflow\interfaces;

use yii\base\Response;
use yii\web\User;

/**
 * PHP Version 5.5
 *
 *  Linear workflow step interface
 *
 * @category workflow\steps
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
interface StepInterface
{
    /**
     * Returns the next step of the workflow chain
     *
     * return StepInterface|null
     */
    public function getNextStep();

    /**
     * Returns the prev step of the workflow chain
     *
     * return StepInterface|null
     */
    public function getPrevStep();

    /**
     * Retirns an array of defined step restrictions in order to be considered satisfied and can be passed on next one
     *
     * @return array
     */
    public function getRestrictions();

    /**
     * Verifies the if the model current stats satisfies the step restrictions to be passed on next one
     *
     * @param WorkflowServiceInterface $model the component model to be manipulated inside the step
     *
     * @return Response
     */
    public function satisfiesRestrictions(WorkflowServiceInterface $model);
    /**
     * Executes the given step
     *
     * @param WorkflowServiceInterface $model the component model to be manipulated inside the step
     *
     * @return Response
     */
    public function run(WorkflowServiceInterface $model);

    /**
     * Confirms if the provided user has permission to access given step
     *
     * @param User $user The user whose access should be verified
     *
     * @return bool
     */
    public function isAccessible(User $user);

    /**
     * Confirms if the provided user has permission to access given step
     *
     * @param User $user The user whose edit permissions should be verified
     *
     * @return bool
     */
    public function isEditable(User $user);
}