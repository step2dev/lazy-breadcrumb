<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach ($breadcrumbs as $crumb)
            @if (!$loop->first)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.05 4.05a.5.5 0 0 1 .7 0l5 5a.5.5 0 0 1 0 .7l-5 5a.5.5 0 0 1-.7-.7L11.29 10 7.05 5.75a.5.5 0 0 1 0-.7z"/>
                        </svg>
                    </div>
                </li>
            @endif

            <li class="inline-flex items-center">
                @if ($loop->last)
                    <span class="text-sm font-medium text-gray-500">{{ $crumb['title'] }}</span>
                @else
                    <a href="{{ $crumb['url'] }}" class="text-sm font-medium text-blue-600 hover:underline">
                        {{ $crumb['title'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
