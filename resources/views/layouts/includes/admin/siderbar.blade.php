<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-blue-900 border-r border-gray-100 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-900">
        <ul class="space-y-2 font-medium">
            @foreach ($itemsSidebar as $link)
                <li>
                    {!! $link->render() !!}
                </li>
            @endforeach
        </ul>
    </div>
</aside>