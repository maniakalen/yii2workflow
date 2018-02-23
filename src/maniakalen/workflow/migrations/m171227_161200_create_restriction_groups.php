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

class m171030_173900_create_restriction_groups extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow_step_restrictions_groups', [
            'id' => $this->primaryKey(),
            'step_action_id' => $this->integer()->null(),
            'title' => $this->string(64),
            'status' => $this->boolean()->defaultValue(true)
        ]);
        $this->addForeignKey(
            'fk-workflow_rest_steps-step_id',
            'workflow_step_restrictions_groups',
            'step_action_id',
            'workflow_step_actions',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropTable('workflow_step_restrictions_groups');
    }
}