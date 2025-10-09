@php
    // Expected: $items = [ ['label' => __('Dashboard'), 'url' => route('customer.dashboard', )], ['label' => __('Orders')] ]
    $items = $items ?? [];
@endphp

@if(!empty($items))
    <nav aria-label="breadcrumb" class="breadcrumb-wrap mb-0">
        <ol class="breadcrumb align-items-center">
            @foreach($items as $index => $item)
                @if(isset($item['url']) && $index < count($items) - 1)
                    <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif


