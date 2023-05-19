// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyD9AoroRZeM4L_i-hfVfCPWu_3ZmMoqzc4",
  authDomain: "pixel-vortex.firebaseapp.com",
  projectId: "pixel-vortex",
  storageBucket: "pixel-vortex.appspot.com",
  messagingSenderId: "289699013786",
  appId: "1:289699013786:web:98113aadf8a127abd7ab23"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Authentication and get a reference to the service
export const auth = getAuth(app);
