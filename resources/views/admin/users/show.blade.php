@extends('admin.layouts.app')
@section('title', __('admin.user_details'))
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.user_details') }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="icon-arrow-left"></i> {{ __('admin.back_to_users') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.name') }}</label>
                                <p class="form-control-plaintext">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.email') }}</label>
                                <p class="form-control-plaintext">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.registration_date') }}</label>
                                <p class="form-control-plaintext">{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.last_updated') }}</label>
                                <p class="form-control-plaintext">{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($user->email_verified_at)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('admin.email_verified_at') }}</label>
                                    <p class="form-control-plaintext">{{ $user->email_verified_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-group {
        margin-bottom: 2rem;
    }
    
    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.8rem;
        display: block;
        font-size: 18px !important;
    }
    
    .form-control-plaintext {
        padding: 0.8rem 0;
        font-size: 18px !important;
        line-height: 1.6;
        color: #495057;
        background-color: transparent;
        border: none;
        font-weight: 500;
    }
    
    .card-title {
        font-size: 28px !important;
        font-weight: 700 !important;
        margin-bottom: 2rem !important;
    }
    
    .card {
        padding: 2rem !important;
    }
    
    .btn {
        font-size: 16px !important;
        padding: 12px 24px !important;
    }
    
    .dark-theme .form-group label {
        color: #fff;
        font-size: 18px !important;
    }
    
    .dark-theme .form-control-plaintext {
        color: #ccc;
        font-size: 18px !important;
    }
    
    .dark-theme .card-title {
        color: #fff;
        font-size: 28px !important;
    }
    
    .dark-theme .card {
        background-color: #2d3748 !important;
        color: #fff;
    }
</style>
@endpush
