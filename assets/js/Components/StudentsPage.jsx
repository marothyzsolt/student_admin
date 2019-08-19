import React, {Component} from 'react';

import SearchBox from './SearchBox'
import CheckBox from './CheckBox'
import UserTable from './UserTable'

class MainPage extends Component {
    render () {
        return (

            <section className="main">
                <div className="container-fluid row">
                    <div className="col-md-10 offset-1 base row">
                        <div className="col-md-3 side-left">
                            <div className="search">
                                <div className="title">Search for name</div>
                                <SearchBox/>
                            </div>
                            <hr />
                            <div className="filter">
                                <div className="title">Filters for study groups</div>
                                <CheckBox name="Test 1"/>
                                <CheckBox name="Test 2"/>
                            </div>
                        </div>
                        <div className="col-md-9 side-right">
                            <div className="title">
                                <i className="fa fa-user-o" />
                                <span className="student-num">{this.props.students_all} Students</span>
                                <button className="btn btn-custom icon-edit">New</button>
                            </div>
                            <hr />
                            <div className="main-content">
                                <div className="table-responsive">
                                    <UserTable />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default MainPage;