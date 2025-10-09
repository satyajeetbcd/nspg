
@extends('layouts.landingpage.master', ['header' => true, 'footer' => true])
@section('title')
    {!! $title !!}
@endsection
@section('content')

<x-page-title
    :title="$title"
    :subtitle="$description"
/>

<section class="static-content section-gap">
    <div class="container pt-5">
        <div class="mb-5">
            {!! $html !!}
        </div>
    </div>
</section>


@endsection
