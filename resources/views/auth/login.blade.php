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
                <h2 class="title">Iniciar sesión</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" value="{{old('email')}}"
                            title="Por favor, introduce una dirección de correo electrónico válida en el formato usuario@dominio.com"
                            class="form-control border border-primary" id="inputEmail" name="email" />
                            @error('email')
                                <div>
                                    {{$message}}
                                </div>
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control border border-primary"
                            id="inputPassword" name="password" />
                            @error('password')
                                <div>
                                    {{$message}}
                                </div>
                            @enderror
                    </div>
                    <div class="d-grid">
                        <button class="signButton" type="submit">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>
                <div class="mt-3">
                    <p class="end-paragraph text-center">
                        ¿No tienes una cuenta?
                        <a href="{{ route('signup') }}" class="text-primary fw-bold">
                            Regístrate
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.scripts')
</body>

</html>
