@if ($paginator->hasPages())
<div class="category-pagination__wrap">
    <div class="ui pagination menu category-pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <a class="category-pagination__btn icon item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"> <i class="fas fa-angle-left"></i></a>
        @else
        <a class="category-pagination__btn icon item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"> <i class="fas fa-angle-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as  $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element) )

        <a class="category-pagination__num icon item disabled" aria-disabled="true">{{ $element }}</a>
        @endif
        
        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)

        @if ($page == $paginator->currentPage())
        <a class="category-pagination__num item active" href="{{ $url }}" aria-current="page">{{ $page }}</a>
        @else
        <a class="category-pagination__num item" href="{{ $url }}">{{ $page }}</a>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a class="category-pagination__btn icon item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fas fa-angle-right"></i> </a>
        @else
        <a class="category-pagination__btn icon item disabled" aria-disabled="true" aria-label="@lang('pagination.next')"><i class="fas fa-angle-right"></i> </a>
        @endif
    </div>
</div>
@endif