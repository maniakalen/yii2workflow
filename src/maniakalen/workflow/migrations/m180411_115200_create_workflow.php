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

namespace maniakalen\workflow\migrations;

class m180411_115200_create_workflow extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%m_workflow}}',
            [
            'id' => $this->primaryKey(),
            'url_route' => $this->string(45)->notNull(),
            'name' => $this->string(),
            'description' => $this->text(),
            'status' => $this->boolean(),
            'auto_transit' => $this->boolean()
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%workflow}}');
    }
}