<style>
    /* 编辑/新增页：左标题、右编辑框 */
    .fi-resource-edit-record-page .fi-fo-field-wrp > .grid,
    .fi-resource-create-record-page .fi-fo-field-wrp > .grid {
        display: grid !important;
        grid-template-columns: 180px 1fr !important;
        gap: 12px !important;
        align-items: start !important;
    }
    .fi-resource-edit-record-page .fi-fo-field-wrp-label,
    .fi-resource-create-record-page .fi-fo-field-wrp-label {
        padding-top: 0 !important;
        margin-top: 8px !important;
        width: 100% !important;
        justify-content: flex-end !important;
    }
    /* FilePond 透明背景 */
    .filepond--image-preview { background-color: transparent !important; }
    .filepond--panel.filepond--item-panel,
    .filepond--item-panel { background: transparent !important; }
    /* 表格左对齐 */
    .fi-ta-table th, .fi-ta-table td { text-align: left !important; }
    /* 表格列垂直排列修复 */
    .fi-ta-text-item { word-break: normal !important; overflow-wrap: break-word !important; }
</style>
