import React from 'react';
import {render} from 'react-dom';
import Header from "./Components/Header";
import PageSwitcher from "./Components/PageSwitcher";
import MainPage from "./Components/MainPage";

class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            stats: {
                students_all: 0,
                groups: 0
            }
        };
    }

    render () {
        return (
            <div>
                <Header />
                <PageSwitcher students_all={this.state.stats.students_all} />
                <MainPage students_all={this.state.stats.students_all} />
            </div>
        );
    }
}

render(<App/>, document.getElementById('root'));