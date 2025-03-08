<div>
    @if (file_exists(resource_path("svg/{$icon}.svg")))
        {!! file_get_contents(resource_path("svg/{$icon}.svg")) !!}
    @else
        <p>Icon "{{ $icon }}" not found.</p>
    @endif
</div>
