import React from 'react';
import NumberEditor from '../components/valueEditor/numberEditor';
import ColorEditor from '../components/valueEditor/colorEditor';
import { useDispatch } from 'react-redux';
import { AVAILABLE_SHAPES } from '../shapes/availableShapes';
import { formatActiveShape } from '../actions/pages/pages.actions';
import styled, { css } from 'styled-components';
import { THEME } from '../theme/theme';
import OptionEditor from '../components/valueEditor/optionEditor';
import InputEditor from '../components/valueEditor/textEditor';
import CssFiltersEditor from './cssFiltersEditor';
import SvgFilterEditor from './svgFiltersEditor';

export interface EditorProps {
    shape: AVAILABLE_SHAPES;
}

const ModifiedEditor = (WRAPPED_EDITOR: React.ComponentType<EditorProps>) => {
    return function BaseShapeEditor(props: EditorProps) {
        const { shape } = props;
        const dispatch = useDispatch();

        return (
            <EditorContainer>
                <div className='EditorCaegoryContainer'>
                    <div className='editorCategory'>Nombre</div>
                    <InputEditor
                        value={shape.name}
                        label='Nombre'
                        onChange={val => {
                            val && dispatch(formatActiveShape({ id:shape.id, properties: { name: val as string } }));
                        }}
                        fullWidth
                    />
                </div>
                <div className='EditorCaegoryContainer'>
                    <div className='editorCategory'>Borde</div>
                    <NumberEditor
                        value={shape.style.strokeOpacity}
                        label='Opacidad'
                        onChange={val => {
                            val >= 0 && dispatch(formatActiveShape({ id:shape.id, style: { strokeOpacity: val } }));
                        }}
                        step={.1}
                    />
                    <NumberEditor
                        value={shape.style.strokeWidth}
                        label='Tamaño'
                        onChange={val => {
                            val >= 0 && dispatch(formatActiveShape({ id:shape.id, style: { strokeWidth: val } }));
                        }}
                        step={5}
                    />
                    <ColorEditor
                        value={shape.style.stroke}
                        label='Color'
                        onChange={val => {
                            dispatch(formatActiveShape({ id:shape.id, style: { stroke: val } }));
                        }}
                        showPalette
                    />
                </div>
                <div className='EditorCaegoryContainer'>
                    <div className='editorCategory'>Relleno</div>
                    <NumberEditor
                        value={shape.style.fillOpacity}
                        label='Opacidad'
                        onChange={val => {
                            val >= 0 && dispatch(formatActiveShape({ id:shape.id, style: { fillOpacity: val } }));
                        }}
                        step={.1}
                    />
                    <ColorEditor
                        value={shape.style.fill}
                        label='Color'
                        onChange={val => {
                            dispatch(formatActiveShape({ id:shape.id, style: { fill: val } }));
                        }}
                        showPalette
                    />
                </div>
                <WRAPPED_EDITOR shape={shape} />
            </EditorContainer>
        );
    }
}

const EditorContainer = styled.div`
    ${props => {
        const theme = props.theme as THEME;
        return css`
            flex-grow: 1;
            overflow-y: scroll;
            &>.EditorCaegoryContainer{
                border:1px solid #ccc;
                padding:${theme.spacing(1)}px ${theme.spacing(.3)}px;
                margin:${theme.spacing(1)}px ${theme.spacing(.5)}px;
                text-align: left;
                &>.editorCategory{
                    text-align: center;
                    font-weight: bold;
                    opacity:.5;
                    font-size: .8em;
                }
            }
        `;
    }}
`;

export default ModifiedEditor;

