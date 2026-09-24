@props(['errors'])

@if (isset($errors) && $errors->isNotEmpty())
    <div class="alert alert-danger border-0" role="alert">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1 text-center']) }}>
            @foreach ((array) $errors->all() as $error)
                <li style="color: red; font-weight: 600; font-size: 0.9rem">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
