<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 11/04/2018
 * Time: 15:07
 */

namespace maniakalen\workflow\migrations;

use yii\db\Migration;

class m180411_150700_create_step_actions extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%workflow_step_actions}}',
            [
                'id' => $this->primaryKey(),
                'workflow_step_id' => $this->integer(),
                'workflow_action_id' => $this->integer(),
                'auth_item_name' => $this->string(64),
                'name' => $this->string(255),
                'callback' => $this->text(),
                'display_group' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%workflow_step_actions}}');
    }
}