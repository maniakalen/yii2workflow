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

namespace linear\workflow\migrations;

class m171030_115200_create_steps extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'route' => $this->string()->notNull(),
            'steps_class_dir' => $this->string()->notNull(),
            'status' => $this->boolean()
        ]);
    }

    public function down()
    {
        $this->dropTable('workflow');
    }
}