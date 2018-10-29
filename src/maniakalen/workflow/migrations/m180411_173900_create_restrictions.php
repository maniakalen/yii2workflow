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

class m180411_173900_create_restrictions extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('{{%m_workflow_step_restrictions}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'restriction_type' => "ENUM('callback', 'field')",
            'restriction' => $this->text(),
            'comparison' => "ENUM('>', '<', '=', '!=')",
            'value' => $this->string(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('workflow_step_restrictions');
    }
}