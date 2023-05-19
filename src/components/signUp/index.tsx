import React, { useState }  from "react";
import { useDispatch } from "react-redux";
import { useNavigate } from "react-router-dom";
import { auth } from "../../firebase";
import { createUserWithEmailAndPassword, updateProfile } from "firebase/auth";
import { mensajeError } from "../../helpers"

const Content: React.FC = function () {
  const navigate = useNavigate();

  const inicioSesion = () => {
    navigate("/login");
  };

  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [pass, setPass] = useState('');
  const [pass2, setPass2] = useState('');

  const [error, setError] = useState('');

  const validarPass = () => {
    let isValid = true
    if (pass !== '' && pass2 !== ''){
      if (pass !== pass2) {
        isValid = false;
        setError('Las contraseñas no coinciden');
      }
    }
    return isValid
  }

  const registro = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError('');
    if(validarPass()) {
        createUserWithEmailAndPassword(auth, email, pass)
        .then((userCredential) => {
            const user = auth.currentUser;
            if(user !== null) {
                updateProfile(user, {
                    displayName: name
                }).then(() => {
                    navigate("/home");
                }).catch((error) => {
                    setError(mensajeError(error.code));
                });
            }
            console.log(userCredential);
        }).catch((error) => {
            setError(mensajeError(error.code));
        })
    }
    setEmail('');
    setPass('');
    setPass2('');
  }

  return (
    <div className="main-container">
      <div className="signUp-container">
        <div className="shadowbox">
          <h2 className="title">Crear Cuenta</h2>
          {error && <div style={{color: '#ff0033'}} className='auth__error'>{error}</div>}
          <form onSubmit={registro}>
            <div className="mb-3">
              <label className="form-label">Nombre de usuario</label>
              <input
                value={name}
                onChange={(e) => setName(e.target.value)}
                type="text"
                pattern="[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]"
                title="Por favor, introduzca solo carácteres alfanúmericos, puntos y guiones"
                className="form-control"
                id="inputUser"
                name="usuario"
              />
            </div>
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
            <div className="mb-3">
              <label className="form-label">Repetir contraseña</label>
              <input
                value={pass2}
                onChange={(e) => setPass2(e.target.value)}
                type="password"
                className="form-control border border-primary"
                id="inputPassword2"
                name="contrasena2"
              />
            </div>
            <div className="d-grid">
              <button className="signButton" type="submit">
                Crear Cuenta
              </button>
            </div>
          </form>
          <div className="mt-3">
            <p className="end-paragraph">
              ¿Ya tienes una cuenta?{" "}
              <a
                href="#"
                onClick={inicioSesion}
                className="text-primary fw-bold">
                Inicia sesión aquí
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Content;
