import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';

class NavLink extends React.Component {

    render() {
        var path = (window.location.pathname);
        var pathTo = (this.props.to);
        if((window.location.pathname)[0] === '/') {
            path = path.substr(1);
        }
        if((this.props.to)[0] === '/') {
            pathTo = (this.props.to).substr(1);
        }
        var isActive = path === pathTo;
        var className = isActive ? 'col-md-4 box active' : 'col-md-4 box';

        return(
            <Link className={className} {...this.props}>
                {this.props.children}
            </Link>
        );
    }
}

NavLink.contextTypes = {
    router: PropTypes.object
};
export default NavLink;