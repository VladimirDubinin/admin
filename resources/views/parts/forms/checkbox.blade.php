@isset($field)
    <input
        type="checkbox"
        class="form-control mb-2"
        name="{{ $field['name'] }}"
        id="{{ $field['id'] }}"
        value="{{ $field['value'] }}"
    >
    <label for="{{ $field['id'] }}" class="form-check-label">{{ $field['label'] }}</label>
@endisset
