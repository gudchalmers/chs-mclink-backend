@component('mail::layout')
{{-- Header --}}
@slot('header')
    <a href="https://gud.chs.chalmers.se">
        <img src="https://gud.chs.chalmers.se/images/skaparen.png" class="logo" alt="G.U.D. Logo">
    </a>
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }} G.U.D.. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
