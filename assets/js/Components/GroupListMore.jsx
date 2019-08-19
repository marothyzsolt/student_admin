import React, {Component} from 'react';

class GroupListMore extends Component {
    render() {
        if(this.props.groups !== null && this.props.groups.length > 2) {
            return (
                <span>, and <span className='more'>{this.props.groups.length-2} more</span></span>
            );
        }

        return null;
    }
}

export default GroupListMore;