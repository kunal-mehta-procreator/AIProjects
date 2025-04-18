<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class AdminNavWidget extends Widget
{
    public $items = [];
    
    public function init()
    {
        parent::init();
        if (empty($this->items)) {
            $this->items = $this->getDefaultItems();
        }
    }

    public function run()
    {
        return $this->render('admin-nav', [
            'items' => $this->items
        ]);
    }

    protected function getDefaultItems()
    {
        return [
            [
                'label' => 'Dashboard',
                'icon' => 'dashboard',
                'url' => ['/admin/dashboard'],
            ],
            [
                'label' => 'Organization Setup',
                'icon' => 'organization',
                'url' => ['/admin/organization'],
                'items' => [
                    ['label' => 'Organization Info', 'url' => ['/admin/organization/info']],
                    ['label' => 'Organization Units', 'url' => ['/admin/organization/units']],
                ]
            ],
            [
                'label' => 'User Management',
                'icon' => 'users',
                'url' => ['/admin/users'],
                'items' => [
                    ['label' => 'Access Levels', 'url' => ['/admin/users/access-levels']],
                    ['label' => 'Roles', 'url' => ['/admin/users/roles']],
                ]
            ],
            [
                'label' => 'Activity Logs',
                'icon' => 'activity',
                'url' => ['/admin/activity-logs'],
            ],
            [
                'label' => 'Downloads',
                'icon' => 'download',
                'url' => ['/admin/downloads'],
            ],
            [
                'label' => 'Settings',
                'icon' => 'settings',
                'url' => ['/admin/settings'],
            ],
        ];
    }
} 