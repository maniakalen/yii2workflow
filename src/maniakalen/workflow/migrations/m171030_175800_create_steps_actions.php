<?php
/**
 * PHP Version 5.5
 *
 *  $DESCRIPTION$ $END$
 *
 * @category $Category$ $END$
 * @package  $Package$ $END$
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     $LINK$ $END$
 */

class m171030_175800_create_steps_actions extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow_step_actions', [
            'id' => $this->primaryKey(),
            'step_id' => $this->integer(),
            'action_id' => $this->integer(),
            'next_step_action_id' => $this->integer(),
            'permission' => $this->string(64),
            'custom_callback' => $this->text(),
            'status' => $this->boolean()
        ]);

        $this->addForeignKey(
            'fk-workflow_steps_actions-step_id',
            'workflow_step_actions',
            'step_id',
            'workflow_steps',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-workflow_steps_actions-action_id',
            'workflow_step_actions',
            'action_id',
            'workflow_actions',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-workflow_steps_actions-next_step_action_id',
            'workflow_step_actions',
            'next_step_action_id',
            'workflow_step_actions',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('workflow_step_actions');
    }
}