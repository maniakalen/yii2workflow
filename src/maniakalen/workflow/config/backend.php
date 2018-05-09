<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 13/04/2018
 * Time: 8:42
 */

return [
    'routes' => [
        'GET <module:([module])>/admin/workflow-grid' => '<module>/admin/workflow-grid',
        'GET <module:([module])>/admin/workflow-steps-grid' => '<module>/admin/workflow-steps-grid',
        'GET <module:([module])>/admin/workflow-actions-grid' => '<module>/admin/workflow-actions-grid',
        'GET <module:([module])>/admin/workflow-restriction-groups-grid' => '<module>/admin/workflow-restriction-groups-grid',
        'GET <module:([module])>/admin/workflow-restrictions-grid/<id:\d+>' => '<module>/admin/workflow-restriction-groups-grid',
        'GET <module:([module])>/admin/workflow-steps-actions-grid' => '<module>/admin/workflow-steps-actions-grid',

        'GET <module:([module])>/admin/workflow-details/<id:\d+>' => '<module>/admin/workflow-details',
        'GET <module:([module])>/admin/workflow-step-details/<id:\d+>' => '<module>/admin/workflow-step-details',
        'GET <module:([module])>/admin/workflow-action-details/<id:\d+>' => '<module>/admin/workflow-action-details',
        'GET <module:([module])>/admin/workflow-restriction-group-details/<id:\d+>' => '<module>/admin/workflow-restriction-groups-details',
        'GET <module:([module])>/admin/workflow-restriction-details/<id:\d+>' => '<module>/admin/workflow-restriction-details',
        'GET <module:([module])>/admin/workflow-step-action-details/<id:\d+>' => '<module>/admin/workflow-step-action-details',

        'GET <module:([module])>/admin/workflow-delete/<id:\d+>' => '<module>/admin/workflow-delete',
        'GET <module:([module])>/admin/workflow-step-delete/<id:\d+>' => '<module>/admin/workflow-step-delete',
        'GET <module:([module])>/admin/workflow-action-delete/<id:\d+>' => '<module>/admin/workflow-action-delete',
        'GET <module:([module])>/admin/workflow-restriction-group-delete/<id:\d+>' => '<module>/admin/workflow-restriction-groups-delete',
        'GET <module:([module])>/admin/workflow-restriction-delete/<id:\d+>' => '<module>/admin/workflow-restriction-delete',
        'GET <module:([module])>/admin/workflow-step-action-delete/<id:\d+>' => '<module>/admin/workflow-step-action-delete',

        'GET <module:([module])>/admin/workflow-toggle/<id:\d+>' => '<module>/admin/workflow-toggle',
        'GET <module:([module])>/admin/workflow-step-toggle/<id:\d+>' => '<module>/admin/workflow-step-toggle',
        'GET <module:([module])>/admin/workflow-action-toggle/<id:\d+>' => '<module>/admin/workflow-action-toggle',
        'GET <module:([module])>/admin/workflow-restriction-group-toggle/<id:\d+>' => '<module>/admin/workflow-restriction-groups-toggle',
        'GET <module:([module])>/admin/workflow-restriction-toggle/<id:\d+>' => '<module>/admin/workflow-restriction-toggle',

        'GET <module:([module])>/admin/workflow-create' => '<module>/admin/workflow-details',
        'GET <module:([module])>/admin/workflow-step-create' => '<module>/admin/workflow-step-details',
        'GET <module:([module])>/admin/workflow-action-create' => '<module>/admin/workflow-action-details',
        'GET <module:([module])>/admin/workflow-restriction-group-create' => '<module>/admin/workflow-restriction-groups-details',
        'GET <module:([module])>/admin/workflow-restriction-create' => '<module>/admin/workflow-restriction-details',
        'GET <module:([module])>/admin/workflow-step-action-create' => '<module>/admin/workflow-step-action-details',

        'POST <module:([module])>/admin/workflow-details/<id:\d+>' => '<module>/admin/workflow-details-edit',
        'POST <module:([module])>/admin/workflow-step-details/<id:\d+>' => '<module>/admin/workflow-step-details-edit',
        'POST <module:([module])>/admin/workflow-action-details/<id:\d+>' => '<module>/admin/workflow-action-details-edit',
        'POST <module:([module])>/admin/workflow-restriction-group-details/<id:\d+>' => '<module>/admin/workflow-restriction-groups-details-edit',
        'POST <module:([module])>/admin/workflow-restriction-details/<id:\d+>' => '<module>/admin/workflow-restriction-details-edit',
        'POST <module:([module])>/admin/workflow-step-action-details/<id:\d+>' => '<module>/admin/workflow-step-action-details-edit',

        'POST <module:([module])>/admin/workflow-create' => '<module>/admin/workflow-create',
        'POST <module:([module])>/admin/workflow-step-create' => '<module>/admin/workflow-step-create',
        'POST <module:([module])>/admin/workflow-action-create' => '<module>/admin/workflow-action-create',
        'POST <module:([module])>/admin/workflow-restriction-group-create' => '<module>/admin/workflow-restriction-groups-create',
        'POST <module:([module])>/admin/workflow-restriction-create' => '<module>/admin/workflow-restriction-create',
        'POST <module:([module])>/admin/workflow-step-action-create' => '<module>/admin/workflow-step-action-create',
    ],
];