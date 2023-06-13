<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body style="background: rgba(32, 36, 44, 1)">
    <div class="StyledHeader">
        <div class='logo'>
            <a href="{{ route('/') }}" class="decorationNone">Pixel Vortex</a>
        </div>
    </div>
    <div class="main-container">
        <div class="signUp-container">
            <div class="shadowbox">
                <h2 class="title">Crear Cuenta</h2>
                <form action="{{ route('signup.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre de usuario</label>
                        <input type="text" pattern="[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]" value="{{old('username')}}"
                            title="Por favor, introduzca solo carácteres alfanúmericos, puntos y guiones"
                            class="form-control" id="inputUser" name="username" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" value="{{old('email')}}"
                            title="Por favor, introduce una dirección de correo electrónico válida en el formato usuario@dominio.com"
                            class="form-control border border-primary" id="inputEmail" name="email" />
                            @error('email')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-check-all me-2">{{$message}}</i>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control border border-primary"
                            id="inputPassword" name="password" />
                            @error('password')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-check-all me-2">{{$message}}</i>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Repetir contraseña</label>
                        <input type="password" class="form-control border border-primary"
                            id="inputPassword2" name="password_confirmation" />
                            @error('password_confirmation')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-check-all me-2">{{$message}}</i>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                    </div>
                    <div class="d-grid">
                        <button class="signButton" type="submit">
                            Crear Cuenta
                        </button>
                    </div>
                </form>
                <div class="mt-3">
                    <p class="end-paragraph text-center">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login') }}" class="text-primary fw-bold">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.scripts')
</body>

</html>
