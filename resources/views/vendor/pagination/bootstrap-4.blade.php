@if ($paginator->hasPages())
<style>
    .g:hover{
    color: #0e0d0d;
    background: #a3a3a3;
    
    
}
.hh:hover{
    color: #0e0d0d;
    background: #a3a3a3;
}
.g{
    border:none;background-color:#1b1b1b;color:aliceblue;
}
.hh{
    border:none;background-color:#2b2b2b;color:aliceblue;
}
.pagination {
        background-color: #cccccc; /* Cambia a tu color de fondo deseado */
    }

    .pagination .page-link {
        color: white; /* Cambia al color de texto deseado */
    }

    .pagination .page-item.active .page-link {
        background-color: #777777; /* Color de fondo para el ítem activo */
        border-color: #777777; /* Color del borde para el ítem activo */
    }

    .pagination .page-item.disabled .page-link {
        color: #aaaaaa; /* Color de texto para ítems deshabilitados */
    }
</style>
    <nav style="margin-top:1rem;">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                
                <li class="page-item g">
                    <a class="page-link g" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item  disabled" aria-current="page" style="border:none;background-color:#1b1b1b;color:aliceblue;">
                        . . .
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item hh" aria-current="page">
                                <span class="page-link hh" >
                                {{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link g" href="{{ $url }}" 
                                style="" >{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item g">
                    <a class="page-link g" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
                
            @endif
        </ul>
    </nav>
    @section('head')
@endsection

@endif
