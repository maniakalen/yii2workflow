<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 11/04/2018
 * Time: 15:16
 */

namespace maniakalen\workflow\migrations;

use yii\db\Migration;
use yii\helpers\Console;

class m180412_150700_create_indices_and_forein_keys extends Migration
{
    public function safeUp()
    {
        try {
            /** Workflow */
            if ($this->db->getTableSchema('{{%workflow}}')) {
                $this->createIndex('idx_route_search_workflow', '{{%workflow}}', 'url_route');
                $this->createIndex('idx_status_workflow', '{{%workflow}}', 'status');
                $this->createIndex('idx_auto_transit_workflow', '{{%workflow}}', 'auto_transit');
            }

            /** Workflow steps */
            if ($this->db->getTableSchema('{{%workflow_steps}}')) {
                $this->createIndex('idx_route_search_workflow_step', '{{%workflow_steps}}', 'url_route');
                if ($this->db->getTableSchema('{{%workflow}}')) {
                    $this->addForeignKey('idx_fk_workflow_steps_wf_id', '{{%workflow_steps}}', 'workflow_id', '{{%workflow}}', 'id', 'CASCADE', 'CASCADE');
                }
                $this->addForeignKey('idx_fk_workflow_steps_parent_id', '{{%workflow_steps}}', 'parent_id', '{{%workflow_steps}}', 'id', 'CASCADE', 'CASCADE');
                $this->createIndex('idx_uq_workflow_steps_order_idx', '{{%workflow_steps}}', ['workflow_id', 'parent_id', 'order_index'], true);
                $this->createIndex('idx_status_workflow_steps', '{{%workflow_steps}}', 'status');
            }
            /** Workflow actions */
            if ($this->db->getTableSchema('{{%workflow_actions}}')) {
                $this->createIndex('idx_wf_actions_type', '{{%workflow_actions}}', 'type');
                $this->createIndex('idx_wf_actions_status', '{{%workflow_actions}}', 'status');
            }
            /** Workflow step actions */
            if ($this->db->getTableSchema('{{%workflow_step_actions}}')) {
                $this->createIndex('idx_step_actions_uq', '{{%workflow_step_actions}}', ['workflow_step_id', 'workflow_action_id'], true);
            }
            //$this->addForeignKey('idx_fk_workflow_step_actions_auth_item', '{{%workflow_step_actions}}','auth_item_name','auth_item', 'name','CASCADE','CASCADE');

            /** Workflow step restrictions */
            if ($this->db->getTableSchema('{{%workflow_step_restrictions_groups}}')) {
                $this->addForeignKey(
                    'fk_workflow_rest_steps_group_id',
                    '{{%workflow_step_restrictions}}',
                    'group_id',
                    '{{%workflow_step_restrictions_groups}}',
                    'id',
                    'CASCADE'
                );
            }
        } catch (\Exception $e) {
            printf($e->getMessage() . "\n");
            $this->safeDown();
            return false;
        }
        return true;
    }
    public function safeDown()
    {
        $ex = [];
        try {
            if ($this->db->getTableSchema('{{%workflow}}')) {
                $this->dropIndex('idx_route_search_workflow', '{{%workflow}}');
                $this->dropIndex('idx_status_workflow', '{{%workflow}}');
                $this->dropIndex('idx_auto_transit_workflow', '{{%workflow}}');
            }
        } catch (\Exception $e) {
            Console::stdout($e->getMessage());
            $ex[] = $e->getMessage();
        }
        try {
            if ($this->db->getTableSchema('{{%workflow_steps}}')) {
                $this->dropForeignKey('idx_fk_workflow_steps_wf_id', '{{%workflow_steps}}');
                $this->dropForeignKey('idx_fk_workflow_steps_parent_id', '{{%workflow_steps}}');

                $this->dropIndex('idx_route_search_workflow_step', '{{%workflow_steps}}');
                $this->dropIndex('idx_uq_workflow_steps_order_idx', '{{%workflow_steps}}');
                $this->dropIndex('idx_status_workflow_steps', '{{%workflow_steps}}');
            }
        } catch (\Exception $e) {
            Console::stdout($e->getMessage());
            $ex[] = $e->getMessage();
        }
        try {
            if ($this->db->getTableSchema('{{%workflow_actions}}')) {
                $this->dropIndex('idx_wf_actions_type', '{{%workflow_actions}}');
                $this->dropIndex('idx_wf_actions_status', '{{%workflow_actions}}');

            }
        } catch (\Exception $e) {
            Console::stdout($e->getMessage());
            $ex[] = $e->getMessage();
        }
        try {
            if ($this->db->getTableSchema('{{%workflow_step_actions}}')) {
                $this->dropPrimaryKey('idx_step_actions_pk', '{{%workflow_step_actions}}');
            }
        } catch (\Exception $e) {
            Console::stdout($e->getMessage());
            $ex[] = $e->getMessage();
        }
        try {
            if ($this->db->getTableSchema('{{%workflow_step_restrictions_groups}}')) {
                $this->dropForeignKey('fk_workflow_rest_steps_group_id', '{{%workflow_step_restrictions}}');
            }
        } catch (\Exception $e) {
            Console::stdout($e->getMessage());
            $ex[] = $e->getMessage();
        }
        if (!empty($ex)) {
            print(implode("\n", $ex));
            return false;
        }
        return true;
    }
}