@props([
    'label',
    'name',
    'type' => "text" ,
    'value' => ''
])

<div {{ $attributes->merge(['class' => 'form-group has-feedback']) }}>
        <label class="text-dark">{{ $label }}</label>
        <input id="{{ $name }}_input" type="{{ $type }}" placeholder="Masukan {{ Str::lower($label) }}..."
            class="form-control w-100 @error($name) is-invalid @enderror" name="{{ $name }}"
            value="{!! old($name,$value) !!}" autocomplete="off">
        @error($name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>
