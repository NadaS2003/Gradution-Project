<div class="mt-4">
    <div class="flex justify-end border border-black border-opacity-50 p-3 rounded">
        @if ($paginator->hasPages())
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2">
                {{-- زر السابق --}}
                @if ($paginator->onFirstPage())
                    <span class="px-4 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">السابق</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300">السابق</a>
                @endif

                {{-- أرقام الصفحات --}}
                <div class="flex space-x-1">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-2 text-gray-500">...</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-4 py-2 bg-blue-600 text-white font-bold rounded-md shadow-md"> {{ $page }} </span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition duration-300"> {{ $page }} </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- زر التالي --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-300">التالي</a>
                @else
                    <span class="px-4 py-2 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">التالي</span>
                @endif
            </nav>
        @endif
    </div>
</div>
