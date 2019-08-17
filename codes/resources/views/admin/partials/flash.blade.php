@if (session('flash'))

    @php
        $type = key(session('flash'));
        $message = session('flash.'.$type);
        $type = in_array($type, ['error']) ? 'danger' : $type;
    @endphp

    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        {!! $message !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif