@if (count($errors->all()) > 0)

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{Lang::get('Error')}}</strong> {{Lang::get('Check the form errors')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif


@if ($message = Session::get('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{Lang::get('Correcto')}}</strong>
        @if(is_array($message))
            <ul>
                @foreach ($message as $m)
                    <li>{{ Lang::get($m) }}</li>
                @endforeach
            </ul>
        @else
            {{ Lang::get($message) }}
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif



@if ($message = Session::get('error'))

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{Lang::get('Error')}}</strong>
        @if(is_array($message))
            <ul>
                @foreach ($message as $m)
                    <li>{{ Lang::get($m) }}</li>
                @endforeach
            </ul>
        @else
            {{ Lang::get($message) }}
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif


@if ($message = Session::get('validation_errors'))

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
{{--        <strong>{{Lang::get('Error')}}</strong>--}}
        @if(is_array($message))
            <ul>
                @foreach ($message as $m)
                    <li>{{ Lang::get($m) }}</li>
                @endforeach
            </ul>
        @else
            {{ Lang::get($message) }}
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif


@if ($message = Session::get('warning'))

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{Lang::get('Warning')}}</strong>
        @if(is_array($message))
            <ul>
                @foreach ($message as $m)
                    <li>{{ Lang::get($m) }}</li>
                @endforeach
            </ul>
        @else
            {{ Lang::get($message) }}
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif



@if ($message = Session::get('info'))

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>{{Lang::get('Info')}}</strong>
        @if(is_array($message))
            <ul>
                @foreach ($message as $m)
                    <li>{{ Lang::get($m) }}</li>
                @endforeach
            </ul>
        @else
            {{ Lang::get($message) }}
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif