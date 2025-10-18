@extends('website.layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card card-body mx-auto" style="max-width:600px">
        <h3 class="mb-3">{{ __('Order sent successfully') }}</h3>
        <p class="text-muted">{{ __('Order number') }}: <strong>{{ $order->order_number }}</strong></p>
        <p>{{ __('We will contact you soon to confirm the order and delivery details.') }}</p>
        <a href="{{ route('website.home') }}" class="btn btn-primary mt-3">{{ __('Return to Home') }}</a>
    </div>
 </div>
@endsection


