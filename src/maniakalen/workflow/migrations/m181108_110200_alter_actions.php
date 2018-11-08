<?php
namespace maniakalen\workflow\migrations;
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 02/11/2018
 * Time: 11:03
 */
use Yii;

class m181108_110200_alter_actions extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $this->alterColumn('{{%m_workflow_actions}}', 'name', $this->integer(255));

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to modify column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }

        return false;
    }

    public function safeDown()
    {
        try {
            $this->alterColumn('{{%m_workflow_actions}}', 'name', $this->integer(45));

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to revert column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}