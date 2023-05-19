export function mensajeError(authCode: any) {
    switch (authCode) {
      case "auth/invalid-password":
        return "La contraseña es incorrecta";
  
      case "auth/invalid-email":
        return "El correo ingresado no es válido";

      case "auth/email-already-in-use":
        return "El correo ingresado ya esta en uso";

      case "auth/weak-password":
        return "La contraseña es demasiado corta";

      case "auth/wrong-password":
        return "Contraseña incorrecta";

      case "auth/user-not-found":
        return "Usuario no existente";
  
      default:
        return authCode;
    }
}