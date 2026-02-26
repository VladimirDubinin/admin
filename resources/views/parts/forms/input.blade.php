@isset($field)
    <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
    <input
        type="{{ $field['type'] }}"
        class="form-control mb-2"
        name="{{ $field['name'] }}"
        id="{{ $field['id'] }}"
        value="{{ $field['value'] }}"
    >
@endisset
