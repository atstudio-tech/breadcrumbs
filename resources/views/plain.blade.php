<nav aria-label="Breadcrumb">
    <ol role="list" style="display: flex; align-items: center; gap: 1rem">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->first)
                <li>/</li>
            @endif

            @if ($breadcrumb->active)
                <li>{{ $breadcrumb->title }}</li>
            @else
                <li>
                    <a href="{{ $breadcrumb->path }}">
                        {{ $breadcrumb->title }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
