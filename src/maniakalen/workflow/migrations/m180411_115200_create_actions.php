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

class m180411_115200_create_actions extends \yii\db\Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%m_workflow_actions}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(45)->notNull(),
                'type' => "ENUM('a', 'input', 'button')",
                'styles' => $this->text(),
                'service_class' => $this->string(255)->notNull(),
                'status' => $this->boolean(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%workflow_actions}}');
    }
}