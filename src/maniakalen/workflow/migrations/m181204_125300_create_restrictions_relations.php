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

class m181204_125300_create_restrictions_relations extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('m_workflow_restrictions_relations', [
            'id' => $this->primaryKey(),
            'restriction_id' => $this->integer()->notNull(),
            'relation_type' => "ENUM('step', 'action')",
            'related_id' => $this->integer()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('m_workflow_restrictions_relations');
    }
}