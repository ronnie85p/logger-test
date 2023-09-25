@if ($pages > 0)
<ul class="pagination">
    <li class="page-item @if (empty($paginator->previousPageUrl())) disabled @endif">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
        </a>
    </li>

    @foreach ($paginator->getUrlRange(1, $pages) as $page => $url) 
        <li class="page-item @if ($paginator->currentPage() == $page) active @endif">
            <a class="page-link" href="{{ $paginator->currentPage() != $page ? $url : '#' }}">{{ $page }}</a>
        </li>
    @endforeach

    <li class="page-item @if (empty($paginator->nextPageUrl())) disabled @endif">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </a>
    </li>
</ul>
@endif