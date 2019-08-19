import React from 'react';
import {render} from 'react-dom';
import Header from "./Components/Header";
import PageSwitcher from "./Components/PageSwitcher";
import MainPage from "./Components/MainPage";

import {BrowserRouter, Link, Route, Router, Switch} from 'react-router-dom'
import StudentsPage from "./Components/StudentsPage";
import StudyGroupsPage from "./Components/StudyGroupsPage";

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
            <BrowserRouter>
                <div>
                    <Header />
                    <PageSwitcher students_all={this.state.stats.students_all} />
                    <Route exact path="/" component={MainPage}/>
                    <Route path="/students" component={StudentsPage}/>
                    <Route path="/groups" component={StudyGroupsPage}/>
                </div>
            </BrowserRouter>
        );
    }
}

render(<App/>, document.getElementById('root'));