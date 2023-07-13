@props(['name', 'label'])
<div class="form-group">
    <label>{{ $label }}</label>
    <select class="browser-default custom-select" style="width: 100%;" id="{{ $name }}" name="{{ $name }}">
        <option disabled>::Pilih {{ $label }}::</option>
        {{ $slot }}
    </select>
</div>
