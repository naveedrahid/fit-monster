@section('title', 'Login')
<x-app-layout>
    <div style="background:url({{asset('admin/img/bglogin.jpg')}}) no-repeat center / cover;" class="h-100">
        <div class="container-xxl h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-5 col-12">
                    <div class="authentication-wrapper authentication-basic container-p-y">
                        <div class="authentication-inner">
                            <!-- Register -->
                            <div class="card px-sm-6 px-0" style="background:#ffffffd1;">
                                <div class="card-body">
                                    <!-- Logo -->
                                    <div class="app-brand justify-content-center mb-5 text-center">
                                        <a href="javascript:void(0);" class="app-brand-link gap-2">
                                            <span class="app-brand-logo demo">
                                                <span class="text-primary">
                                                    <img src="{{ asset('admin/img/logo.jpg') }}" class="img-fluid"
                                                        alt="" style="height: 70px;object-fit: cover;width: 240px;">
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- /Logo -->

                                    <form id="formAuthentication" class="mb-6" action="{{ route('login') }}"
                                        method="POST">
                                        @csrf

                                        <div class="mb-6">
                                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" placeholder="Enter your email" name="email"
                                                value="{{ old('email') }}" autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-6 form-password-toggle">
                                            <label class="form-label" for="password">{{ __('Password') }}</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" autocomplete="current-password">
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="icon-base bx bx-hide"></i></span>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-8">
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember-me">
                                                        {{ __('Remember Me') }} </label>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}">
                                                        <span>{{ __('Forgot Password?') }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-6">
                                            <button class="btn btn-primary d-grid w-100"
                                                type="submit">{{ __('Login') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /Register -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
