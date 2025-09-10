@push('styles')
<style>
    /* Custom Pagination Styles - Consistent with page theme */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        background: var(--gray-100);
        border: 1px solid var(--gray-300);
    }
    
    .pagination .page-item {
        margin: 0;
    }
    
    .pagination .page-link {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #ffffff;
        text-decoration: none;
        background-color: var(--gray-100);
        border: none;
        border-right: 1px solid var(--gray-300);
        min-width: 40px;
        height: 40px;
        transition: all 0.2s ease-in-out;
    }
    
    .pagination .page-item:last-child .page-link {
        border-right: none;
    }
    
    .pagination .page-link:hover {
        background-color: var(--gray-200);
        color: #ffffff;
    }
    
    .pagination .page-link:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.2);
        background-color: var(--gray-200);
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: #fff;
        font-weight: 600;
    }
    
    .pagination .page-item.active .page-link:hover {
        background-color: var(--primary-color);
        color: #fff;
        opacity: 0.9;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #cccccc;
        background-color: var(--gray-200);
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .pagination .page-item.disabled .page-link:hover {
        cursor: not-allowed;
        background-color: var(--gray-200);
        color: #cccccc;
    }
    
    /* Ensure disabled cursor for all disabled elements */
    .pagination .page-item.disabled,
    .pagination .page-item.disabled *,
    .pagination .page-item.disabled .page-link,
    .pagination .page-item.disabled .page-link * {
        cursor: not-allowed !important;
    }
    
    /* Disabled state for any element with disabled class */
    .disabled,
    .disabled *,
    .disabled:hover,
    .disabled:hover * {
        cursor: not-allowed !important;
    }
    
    .pagination .page-item i {
        font-size: 0.75rem;
    }
    
    /* Special styling for first/last buttons */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 1rem;
        font-weight: 600;
    }
    
    /* Text info styling */
    .text-muted.small {
        color: #ffffff !important;
        opacity: 0.8;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pagination .page-link {
            min-width: 36px;
            height: 36px;
            padding: 6px 8px;
            font-size: 0.8125rem;
        }
        
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 0.875rem;
        }
    }
</style>
@endpush
