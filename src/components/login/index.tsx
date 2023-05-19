import React, { useState } from "react";
import { useDispatch } from "react-redux";
import { useNavigate } from "react-router-dom";
import { auth } from "../../firebase";
import { signInWithEmailAndPassword } from "firebase/auth";
import { mensajeError } from "../../helpers"

const Content: React.FC = function () {
  const navigate = useNavigate();

  const registro = () => {
    navigate("/signUp");
  };

  const [email, setEmail] = useState('');
  const [pass, setPass] = useState('');

  const [error, setError] = useState('');

  const login = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError('');
    signInWithEmailAndPassword(auth, email, pass)
    .then((userCredential) => {
      navigate("/home");
    }).catch((error) => {
      setError(mensajeError(error.code));
    })
  }

  return (
    <div className="main-container">
      <div className="signUp-container">
        <div className="shadowbox">
          <h2 className="title">Iniciar sesión</h2>
          {error && <div style={{color: '#ff0033'}} className='auth__error'>{error}</div>}
          <form onSubmit={login}>
            <div className="mb-3">
              <label className="form-label">Correo electrónico</label>
              <input
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                type="email"
                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                title="Por favor, introduce una dirección de correo electrónico válida en el formato usuario@dominio.com"
                className="form-control border border-primary"
                id="inputEmail"
                name="correo"
              />
            </div>
            <div className="mb-3">
              <label className="form-label">Contraseña</label>
              <input
                value={pass}
                onChange={(e) => setPass(e.target.value)}
                type="password"
                className="form-control border border-primary"
                id="inputPassword"
                name="contrasena"
              />
            </div>
            <div className="d-grid">
              <button className="signButton" type="submit">
                Iniciar Sesión
              </button>
            </div>
          </form>
          <div className="mt-3">
            <p className="end-paragraph">
              ¿No tienes una cuenta?{" "}
              <a href="#" onClick={registro} className="text-primary fw-bold">
                Regístrate
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Content;
