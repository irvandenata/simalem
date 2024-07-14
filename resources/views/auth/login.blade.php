@extends('layouts.base')

@section('title', 'Login')
@section('content')



  <div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
        <div class="w-100 d-flex justify-content-center">
          <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/boy-with-rocket-light.png" class="img-fluid" alt="Login image"
            width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png"
            data-app-light-img="illustrations/boy-with-rocket-light.png">
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="mb-5">
           <h1>SIMALEM</h1>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome ! 👋</h4>
          <p class="mb-4">Silahkan Login</p>

          <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="row mb-3">
              <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Login') }}
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>
  {{-- <div id="about-me"
    class="snap-madatory snap-center mx-auto container min-h-screen justify-center flex lg:flex-row flex-col  lg:items-center "
    id="about-me">

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label">{{ __('Email Address') }}</label>

        <div class="col-md-6">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

        <div class="col-md-6">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="current-password">

          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
          <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
          </button>
        </div>
      </div>
    </form>

  </div> --}}
@endsection
