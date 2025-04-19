<?php

namespace app\widgets;

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;

class AdminGridView extends GridView
{
    /**
     * @var string the default theme
     */
    public $theme = 'bootstrap5';

    /**
     * @var string the default layout
     */
    public $layout = '
        <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    {summary}
                    {toggleData}
                </div>
                <div class="d-flex align-items-center gap-2">
                    {toolbar}
                </div>
            </div>
            {items}
            <div class="d-flex justify-content-between align-items-center">
                <div>{pager}</div>
                <div>{export}</div>
            </div>
        </div>';

    /**
     * @var array the panel configuration
     */
    public $panel = [
        'type' => 'default',
        'heading' => false,
        'before' => false,
        'after' => false,
        'footer' => false,
    ];

    /**
     * @var array the toolbar configuration
     */
    public $toolbar = [];

    /**
     * @var array the export menu configuration
     */
    public $exportConfig = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Configure default styling
        $this->tableOptions = ArrayHelper::merge([
            'class' => 'table table-striped table-hover',
            'style' => 'margin-bottom: 0;'
        ], $this->tableOptions);

        // Configure Pjax
        $this->pjax = true;
        $this->pjaxSettings = [
            'options' => [
                'id' => 'admin-grid-pjax',
                'class' => 'pjax-container',
                'timeout' => 5000,
            ],
        ];

        // Configure filters
        $this->filterRowOptions = ['class' => 'filter-row'];
        $this->filterPosition = self::FILTER_POS_HEADER;
        $this->filterModel = $this->dataProvider->getModels()[0] ?? null;

        // Configure responsive settings
        $this->responsive = true;
        $this->responsiveWrap = false;
        $this->hover = true;
        $this->striped = true;
        $this->bordered = false;
        $this->condensed = true;

        // Configure export settings
        $this->export = [
            'fontAwesome' => true,
            'showConfirmAlert' => false,
            'target' => GridView::TARGET_BLANK,
        ];

        // Configure toolbar buttons
        $this->toolbar = ArrayHelper::merge([
            [
                'content' => Html::a(
                    '<i class="fas fa-plus"></i> Create New',
                    ['create'],
                    ['class' => 'btn btn-success']
                )
            ],
            '{export}',
            '{toggleData}'
        ], $this->toolbar);

        // Configure toggle data button
        $this->toggleDataOptions = [
            'all' => [
                'icon' => 'fas fa-expand',
                'label' => 'Show All',
                'class' => 'btn btn-outline-secondary',
                'title' => 'Show all records',
            ],
            'page' => [
                'icon' => 'fas fa-compress',
                'label' => 'Show Page',
                'class' => 'btn btn-outline-secondary',
                'title' => 'Show records per page',
            ],
        ];

        // Configure pagination
        $this->pager = [
            'options' => ['class' => 'pagination justify-content-center'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['class' => 'page-link'],
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
        return parent::run();
    }

    /**
     * Registers required assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        $view->registerCss("
            .grid-view .table thead th {
                background-color: #f8f9fa;
                border-top: none;
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.875rem;
            }
            .grid-view .table tbody td {
                vertical-align: middle;
                font-size: 0.875rem;
            }
            .grid-view .filter-row td {
                padding: 0.5rem;
                background-color: #fff;
            }
            .grid-view .filter-row input,
            .grid-view .filter-row select {
                border-radius: 0.25rem;
                border: 1px solid #ced4da;
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }
            .grid-view .btn-group {
                display: flex;
                gap: 0.25rem;
            }
            .grid-view .pagination {
                margin-bottom: 0;
            }
            .grid-view .summary {
                color: #6c757d;
                font-size: 0.875rem;
            }
        ");
    }
} 