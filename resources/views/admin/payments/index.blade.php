@extends('admin.layouts.app')

@section('title', 'Manage Payments')

@section('content')
<style>
    /* Main Container */
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
        --sidebar-width: 250px;
        --navbar-height: 60px;
    }
    
    .container {
        background-color: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Header Section */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    .page-header h1 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(57, 61, 114, 0.2);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 800px;
    }

    .table thead {
        background-color: var(--primary);
        color: white;
        position: sticky;
        top: 0;
    }

    .table th {
        padding: 0.75rem;
        font-weight: 500;
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        font-size: 0.875rem;
    }

    .table tbody tr:hover {
        background-color: rgba(57, 61, 114, 0.03);
    }

    /* Status Badges */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
        border-radius: 0.25rem;
        text-transform: capitalize;
        color: white;
    }

    .badge-completed {
        background-color: #28a745;
    }

    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-failed {
        background-color: #dc3545;
    }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.375rem 0.5rem;
        min-width: 2rem;
        height: 2rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .btn-show {
        background-color: var(--primary);
        color: white;
        border: none;
    }

    .btn-show:hover {
        background-color: #2a2d55;
    }

    .btn-edit {
        background-color: #17a2b8;
        color: white;
        border: none;
    }

    .btn-edit:hover {
        background-color: #138496;
    }

    .btn-delete {
        background-color: var(--dark);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        background-color: var(--dark);
    }

    .btn-print {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn-print:hover {
        background-color: #5a6268;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .page-link {
        color: var(--primary);
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-content, .print-content * {
            visibility: visible;
        }
        .print-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }

    /* Mobile Table Layout */
    @media (max-width: 767px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .header-actions .btn {
            flex: 1;
            min-width: 0;
        }
    }

    @media (max-width: 575px) {
        .container {
            padding: 1rem;
        }
        
        .page-header h1 {
            font-size: 1.25rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h1>Payments Management</h1>
        <div class="header-actions">
            <button onclick="printAllPayments()" class="btn btn-secondary">
                <i class="fas fa-print"></i> Print All
            </button>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table" id="payments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Item Name</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>JOD{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                        <td>
                            <span class="badge badge-{{ $payment->status }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->payment_for_type ?? 'N/A' }}</td>
                        <td>{{ $payment->item_name ?? 'N/A' }}</td>
                        <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                   class="btn btn-sm btn-show" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            
                                <button onclick="printSinglePayment({{ $payment->id }})" 
                                        class="btn btn-sm btn-print" title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

 
</div>

<script>
    function printAllPayments() {
        const tableClone = document.getElementById('payments-table').cloneNode(true);
        
        // Remove action column from print
        const thead = tableClone.querySelector('thead');
        const headCells = thead.querySelectorAll('th');
        headCells[headCells.length - 1].remove();

        const rows = tableClone.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells[cells.length - 1].remove();
        });

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>All Payments Report</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h1 { color: #333; text-align: center; margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #393D72; color: white; }
                    .badge { padding: 3px 8px; border-radius: 4px; font-weight: bold; color: white; }
                    .badge-completed { background-color: #28a745; }
                    .badge-pending { background-color: #ffc107; color: #212529; }
                    .badge-failed { background-color: #dc3545; }
                    .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
                    @page { size: auto; margin: 10mm; }
                </style>
            </head>
            <body>
                <h1>All Payments Report</h1>
                ${tableClone.outerHTML}
                <div class="footer">
                    Generated on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}
                </div>
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.print();
                            window.close();
                        }, 200);
                    };
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    function printSinglePayment(paymentId) {
        // In a real application, you would fetch the payment details via AJAX
        // For this example, we'll just print the row data
        
        const row = document.querySelector(`tr:has(td:first-child:contains("${paymentId}"))`);
        if (!row) return;
        
        const rowClone = row.cloneNode(true);
        
        // Remove action buttons from print
        const cells = rowClone.querySelectorAll('td');
        cells[cells.length - 1].remove();
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Payment Receipt #${paymentId}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
                    h1 { color: #333; text-align: center; margin-bottom: 20px; }
                    .receipt-header { text-align: center; margin-bottom: 30px; }
                    .receipt-header h2 { margin: 0; color: #393D72; }
                    .receipt-header p { margin: 5px 0; color: #666; }
                    .receipt-details { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    .receipt-details th { text-align: left; padding: 8px; background-color: #f5f5f5; }
                    .receipt-details td { padding: 8px; border-bottom: 1px solid #eee; }
                    .total { font-weight: bold; font-size: 1.1em; margin-top: 20px; }
                    .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 10px; }
                    @page { size: auto; margin: 10mm; }
                </style>
            </head>
            <body>
                <div class="receipt-header">
                    <h2>Payment Receipt</h2>
                    <p>Receipt #${paymentId}</p>
                    <p>Date: ${new Date().toLocaleDateString()}</p>
                </div>
                
                <table class="receipt-details">
                    <tr>
                        <th>Payment ID:</th>
                        <td>${rowClone.cells[0].textContent}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>${rowClone.cells[1].textContent}</td>
                    </tr>
                    <tr>
                        <th>Payment Method:</th>
                        <td>${rowClone.cells[2].textContent}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>${rowClone.cells[3].textContent.trim()}</td>
                    </tr>
                    <tr>
                        <th>Payment For:</th>
                        <td>${rowClone.cells[4].textContent}</td>
                    </tr>
                    <tr>
                        <th>Item:</th>
                        <td>${rowClone.cells[5].textContent}</td>
                    </tr>
                    <tr>
                        <th>Date Paid:</th>
                        <td>${rowClone.cells[6].textContent}</td>
                    </tr>
                </table>
                
                <div class="footer">
                    Thank you for your payment.<br>
                    Generated on ${new Date().toLocaleDateString()}<br>
                    For any questions, please contact support.
                </div>
                
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.print();
                            window.close();
                        }, 200);
                    };
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>

@endsection