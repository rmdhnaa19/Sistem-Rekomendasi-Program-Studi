<div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>{{ $breadcrumb->title }}</h3>
        <p class="text-subtitle text-muted">
            {{ $breadcrumb->paragraph }}
        </p>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class='breadcrumb-header'>
            <ol class="breadcrumb">
                @foreach ($breadcrumb->list as $key => $value)
                    @if ($key == count($breadcrumb->list) - 1)
                        <li class="breadcrumb-item active" aria-current="page">{{ $value['label'] }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $value['url'] }}">{{ $value['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>
