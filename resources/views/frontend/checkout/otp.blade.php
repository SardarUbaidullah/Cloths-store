@extends('frontend.layouts.main')
@section('main-container')
<div class="container" style="margin-top:150px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Enter OTP sent to your phone</h3>
            @if(session('error'))<p class="text-danger">{{ session('error') }}</p>@endif
            <form action="{{ route('checkout.verifyOtp') }}" method="POST">
                @csrf
                <input type="number" name="otp" placeholder="6-digit OTP" class="form-control mb-2" required>
                <button type="submit" class="btn btn-primary">Verify OTP & Place Order</button>
            </form>
        </div>
    </div>
</div>
@endsection
