import React, {Component} from 'react';

import img_logo from '../../img/saf.png'
import img_user from '../../img/user.png'
import {Link} from "react-router-dom";

class Header extends Component {
    render () {
        return (

            <section className="header container-fluid">
                <div className="row">
                    <div className="offset-sm-1 col-sm-6 col-12 logo">
                        <Link to="/">
                            <img src={img_logo} alt="Logo" />
                        </Link>
                    </div>
                    <div className="col-sm-4 user">
                        <span className="name">
                            <span className="dropdown cursor-pointer">
                                <span className="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src={img_user} alt="ProfileImage" className="rounded-pill" width="40px" />
                                    Adam
                                </span>
                                <div className="dropdown-menu dropdown-menu-right">
                                    <a className="dropdown-item" href="/logout">Log out</a>
                                </div>
                            </span>
                        </span>
                    </div>
                </div>
            </section>
        );
    }
}

export default Header;