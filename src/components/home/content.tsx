import React from "react";
import { useDispatch } from "react-redux";
import Styled, { css } from 'styled-components';
import { useNavigate } from "react-router-dom";
import "../../assets/style.css"

const Content: React.FC = function () {
  const navigate = useNavigate();

  const registro = () => {
    navigate('/signUp');
}

const inicioSesion = () => {
    navigate('/login');
}

  return (
      <section className="hero section">
        <div className="container">
          <div className="hero-inner">
            <div className="hero-copy">
              <h1 className="hero-title mt-0 h1">
                Crea tus diseños de forma fácil desde la web
              </h1>
              <p className="hero-paragraph p">
                Dale vida a tus ideas de manera sencilla desde Pixel Vortex,
                inicia sesión o regístrate y diseña lo que te diga tu mente.
              </p>
              <div className="hero-cta">
                <a className="button button-primary a" href="#" onClick={registro}>
                  Regístrate
                </a>
                <a className="button a" href="#" onClick={inicioSesion}>
                  Inicia sesión
                </a>
              </div>
            </div>
            <div className="hero-figure anime-element">
              <svg
                className="placeholder"
                width="500"
                height="396"
                viewBox="0 0 528 396"
              >
                <rect
                  width="528"
                  height="396"
                  style={{ fill: "transparent" }}
                />
              </svg>
              <div
                className="hero-figure-box hero-figure-box-01"
                data-rotation="45deg"
              ></div>
              <div
                className="hero-figure-box hero-figure-box-02"
                data-rotation="-45deg"
              ></div>
              <div
                className="hero-figure-box hero-figure-box-03"
                data-rotation="0deg"
              ></div>
              <div
                className="hero-figure-box hero-figure-box-04"
                data-rotation="-135deg"
              ></div>
              <div className="hero-figure-box hero-figure-box-05"></div>
              <div className="hero-figure-box hero-figure-box-06"></div>
              <div className="hero-figure-box hero-figure-box-07"></div>
              <div
                className="hero-figure-box hero-figure-box-08"
                data-rotation="-22deg"
              ></div>
              <div
                className="hero-figure-box hero-figure-box-09"
                data-rotation="-52deg"
              ></div>
              <div
                className="hero-figure-box hero-figure-box-10"
                data-rotation="-50deg"
              ></div>
            </div>
          </div>
        </div>
      </section>
  );
};

export default Content;
