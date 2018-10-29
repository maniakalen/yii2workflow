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
use Yii;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
use yii\rbac\Item;

class m180508_100000_alter_steps extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $this->addColumn('{{%m_workflow_steps}}', 'auth_item_name', $this->string(64));

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
            $this->dropColumn('{{%m_workflow_steps}}', 'auth_item_name');

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to remove new column', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}