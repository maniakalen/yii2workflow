<?php
namespace maniakalen\workflow\migrations;
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 02/11/2018
 * Time: 11:03
 */
use Yii;

class m181204_120000_alter_restrictions extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $this->renameTable('{{%m_workflow_step_restrictions}}', '{{%m_workflow_restrictions}}');
            $this->renameTable('{{%m_workflow_step_restrictions_groups}}', '{{%m_workflow_restrictions_groups}}');
            $this->addColumn('{{%m_workflow_restrictions}}', 'apply_type', 'ENUM("render", "process")');

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to add column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }

        return false;
    }

    public function safeDown()
    {
        try {
            $this->dropColumn('{{%m_workflow_restrictions}}', 'apply_type');
            $this->renameTable('{{%m_workflow_restrictions}}', '{{%m_workflow_step_restrictions}}');
            $this->renameTable('{{%m_workflow_restrictions_groups}}', '{{%m_workflow_step_restrictions_groups}}');
            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to revert column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}