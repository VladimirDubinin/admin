@isset($field)
    <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
    <select
        class="form-control mb-2"
        name="{{ $field['name'] }}"
        id="{{ $field['id'] }}"
    >
        @if ($field['defaultNothing'])
            <option value=""></option>
        @endif
        @foreach($field['items'] as $item)
                <option {{ $item->id == $field['value'] ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
@endisset
