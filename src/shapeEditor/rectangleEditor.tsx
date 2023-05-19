import React from 'react';
import NumberEditor from '../components/valueEditor/numberEditor';
import { useDispatch } from 'react-redux';
import { formatActiveShape } from '../actions/pages/pages.actions';
import BaseShapeEditor, { EditorProps } from './baseShapeEditor';
import { RECTANGLE_SHAPE } from '../shapes/rectangle';

const RectangleEditor: React.FC<EditorProps> = function ({ shape }) {
    const dispatch = useDispatch();
    const s = shape as RECTANGLE_SHAPE
    return (
        <>
            <div className='EditorCaegoryContainer'>
                <div className='editorCategory'>Dimensiones</div>
                <NumberEditor
                    value={s.height}
                    label='Alto'
                    onChange={val => {
                        val > 0 && dispatch(formatActiveShape({ id: s.id, properties: { height: val } }));
                    }}
                    step={10}
                />
                <NumberEditor
                    value={s.width}
                    label='Ancho'
                    onChange={val => {
                        val > 0 && dispatch(formatActiveShape({ id: s.id, properties: { width: val } }));
                    }}
                    step={10}
                />
            </div>
            <div className='EditorCaegoryContainer'>
                <div className='editorCategory'>Radius-corner</div>
                <NumberEditor
                    value={s.rx}
                    label='rX'
                    onChange={val => {
                        val > 0 && dispatch(formatActiveShape({ id: s.id, properties: { rx: val } }));
                    }}
                    step={5}
                />
                <NumberEditor
                    value={s.ry}
                    label='rY'
                    onChange={val => {
                        val > 0 && dispatch(formatActiveShape({ id: s.id, properties: { ry: val } }));
                    }}
                    step={5}
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

export default BaseShapeEditor(RectangleEditor);