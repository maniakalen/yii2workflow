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

class m180417_100000_define_permissions extends \yii\db\Migration
{
    public function safeUp()
    {
        try {
            $authManager = Yii::$app->getAuthManager();
            if (!$authManager instanceof DbManager) {
                throw new InvalidConfigException(
                    'You should configure "authManager" component to use 
            database before executing this migration.'
                );
            }
            $time = time();
            $this->batchInsert(
                $authManager->itemTable,
                ['name', 'type', 'description', 'created_at', 'updated_at'],
                [
                    [
                        'maniakalen\workflow\view',
                        Item::TYPE_PERMISSION,
                        'Permissions to view the configured workflows',
                        $time,
                        $time
                    ],
                    [
                        'maniakalen\workflow\edit',
                        Item::TYPE_PERMISSION,
                        'Permissions to edit workflow configurations',
                        $time,
                        $time
                    ],
                    [
                        'maniakalen\workflow\delete',
                        Item::TYPE_PERMISSION,
                        'Permissions to delete workflows',
                        $time,
                        $time
                    ]
                ]
            );

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to apply permissions migration', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }

        return false;
    }

    public function safeDown()
    {
        try {
            $authManager = Yii::$app->getAuthManager();
            if (!$authManager instanceof DbManager) {
                throw new InvalidConfigException(
                    'You should configure "authManager" component to use 
            database before executing this migration.'
                );
            }

            $this->delete(
                $authManager->itemTable,
                [
                    'in',
                    'name',
                    [
                        'maniakalen\workflow\view',
                        'maniakalen\workflow\edit',
                        'maniakalen\workflow\delete'
                    ]
                ]
            );

            return true;
        } catch (\Exception $ex) {
            Yii::error('Failed to migrate down permissions migration', 'workflow');
            Yii::error($ex->getMessage(), 'workflow');
        }
        return false;
    }
}