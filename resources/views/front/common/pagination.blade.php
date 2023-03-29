@if ($paginator->hasPages())
    <div class="col-12">
        <nav class="ctm-pagination d-flex justify-content-end mt-2" aria-label="Page navigation ">
            <ul class="pagination">

                {{-- @if (!$paginator->onFirstPage()) --}}
                <li class="page-item">
                    <a class="arrow-btn " href="{{ $paginator->previousPageUrl() }}">
                        <img src="{{ asset('assets/front/img/left-icon.png') }}" class="img-fluid arrow-right">
                    </a>
                </li>
                {{-- @endif --}}
                <div class="page-inner d-flex align-items-center">
                    @foreach ($elements as $element)

                        @if (is_string($element))
                            <li><a href="javascript:void(0)" class="mx-0">…</a>
                        @endif
                        @if (is_array($element))

                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item"><a class="page-link active"
                                                             href="javascript:void(0);">{{ $page }}</a></li>
                                @else
                                    <li><a href={{ $url }} class="page-link">{{ $page }}</a>
                                @endif
                            @endforeach

                        @endif

                    @endforeach
                </div>
                {{-- @if ($paginator->hasMorePages()) --}}
                <li class="page-item">
                    <a class="arrow-btn" href="{{ $paginator->nextPageUrl() }}">
                        <img src="{{ asset('assets/front/img/right-icon.png') }}" class="img-fluid arrow-right">
                    </a>
                </li>
                {{-- @endif --}}
            </ul>
        </nav>
    </div>
@endif
