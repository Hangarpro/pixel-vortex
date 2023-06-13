<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
    <script src="https://kit.fontawesome.com/613e4ee7d3.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="user-project" id="app">
        <form id="project-form" action="{{ route('design.store') }}" method="POST" class="d-flex flex-column h-100" @keydown.enter="preventFormSubmit" enctype="multipart/form-data">
        @csrf
        <input type="text" id="user_id" name="user_id" value="{{auth()->id()}}" hidden>
        <input type="text" id="inputData" name="data" hidden>
        <input type="hidden" id="imageInput" name="image">
        
        <div class="header-toolbar ps-2">
            <div class="figures-bar d-flex align-items-center">
                <div class="d-flex">
                    <button type="button" id="buttonCursor" @click="cursorNormal()"
                        :class="(dibujar == false) ? 'bg-black' : ''" class="mx-1 border">
                        <i class="fa-sharp fa-solid fa-arrow-pointer"
                            :style="(dibujar == false) ? 'color: white' : ''"></i>
                    </button>
                    <button type="button" id="buttonRect" @click="dibujarFigura('rect')"
                        :class="(dibujar == true && tipoFigura === 'rect') ? 'bg-black' : ''" class="mx-1 border">
                        <i class="fa-solid fa-rectangle"
                            :style="(dibujar == true && tipoFigura === 'rect') ? 'color: white' : ''"></i>
                    </button>
                    <button type="button" id="buttonLine" @click="dibujarFigura('line')"
                        :class="(dibujar == true && tipoFigura === 'line') ? 'bg-black' : ''" class="mx-1 border">
                        <i class="fa-regular fa-pen-line"
                            :style="(dibujar == true && tipoFigura === 'line') ? 'color: white' : ''"></i>
                    </button>
                    <button type="button" id="buttonEllipse" @click="dibujarFigura('ellipse')"
                        :class="(dibujar == true && tipoFigura === 'ellipse') ? 'bg-black' : ''"
                        class="mx-1 border">
                        <i class="fa-solid fa-circle"
                            :style="(dibujar == true && tipoFigura === 'ellipse') ? 'color: white' : ''"></i>
                    </button>
                    <button type="button" id="buttonText" @click="dibujarFigura('text')"
                        :class="(dibujar == true && tipoFigura === 'text') ? 'bg-black' : ''" class="mx-1 border">
                        <i class="fa-solid fa-text"
                            :style="(dibujar == true && tipoFigura === 'text') ? 'color: white' : ''"></i>
                    </button>
                </div>
            </div>
            <div class="project-title d-flex justify-content-center align-items-center">
                <input type="text" id="title" name="title" value="Unknown" required>
            </div>
            <div class="project-save d-flex justify-content-center align-items-center">
                <button type="button" @click="guardar()" class="btn btn-outline-dark me-4">
                    Guardar
                </button>
                <a href="{{ route('home') }}" class="btn btn-danger">Salir</a>
            </div>
        </div>

        <div class="d-flex h-100 text-black">
            <div class="sidebar-elements bg-light">
                <h2 class="text-center pt-3 px-4 text-secondary">
                    Elementos
                </h2>
                <div class="list-of-elements px-2">
                    <div class="row">
                        <div v-for="(figura, index) in figuras" :class="figura.selected ? 'bgcolor-hover-btn' : ''"
                            class="col-12 border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center w-100" @click="seleccionarFigura(index)">
                                    <i :class="asignarIconoFigura(figura.type)" class="fa-solid icon-figure"
                                        :key="'iconoFigura' + index"
                                        :style="{ color: obtenerColorRGB(figura.fill_r, figura.fill_g, figura.fill_b) }"></i>
                                    <h3 class="name-figure ms-2 mb-0">
                                        @{{ figura.type }} - @{{ figura.id }}
                                    </h3>
                                </div>
                                <div class="btns-figure d-flex align-items-center bg-light">
                                    <button v-if="index!=figuras.length-1" type="button"
                                        :key="'moverCapaSiguienteFigura' + figura.id"
                                        :id="'moverCapaSiguienteFigura' + figura.id"
                                        @click="moverCapaFigura(index,'siguiente')">
                                        <i class="fa-solid fa-arrow-down" style="color: black"></i>
                                    </button>
                                    <button v-if="index!=0" type="button"
                                        :key="'moverCapaAnteriorFigura' + figura.id"
                                        :id="'moverCapaAnteriorFigura' + figura.id"
                                        @click="moverCapaFigura(index,'anterior')">
                                        <i class="fa-solid fa-arrow-up" style="color: black"></i>
                                    </button>
                                    <button type="button" :key="'ocultarFigura' + figura.id"
                                        :id="'ocultarFigura' + figura.id" @click="ocultarFigura(figura.id)">
                                        <i v-if="figura.hidden==false" class="fa-solid fa-eye"
                                            style="color: black"></i>
                                        <i v-else class="fas fa-eye-slash" style="color: black"></i>
                                    </button>
                                    <button type="button" :key="'eliminarFigura' + figura.id"
                                        :id="'eliminarFigura' + figura.id"
                                        @click="eliminarFigura(figura.id,index)">
                                        <i class="fa-solid fa-trash-can" style="color: black"></i>
                                    </button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="area-canvas" class="area-canvas d-flex justify-content-center align-items-center">

                </div>

                @if (session('success'))
                    <div id="message-success" class="alert alert-success alert-dismissible fade show"
                        role="alert">
                        Se han guardado los cambios correctamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @elseif (session('error'))
                    <div id="message-error" class="alert alert-danger alert-dismissible fade show"
                        role="alert">
                        Ha surgido un error, no se pudieron guardar los cambios.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                <div class="sidebar-options bg-light p-1">
                    <div v-if="figuraSeleccionada&&figuraObjeto.type!=='line'"
                        class="filled px-2 mb-4 mt-3 p-1 border">
                        <div class="d-flex flex-column text-center mb-3">
                            <h2 class="px-2 mb-0 text-secondary">
                                Borde
                            </h2>
                        </div>
                        <div class="row justify-content-center px-2 m-0">
                            <div class="row justify-content-between" style="display: flex">
                                <div class="col-6 mb-2">

                                    <label for="" class="form-label text-black">Color</label>
                                    <input class="border" type="color" id="color_pick2"
                                        @change="cambiarColor(figuraObjeto.id, 'border')" value="#000000"
                                        style="width:85%;">

                                </div>

                                <div class="col-6 mb-2">

                                    <label for="" class="form-label text-black">Opacidad</label>
                                    <input type="number" name="" id="border_a" class="ms-2 border"
                                        min="0" max="255" v-model="figuraObjeto.border_a">

                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-center">
                                    <label for="" class="me-4 text-black">Grosor:</label>
                                    <input type="number" name="" id="thickness" class="ms-2 me-1 border"
                                        min="0" max="255" v-model="figuraObjeto.thickness">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="figuraSeleccionada" class="filled px-2 mb-4 p-1 border">
                        <div class="d-flex flex-column text-center mb-3">
                            <h2 class="px-2 mb-0 text-secondary">
                                Relleno
                            </h2>
                        </div>
                        <div class="row justify-content-center px-2 m-0">
                            <div class="row justify-content-between" style="display: flex">
                                <div class="col-6 mb-2">
                                    <label for="" class="form-label text-black">Color</label>
                                    <input v-if="figuraObjeto.type==='line'" type="color" id="color_pick"
                                        @change="cambiarColor(figuraObjeto.id, 'fill')" value="#000000"
                                        style="width:85%; form-control border">
                                    <input v-else type="color" id="color_pick"
                                        @change="cambiarColor(figuraObjeto.id, 'fill')" value="#ffffff"
                                        style="width:85%; form-control border">
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="form-label text-black">
                                        Opacidad
                                    </label>
                                    <input type="number" name="" id="fill_a" class="ms-2 border"
                                        min="0" max="255" v-model="figuraObjeto.fill_a">
                                </div>
                            </div>
                            <div v-if="figuraObjeto.type==='line'" class="col-12 mb-2">
                                <div class="d-flex justify-content-center">
                                    <label for="" class="me-4 text-black">Grosor:</label>
                                    <input type="number" name="" id="thickness" class="ms-2 me-1 border"
                                        min="1" max="255" v-model="figuraObjeto.thickness">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="figuraSeleccionada && figuraObjeto.type=='text'"
                        class="measures px-2 mb-4 p-1 border text-black">
                        <h2 class="text-center px-2 text-secondary">
                            Contenido
                        </h2>
                        <div class="row justify-content-center px-2 m-0">
                            <div class="row justify-content-between" style="display: flex">
                                <div class="col-12 mb-2 text-center">
                                    <label for="">Texto</label>
                                    <input type="text" name="" id="text" class="ms-2 border"
                                        minlength="0" maxlength="150" placeholder="Escribe aquí"
                                        v-model="figuraObjeto.text">
                                </div>

                            </div>
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-center">
                                    <label for="">Tamaño:</label>
                                    <input type="number" name="" id="size" class="ms-2 border"
                                        min="0" v-model="figuraObjeto.size">
                                </div>

                            </div>

                            <div v-if="figuraObjeto.corner!=null" class="col-12 mb-2">
                                <div class="d-flex">
                                    <label for="">Radius-corner:</label>
                                    <input type="number" name="" id="rounded_corner" class="ms-2 border"
                                        min="0" v-model="figuraObjeto.corner">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="figuraSeleccionada && figuraObjeto.type!=='line' && figuraObjeto.type!=='text'"
                        class="measures px-2 mb-4 p-1 border text-black">
                        <h2 class="text-center px-2 text-secondary">
                            Dimensiones
                        </h2>
                        <div class="row justify-content-center px-2 m-0">
                            <div class="row justify-content-between" style="display: flex">
                                <div class="col-6 mb-2">
                                    <label for="">Ancho</label>
                                    <input type="number" name="" id="w" class="border"
                                        v-model="figuraObjeto.w">
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="">Alto</label>
                                    <input type="number" name="" id="h" class="border"
                                        v-model="figuraObjeto.h">
                                </div>
                            </div>
                            <div v-if="figuraObjeto.corner!=null" class="col-12 mb-2">
                                <div class="d-flex">
                                    <label for="">Radius-corner:</label>
                                    <input type="number" name="" id="rounded_corner" class="ms-2 border"
                                        min="0" v-model="figuraObjeto.corner">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="figuraSeleccionada && figuraObjeto.type!=='line'"
                        class="measures px-2 mb-4 p-1 border text-black">
                        <h2 class="text-center px-2 text-secondary">
                            Coordenadas
                        </h2>
                        <div class="row justify-content-center px-2 m-0">
                            <div class="row justify-content-between" style="display: flex">
                                <div class="col-6 mb-2">
                                    <label for="" class="ms-3">X</label>
                                    <input type="number" name="" id="x" class="border"
                                        min="0" v-model="figuraObjeto.x">
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="ms-3">Y</label>
                                    <input type="number" name="" id="y" class="border"
                                        min="0" v-model="figuraObjeto.y">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="figuraSeleccionada && figuraObjeto.type=='line'"
                        class="measures px-2 mb-4 p-1 border text-black">
                        <h2 class="text-center px-2 text-secondary">
                            Coordenadas
                        </h2>
                        <div class="row justify-content-between px-2 m-0" style="display: flex">
                            <div class="col-6 mb-2">
                                <label for="">Punto[0]X</label>
                                <input type="number" name="" id="x1" class="ms-2 border"
                                    min="0" v-model="figuraObjeto.x1">
                            </div>
                            <div class="col-6 mb-2">
                                <label for="">Punto[0]Y:</label>
                                <input type="number" name="" id="y1" class="ms-2 border"
                                    min="0" v-model="figuraObjeto.y1">
                            </div>
                        </div>
                        <div class="row justify-content-between px-2 m-0" style="display: flex">
                            <div class="col-6 mb-2">
                                <label for="" cl>Punto[1]X</label>
                                <input type="number" name="" id="x2" class="ms-2 border"
                                    min="0" v-model="figuraObjeto.x2">
                            </div>
                            <div class="col-6 mb-2">
                                <label for="">Punto[1]X</label>
                                <input type="number" name="" id="y2" class="ms-2 border"
                                    min="0" v-model="figuraObjeto.y2">
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </form><!-- end form -->
    </div>
    
    

    @include('layouts.scripts')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js" integrity="sha512-3RlxD1bW34eFKPwj9gUXEWtdSMC59QqIqHnD8O/NoTwSJhgxRizdcFVQhUMFyTp5RwLTDL0Lbcqtl8b7bFAzog==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    figuras: [],
                    figuraSeleccionada: false,
                    figuraID: null,
                    figuraObjeto: null,
                    dibujar: false,
                    tipoFigura: '',
                    puntoInicio: [],
                    puntoFinal: [],
                    ctrlPresionado: false,
                }
            },
            methods: {
                preventFormSubmit(event) {
                    event.preventDefault();
                },
                cursorNormal() {
                    this.dibujar = false;
                    this.tipoFigura = '';
                    this.puntoInicio = [];
                    this.puntoFinal = [];
                    document.body.style.cursor = "default";
                },
                dibujarFigura(tipoFigura) {
                    this.resetearVariables();
                    this.dibujar = true;
                    this.tipoFigura = tipoFigura;
                    document.body.style.cursor = "crosshair";
                },
                addFigure(tipoFigura, x = 100, y = 100) {
                    this.figuras.unshift(new Figura(tipoFigura, x, y));
                },
                guardar() {
                    document.getElementById("inputData").value = JSON.stringify(this.figuras);
                    let p5canvas = document.getElementById("defaultCanvas0");
                    let image = p5canvas.toDataURL('image/png');
                    document.getElementById("imageInput").value = image;
                    document.getElementById("project-form").submit();
                },
                ocultarFigura(id) {
                    const index = this.figuras.findIndex(figura => figura.id === id);
                    if(this.figuras[index].hidden==false) {
                        this.figuras[index].hidden = true;
                    } else {
                        this.figuras[index].hidden = false;
                    }
                },
                eliminarFigura(id, index) {
                    if(this.figuraID==index) {
                        this.resetearVariables();
                    }
                    const nuevoArray = this.figuras.filter(figura => figura.id !== id);
                    if(nuevoArray.length==0) {
                        this.figuras = [];
                        this.resetearVariables();
                    } else {
                        this.figuras = nuevoArray;
                    }
                },
                resetearVariables() {
                    this.figuraID = null;
                    this.figuraSeleccionada = false;
                    this.figuraObjeto = null;
                    this.figuras.forEach(element => {
                        element.selected = false;
                    });
                },
                cambiarColor(id, r, g, b, a, option) {
                    const index = this.figuras.findIndex(figura => figura.id === id);
                    this.figuras[index].cambiarColorPredeterminado(r, g, b, a, option);
                },
                seleccionarFigura(index) {
                    this.resetearVariables();
                    if(this.dibujar==false) {
                        this.figuras[index].selected = true;
                        this.figuraID = index;
                        this.figuraSeleccionada = true;
                        this.figuraObjeto = this.figuras[index];
                    }
                },
                moverCapaFigura(index, posicion) {
                    let aux = this.figuras[index];
                    if(posicion==="siguiente") {
                        if (index < 0 || index >= this.figuras.length-1) {
                            console.error("FUERA DE RANGO - Siguiente");
                            return;
                        }
                        this.figuras[index] = this.figuras[index+1];
                        this.figuras[index+1] = aux;
                        this.resetearVariables();
                        this.figuras[index].selected = false;
                        this.figuras[index+1].selected = true;
                        this.figuraSeleccionada = true; 
                        this.figuraID = index+1;
                        this.figuraObjeto = this.figuras[index+1];
                    } else if(posicion==="anterior") {
                        if (index <= 0 || index > this.figuras.length) {
                            console.error("FUERA DE RANGO - Anterior");
                            return;
                        }
                        this.figuras[index] = this.figuras[index-1];
                        this.figuras[index-1] = aux;
                        this.resetearVariables();
                        this.figuras[index].selected = false;
                        this.figuras[index-1].selected = true;
                        this.figuraSeleccionada = true; 
                        this.figuraID = index-1;
                        this.figuraObjeto = this.figuras[index-1];
                    }
                },
                obtenerColorRGB(r, g, b) {
                    return `rgb(${r}, ${g}, ${b})`;
                },
                asignarIconoFigura(tipo) {
                    if (tipo === 'rect') {
                        return 'fa-square';
                    } else if (tipo === 'line') {
                        return 'fa-minus';
                    } else if (tipo === 'ellipse') {
                        return 'fa-circle';
                    } else if (tipo === 'text') {
                        return 'fa-t';
                    } else {
                        return '';
                    }
                },
                detectarCtrlPresionado(event) {
                    if (event.key === 'Control') {
                        this.ctrlPresionado = true;
                    }
                },
                detectarCtrlSoltado(event) {
                    if (event.key === 'Control') {
                        this.ctrlPresionado = false;
                    }
                },
            },
            mounted() {
                document.addEventListener('keydown', this.detectarCtrlPresionado);
                document.addEventListener('keyup', this.detectarCtrlSoltado);

                //CANVAS
                new p5((p) => {
                    let offsetX = 0;
                    let offsetY = 0;
                    let offsetX2 = 0;
                    let offsetY2 = 0;
                    let rectX = 0;
                    let rectY = 0;
                    let rectWidth = 0;
                    let rectHeight = 0;

                    p.setup = () => {
                        var divCanvas = document.getElementById("area-canvas");
                        var canvasAncho = divCanvas.offsetWidth;
                        var canvasAlto = divCanvas.offsetHeight;
                        p.createCanvas(canvasAncho, canvasAlto);
                    };

                    p.draw = () => {
                        p.background(255);
                        for (let i = this.figuras.length - 1; i >= 0; i--) {
                            if(this.figuras[i].hidden==false) {
                                if(this.figuras[i].selected==true) {
                                    p.stroke(12, 140, 233);
                                    p.strokeWeight(2);
                                    p.fill(0,0,0,0);
                                    if(this.figuras[i].type==="text") {
                                        p.rect(this.figuras[i].x-2, this.figuras[i].y-(this.figuras[i].h), this.figuras[i].w+4, this.figuras[i].h+8);
                                    } else if(this.figuras[i].type==='line') {
                                        rectX = Math.min(this.figuras[i].x1, this.figuras[i].x2);
                                        rectY = Math.min(this.figuras[i].y1, this.figuras[i].y2);
                                        rectWidth = Math.abs(this.figuras[i].x2 - this.figuras[i].x1);
                                        rectHeight = Math.abs(this.figuras[i].y2 - this.figuras[i].y1);                   
                                        p.rect(rectX, rectY, rectWidth, rectHeight);
                                    } else {
                                        if(this.figuras[i].w>=0&&this.figuras[i].h>=0) {
                                            p.rect(this.figuras[i].x-6, this.figuras[i].y-6, this.figuras[i].w+12, this.figuras[i].h+12);
                                        } else if(this.figuras[i].w<0&&this.figuras[i].h>=0) {
                                            p.rect(this.figuras[i].x+6, this.figuras[i].y-6, this.figuras[i].w-12, this.figuras[i].h+12);
                                        } else if(this.figuras[i].w>=0&&this.figuras[i].h<0) {
                                            p.rect(this.figuras[i].x-6, this.figuras[i].y+6, this.figuras[i].w+12, this.figuras[i].h-12);
                                        } else if(this.figuras[i].w<0&&this.figuras[i].h<0) {
                                            p.rect(this.figuras[i].x+6, this.figuras[i].y+6, this.figuras[i].w-12, this.figuras[i].h-12);
                                        }
                                    }
                                }
                                this.figuras[i].dibujar(p);
                            }
                        }

                        if(this.dibujar==true){
                            if(this.puntoInicio!=null) {
                                p.stroke(0);
                                p.fill(255,255,255,0);
                                p.strokeWeight(2);
                                if(this.tipoFigura==='rect') {
                                    p.rect(this.puntoInicio.x, this.puntoInicio.y, p.mouseX-this.puntoInicio.x, p.mouseY-this.puntoInicio.y);
                                } else if(this.tipoFigura==='line') {
                                    p.line(this.puntoInicio.x, this.puntoInicio.y, p.mouseX, p.mouseY);
                                } else if(this.tipoFigura==='ellipse') {
                                    p.ellipse(this.puntoInicio.x+((p.mouseX-this.puntoInicio.x)/2), this.puntoInicio.y+((p.mouseY-this.puntoInicio.y)/2), (p.mouseX-this.puntoInicio.x), (p.mouseY-this.puntoInicio.y));
                                }
                            }
                        }

                        if(this.figuraID!=null) {
                            if(this.figuras[this.figuraID].selected==true) {
                                if (this.ctrlPresionado) {
                                    if(this.figuras[this.figuraID].type==='rect'||this.figuras[this.figuraID].type==='ellipse') {
                                        this.figuras[this.figuraID].updateMedidas(this.figuras[this.figuraID].x, this.figuras[this.figuraID].y, p.mouseX - this.figuras[this.figuraID].x, p.mouseY - this.figuras[this.figuraID].y);
                                    } else if(this.figuras[this.figuraID].type==='line') {
                                        this.figuras[this.figuraID].updateLinea(this.figuras[this.figuraID].x1, this.figuras[this.figuraID].y1, p.mouseX, p.mouseY);
                                    }
                                }
                            }
                        }
                    };

                    p.mouseClicked = () => {              
                        if(this.dibujar==false) {
                            this.figuras.forEach((figura, index) => {
                                if(this.figuraSeleccionada==false&&figura.hidden==false) {
                                    if (figura.type!=='text'&&figura.type!=='line') {
                                        let entra = false;
                                        if(figura.w>=0&&figura.h>=0) {
                                            if(p.mouseX >= figura.x && p.mouseX <= figura.x + figura.w && p.mouseY >= figura.y && p.mouseY <= figura.y + figura.h) {
                                                entra = true;
                                            }
                                        } else if(figura.w<0&&figura.h>=0) {
                                            if(p.mouseX <= figura.x && p.mouseX >= figura.x + figura.w && p.mouseY >= figura.y && p.mouseY <= figura.y + figura.h) {
                                                entra = true;
                                            }
                                        } else if(figura.w>=0&&figura.h<0) {
                                            if(p.mouseX >= figura.x && p.mouseX <= figura.x + figura.w && p.mouseY <= figura.y && p.mouseY >= figura.y + figura.h) {
                                                entra = true;
                                            }
                                        } else if(figura.w<0&&figura.h<0) {
                                            if(p.mouseX <= figura.x && p.mouseX >= figura.x + figura.w && p.mouseY <= figura.y && p.mouseY >= figura.y + figura.h) {
                                                entra = true;
                                            }
                                        }
                                        if(entra) {
                                            this.figuraSeleccionada = true; 
                                            figura.selected = true;
                                            this.figuraID = index;
                                            this.figuraObjeto = figura;
                                        }
                                    } else if(p.mouseX >= figura.x  &&
                                        p.mouseX <= figura.x + figura.w &&
                                        p.mouseY >= figura.y - figura.h &&
                                        p.mouseY <= figura.y+8 &&
                                        figura.type==='text') {
                                        this.figuraSeleccionada = true; 
                                        figura.selected = true;
                                        this.figuraID = index;
                                        this.figuraObjeto = figura;
                                    } else if(figura.type==='line') {
                                        let rectX2 = Math.min(figura.x1, figura.x2);
                                        let rectY2 = Math.min(figura.y1, figura.y2);
                                        let rectWidth2 = Math.abs(figura.x2 - figura.x1);
                                        let rectHeight2 = Math.abs(figura.y2 - figura.y1);
                                        if (p.mouseX >= rectX2 && p.mouseX <= rectX2 + rectWidth2 && p.mouseY >= rectY2 && p.mouseY <= rectY2 + rectHeight2) {
                                            this.figuraSeleccionada = true; 
                                            figura.selected = true;
                                            this.figuraID = index;
                                            this.figuraObjeto = figura;
                                        }
                                    }
                                }
                            });
                        }
                    }

                    p.mousePressed = () => {
                        if(this.dibujar && (p.mouseX > 0 && p.mouseX < p.width && p.mouseY > 0 && p.mouseY < p.height)) {
                            if(this.tipoFigura==='text'&&this.tipoFigura!=='') {
                                this.addFigure(this.tipoFigura, p.mouseX, p.mouseY);
                            } else {
                                if(this.puntoInicio.length==0) {
                                    this.puntoInicio = {
                                        x: p.mouseX,
                                        y: p.mouseY,
                                    }
                                } else if(this.puntoFinal.length==0) {
                                    this.puntoFinal = {
                                        x: p.mouseX,
                                        y: p.mouseY,
                                    }
                                    this.addFigure(this.tipoFigura);
                                    if(this.tipoFigura==='line') {
                                        this.figuras[0].updateLinea(this.puntoInicio.x, this.puntoInicio.y, this.puntoFinal.x, this.puntoFinal.y);
                                    } else {
                                        this.figuras[0].updateMedidas(this.puntoInicio.x, this.puntoInicio.y, this.puntoFinal.x-this.puntoInicio.x, this.puntoFinal.y-this.puntoInicio.y);
                                    }
                                    this.puntoInicio = [];
                                    this.puntoFinal = [];
                                }
                            }
                        }

                        if(this.figuraID !== null && this.figuras[this.figuraID] !== undefined) {
                            if(this.figuras[this.figuraID].type!=='text'&&this.figuras[this.figuraID].type!=='line') {
                                let entra = false;
                                if(this.figuras[this.figuraID].w>=0&&this.figuras[this.figuraID].h>=0) {
                                    if(p.mouseX >= this.figuras[this.figuraID].x && p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY >= this.figuras[this.figuraID].y && p.mouseY <= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w<0&&this.figuras[this.figuraID].h>=0) {
                                    if(p.mouseX <= this.figuras[this.figuraID].x && p.mouseX >= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY >= this.figuras[this.figuraID].y && p.mouseY <= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w>=0&&this.figuras[this.figuraID].h<0) {
                                    if(p.mouseX >= this.figuras[this.figuraID].x && p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY <= this.figuras[this.figuraID].y && p.mouseY >= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w<0&&this.figuras[this.figuraID].h<0) {
                                    if(p.mouseX <= this.figuras[this.figuraID].x && p.mouseX >= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY <= this.figuras[this.figuraID].y && p.mouseY >= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                }
                                if(entra) {
                                    offsetX = p.mouseX - this.figuras[this.figuraID].x;
                                    offsetY = p.mouseY - this.figuras[this.figuraID].y;
                                }
                            } else if(
                                p.mouseX >= this.figuras[this.figuraID].x  &&
                                p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w &&
                                p.mouseY >= this.figuras[this.figuraID].y - this.figuras[this.figuraID].h &&
                                p.mouseY <= this.figuras[this.figuraID].y+8 &&
                                this.figuras[this.figuraID].type==='text'
                            ) {
                                offsetX = p.mouseX - this.figuras[this.figuraID].x;
                                offsetY = p.mouseY - this.figuras[this.figuraID].y;
                            } else if(this.figuras[this.figuraID].type==='line') {
                                let rectX3 = Math.min(this.figuras[this.figuraID].x1, this.figuras[this.figuraID].x2);
                                let rectY3 = Math.min(this.figuras[this.figuraID].y1, this.figuras[this.figuraID].y2);
                                let rectWidth3 = Math.abs(this.figuras[this.figuraID].x2 - this.figuras[this.figuraID].x1);
                                let rectHeight3 = Math.abs(this.figuras[this.figuraID].y2 - this.figuras[this.figuraID].y1);

                                if (p.mouseX >= rectX3 && p.mouseX <= rectX3 + rectWidth3 && p.mouseY >= rectY3 && p.mouseY <= rectY3 + rectHeight3) {
                                    offsetX = p.mouseX - this.figuras[this.figuraID].x1;
                                    offsetY = p.mouseY - this.figuras[this.figuraID].y1;
                                    offsetX2 = p.mouseX - this.figuras[this.figuraID].x2;
                                    offsetY2 = p.mouseY - this.figuras[this.figuraID].y2;
                                }
                            }
                        }
                    }

                    p.mouseDragged = () => {
                        if(this.figuraID !== null && this.figuras[this.figuraID] !== undefined) {
                            if(this.figuras[this.figuraID].type!=='text'&&this.figuras[this.figuraID].type!=='line') {
                                let entra = false;
                                if(this.figuras[this.figuraID].w>=0&&this.figuras[this.figuraID].h>=0) {
                                    if(p.mouseX >= this.figuras[this.figuraID].x && p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY >= this.figuras[this.figuraID].y && p.mouseY <= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w<0&&this.figuras[this.figuraID].h>=0) {
                                    if(p.mouseX <= this.figuras[this.figuraID].x && p.mouseX >= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY >= this.figuras[this.figuraID].y && p.mouseY <= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w>=0&&this.figuras[this.figuraID].h<0) {
                                    if(p.mouseX >= this.figuras[this.figuraID].x && p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY <= this.figuras[this.figuraID].y && p.mouseY >= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w<0&&this.figuras[this.figuraID].h<0) {
                                    if(p.mouseX <= this.figuras[this.figuraID].x && p.mouseX >= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY <= this.figuras[this.figuraID].y && p.mouseY >= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                }
                                if(entra==true && this.figuras[this.figuraID].hidden==false) {
                                    this.figuras[this.figuraID].x = p.mouseX - offsetX;
                                    this.figuras[this.figuraID].y = p.mouseY - offsetY;
                                }
                            } else if(
                                p.mouseX >= this.figuras[this.figuraID].x  &&
                                p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w &&
                                p.mouseY >= this.figuras[this.figuraID].y - this.figuras[this.figuraID].h &&
                                p.mouseY <= this.figuras[this.figuraID].y+8 &&
                                this.figuras[this.figuraID].type==='text') {
                                    if (this.figuraID !== null && this.figuras[this.figuraID].hidden==false) {
                                    this.figuras[this.figuraID].x = p.mouseX - offsetX;
                                    this.figuras[this.figuraID].y = p.mouseY - offsetY;
                                }
                            } else if(this.figuras[this.figuraID].type==='line') {
                                let rectX4 = Math.min(this.figuras[this.figuraID].x1, this.figuras[this.figuraID].x2);
                                let rectY4 = Math.min(this.figuras[this.figuraID].y1, this.figuras[this.figuraID].y2);
                                let rectWidth4 = Math.abs(this.figuras[this.figuraID].x2 - this.figuras[this.figuraID].x1);
                                let rectHeight4 = Math.abs(this.figuras[this.figuraID].y2 - this.figuras[this.figuraID].y1);
                                
                                if (p.mouseX >= rectX4 && p.mouseX <= rectX4 + rectWidth4 && p.mouseY >= rectY4 && p.mouseY <= rectY4 + rectHeight4) {
                                    if (this.figuraID !== null && this.figuras[this.figuraID].hidden==false) {
                                        this.figuras[this.figuraID].x1 = p.mouseX - offsetX;
                                        this.figuras[this.figuraID].y1 = p.mouseY - offsetY;
                                        this.figuras[this.figuraID].x2 = p.mouseX - offsetX2;
                                        this.figuras[this.figuraID].y2 = p.mouseY - offsetY2;
                                    }
                                }
                            }
                        }    
                    }

                    p.mouseReleased = () => {
                        if(this.figuraID !== null && this.figuras[this.figuraID] !== undefined) {
                            if(this.figuras[this.figuraID].type!=='text'&&this.figuras[this.figuraID].type!=='line') {
                                let entra = false;
                                if(this.figuras[this.figuraID].w>=0&&this.figuras[this.figuraID].h>=0) {
                                    if(p.mouseX >= this.figuras[this.figuraID].x && p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY >= this.figuras[this.figuraID].y && p.mouseY <= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w<0&&this.figuras[this.figuraID].h>=0) {
                                    if(p.mouseX <= this.figuras[this.figuraID].x && p.mouseX >= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY >= this.figuras[this.figuraID].y && p.mouseY <= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w>=0&&this.figuras[this.figuraID].h<0) {
                                    if(p.mouseX >= this.figuras[this.figuraID].x && p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY <= this.figuras[this.figuraID].y && p.mouseY >= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                } else if(this.figuras[this.figuraID].w<0&&this.figuras[this.figuraID].h<0) {
                                    if(p.mouseX <= this.figuras[this.figuraID].x && p.mouseX >= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w && p.mouseY <= this.figuras[this.figuraID].y && p.mouseY >= this.figuras[this.figuraID].y + this.figuras[this.figuraID].h) {
                                        entra = true;
                                    }
                                }
                                if(entra==false && (p.mouseX > 0 && p.mouseX < p.width && p.mouseY > 0 && p.mouseY < p.height)) {
                                    this.figuras[this.figuraID].selected = false;
                                    this.figuraSeleccionada = false;
                                }
                            } else if(
                                !(p.mouseX >= this.figuras[this.figuraID].x  &&
                                p.mouseX <= this.figuras[this.figuraID].x + this.figuras[this.figuraID].w &&
                                p.mouseY >= this.figuras[this.figuraID].y - this.figuras[this.figuraID].h &&
                                p.mouseY <= this.figuras[this.figuraID].y+8) &&
                                this.figuras[this.figuraID].type==='text') {
                                if (this.figuraID !== null && (p.mouseX > 0 && p.mouseX < p.width && p.mouseY > 0 && p.mouseY < p.height)) {
                                    this.figuras[this.figuraID].selected = false;
                                    this.figuraSeleccionada = false;
                                }
                            } else if(this.figuras[this.figuraID].type==='line') {
                                let rectX5 = Math.min(this.figuras[this.figuraID].x1, this.figuras[this.figuraID].x2);
                                let rectY5 = Math.min(this.figuras[this.figuraID].y1, this.figuras[this.figuraID].y2);
                                let rectWidth5 = Math.abs(this.figuras[this.figuraID].x2 - this.figuras[this.figuraID].x1);
                                let rectHeight5 = Math.abs(this.figuras[this.figuraID].y2 - this.figuras[this.figuraID].y1);
                                if (!(p.mouseX >= rectX5 && p.mouseX <= rectX5 + rectWidth5 && p.mouseY >= rectY5 && p.mouseY <= rectY5 + rectHeight5)) {
                                    if (this.figuraID !== null && (p.mouseX > 0 && p.mouseX < p.width && p.mouseY > 0 && p.mouseY < p.height)) {
                                        this.figuras[this.figuraID].selected = false;
                                        this.figuraSeleccionada = false;
                                    }
                                }
                            }
                        }
                    }
                }, "area-canvas");
            },
        })
        app.mount('#app')
    </script>
</body>
</html>