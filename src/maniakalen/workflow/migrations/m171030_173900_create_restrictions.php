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

class m171030_173900_create_restrictions extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow_step_restrictions', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'restriction_type' => "ENUM('callback', 'field')",
            'restriction' => $this->text(),
            'comparison' => "ENUM('>', '<', '=', '!=')",
            'value' => $this->string(),
        ]);
        $this->addForeignKey(
            'fk-workflow_rest_steps-step_id',
            'workflow_step_restrictions',
            'group_id',
            'workflow_step_restrictions_groups',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropTable('workflow_step_restrictions');
    }
}