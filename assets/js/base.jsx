import React from 'react';
import {render} from 'react-dom';
import Header from "./Components/Header";
import PageSwitcher from "./Components/PageSwitcher";
import MainPage from "./Components/MainPage";

import {BrowserRouter, Link, Route, Router, Switch} from 'react-router-dom'
import StudentsPage from "./Components/StudentsPage";
import StudyGroupsPage from "./Components/StudyGroupsPage";

const renderMergedProps = (component, ...rest) => {
    const finalProps = Object.assign({}, ...rest);
    return (
        React.createElement(component, finalProps)
    );
}

const PropsRoute = ({ component, ...rest }) => {
    return (
        <Route {...rest} render={routeProps => {
            return renderMergedProps(component, routeProps, rest);
        }}/>
    );
}

class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            stats: {
                students_total: 0,
                groups_total: 0,
                students_in_groups: 0
            }
        };
    }

    componentDidMount() {
        fetch('/stats')
            .then(response => response.json())
            .then(data => {
                this.setState({
                    stats: {
                        students_total: data.students_total,
                        groups_total: data.groups_total,
                        students_in_groups: data.students_in_groups
                    }
                });
            });
    }

    render () {
        return (
            <BrowserRouter>
                <div>
                    <Header />
                    <PageSwitcher stats={this.state.stats} />

                    <PropsRoute exact path="/" component={MainPage}/>
                    <PropsRoute path="/students" component={StudentsPage} stats={this.state.stats}/>
                    <PropsRoute path="/groups" component={StudyGroupsPage}/>
                </div>
            </BrowserRouter>
        );
    }
}

render(<App/>, document.getElementById('root'));