<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .preview-page-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 20px 24px;
        border-radius: 16px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .preview-container {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .preview-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .report-table th,
    .report-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }
    .report-table th {
        background-color: #bfbfbf;
    }
    .report-table .section-title {
        background-color: #bfbfbf;
        font-weight: bold;
        text-align: left;
        padding: 6px 8px;
    }
    @media print {
        .sidebar, .navbar-custom, footer, .preview-actions, .no-print, .preview-page-header {
            display: none !important;
        }
        .content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .preview-container {
            box-shadow: none;
            padding: 0;
        }
    }
</style>
