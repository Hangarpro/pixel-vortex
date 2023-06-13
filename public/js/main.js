class Figura {
    constructor(tipoFigura, x = 100, y = 100) {
        this.id = Figura.generarID();
        this.type = tipoFigura;
        this.hidden = false;
        this.selected = false;

        if(tipoFigura === 'rect') {
            this.x = x;
            this.y = y;
            this.w = 100;
            this.h = 50;
            this.corner = 0;
            /* RELLENO */
            this.fill_r = 255;
            this.fill_g = 255;
            this.fill_b = 255;
            this.fill_a = 255;
            /* BORDE */
            this.thickness = 2;
            this.border_r = 0;
            this.border_g = 0;
            this.border_b = 0;
            this.border_a = 255;
            /* FONT */
            this.size = null;
            this.text = null;
        } else if(tipoFigura === 'line') {
            this.x1 = 0;
            this.y1 = 0;
            this.x2 = 100;
            this.y2 = 100;
            this.thickness = 2;
            /* RELLENO */
            this.fill_r = 0;
            this.fill_g = 0;
            this.fill_b = 0;
            this.fill_a = 255;
            /* FONT */
            this.size = null;
            this.text = null;
        } else if(tipoFigura === 'ellipse') {
            this.x = x;
            this.y = y;
            this.w = 50; //RADIO X
            this.h = 50; //RADIO Y
            this.corner = null;
            /* RELLENO */
            this.fill_r = 255;
            this.fill_g = 255;
            this.fill_b = 255;
            this.fill_a = 255;
            /* BORDE */
            this.thickness = 2;
            this.border_r = 0;
            this.border_g = 0;
            this.border_b = 0;
            this.border_a = 255;
            /* FONT */
            this.size = null;
            this.text = null;
        } else if(tipoFigura === 'text') {
            this.x = x;
            this.y = y;
            this.w = 0;
            this.h = 0;
            this.size = 16;
            /* RELLENO */
            this.fill_r = 0;
            this.fill_g = 0;
            this.fill_b = 0;
            this.fill_a = 255;
            /* BORDE */
            this.thickness = 1;
            this.border_r = 255;
            this.border_g = 255;
            this.border_b = 255;
            this.border_a = 0;
            /* FONT */
            this.size = 16;
            this.text = "TEXTO";
        }
    }

    dibujar(p) {
        if (this.type == 'rect') {
            //BORDE GROSOR
            p.strokeWeight(this.thickness);
            //BORDE COLOR Y OPACIDAD
            p.stroke(this.border_r, this.border_g, this.border_b, this.border_a);
            //RELLENO COLOR Y OPACIDAD
            p.fill(this.fill_r, this.fill_g, this.fill_b, this.fill_a);
            //DIBUJAR RECTÁNGULO Y ESQUINAS REDONDEADAS
            p.rect(this.x, this.y, this.w, this.h, this.corner);
        } else if (this.type === 'line') {
            //GROSOR
            p.strokeWeight(this.thickness);
            //COLOR Y OPACIDAD
            p.stroke(this.fill_r, this.fill_g, this.fill_b, this.fill_a);
            //DIBUJAR LÍNEA
            p.line(this.x1, this.y1, this.x2, this.y2);
        } else if (this.type === 'ellipse') {
            //BORDE COLOR Y OPACIDAD
            p.stroke(this.border_r, this.border_g, this.border_b, this.border_a);
            //BORDE GROSOR
            p.strokeWeight(this.thickness);
            //RELLENO COLOR Y OPACIDAD
            p.fill(this.fill_r, this.fill_g, this.fill_b, this.fill_a);
            //DIBUJAR ELIPSE
            p.ellipse(this.x+(this.w/2), this.y+(this.h/2), this.w, this.h);
        } else if(this.type === 'text') {
            //WIDTH AND HEIGHT
            this.w = p.textWidth(this.text);
            this.h = p.textAscent() + p.textDescent();
            //GROSOR
            p.strokeWeight(this.thickness);
            //BORDE COLOR Y OPACIDAD
            p.stroke(this.border_r, this.border_g, this.border_b, this.border_a);
            //RELLENO COLOR Y OPACIDAD
            p.fill(this.fill_r, this.fill_g, this.fill_b, this.fill_a);
            //TAMAÑO DE LETRA
            p.textSize(this.size);
            //DIBUJAR TEXTO
            p.text(this.text, this.x, this.y);
        } else {
            console.log('No se pudo dibujar la figura.');
        }
    }

    static generarID() {
        return Math.floor(Math.random() * (9999999 - 1000000 + 1) + 1000000)
    }

    cambiarColorPredeterminado(r, g, b, a, option) {
        if(option==='fill') {
            this.fill_r = r;
            this.fill_g = g;
            this.fill_b = b;
            this.fill_a = a;
        } else if(option==='border') {
            this.border_r = r;
            this.border_g = g;
            this.border_b = b;
            this.border_a = a;
        } 
    }

    updateLinea(x1,y1,x2,y2) {
        this.x1 = x1;
        this.y1 = y1;
        this.x2 = x2;
        this.y2 = y2;
    }
    updateRelleno(r,g,b,a) {
        this.fill_r = r;
        this.fill_g = g;
        this.fill_b = b;
        this.fill_a = a;
    }
    updateBorde(r,g,b,a) {
        this.border_r = r;
        this.border_g = g;
        this.border_b = b;
        this.border_a = a;
    }
    updateGrosor(thickness) {
        this.thickness = thickness;
    }
    updateMedidas(x,y,w,h) {
        this.x = x;
        this.y = y;
        this.w = w;
        this.h = h;
    }
    updateTexto(size,text) {
        this.size = size;
        this.text = text;
    }

}
