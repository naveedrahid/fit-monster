@section('title', 'Sign up')
<x-app-layout>
    <div class="container-xxl h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-5 col-12">
                <div class="authentication-wrapper authentication-basic container-p-y">
                    <div class="authentication-inner">
                        <!-- Register -->
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
                                <h4 class="mb-1">{{ __('Adventure starts here') }} 👋</h4>
                                <p class="mb-6">{{ __('Make your app management easy and fun!') }}</p>

                                <form id="formAuthentication" class="mb-6" action="{{ route('register') }}"
                                    method="POST">
                                    @csrf

                                        <div class="mb-6">
                                            <label class="form-label" for="name">{{ __('Name') }}</label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-6">
                                            <label for="email"
                                                class="form-label">{{ __('Email Address') }}</label>

                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-password-toggle mb-6">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="············" aria-describedby="password" required autocomplete="new-password">
                                                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
    
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-password-toggle mb-6">
                                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                            <div class="input-group input-group-merge">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="············" aria-describedby="password" required autocomplete="new-password">
                                                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        <div class="mb-6">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
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
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                    class="form-label">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="form-label">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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
