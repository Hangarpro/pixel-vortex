<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="StyledHeader" style="background: white">
        <div class='logo' style="color: black">
            Pixel Vortex
        </div>
        <div class='displayName me-5'>
            Hola {{ Auth::user()->username }}
        </div>
        <nav>
            <a class="btn btn-outline-dark" href="{{ route('design.create') }}">Crear un nuevo proyecto</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </nav>
    </div>
    <div class="ProjectsContainer">
        <h2 class="text-center">Mis Proyectos</h2>
        @if (isset($designs))
            @if (count($designs) > 0)
                <div class='projectCardContainer row'>
                    @foreach ($designs as $design)
                    <div class='projectCard col-3'>
                        <div class='projectCardHeader'>
                            <div class='projectName'>{{$design->title}}</div>
                            <form id="formDestroy{{$design->id}}" action="{{route('design.delete', $design->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="text" name="id{{$design->id}}" value="{{$design->id}}" hidden>
                            </form>
                            <span onclick="destroy({{$design->id}})">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </span>
                        </div>
                        <span>
                            <a href="{{url('/design/'.$design->id.'/edit')}}" class="text-white">
                            <img src="{{ $design->image }}" class="mb-3 img-thumbnail" alt="">
                        </a>
                        </span>
                        
                    </div>
                    @endforeach
                </div>
            @else
                <div class='noItems'>
                    No hay proyectos para mostrar
                </div>
            @endif
        @endif
    </div>

    @include('layouts.scripts')

    <script>
        function destroy(id) {
            document.getElementById("formDestroy" + id).submit();
        }
    </script>
</body>

</html>
