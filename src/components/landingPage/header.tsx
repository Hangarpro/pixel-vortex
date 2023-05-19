import React, { useRef, useEffect, useState } from 'react';
import Styled, { css } from 'styled-components';
import { THEME } from '../../theme/theme';
import Button from '../button.component';
import { useDispatch } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import { createNewFile } from '../../actions/pages/pages.actions';
import { PAGES } from '../../actions/pages/pages.interface';
import generateId from '../../utils/idGenerator';
import { auth } from "../../firebase";
import { onAuthStateChanged, signOut } from "firebase/auth";

const Header: React.FC = function () {
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const fileInputRef = useRef<HTMLInputElement>(null);

    const [authUser, setAuthUser] = useState(null);
    var displayName = null;

    useEffect(() => {
        const listen = onAuthStateChanged(auth, (user) => {
            if (user !== null) {
                displayName = auth.currentUser?.displayName;
            } else {
                navigate('/login');
            }
        })
    });

    const userSignOut = () => {
        signOut(auth).then(() => {
            navigate('/');
        });
    }

    const createNewFileHandler = () => {
        dispatch(createNewFile());
        navigate('/editor');
    }
    
    return (
        <StyledHeader>
            <div className='logo'>
                Pixel Vortex
            </div>
            <div className='displayName'>
                Hola { auth.currentUser?.displayName }
            </div>
            <nav>
                <Button title='Crear un nuevo proyecto' onClick={createNewFileHandler} />
                <Button title ='Cerrar sesión' onClick={userSignOut} />
            </nav>
        </StyledHeader>
    );
}

const StyledHeader = Styled.header`
    ${props => {
        const theme = props.theme as THEME;
        return css`
                height:10%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding:0 ${theme.spacing(4)}px;
                position:sticky;
                top:0;
                left:0;
                background-color: white;
                box-shadow:0 1px 2px rgba(0,0,0,.09);
                &>.logo{
                    font-family: 'Dancing Script', cursive;
                    font-size: 40px;
                }
                &>nav{
                    display: flex;
                    align-items: center;
                    &>button:first-child{
                        margin-right:${theme.spacing(2)}px;
                    }
                    &>button:nth-child(2){
                        background-color:#333;
                        color:white;
                        border-radius: 8px;
                        transform:scale(1.1)
                    }
                }
            `;
    }
    }
`;

export default Header;