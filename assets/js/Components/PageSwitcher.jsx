import React, {Component} from 'react';

class PageSwitcher extends Component {


    constructor(props) {
        super(props);
        this.state = {
            stats: {
                students_all: this.props.students_all,
                students: 0,
                groups: 0
            }
        };
    }


    render () {
        return (

            <section className="page-switcher">
                <div className="container-fluid row">
                    <div className="col-md-11 offset-1">
                        <div className="row box-group">
                            <div className="col-md-4 box active">
                                <h5>Students</h5>
                                <small>{this.state.stats.students_all} student registered</small>
                            </div>
                            <div className="col-md-4 box">
                                <h5>Study Groups</h5>
                                <small>{this.state.stats.groups} study groups with {this.state.stats.students} students</small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default PageSwitcher;