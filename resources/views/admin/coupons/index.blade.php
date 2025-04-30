@extends('admin.layouts.app')

@section('title', 'Coupons Management')

@section('content')
<style>
    /* Styling */
    .container {
        background-color: white;
        padding: 20px;
        font-size: 1rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        width: 100%;
        overflow-x: auto;
    }
    .section-header {
        color: var(--primary);
        margin-bottom: 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
    }
    .table {
        font-size: 1rem;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        width: 100%;
    }
    .table thead {
        background-color: var(--primary);
        color: white;
    }
    .table th, .table td {
        white-space: nowrap;
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: rgba(254, 56, 115, 0.1);
    }
    .btn {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .btn-primary:hover {
        background-color: #2c3060;
        border-color: #2c3060;
    }
    .btn-edit {
        background-color: var(--accent);
        color: white;
        border: none;
    }
    .btn-edit:hover {
        background-color: #0e0f1f;
    }
    .btn-delet {
        background-color: var(--dark);
        color: white;
        border: none;
    }
    .btn-delet:hover {
        background-color: #e0265e;
    }
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
    }
    .badge-active {
        background-color: var(--primary);
        color: white;
    }
    .badge-inactive {
        background-color: var(--secondary);
        color: #393D72;
    }
    .badge-percent {
        background-color: var(--dark);
        color: white;
    }
    .badge-fixed {
        background-color: var(--accent);
        color: white;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    .search-filter {
        background-color: #f8f9fa;
        padding: 1.2rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .search-filter {
            padding: 1rem;
        }
    }
    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
        }
        .table thead {
            display: none;
        }
        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem;
            border-bottom: 1px solid #f1f1f1;
        }
        .table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            margin-right: 1rem;
            flex: 1;
        }
        .action-buttons {
            justify-content: flex-end;
        }
    }
</style>

<div class="container">
    <div class="section-header d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Coupons Management</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mt-2 mt-sm-0">
            <i class="fas fa-plus me-1"></i> <span class="d-none d-sm-inline">Create New Coupon</span>
        </a>
    </div>


    <!-- Coupons Table -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($coupons as $coupon)
                <tr>
                    <td data-label="Code"><strong>{{ $coupon->code }}</strong></td>
                    <td data-label="Amount">
                        {{ $coupon->discount_amount }} {{ $coupon->discount_type == 'percentage' ? '%' : config('settings.currency_symbol', '$') }}
                    </td>
                    <td data-label="Type">
                        <span class="badge badge-{{ $coupon->discount_type == 'percentage' ? 'percent' : 'fixed' }}">
                            {{ ucfirst($coupon->discount_type) }}
                        </span>
                    </td>
                    <td data-label="Status">
                        <span class="badge badge-{{ $coupon->status == 'active' ? 'active' : 'inactive' }}">
                            {{ ucfirst($coupon->status) }}
                        </span>
                    </td>
                    <td data-label="Course">{{ $coupon->course->title ?? 'All Courses' }}</td>
                    <td data-label="Actions">
                        <div class="action-buttons">
                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-edit btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delet btn-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No coupons found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{-- @if($coupons->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $coupons->links() }}
    </div>
    @endif
</div> --}}
@endsection
