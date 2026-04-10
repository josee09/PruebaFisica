@extends('layouts.app')

{{-- REGISTRO DE USUARIO --}}

@section('content')

{{-- GENTELELLA --}}
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Policia Nacional | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>
  {{-- GENTELELLA --}}

  <body class="login">
    <div class="container">

      <div>


        <div class="login_wrapper">
          <div class="animate form login_form">
            <section class="login_content">
              <form method="POST" action="{{ route('register') }}">
                @csrf
  
                <h1>Registro de usuario</h1>
                
                <div>
                  <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Nombre de usuario') }}</label>
  
                  <div class="col-md-9">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
  
                <div>
                  <label for="email" class="col-md-3 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>
  
                  <div class="col-md-9">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
  
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
  
                <div>
                  <label for="password" class="col-md-3 col-form-label text-md-end">{{ __('Contraseña') }}</label>
  
                  <div class="col-md-9">
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
  
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
  
                <div>
                  <label for="password-confirm" class="col-md-3 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>
  
                  <div class="col-md-9">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
                </div>
  
                <div>
                  <div class="col-md-0">
                    <button type="submit" class="btn btn-primary">
                      {{ __('Registrarme') }}
                    </button>
                  </div>
                </div>
  
                <div>
                  <a class="reset_pass" href="{{ route('login')}}">¿Ya cuentas con un usuario?</a>
                </div>
  
              </form>
            </section>
          </div>
        </div>
      </div>

    </div> 
  </body>

@endsection
