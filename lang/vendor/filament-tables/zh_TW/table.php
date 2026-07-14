<?php

return [

    'fields' => [

        'search' => [
            'label' => '搜尋',
            'placeholder' => '搜尋',
        ],

    ],

    'actions' => [

        'filter' => [
            'label' => '篩選',
        ],

        'open_bulk_actions' => [
            'label' => '打開動作',
        ],

        'toggle_columns' => [
            'label' => '顯示／隱藏直列',
        ],

    ],

    'empty' => [
        'heading' => '未找到資料',
    ],

    'filters' => [

        'actions' => [

            'reset' => [
                'label' => '重設篩選',
            ],

        ],

        'multi_select' => [
            'placeholder' => '全部',
        ],

        'select' => [
            'placeholder' => '全部',
        ],

        'trashed' => [

            'label' => '已刪除的資料',

            'only_trashed' => '僅顯示已刪除的資料',

            'with_trashed' => '包含已刪除的資料',

            'without_trashed' => '不含已刪除的資料',

        ],

    ],

    'selection_indicator' => [

        'selected_count' => '已選擇 :count 個項目',

        'actions' => [

            'select_all' => [
                'label' => '選擇全部 :count 項',
            ],

            'deselect_all' => [
                'label' => '取消選擇全部',
            ],

        ],

    ],

'column_toggle' => [

        'heading' => '欄位',

    ],

    'columns' => [

        'actions' => [
            'label' => '操作|操作',
        ],

        'text' => [

            'actions' => [
                'collapse_list' => '顯示少 :count 個',
                'expand_list' => '顯示多 :count 個',
            ],

            'more_list_items' => '還有 :count 個',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => '分組依據',
                'placeholder' => '分組依據',
            ],

            'direction' => [

                'label' => '分組方向',

                'options' => [
                    'asc' => '升序',
                    'desc' => '降序',
                ],

            ],

        ],

    ],

    'reorder_indicator' => '拖放記錄以重新排序。',

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => '排序依據',
            ],

            'direction' => [

                'label' => '排序方向',

                'options' => [
                    'asc' => '升序',
                    'desc' => '降序',
                ],

            ],

        ],

    ],

    'summary' => [

        'heading' => '摘要',

        'subheadings' => [
            'all' => '全部 :label',
            'group' => ':group 摘要',
            'page' => '此頁面',
        ],

        'summarizers' => [

            'average' => [
                'label' => '平均',
            ],

            'count' => [
                'label' => '計數',
            ],

            'sum' => [
                'label' => '總和',
            ],

        ],

    ],

];
