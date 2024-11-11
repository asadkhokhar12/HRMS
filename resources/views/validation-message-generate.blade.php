<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ _trans('auth.Validation Message Generate') }}</title>
    <link rel="stylesheet" href="{{ global_asset('frontend/css/') }}/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="text-success">{{ _trans('auth.Validation Message Generate') }}</h2>
        <form action="{{ route('message_generate') }}" method="post">
            @csrf
            <input type="text" name="field" value="{{ $field ?? '' }}" placeholder="{{ _trans('auth.Field') }}">
            <input type="text" name="rules" value="{{ $rules ?? '' }}" placeholder="{{ _trans('auth.rules') }}">
            <input type="submit" class="btn btn-success" value="Submit">
        </form>

        @if (isset($arr) and count($arr))
            <ul>

                @foreach ($arr as $key => $value)
                    <li>'{{ $key }}' => '{{ $value }}',</li>
                @endforeach
            </ul>
        @endif
    </div>
</body>

</html>
