@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Book a cleaner</h1>
    <hr/>

    @if ($errors->has('schedule'))
        <ul class="alert alert-danger">
            @foreach ($errors->get('schedule') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if (session('suggestions'))
        <div class="alert alert-success">
            Unfortunately, there are no available cleaners on that date and time.
            <br>
    
            @if (is_array(session('suggestions')) && count(session('suggestions')) > 0)
                
                But there are some on these dates: 
                @foreach (session('suggestions') as $suggestion)
                    <span style="padding: 0 3em">
                        <a href="#dateinput" onclick="setDate('{{ $suggestion }}')">{{ $suggestion }}</a>
                    </span>
                @endforeach

            @else

                Please pick another date or time.

            @endif
        </div>
    @endif

    {!! Form::open(['url' => '/book', 'class' => 'form-horizontal', 'files' => true]) !!}

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <h4>Please tell us about yourself</h4>
            </div>
        </div>

        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
            {!! Form::label('first_name', 'First Name', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
            {!! Form::label('last_name', 'Last Name', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
            {!! Form::label('phone_number', 'Phone Number', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
                {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <hr />

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <h4>When do you need a cleaner?</h4>
            </div>
        </div>        

        <div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
            {!! Form::label('city_id', 'City', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('city_id', $cities, null, ['class' => 'form-control', 'placeholder' => 'Select your city...']) !!}
                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
            {!! Form::label('date', 'Date', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::date('date', \Carbon\Carbon::now(), [
                    'id' => 'dateinput', 
                    'min' => \Carbon\Carbon::now()->format('Y-m-d'),
                    'class' => 'form-control']) !!}
                {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('time') ? 'has-error' : ''}}">
            {!! Form::label('time', 'Time', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('time', 
                    array_combine(config('booking.times'), config('booking.times')), 
                    null, 
                    ['class' => 'form-control', 'placeholder' => 'Select a time...']) !!}
                {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('duration') ? 'has-error' : ''}}">
            {!! Form::label('duration', 'Duration', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('duration', config('booking.durations'), null, ['class' => 'form-control']) !!}
                {!! $errors->first('duration', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::submit('Book', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    {!! Form::close() !!}


</div>
@endsection


@push('scripts')

<script type="text/javascript">
    
    function setDate(d) {
        $('#dateinput').val(d);
    }

</script>


@endpush