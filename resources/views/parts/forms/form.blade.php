@isset($form)
    @foreach($form as $field)
        @if ($field['type'] === 'text' | $field['type'] === 'email' | $field['type'] === 'number')
            @include('parts.forms.input', ['field' => $field])
        @elseif ($field['type'] === 'checkbox')
            @include('parts.forms.checkbox', ['field' => $field])
        @elseif ($field['type'] === 'select')
            @include('parts.forms.select', ['field' => $field])
        @endif
    @endforeach
@endisset
