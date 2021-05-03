@extends('layouts.app1')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{asset('images/logo.svg')}}" alt="logo">
                            </div>
                            <h4>Restablecer la contraseña</h4>
                            <h6 class="font-weight-light">Ingresa tu email para enviarte el formulario de
                                recuperación.</h6>
                            @if (session('status'))
                                <div class="alert card bg-gradient-primary border-0 text-center" role="alert">
                                        <p class="mb-0 text-white font-weight-medium">{{ session('status') }}</p>
                                </div>
                            @endif
                            <form class="pt-3" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        {{ __('Enviar enlace') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
