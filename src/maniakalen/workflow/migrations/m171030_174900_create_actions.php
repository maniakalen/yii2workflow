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

class m171030_174900_create_actions extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow_actions', [
            'id' => $this->primaryKey(),
            'action_type' => "ENUM('a', 'submitButton')",
            'title' => $this->string(255),
            'action' => $this->text(),
            'template' => $this->string(255),
            'display_options' => $this->text(),
            'status' => $this->boolean()
        ]);
    }

    public function down()
    {
        $this->dropTable('workflow_actions');
    }
}