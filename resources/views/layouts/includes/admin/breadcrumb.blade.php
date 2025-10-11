@if (count($breadcrumbs))
    <nav class="mb-4">
        <ol class="flex flex-wrap">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    @isset($item['route'])
                        <a href="{{ $item['route'] }}" class="text-black hover:text-blue-600 transition-colors duration-200 font-medium">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span class="text-black font-medium">
                            {{ $item['name'] }}
                        </span>
                    @endisset

                    @if (!$loop->last)
                        <svg class="w-3 h-3 mx-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
