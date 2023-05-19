import React, { Suspense, lazy } from 'react';
import { Routes, Route } from 'react-router-dom';
import Home from '../views/home';
import Login from '../views/login';
import SignUp from '../views/signUp';
import LandingPage from '../views/landingPage';
import UiEditor from '../views/uiEditor';

const Router: React.FC<{}> = function () {
    return (
        <Routes>
            <Route path='/' element={<Home />} />
            <Route path='/login' element={<Login />} />
            <Route path='/signUp' element={<SignUp />} />
            <Route path='/home' element={<LandingPage />} />
            <Route path='/editor' element={<UiEditor />} />
        </Routes>
    );
}

export default Router;