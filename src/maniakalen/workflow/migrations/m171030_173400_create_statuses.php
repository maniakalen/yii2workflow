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

class m171030_173400_create_statuses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('workflow_status', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'active' => $this->boolean(),
        ]);
    }

    public function down()
    {
        $this->dropTable('workflow_status');
    }
}