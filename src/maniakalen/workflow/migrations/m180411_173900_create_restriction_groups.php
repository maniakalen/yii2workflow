<?php
namespace maniakalen\workflow\migrations;
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

class m180411_173900_create_restriction_groups extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('{{%workflow_step_restrictions_groups}}', [
            'id' => $this->primaryKey(),
            'step_id' => $this->integer()->null(),
            'action_id' => $this->integer()->null(),
            'title' => $this->string(64),
            'status' => $this->boolean()->defaultValue(true),
            'target_step_id' => $this->integer()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%workflow_step_restrictions_groups}}');
    }
}