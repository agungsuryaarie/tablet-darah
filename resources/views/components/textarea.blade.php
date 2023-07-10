@props(['name', 'label'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-control summernote']) }} rows="3">{{ $slot }}</textarea>
</div>
