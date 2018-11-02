<?php
namespace maniakalen\workflow\migrations;
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 02/11/2018
 * Time: 11:03
 */
use Yii;

class m181102_110200_alter_steps extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $this->addColumn('{{%m_workflow_steps}}', 'prev_step_id', $this->integer());

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to add new column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }

        return false;
    }

    public function safeDown()
    {
        try {
            $this->dropColumn('{{%m_workflow_steps}}', 'prev_step_id');

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to remove new column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}