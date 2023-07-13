@props(['name', 'label'])
<div class="form-group">
    <label>{{ $label }}</label>
    <select class="browser-default custom-select select2bs4" style="width: 100%;" id="{{ $name }}"
        name="{{ $name }}">
        <option selected disabled>::Pilih {{ $label }}::</option>
        {{ $slot }}
    </select>
</div>
