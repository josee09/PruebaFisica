@extends('layouts.app')

{{-- LOGIN DE USUARIO --}}

@section('content')

{{-- GENTELELLA --}}
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Policia Nacional | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head><html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Policia Nacional | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	    <!-- Animate.css -->
      <link href="{{asset('build/css/animate.min.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>
{{-- GENTELELLA --}}

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="position: relative;">
              <img style="position: absolute; width: 200px; height: 200px; top: -50px; left: 50%; transform: translateX(-50%); z-index: 1;" src="{{ asset('images/img.png') }}" alt="">
            </br></br></br></br>  </br></br></br></br>
              <h1 style="position: relative; z-index: 2;">Inicio de sesión</h1>
              <p>SISTEMA WEB DE EVALUACIÓN PRUEBA FÍSICA</p>
            </div>

            <div>
              <input id="email" type="email" placeholder="Correo electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              </div>

            <div>
              <input id="password" type="password"  placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>

            <div class="row mb-3">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>


                      <label class="form-check-label" for="remember">
                          {{ __('Recuerdame') }}
                      </label>
              </div>
          </div>


          <div class="row mb-0">
            <button type="submit" class="btn btn-primary">
                {{ __('Acceso') }}
            </button>
              {{-- <p class="change_link">¿Nuevo en el sitio?
                <a href="register" class="to_register"> Crear usuario </a>
              </p>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                  <a class="reset_pass" href="#">¿Ha perdido su contraseña?</a>
                </a>
            @endif --}}
        </div>

        <div class="separator">

           {{--  <div>
              <a class="btn btn-default submit" href="index.html">Acceso</a>
              <a class="reset_pass" href="#">¿Perdiste tu contraseña?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">¿Nuevo en el sitio?
                <a href="#signup" class="to_register"> Crear una cuenta </a>
              </p>

              <div class="clearfix"></div>
              <br />  --}}

              <div>
                {{-- <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1> --}}
                  <strong>INVESTIGACIÓN Y DESARROLLO TECNOLÓGICO - DIRECCIÓN POLICIAL DE
                      TELEMÁTICA - POLICÍA NACIONAL DE HONDURAS ©{{date("Y")}}</strong>

              </div>
            </div>
          </form>
        </section>
      </div>

     {{--  <div id="register" class="animate form registration_form">
        <section class="login_content">
          <form>
            <h1>Create Account</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <a class="btn btn-default submit" href="index.html">Submit</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member ?
                <a href="#signin" class="to_register"> Log in </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 4 template. Privacy and Terms</p>
              </div>
            </div>
          </form>
        </section>
      </div> --}}
    </div>
  </div>
</body>



@endsection
