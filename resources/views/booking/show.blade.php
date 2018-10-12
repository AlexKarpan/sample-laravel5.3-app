@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Booking {{ $booking->id }}
        <a href="{{ url('booking/' . $booking->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Booking"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['booking', $booking->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete Booking',
                    'onclick'=>'return confirm("Confirm delete?")'
            ))!!}
        {!! Form::close() !!}
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>ID</th><td>{{ $booking->id }}</td>
                </tr>
                <tr><th> Customer Id </th><td> {{ $booking->customer_id }} </td></tr><tr><th> Cleaner Id </th><td> {{ $booking->cleaner_id }} </td></tr><tr><th> City Id </th><td> {{ $booking->city_id }} </td></tr><tr><th> Starts At </th><td> {{ $booking->starts_at }} </td></tr><tr><th> Ends At </th><td> {{ $booking->ends_at }} </td></tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
