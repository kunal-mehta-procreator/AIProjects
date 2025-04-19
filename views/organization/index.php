<?php

use app\widgets\EnhancedGridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Organization Units Type';

// Define the filter dropdowns
$filterDropdowns = [
    [
        'label' => 'Org. Unit T...',
        'attribute' => 'organization_unit_type',
        'items' => [
            '' => 'All',
            'Faculty' => 'Faculty',
            'Administration' => 'Administration',
            'Campus' => 'Campus',
            'Branch' => 'Branch',
            'Hostel' => 'Hostel',
            'School' => 'School',
            'Office' => 'Office',
        ],
    ],
    [
        'label' => 'Status',
        'attribute' => 'status',
        'items' => [
            '' => 'All',
            'Active' => 'Active',
            'Inactive' => 'Inactive',
        ],
    ],
];

// Define the grid columns
$gridColumns = [
    [
        'class' => 'yii\grid\CheckboxColumn',
        'headerOptions' => ['style' => 'width: 30px;'],
    ],
    [
        'attribute' => 'id',
        'label' => 'ID',
        'headerOptions' => ['style' => 'width: 80px;'],
    ],
    [
        'attribute' => 'name',
        'label' => 'NAME',
        'format' => 'raw',
        'value' => function($model) {
            return Html::a($model->name, ['view', 'id' => $model->id], [
                'class' => 'text-decoration-none text-reset fw-medium'
            ]);
        },
    ],
    [
        'attribute' => 'organization_unit_type',
        'label' => 'ORGANIZATION UNIT TYPE',
    ],
    [
        'attribute' => 'parent',
        'label' => 'PARENT',
    ],
    [
        'attribute' => 'institute_name',
        'label' => 'INSTITUTE NAME',
    ],
    [
        'attribute' => 'status',
        'label' => 'STATUS',
        'format' => 'raw',
        'value' => function($model) {
            $class = $model->status === 'Active' ? 'active' : 'inactive';
            return Html::tag('span', $model->status, ['class' => "status-badge $class"]);
        },
        'headerOptions' => ['style' => 'width: 100px;'],
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'view' => function ($url) {
                return Html::a('<i class="fas fa-eye"></i>', $url, [
                    'class' => 'btn-action',
                    'title' => 'View',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'update' => function ($url) {
                return Html::a('<i class="fas fa-edit"></i>', $url, [
                    'class' => 'btn-action',
                    'title' => 'Edit',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
            'delete' => function ($url) {
                return Html::a('<i class="fas fa-ellipsis-v"></i>', $url, [
                    'class' => 'btn-action',
                    'title' => 'More',
                    'data-bs-toggle' => 'tooltip',
                ]);
            },
        ],
        'headerOptions' => ['style' => 'width: 100px;'],
    ],
];

// Render the grid
echo EnhancedGridView::widget([
    'id' => 'organization-grid',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'headerTitle' => 'Organization Units Type',
    'headerDescription' => 'Create and manage organization unit types for improved structure and efficiency.',
    'filterDropdowns' => $filterDropdowns,
    'toolbar' => [
        'content' => Html::a(
            '<i class="fas fa-plus"></i> ADD ORGANIZATION UNIT TYPE',
            ['create'],
            ['class' => 'btn-add']
        ),
    ],
    'customStyle' => [
        'headerBg' => '#ffffff',
        'headerTextColor' => '#2c3e50',
        'borderColor' => '#e2e8f0',
        'activeColor' => '#6366f1',
        'hoverBg' => '#f8fafc',
    ],
    'pager' => [
        'options' => ['class' => 'pagination modern-pagination'],
        'maxButtonCount' => 5,
        'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
        'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
        'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
        'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
    ],
]);