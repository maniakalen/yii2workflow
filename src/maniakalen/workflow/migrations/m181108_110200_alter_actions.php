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
            $this->alterColumn('{{%m_workflow_actions}}', 'name', $this->string(255));
            $this->alterColumn('{{%m_workflow_actions}}', 'type', "ENUM('a', 'input', 'button')");

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
            $this->alterColumn('{{%m_workflow_actions}}', 'name', $this->string(45));
            $this->alterColumn('{{%m_workflow_actions}}', 'type', "ENUM('a', 'input')");
            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to revert column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}