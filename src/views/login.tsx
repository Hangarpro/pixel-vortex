import Header from '../components/home/header';
import Content from '../components/login/index';

const home = function () {
    return (
        <body style={{background: 'rgba(32, 36, 44, 1)', overflow: 'auto'}}>
        <Header />
        <Content />
       </body>
    );
}

export default home;