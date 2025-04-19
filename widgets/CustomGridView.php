<?php

namespace app\widgets;

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Json;

class CustomGridView extends GridView
{
    /**
     * @var string Path to the JSON data file
     */
    public $dataFile = '@webroot/data/organization-data.json';

    /**
     * @var array Default column configuration
     */
    public $defaultColumnConfig = [
        'headerOptions' => ['class' => 'custom-header'],
        'contentOptions' => ['class' => 'custom-cell'],
    ];

    /**
     * Initializes the widget
     */
    public function init()
    {
        // Load data from JSON file
        $jsonData = Json::decode(file_get_contents(\Yii::getAlias($this->dataFile)), true);
        
        // Configure default settings
        $this->configureDefaults();
        
        // Configure data provider
        $this->dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $jsonData['data'],
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'attributes' => ['id', 'title', 'organization_unit_type', 'parent', 'institute_name', 'status'],
            ],
        ]);

        // Configure columns if not set
        if (empty($this->columns)) {
            $this->columns = $this->getDefaultColumns();
        }

        parent::init();
    }

    /**
     * Configure default grid settings
     */
    protected function configureDefaults()
    {
        $this->pjax = true;
        $this->responsive = true;
        $this->hover = true;
        $this->striped = false;
        $this->headerRowOptions = ['class' => 'custom-header-row'];
        $this->filterRowOptions = ['class' => 'custom-filter-row'];
        $this->options = ['class' => 'custom-grid'];
        $this->layout = "{items}\n<div class='custom-grid-footer'>{summary}\n{pager}</div>";
        $this->pager = [
            'options' => ['class' => 'custom-pager'],
            'maxButtonCount' => 5,
            'firstPageLabel' => '<<',
            'lastPageLabel' => '>>',
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
        ];
    }

    /**
     * Get default column configuration
     */
    protected function getDefaultColumns()
    {
        return [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'custom-checkbox-header'],
                'contentOptions' => ['class' => 'custom-checkbox-cell'],
            ],
            [
                'attribute' => 'id',
                'label' => 'ID',
                'mergeHeader' => true,
            ],
            [
                'attribute' => 'name',
                'label' => 'NAME',
                'mergeHeader' => true,
            ],
            [
                'attribute' => 'organization_unit_type',
                'label' => 'ORGANIZATION UNIT TYPE',
                'mergeHeader' => true,
            ],
            [
                'attribute' => 'parent',
                'label' => 'PARENT',
                'mergeHeader' => true,
            ],
            [
                'attribute' => 'institute_name',
                'label' => 'INSTITUTE NAME',
                'mergeHeader' => true,
            ],
            [
                'attribute' => 'status',
                'label' => 'STATUS',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('div', 
                        Html::tag('span', '✓', ['class' => 'status-icon']) . 
                        $model['status'], 
                        ['class' => 'status-badge ' . strtolower($model['status'])]
                    );
                },
                'mergeHeader' => true,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{more}',
                'buttons' => [
                    'more' => function ($url, $model) {
                        return Html::button('⋮', [
                            'class' => 'more-actions-btn',
                            'data-id' => $model['id']
                        ]);
                    },
                ],
                'headerOptions' => ['class' => 'action-column-header'],
                'contentOptions' => ['class' => 'action-column-cell'],
            ],
        ];
    }
} 