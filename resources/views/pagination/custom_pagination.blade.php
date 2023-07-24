<!-- Example of custom pagination -->
<li class="page-item {{ $paginator->currentPage() === 1 ? 'disabled' : '' }}">
    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
</li>
@foreach ($elements as $element)
    @if (is_string($element))
        <li class="page-item disabled">
            <span class="page-link">{{ $element }}</span>
        </li>
    @endif

    @if (is_array($element))
        @foreach ($element as $page => $url)
            <li class="page-item {{ $page === $paginator->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach
    @endif
@endforeach
<li class="page-item {{ $paginator->currentPage() === $paginator->lastPage() ? 'disabled' : '' }}">
    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
</li>
