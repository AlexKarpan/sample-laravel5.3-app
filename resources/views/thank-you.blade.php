@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Thank you for booking a cleaning session</h3>

    <p>
        You will be served by {{ $booking->cleaner->first_name }} {{ $booking->cleaner->last_name }} on {{ $booking->starts_at->format('Y-m-d') }} at {{ $booking->starts_at->format('H:m') }}.
    </p>

</div>
@endsection