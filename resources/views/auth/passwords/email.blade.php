@section('title', 'Forgot Password')
<x-app-layout>
    <div class="container-xxl h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-5 col-12">
                <div class="authentication-wrapper authentication-basic container-p-y">
                    <div class="authentication-inner">
                        <!-- Reset Password -->
                        <div class="card px-sm-6 px-0">
                            <div class="card-body">
                                <!-- Logo -->
                                <div class="app-brand justify-content-center">
                                    <a href="javascript:void(0);" class="app-brand-link gap-2">
                                        <span class="app-brand-logo demo">
                                            <span class="text-primary">
                                                <img src="{{ asset('admin/img/logo.png') }}" width="25" class="img-fluid" alt="">
                                            </span>
                                        </span>
                                        <span
                                            class="app-brand-text demo text-heading fw-bold">{{ __('Sneat') }}</span>
                                    </a>
                                </div>
                                <!-- /Logo -->
                                <h4 class="mb-1">{{ __('Forgot Password?') }} 🔒</h4>
                                <p class="mb-6">
                                    {{ __("Enter your email and we'll send you instructions to reset your password") }}
                                </p>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form id="formAuthentication" class="mb-6" action="{{ route('password.email') }}"
                                    method="POST">
                                    @csrf

                                    <div class="mb-6">
                                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                        <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="mb-6">
                                        <button class="btn btn-primary d-grid w-100"
                                            type="submit">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /Reset Password -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
