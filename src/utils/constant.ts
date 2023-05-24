import { BsCircle, BsSquare, BsFillCursorFill } from 'react-icons/bs';
import { AiOutlineLine } from 'react-icons/ai';
import { FaSortAlphaUp } from 'react-icons/fa';

export enum SHAPE_TYPES {
    CIRCLE = 'Círculo',
    RECTANGLE = 'Rectángulo',
    ELLIPSE = 'Ellipse',
    LINE = 'Línea',
    POLYLINE = 'POLYLINE',
    POLYGON = 'POLYGON',
    PATH = 'PATH',
    TEXT = 'Texto',
    PAN = 'Cursor',
    GROUP = 'Group',
};

export enum HELPERS {
    GRID = 'Grid',
    POINTER = 'Pointer',
    SHAPE = 'SHAPE'
}

export const ToolBarOptions = {
    TOOLS: '', 
}

export const multiPointShpes = [
    SHAPE_TYPES.PATH,
    SHAPE_TYPES.POLYGON,
    SHAPE_TYPES.POLYLINE,
    SHAPE_TYPES.LINE
];

export const TOOLS = [
    {
        icon: BsCircle,
        title: SHAPE_TYPES.ELLIPSE,
        style: { transform: 'scaleX(1.5)' }
    },
    {
        icon: BsSquare,
        title: SHAPE_TYPES.RECTANGLE
    },
    {
        icon: AiOutlineLine,
        title: SHAPE_TYPES.LINE
    },
    {
        icon: FaSortAlphaUp,
        title: SHAPE_TYPES.TEXT
    },
    {
        icon: BsFillCursorFill,
        title: SHAPE_TYPES.PAN
    },
];

export const availableFonts = [
    "American Typewriter",
    "Andale Mono",
    "Arial",
    "Arial Black",
    "Arial Narrow",
    "Arial Rounded MT Bold",
    "Arial Unicode MS",
    "Avenir",
    "Avenir Next",
    "Avenir Next Condensed",
    "Baskerville",
    "Big Caslon",
    "Bodoni 72",
    "Bodoni 72 Oldstyle",
    "Bodoni 72 Smallcaps",
    "Bradley Hand",
    "Brush Script MT",
    "Chalkboard",
    "Chalkboard SE",
    "Chalkduster",
    "Charter",
    "Cochin",
    "Comic Sans MS",
    "Copperplate",
    "Courier",
    "Courier New",
    "DIN Alternate",
    "DIN Condensed",
    "Didot",
    "Futura",
    "Geneva",
    "Georgia",
    "Gill Sans",
    "Helvetica",
    "Helvetica Neue",
    "Herculanum",
    "Hoefler Text",
    "Impact",
    "Lucida Grande",
    "Luminari",
    "Marker Felt",
    "Menlo",
    "Microsoft Sans Serif",
    "Monaco",
    "Noteworthy",
    "Optima",
    "Palatino",
    "Papyrus",
    "Phosphate",
    "Rockwell",
    "Savoye LET",
    "SignPainter",
    "Skia",
    "Snell Roundhand",
    "Symbol",
    "Tahoma",
    "Times",
    "Times New Roman",
    "Trattatello",
    "Trebuchet MS",
    "Verdana",
    "Webdings",
    "Wingdings",
    "Zapfino"
];

export enum TRANSFORM_CURSOR_MAPPING {
    SCALE = 'cell',
    ROTATE = 'alias',
    DEFAULT = 'default'
}