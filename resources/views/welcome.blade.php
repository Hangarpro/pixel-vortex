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

    <section class="hero section">
        <div class="container">
            <div class="hero-inner">
                <div class="hero-copy">
                    <h1 class="hero-title mt-0 h1">
                        Crea tus diseños de forma fácil desde la web
                    </h1>
                    <p class="hero-paragraph p">
                        Dale vida a tus ideas de manera sencilla desde Pixel Vortex,
                        inicia sesión o regístrate y diseña lo que te diga tu mente.
                    </p>
                    <div class="hero-cta">
                        <a class="button button-primary a" href="{{ route('signup') }}">
                            Regístrate
                        </a>
                        <a class="button a" href="{{ route('login') }}">
                            Inicia sesión
                        </a>
                    </div>
                </div>
                <div class="hero-figure anime-element">
                    <svg class="placeholder" width="400" height="396" viewBox="0 0 528 396">
                        <rect width="528" height="396" style="fill:transparent;" />
                    </svg>
                    <div class="hero-figure-box hero-figure-box-01" data-rotation="45deg"></div>
                    <div class="hero-figure-box hero-figure-box-02" data-rotation="-45deg"></div>
                    <div class="hero-figure-box hero-figure-box-03" data-rotation="0deg"></div>
                    <div class="hero-figure-box hero-figure-box-04" data-rotation="-135deg"></div>
                    <div class="hero-figure-box hero-figure-box-05"></div>
                    <div class="hero-figure-box hero-figure-box-06"></div>
                    <div class="hero-figure-box hero-figure-box-07"></div>
                    <div class="hero-figure-box hero-figure-box-08" data-rotation="-22deg"></div>
                    <div class="hero-figure-box hero-figure-box-09" data-rotation="-52deg"></div>
                    <div class="hero-figure-box hero-figure-box-10" data-rotation="-50deg"></div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.scripts')
</body>

</html>
