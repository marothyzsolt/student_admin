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
                        <div className="col-md-11 side-right">
                            <div className="title">
                                <i className="fa fa-user-o" />
                                <span className="student-num">Main Page</span>
                            </div>
                            <hr />
                            <div className="main-content">
                                Main Page
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default MainPage;