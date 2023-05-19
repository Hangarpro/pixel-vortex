import React, { useRef } from 'react';
import Styled, { css } from 'styled-components';
import { THEME } from '../../theme/theme';
import { useNavigate } from 'react-router-dom';

const Header: React.FC = function () {
    const navigate = useNavigate();
    const fileInputRef = useRef<HTMLInputElement>(null);

    const returnHome = () => {
        navigate('/');
    }

    return (
        <StyledHeader>
            <div className='logo'>
                <a onClick={returnHome} href='#' style={{textDecoration: 'none', color: 'white'}}>Pixel Vortex</a>
            </div>
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
                background-color: rgba(32, 36, 44, 1);
                box-shadow:0 1px 2px rgba(0,0,0,.09);
                &>.logo{
                    color: white;
                    font-family: 'Dancing Script', cursive;
                    font-size: 40px;
                }
            `;
    }
    }
`;

export default Header;