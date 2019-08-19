import React, {Component} from 'react';

import NavLink from './NavLink'

class PageSwitcher extends Component {


    constructor(props) {
        super(props);
    }


    render () {
        return (
            <section className="page-switcher">
                <div className="container-fluid row">
                    <div className="col-md-11 offset-1">
                        <div className="row box-group">
                            <NavLink to="/students">
                                <h5>Students</h5>
                                <small>{this.props.stats.students_total} student registered</small>
                            </NavLink>
                            <NavLink to="groups">
                                <h5>Study Groups</h5>
                                <small>{this.props.stats.groups_total} study groups with {this.props.stats.students_in_groups} students</small>
                            </NavLink>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default PageSwitcher;