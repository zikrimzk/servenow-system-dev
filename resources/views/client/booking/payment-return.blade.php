@extends('client.layouts.main')

@php
    
    if ($datas['status_id']  == '1') {
        $b = '#14da2f';
    } elseif($datas['status_id']  == '3'){
        $b = '#e92c0b';
    }
    else{
        $b = '#ebca10';
    }
@endphp

<style>
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }

    .success-icon {
        background-color: {{ $b }};
        color: white;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        margin-top: -40px;
        font-size: 2rem;
        position: relative;
    }

    .success-icon::before {
        content: '\2713';
        font-size: 2rem;
        font-weight: bold;
        color: white;
    }


    .card-header {
        text-align: center;
        font-weight: bold;
        font-size: 1.5rem;
        color: #007bff;
    }

    .card-body {
        text-align: center;
        padding: 2rem;
    }

    .divider {
        border-top: 1px dashed #244066;
        margin: 1rem 0;
    }

    .text-highlight {
        font-weight: bold;
        color: #244066;
    }

    .footer-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>


<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card w-75 pt-5">
        @if ($datas['status_id'] == '1')
            <div class="card-header py-4">Transaction Successful!</div>
        @elseif($datas['status_id'] == '3')
            <div class="card-header py-4">Transaction Failed!</div>
        @else
            <div class="card-header py-4">Transaction Pending!</div>
        @endif

        <div class="card-body">
            <div class="success-icon">
                <i class="bi bi-check-lg fs-1"></i>
            </div>
            <div class="mt-3">
                <h5 class="text-highlight"> {{ $datas['order_id'] }}</h5>
                {{-- <p>Amount: <span class="text-highlight">RM 10</span></p> --}}

            </div>
            <div class="divider"></div>
            <div>
                <p>Transaction #: <span class="text-highlight">{{ $datas['transaction_id'] }}</span></p>
                <p>{{ $datas['current_date'] }} | {{ $datas['current_time']}}</p>
            </div>
            <div class="footer-text mt-4">
                Your transaction has been successfully completed!
                We’re processing your request, and all details will soon be visible in your account. Rest assured,
                everything is on track, and you will receive updates once the process is finalized.
            </div>
            <div class="footer-text mt-4">
                <div class="fw-bold">
                    You will be redirecting to the homepage in <span id="countdown">10 </span> second.
                </div>
              
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript function for the countdown
    function startCountdown() {
        let countdownElement = document.getElementById('countdown');
        let secondsRemaining = 10;

        // Update the countdown every 1 second
        let countdownInterval = setInterval(() => {
            secondsRemaining--;
            countdownElement.textContent = secondsRemaining;

            // Redirect after countdown ends
            if (secondsRemaining <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "{{ route('clientBookHistory') }}";
            }
        }, 1000);
    }

    // Start countdown when the page loads
    window.onload = startCountdown;
</script>





{{-- @section('footer')
    @include('client.layouts.footer')
@endsection --}}
