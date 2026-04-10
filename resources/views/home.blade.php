<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.ico')}}" type="image/ico"/>

    <title>Policia Nacional | </title>

    <!-- FONTAWESOME -->
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"-->
    <!-- Bootstrap -->
    <link href="{{ asset('cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css')}}">
    <link href="{{ asset('../vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('../vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('../vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('../vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{ asset('../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{ asset('../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}"
          rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('../vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('../vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('../build/css/custom.min.css')}}" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{ asset('../vendors/jquery/dist/jquery.min.js')}}"></script>
    <link
        rel="stylesheet"
        href="{{asset('build/css/selectize.bootstrap4.css')}}"
    />
    <script
        src="{{asset('build/js/selectize.min.js')}}"
    ></script>

    <style>
        .centered-content {
            text-align: center;
        }
    </style>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{route('home')}}" class="site_title"></i> <img width="50px" height="50px"
                                                                             src="{{ asset('images/img.png') }}" alt=""><span>Policía Nacional</span></a>
                </div>

                <div class="clearfix"></div>
                <br/>
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>MENÚ</h3>
                        <ul class="nav side-menu">
                            @if(auth()->user()->hasRole('Administrador'))
                                @can('registros.index')
                                    <li><a><i class="fa fa-pencil"></i> Registro de Personal <span
                                                class="fa fa-chevron-down"></span></a>
                                        @endcan
                                        <ul class="nav child_menu">
                                            <li><a href="{{route('registros.index')}}">Lista de Registros</a></li>
                                        </ul>
                                    </li>
                            @endif
                                    @if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Medico'))
                                        @can('medica.index')
                                            <li><a><i class="fa fa-stethoscope"></i> Evaluacion Medica <span
                                                        class="fa fa-chevron-down"></span></a>

                                                <ul class="nav child_menu">
                                                    <li><a href="{{ route('medica.index') }}">Lista de Evaluaciones</a></li>
                                                    {{-- <li><a href="{{ route('medica.create') }}">Nueva Evaluación</a></li> --}}
                                                </ul>
                                            </li>
                                        @endcan
                                    @endif

                                    @if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Nutricionista'))
                                        @can('bioimpedancia.index')
                                            <li><a><i class="fa fa-calculator"></i> Bioimpedancia <span
                                                        class="fa fa-chevron-down"></span></a>

                                                <ul class="nav child_menu">
                                                    <li><a href="#">Lista de Bioimpedancia</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                    @endif
                                    @if(auth()->user()->hasRole('Administrador'))
                                        {{-- Mostrar todo para Admin --}}
                                        @can('registros.index')
                                            <li><a><i class="fa fa-child"></i> Prueba Física <span
                                                        class="fa fa-chevron-down"></span></a>

                                                <ul class="nav child_menu">
                                                    <li><a href="{{ route('registro.registro')}}">Registro de
                                                            Evaluaciones</a>
                                                    </li>
                                                    <li><a href="{{ route('fisica.index')}}">Lista de Evaluaciones</a></li>
                                                    <li><a href="{{ route('principal.index')}}">Lista de Eventos
                                                            Principales</a>
                                                    </li>
                                                    <li><a href="{{ route('alterno.index')}}">Lista de Eventos Alternos</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endcan
                                        @can('lugares-evaluacion.index')
                                            <li><a><i class="fa fa-map"></i> Lugar de Evaluacion <span
                                                        class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a href="{{route('lugares-evaluacion.index')}}">Lista de Lugares de
                                                            Evaluacion</a></li>
                                                </ul>
                                            </li>
                                        @endcan
                                        <li><a><i class="fa fa-file-text"></i> Reportes <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="{{route('Reportes.index')}}"> Reportes de resultados</a></li>
                                            </ul>
                                        </li>
                                    @endif

                                    {{-- Modulo de Terna / Evaluacion en Campo (Visible para Admin y Evaluador) --}}
                                    @can('ternas.index')
                                        <li><a><i class="fa fa-users" aria-hidden="true"></i>
                                                Terna Evaluadora <span
                                                    class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                @if(auth()->user()->hasRole('Administrador'))
                                                    <li><a href="{{route('terna-evaluadora.index')}}">Lista de Ternas de
                                                            Evaluacion</a></li>
                                                @endif
                                                <li><a href="{{ route('terna.pruebas.index') }}">Evaluación en Campo</a></li>
                                            </ul>
                                        </li>
                                    @endcan
                        </ul>
                    </div>
                    @php
                        $Usuario = auth()->user()->id;
                    @endphp
                    <div class="menu_section">
                        @can('registrousuario')
                            <h3>Administrador</h3>
                        @endcan
                        <ul class="nav side-menu">
                            @can('registrousuario')
                                <li><a><i class="fa fa-pencil"></i> Registro de Usuarios <span
                                            class="fa fa-chevron-down"></span></a>
                                    @endcan
                                    <ul class="nav child_menu">
                                        <li class="sub_menu"><a href="{{route('registrousuario')}}"><font
                                                    style="vertical-aling"> Lista de Usuarios </font></a></li>
                                        <li class="sub_menu"><a href="{{route('Roles.index')}}"><font
                                                    style="vertical-aling"> Roles </font></a></li>
                                    </ul>
                                </li>
                                @can('bitacorapersonal')
                                    <li><a><i class="fa fa-list-alt"></i> Bitacoras <span
                                                class="fa fa-chevron-down"></span></a>
                                        @endcan
                                        <ul class="nav child_menu">
                                            <li class="sub_menu"><a href="{{route('bitacorausuario')}}"><font
                                                        style="vertical-aling"> B. Usuarios</font> </a></li>
                                            <li class="sub_menu"><a href="{{route('bitacorapersonal')}}"><font
                                                        style="vertical-aling"> B.Personal</font></a></li>
                                            <li class="sub_menu"><a><font style="vertical-aling"> B. Evaluación
                                                        médica</font></a></li>
                                            <li class="sub_menu"><a><font style="vertical-aling"> B. Evaluación
                                                        física</font></a></li>
                                        </ul>
                                    </li>
                    </div>


                </div>
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                    <ul class=" navbar-right">
                        <li class="nav-item dropdown open" style="padding-left: 15px;">
                            <a href="{{ asset('javascript:;')}}" class="user-profile dropdown-toggle"
                               aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/img.jpg')}}" alt=""> {{ auth()->user()->name }} </a>
                            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                {{-- <a class="dropdown-item"  href="{{ asset('javascript:;')}}"> Perfil </a> --}}
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt" style="color: red;"></i>
                                    <!-- Cambia el color a tu preferencia -->
                                    <span style="margin-left: 10px; font-weight: bold;">Cerrar sesión</span>
                                    <!-- Agrega un espacio y un texto descriptivo -->
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>

                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Alert-->
        <div class="right_col" role="main">
            <div class="">
                @if ( $mensaje=Session::get('mensaje') )
                    <div id='mensaje' class="alert alert-success col-md-4 alert-dismissible fade show text-center"
                         role="alert" style="position: absolute; left: 50%; transform: translateX(-50%);">
                        <strong></strong>{{ $mensaje }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ( $mensaje=Session::get('error') )
                    <div id='mensaje' class="alert alert-danger col-md-4 alert-dismissible fade show text-center"
                         role="alert" style="position: absolute; left: 50%; transform: translateX(-50%);">
                        <strong></strong>{{ $mensaje }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ( $mensaje=Session::get('confirmacion') )
                    <div id="conf" class="alert alert-success col-md-4 alert-dismissible fade show text-center"
                         role="alert" style="position: absolute; left: 50%; transform: translateX(-50%);">
                        <strong></strong>{{ $mensaje }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </br>
                        <button type="button" class="btn btn-danger" onclick="borrar()"> No</button>
                        <button type="button" class="btn btn-primary" data-toggle='modal'
                                data-target="#NuevoAlterno{{ $principal->id}}" id="NuevoAlterno" onclick="borrar()"> Sí
                        </button>
                    </div>
                @endif
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 ">
                    <h1>
                        <center>@yield('titulo')</center>
                    </h1>
                    @yield('contenido')
                </div>
            </div>
            <script>
                try {
                    const mensaje = document.getElementById('mensaje')

                    // duración de las alertas de mensaje y error
                    if(mensaje != null) {
                        setTimeout("document.getElementById('mensaje').style.display ='none'", 7000);
                    }

                    //  eliminar div
                    var clic = 1;

                    function borrar() {
                        if (clic == 1) {
                            document.getElementById('conf').style.display = 'none';
                        }
                    }
                } catch (e){

                }

            </script>
        </div>
        <!-- /Alert -->

        <!-- footer content -->
        <footer>
            <div class="centered-content">
                    <strong>INVESTIGACIÓN Y DESARROLLO TECNOLÓGICO - DIRECCIÓN POLICIAL DE
                        TELEMÁTICA - POLICÍA NACIONAL DE HONDURAS ©2024 - {{date("Y")}}</strong>
            </div>

            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

{{-- validación de campos --}}
<script language="javascript" type="text/javascript">
    //*** Este Codigo permite Validar que sea un campo Numerico
    function validarNumeros(event) {
        var tecla = event.which ? event.which : event.keyCode;
        if (tecla < 48 || tecla > 57) {
            event.preventDefault();
        }
    }

    // function validarNumerosPunto(event) {
    //     var tecla = event.which ? event.which : event.keyCode;
    //     if (tecla !== 46 && (tecla < 48 || tecla > 57)) {
    //         event.preventDefault();
    //     }
    // }

    //*** Este Codigo permite Validar que sea un campo tiempo
    function validarTiempos(event) {
        var tecla = event.which ? event.which : event.keyCode;
        if ((tecla < 48 || tecla > 57) && tecla !== 58) {
            event.preventDefault();
        }
    }

    // *** Este Codigo permitir números (del 0 al 9) y la tecla de slash "/"
    function validarPresion(event) {
        var tecla = event.which ? event.which : event.keyCode;
        if ((tecla < 48 || tecla > 57) && tecla !== 47) {
            event.preventDefault();
        }
    }

    // *** Este Codigo permitir números (del 0 al 9) y la tecla de slash "%"
    function validarSaturacion(event) {
        var tecla = event.which ? event.which : event.keyCode;
        if ((tecla < 48 || tecla > 57) && tecla !== 37) {
            event.preventDefault();
        }
    }

    //*** Este Codigo permite Validar que sea un campo texto
    function validarLetras(event) {
        var tecla = event.which ? event.which : event.keyCode;
        var letra = String.fromCharCode(tecla);
        var letrasPermitidas = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

        // Permitir letras y caracteres acentuados
        if (!letrasPermitidas.test(letra)) {
            event.preventDefault();
        }
    }
</script>


{{-- Mensaje de alerta --}}
{{-- Scripts --}}
{{--<script src="{{ asset('resources/js/components/app.js')}}"></script> --}}

<!-- Bootstrap -->
<script src="{{ asset('../vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('../vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{ asset('../vendors/nprogress/nprogress.js')}}"></script>
<!-- jQuery Smart Wizard -->
<script src="{{ asset('../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js')}}"></script>
<!-- Chart.js -->
<script src="{{ asset('../vendors/Chart.js/dist/Chart.min.js')}}"></script>
<!-- gauge.js -->
<script src="{{ asset('../vendors/gauge.js/dist/gauge.min.js')}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<!-- iCheck -->
<!-- PNotify -->
<script src="../vendors/pnotify/dist/pnotify.js"></script>
<script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>
<script src="{{ asset('../vendors/iCheck/icheck.min.js')}}"></script>
<!-- Datatables -->
<script src="{{ asset('../vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{ asset('../vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="{{ asset('../vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{ asset('../vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('../vendors/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- Skycons -->
<script src="{{ asset('../vendors/skycons/skycons.js')}}"></script>
<!-- Flot -->
<script src="{{ asset('../vendors/Flot/jquery.flot.js')}}"></script>
<script src="{{ asset('../vendors/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('../vendors/Flot/jquery.flot.time.js')}}"></script>
<script src="{{ asset('../vendors/Flot/jquery.flot.stack.js')}}"></script>
<script src="{{ asset('../vendors/Flot/jquery.flot.resize.js')}}"></script>
<!-- Flot plugins -->
<script src="{{ asset('../vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
<script src="{{ asset('../vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
<script src="{{ asset('../vendors/flot.curvedlines/curvedLines.js')}}"></script>
<!-- DateJS -->
<script src="{{ asset('../vendors/DateJS/build/date.js')}}"></script>
<!-- JQVMap -->
<script src="{{ asset('../vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
<script src="{{ asset('../vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
<script src="{{ asset('../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('../vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('../vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('../build/js/custom.min.js')}}"></script>

<script>

</script>
</body>
</html>
