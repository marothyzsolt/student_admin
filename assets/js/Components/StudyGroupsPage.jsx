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
                                <div className="title">Search for groups</div>
                                <SearchBox/>
                            </div>
                            <hr />
                            <div className="filter">
                                <div className="title">Filters for subjects</div>
                                <CheckBox name="Test 1"/>
                                <CheckBox name="Test 2"/>
                            </div>
                        </div>
                        <div className="col-md-9 side-right">
                            <div className="title">
                                <i className="fa fa-user-o" />
                                <span className="student-num">{this.props.groups_all} Groups</span>
                                <button className="btn btn-custom icon-edit">New</button>
                            </div>
                            <hr />
                            <div className="main-content">
                                <div className="table-responsive">
                                    null table
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