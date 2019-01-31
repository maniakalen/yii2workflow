<?php
namespace maniakalen\workflow\migrations;
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 02/11/2018
 * Time: 11:03
 */
use Yii;

class m190131_085014_alter_workflows extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $this->addColumn('{{%m_workflow}}', 'layout', $this->string());

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
            $this->dropColumn('{{%m_workflow}}', 'layout');

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to remove new column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}