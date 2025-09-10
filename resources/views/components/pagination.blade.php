@if($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        @if($showInfoText)
            <div class="text-muted small">
                {{ $showInfo }}
            </div>
        @endif
        
        <nav aria-label="Pagination">
            <ul class="pagination pagination-sm mb-0">
                {{-- First Page Link --}}
                @if ($paginator->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url(1) }}" title="First page">
                            &laquo;
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" title="First page">
                            &laquo;
                        </span>
                    </li>
                @endif

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" title="Previous page">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" title="Previous page">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                    
                    // Adjust range if we're near the beginning or end
                    if ($end - $start < 4) {
                        if ($start == 1) {
                            $end = min($lastPage, $start + 4);
                        } else {
                            $start = max(1, $end - 4);
                        }
                    }
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $currentPage)
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" title="Next page">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" title="Next page">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif

                {{-- Last Page Link --}}
                @if ($paginator->currentPage() < $paginator->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" title="Last page">
                            &raquo;
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" title="Last page">
                            &raquo;
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
