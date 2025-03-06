@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                السابق
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               rel="prev"
               class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-500
          rounded-md transition ease-in-out duration-150
          hover:bg-blue-600 hover:text-white
          focus:outline-none focus:ring ring-blue-300 focus:border-blue-500
          active:bg-blue-700 active:text-white ml-4">
                السابق
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-500
          rounded-md transition ease-in-out duration-150
          hover:bg-blue-600 hover:text-white
          focus:outline-none focus:ring ring-blue-300 focus:border-blue-500
          active:bg-blue-700 active:text-white mr-4">
                التالي
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                التالي
            </span>
        @endif
    </nav>
@endif
