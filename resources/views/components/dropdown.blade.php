@props(['name', 'label'])
<div class="form-group">
    <label>{{ $label }}</label>
    <select class="form-control" style="width: 100%;" id="{{ $name }}" name="{{ $name }}">
        <option selected disabled>::Pilih {{ $label }}::</option>
        {{ $slot }}
    </select>
</div>
