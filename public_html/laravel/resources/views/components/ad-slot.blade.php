@props([
    'slotId' => null,
    'format' => 'auto',
    'responsive' => 'true',
    'layoutKey' => null,
    'style' => 'display:block;',
    'class' => ''
])

<div class="google-ad-wrapper {{ $class }}" style="overflow:hidden; clear:both; width: 100%;">
    <ins class="adsbygoogle"
         style="{{ $style }}"
         data-ad-client="ca-pub-8168100361388093"
         @if(!empty($slotId)) data-ad-slot="{{ $slotId }}" @endif
         data-ad-format="{{ $format }}"
         @if(!empty($layoutKey)) data-ad-layout-key="{{ $layoutKey }}" @endif
         data-full-width-responsive="{{ $responsive }}"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
