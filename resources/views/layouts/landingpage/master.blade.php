@if (isset($header) && $header !== false)
@include('layouts.landingpage.header')
@endif



@yield('content')
@if (isset($footer) && $footer !== false)
    @include('layouts.landingpage.footer')
@endif
