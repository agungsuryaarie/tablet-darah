@props(['type', 'name', 'label'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-control']) }}>
</div>
