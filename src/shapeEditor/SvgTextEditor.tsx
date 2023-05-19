import React from 'react';
import NumberEditor from '../components/valueEditor/numberEditor';
import { useDispatch } from 'react-redux';
import { formatActiveShape } from '../actions/pages/pages.actions';
import BaseShapeEditor, { EditorProps } from './baseShapeEditor';
import { TEXT_SHAPE } from '../shapes/text';
import TextEditor from '../components/valueEditor/textEditor';
import OptionEditor from '../components/valueEditor/optionEditor';
import { availableFonts } from '../utils/constant';

const SvgTEXTEditor: React.FC<EditorProps> = function ({ shape }) {
    const dispatch = useDispatch();
    const s = shape as TEXT_SHAPE;
    return (
        <>
            <div className='EditorCaegoryContainer'>
                <div className='editorCategory'>Contenido</div>
                <TextEditor
                    label='Texto'
                    value={s.text}
                    onChange={val => {
                        dispatch(formatActiveShape({ id:s.id, properties: { text: val as string } }))
                    }}
                    fullWidth
                />
            </div>
            <div className='EditorCaegoryContainer'>
                <div className='editorCategory'>Fuente</div>
                <NumberEditor
                    label='Tamaño'
                    value={s.fontSize}
                    onChange={val => {
                        val >= 10 && dispatch(formatActiveShape({ id:s.id, properties: { fontSize: val } }))
                    }}
                    step={10}
                />
                <OptionEditor
                    label='Estilo'
                    value={s.fontStyle}
                    onChange={val => {
                        dispatch(formatActiveShape({ id:s.id, properties: { fontStyle: val } }))
                    }}
                    options={['normal', 'italic']}
                />
            </div>
            <div className='EditorCaegoryContainer'>
                <div className='editorCategory'>Coordenadas</div>
                <NumberEditor
                    value={s.x}
                    label='X'
                    onChange={val => {
                        val > 0 && dispatch(formatActiveShape({ id: s.id, properties: { x: val } }));
                    }}
                    step={5}
                />
                <NumberEditor
                    value={s.y}
                    label='Y'
                    onChange={val => {
                        val > 0 && dispatch(formatActiveShape({ id: s.id, properties: { y: val } }));
                    }}
                    step={5}
                />
            </div>
        </>
    );
}

export default BaseShapeEditor(SvgTEXTEditor);