<?php

namespace app\widgets;

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use yii\web\JsExpression;
use yii\web\View;

/**
 * EnhancedGridView extends Kartik's GridView with modern UI styling
 */
class EnhancedGridView extends GridView
{
    /**
     * @var array Custom styling options
     */
    public $customStyle = [];

    /**
     * @var string Header title
     */
    public $headerTitle = '';

    /**
     * @var string Header description
     */
    public $headerDescription = '';

    /**
     * @var array Filter dropdown options
     */
    public $filterDropdowns = [];

    /**
     * @var array Advanced filter options
     */
    public $advancedFilterOptions = [];

    /**
     * @var bool Enable step search functionality
     */
    public $enableStepSearch = false;

    /**
     * @var array Step search configuration
     */
    public $stepSearchConfig = [];

    /**
     * @var bool Enable infinite scroll
     */
    public $enableInfiniteScroll = false;

    /**
     * @var array Infinite scroll options
     */
    public $infiniteScrollOptions = [
        'loadingText' => 'Loading more items...',
        'threshold' => 50,
        'itemsPerLoad' => 20,
    ];

    /**
     * @var array Custom action button configuration
     */
    public $customActionButtons = [];

    /**
     * @var array Enhanced export options
     */
    public $enhancedExportOptions = [];

    /**
     * @var bool Enable row dragging
     */
    public $enableRowDragging = false;

    /**
     * @var array Row dragging options
     */
    public $rowDraggingOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initDefaultOptions();
        parent::init();
    }

    /**
     * Initialize default options
     */
    protected function initDefaultOptions()
    {
        // Default styling
        $this->customStyle = ArrayHelper::merge([
            'headerBg' => '#ffffff',
            'headerTextColor' => '#2c3e50',
            'borderColor' => '#e2e8f0',
            'activeColor' => '#6366f1',
            'hoverBg' => '#f8fafc',
        ], $this->customStyle);

        // Table options
        $this->tableOptions = [
            'class' => 'table table-hover modern-grid-table',
            'style' => 'margin-bottom: 0;'
        ];

        // Layout configuration
        $this->layout = $this->getModernLayout();

        // Grid configuration
        $this->filterPosition = self::FILTER_POS_HEADER;
        $this->responsive = true;
        $this->hover = true;
        $this->striped = false;
        $this->bordered = false;
        $this->condensed = true;

        // Pjax configuration
        $this->pjax = true;
        $this->pjaxSettings = [
            'options' => [
                'id' => 'modern-grid-pjax',
                'timeout' => 3000,
                'enablePushState' => false,
            ],
        ];

        // Pagination configuration
        $this->pager = [
            'options' => ['class' => 'pagination modern-pagination'],
            'maxButtonCount' => 5,
            'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
            'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
            'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
            'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
        ];

        // Configure advanced features
        $this->configureAdvancedFeatures();

        // Configure custom actions
        $this->configureCustomActions();

        // Configure enhanced filters
        $this->configureEnhancedFilters();
    }

    /**
     * Configure advanced features like infinite scroll and row dragging
     */
    protected function configureAdvancedFeatures()
    {
        // Configure floating header
        $this->floatHeader = true;
        $this->floatHeaderOptions = [
            'scrollingTop' => 0,
            'position' => 'absolute',
        ];

        // Configure infinite scroll if enabled
        if ($this->enableInfiniteScroll) {
            $this->configureInfiniteScroll();
        }

        // Configure row dragging if enabled
        if ($this->enableRowDragging) {
            $this->configureRowDragging();
        }
    }

    /**
     * Configure custom action buttons and toolbar
     */
    protected function configureCustomActions()
    {
        // Merge custom action buttons with defaults
        $this->toolbar = ArrayHelper::merge([
            [
                'content' => $this->renderCustomActionButtons()
            ],
            '{export}',
            '{toggleData}',
            $this->enableStepSearch ? '{step-search}' : '',
        ], $this->toolbar ?? []);

        // Configure export settings
        $this->export = ArrayHelper::merge([
            'fontAwesome' => true,
            'showConfirmAlert' => false,
            'target' => self::TARGET_BLANK,
            'filename' => 'grid-export-' . date('Y-m-d'),
        ], $this->enhancedExportOptions);
    }

    /**
     * Configure enhanced filters including step search
     */
    protected function configureEnhancedFilters()
    {
        $this->filterRowOptions = ['class' => 'enhanced-filter-row'];
        $this->filterPosition = self::FILTER_POS_HEADER;
        
        if ($this->enableStepSearch) {
            $this->stepSearchConfig = ArrayHelper::merge([
                'steps' => [
                    'basic' => ['name', 'email'],
                    'advanced' => ['phone', 'address'],
                    'date' => ['created_at', 'updated_at'],
                ],
                'defaultStep' => 'basic',
            ], $this->stepSearchConfig);
        }
    }

    /**
     * Configure infinite scroll functionality
     */
    protected function configureInfiniteScroll()
    {
        $this->pager = false;
        $view = $this->getView();
        
        $js = new JsExpression("
            let loading = false;
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - {$this->infiniteScrollOptions['threshold']} && !loading) {
                    loading = true;
                    let page = parseInt($('#modern-grid-pjax').attr('data-page') || 1);
                    $.pjax.reload({
                        container: '#modern-grid-pjax',
                        url: window.location.href,
                        data: { page: page + 1 },
                        push: false,
                        replace: false
                    }).done(function() {
                        loading = false;
                        $('#modern-grid-pjax').attr('data-page', page + 1);
                    });
                }
            });
        ");
        
        $view->registerJs($js, View::POS_READY);
    }

    /**
     * Configure row dragging functionality
     */
    protected function configureRowDragging()
    {
        $view = $this->getView();
        
        $js = new JsExpression("
            $('.modern-grid-table tbody').sortable({
                handle: '.drag-handle',
                axis: 'y',
                update: function(event, ui) {
                    let items = [];
                    $('.modern-grid-table tbody tr').each(function(index) {
                        items.push({
                            id: $(this).data('key'),
                            position: index + 1
                        });
                    });
                    // Ajax call to update positions
                    $.post('{$this->rowDraggingOptions['updateUrl']}', {items: items});
                }
            });
        ");
        
        $view->registerJs($js, View::POS_READY);
    }

    /**
     * Render custom action buttons
     */
    protected function renderCustomActionButtons()
    {
        $buttons = '';
        foreach ($this->customActionButtons as $button) {
            $buttons .= Html::button(
                $button['label'],
                ArrayHelper::merge([
                    'class' => 'btn btn-custom',
                    'data-pjax' => 0,
                ], $button['options'] ?? [])
            ) . ' ';
        }
        return $buttons;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerModernAssets();
        return parent::run();
    }

    /**
     * Register required assets
     */
    protected function registerModernAssets()
    {
        $view = $this->getView();
        
        // Register custom CSS
        $css = $this->getModernCss();
        $view->registerCss($css);

        // Register custom JS
        $js = $this->getModernJs();
        $view->registerJs($js, View::POS_READY);
    }

    /**
     * Get modern layout template
     */
    protected function getModernLayout()
    {
        return '
        <div class="modern-grid-wrapper">
            <div class="modern-grid-header">
                <div class="header-content">
                    <div class="header-left">
                        <h1>{title}</h1>
                        <p class="header-description">{description}</p>
                    </div>
                    <div class="header-right">
                        <div class="action-buttons">
                            {toolbar}
                        </div>
                    </div>
                </div>
                <div class="filter-bar">
                    <div class="filter-left">
                        <div class="filter-dropdowns">
                            {filter-dropdowns}
                        </div>
                    </div>
                    <div class="filter-right">
                        <div class="search-box">
                            {search}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modern-grid-content">
                {items}
            </div>
            <div class="modern-grid-footer">
                <div class="footer-left">
                    <div class="total-records">
                        {summary}
                    </div>
                </div>
                <div class="footer-center">
                    {pager}
                </div>
                <div class="footer-right">
                    <div class="per-page-dropdown">
                        {perPage}
                    </div>
                </div>
            </div>
        </div>';
    }

    /**
     * Get modern CSS styles
     */
    protected function getModernCss()
    {
        return "
            .modern-grid-wrapper {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }

            .modern-grid-header {
                padding: 1.5rem 1.5rem 1rem;
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1.5rem;
            }

            .header-left h1 {
                font-size: 1.5rem;
                font-weight: 600;
                color: {$this->customStyle['headerTextColor']};
                margin: 0 0 0.5rem;
            }

            .header-description {
                color: #64748b;
                font-size: 0.875rem;
                margin: 0;
            }

            .filter-bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                padding: 0.75rem 0;
            }

            .filter-dropdowns {
                display: flex;
                gap: 0.75rem;
            }

            .filter-dropdown {
                position: relative;
            }

            .filter-dropdown select {
                appearance: none;
                background: #fff;
                border: 1px solid {$this->customStyle['borderColor']};
                border-radius: 6px;
                padding: 0.5rem 2rem 0.5rem 1rem;
                font-size: 0.875rem;
                color: #1e293b;
                cursor: pointer;
                min-width: 140px;
            }

            .search-box input {
                border: 1px solid {$this->customStyle['borderColor']};
                border-radius: 6px;
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                width: 240px;
            }

            .modern-grid-content {
                padding: 0 1.5rem;
            }

            .modern-grid-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            .modern-grid-table thead th {
                background: {$this->customStyle['headerBg']};
                color: #64748b;
                font-weight: 600;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid {$this->customStyle['borderColor']};
            }

            .modern-grid-table tbody td {
                padding: 1rem;
                color: #1e293b;
                font-size: 0.875rem;
                border-bottom: 1px solid {$this->customStyle['borderColor']};
                vertical-align: middle;
            }

            .modern-grid-table tbody tr:hover {
                background-color: {$this->customStyle['hoverBg']};
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 500;
            }

            .status-badge.active {
                background-color: #dcfce7;
                color: #166534;
            }

            .status-badge.inactive {
                background-color: #fee2e2;
                color: #991b1b;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
            }

            .btn-add {
                background-color: {$this->customStyle['activeColor']};
                color: #ffffff;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.875rem;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s;
                border: none;
            }

            .btn-add:hover {
                opacity: 0.9;
            }

            .modern-grid-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.5rem;
                border-top: 1px solid {$this->customStyle['borderColor']};
            }

            .total-records {
                color: #64748b;
                font-size: 0.875rem;
            }

            .modern-pagination {
                display: flex;
                gap: 0.25rem;
                margin: 0;
            }

            .modern-pagination .page-item .page-link {
                border: none;
                padding: 0.5rem 0.75rem;
                color: #64748b;
                border-radius: 6px;
                font-size: 0.875rem;
            }

            .modern-pagination .page-item.active .page-link {
                background-color: {$this->customStyle['activeColor']};
                color: #ffffff;
            }

            .per-page-dropdown select {
                border: 1px solid {$this->customStyle['borderColor']};
                border-radius: 6px;
                padding: 0.5rem 2rem 0.5rem 1rem;
                font-size: 0.875rem;
                color: #64748b;
            }

            .row-actions {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-end;
            }

            .btn-action {
                padding: 0.25rem;
                border-radius: 4px;
                color: #64748b;
                transition: all 0.2s;
            }

            .btn-action:hover {
                background-color: {$this->customStyle['hoverBg']};
                color: {$this->customStyle['activeColor']};
            }
        ";
    }

    /**
     * Get modern JavaScript
     */
    protected function getModernJs()
    {
        return new JsExpression("
            // Initialize tooltips
            $('[data-bs-toggle=\"tooltip\"]').tooltip();

            // Handle filter dropdowns
            $('.filter-dropdown select').change(function() {
                let filterType = $(this).data('filter');
                let value = $(this).val();
                // Trigger filter update
                $('#modern-grid-pjax').find('input[name=\"' + filterType + '\"]').val(value).trigger('change');
            });
        ");
    }
} 