@extends('website.layouts.app')

@section('title', __('website.wheel_of_fortune'))

@section('content')
<div class="wheel-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($isEnabled)
                <div class="wheel-card">
                    <div class="wheel-header text-center">
                        <h1 class="wheel-title">{{ __('website.wheel_of_fortune') }}</h1>
                        <p class="wheel-description">{{ __('website.wheel_description') }}</p>
                    </div>

                    <div class="wheel-game">
                        <div class="wheel-wrapper">
                            <div class="wheel" id="wheel">
                                @foreach($prizes as $index => $prize)
                                <div class="wheel-segment" data-prize="{{ $prize->id }}" style="--segment-index: {{ $index }}">
                                    <div class="segment-content">
                                        <div class="prize-icon">
                                            @if($prize->type == 'points')
                                                <i class="fa fa-star"></i>
                                            @elseif($prize->type == 'discount')
                                                <i class="fa fa-percent"></i>
                                            @elseif($prize->type == 'free_shipping')
                                                <i class="fa fa-truck"></i>
                                            @else
                                                <i class="fa fa-gift"></i>
                                            @endif
                                        </div>
                                        <div class="prize-name">{{ $prize->name }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="wheel-pointer"></div>
                        </div>

                        <div class="wheel-controls text-center">
                            <button class="btn btn-primary btn-lg spin-btn" id="spinBtn">
                                <i class="fa fa-play"></i> {{ __('website.spin_wheel') }}
                            </button>
                        </div>
                    </div>

                    <div class="wheel-prizes">
                        <h3>{{ __('website.available_prizes') }}</h3>
                        <div class="row">
                            @foreach($prizes as $prize)
                            <div class="col-md-4 mb-3">
                                <div class="prize-card">
                                    <div class="prize-icon">
                                        @if($prize->type == 'points')
                                            <i class="fa fa-star"></i>
                                        @elseif($prize->type == 'discount')
                                            <i class="fa fa-percent"></i>
                                        @elseif($prize->type == 'free_shipping')
                                            <i class="fa fa-truck"></i>
                                        @else
                                            <i class="fa fa-gift"></i>
                                        @endif
                                    </div>
                                    <h5>{{ $prize->name }}</h5>
                                    <p>{{ $prize->description }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="wheel-disabled text-center">
                    <i class="fa fa-ban fa-3x text-muted mb-3"></i>
                    <h3>{{ __('website.wheel_disabled') }}</h3>
                    <p>{{ __('website.wheel_disabled_message') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.wheel-container {
    padding: 3rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.wheel-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.wheel-title {
    color: #333;
    margin-bottom: 1rem;
}

.wheel-description {
    color: #666;
    margin-bottom: 2rem;
}

.wheel-game {
    margin: 2rem 0;
}

.wheel-wrapper {
    position: relative;
    width: 300px;
    height: 300px;
    margin: 0 auto;
}

.wheel {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    position: relative;
    overflow: hidden;
    border: 8px solid #fff;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    transition: transform 3s cubic-bezier(0.23, 1, 0.32, 1);
}

.wheel-segment {
    position: absolute;
    width: 50%;
    height: 50%;
    transform-origin: 100% 100%;
    clip-path: polygon(0 0, 100% 0, 50% 100%);
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57, #ff9ff3);
}

.wheel-segment:nth-child(1) { transform: rotate(0deg); }
.wheel-segment:nth-child(2) { transform: rotate(60deg); }
.wheel-segment:nth-child(3) { transform: rotate(120deg); }
.wheel-segment:nth-child(4) { transform: rotate(180deg); }
.wheel-segment:nth-child(5) { transform: rotate(240deg); }
.wheel-segment:nth-child(6) { transform: rotate(300deg); }

.segment-content {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    text-align: center;
    color: white;
    font-weight: bold;
}

.prize-icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.prize-name {
    font-size: 0.8rem;
}

.wheel-pointer {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 15px solid transparent;
    border-right: 15px solid transparent;
    border-top: 30px solid #ff6b6b;
    z-index: 10;
}

.spin-btn {
    padding: 1rem 2rem;
    font-size: 1.2rem;
    border-radius: 50px;
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
    border: none;
    color: white;
    font-weight: bold;
    transition: all 0.3s ease;
}

.spin-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.spin-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.wheel-prizes {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}

.prize-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s ease;
}

.prize-card:hover {
    transform: translateY(-5px);
}

.prize-card .prize-icon {
    font-size: 2rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.wheel-disabled {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .wheel-wrapper {
        width: 250px;
        height: 250px;
    }
    
    .wheel-card {
        padding: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wheel = document.getElementById('wheel');
    const spinBtn = document.getElementById('spinBtn');
    let isSpinning = false;

    spinBtn.addEventListener('click', function() {
        if (isSpinning) return;
        
        isSpinning = true;
        spinBtn.disabled = true;
        spinBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{ __("website.spinning") }}...';

        // Make AJAX request to spin
        fetch('{{ route("website.wheel.spin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Calculate rotation
                const segments = {{ $prizes->count() }};
                const segmentAngle = 360 / segments;
                const prizeIndex = data.prize.id - 1;
                const rotation = (360 * 5) + (segmentAngle * prizeIndex);
                
                // Apply rotation
                wheel.style.transform = `rotate(${rotation}deg)`;
                
                // Show result after animation
                setTimeout(() => {
                    Swal.fire({
                        title: '{{ __("website.congratulations") }}!',
                        text: data.prize.name,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: '{{ __("website.claim_prize") }}',
                        cancelButtonText: '{{ __("website.cancel") }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            claimPrize(data.spin_id, data.security_hash);
                        }
                    });
                }, 3000);
            } else {
                Swal.fire({
                    title: '{{ __("website.error") }}',
                    text: data.message,
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: '{{ __("website.error") }}',
                text: '{{ __("website.something_went_wrong") }}',
                icon: 'error'
            });
        })
        .finally(() => {
            isSpinning = false;
            spinBtn.disabled = false;
            spinBtn.innerHTML = '<i class="fa fa-play"></i> {{ __("website.spin_wheel") }}';
        });
    });

    function claimPrize(spinId, securityHash) {
        fetch('{{ route("website.wheel.claim") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                spin_id: spinId,
                security_hash: securityHash
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '{{ __("website.congratulations") }}!',
                    text: data.message,
                    icon: 'success'
                });
            } else {
                Swal.fire({
                    title: '{{ __("website.error") }}',
                    text: data.message,
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: '{{ __("website.error") }}',
                text: '{{ __("website.something_went_wrong") }}',
                icon: 'error'
            });
        });
    }
});
</script>
@endpush
