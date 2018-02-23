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

class m171030_115200_create_steps extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow_steps', [
            'id' => $this->primaryKey(),
            'workflow_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->null(),
            'status_id' => $this->integer(),
            'view' => $this->string(128),
            'class' => $this->string(255),
            'callback' => $this->text(),
            'title' => $this->text(),
            'active' => $this->boolean(),
            'access_control' => $this->string(128),
            'edit_control' => $this->string(128),
        ]);

        $this->addForeignKey(
            'fk-workflow_steps-parent_id',
            'workflow_steps',
            'parent_id',
            'workflow_steps',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-workflow_main_id',
            'workflow_steps',
            'workflow_id',
            'workflow',
            'id',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable('workflow_steps');
    }
}