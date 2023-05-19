import Header from '../components/home/header';
import Content from '../components/home/content';

const home = function () {
    return (
       <body style={{background: 'rgba(32, 36, 44, 1)'}}>
        <Header />
        <Content />
       </body>
    );
}

export default home;