@include('header')

<div class="row">
    <div class="col-12">
        @if($component)
            @include('components/' . $component)
        @endif
    </div>
</div>

@include('footer')
