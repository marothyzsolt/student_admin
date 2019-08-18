import React, {Component} from 'react';

import CheckBox from './CheckBox'

class UserTableRow extends Component {

    constructor(props) {
        super(props);
    }


    render() {
        return (
            <tr>
                <td>
                    <CheckBox checked={this.props.checked}/>
                </td>
                <td>
                    <img src={this.props.student.img} alt="" className="rounded-pill" width="30px" />
                </td>
                <td>{this.props.student.name}</td>
                <td>{this.props.student.sex}</td>
                <td>{this.props.student.birth_place}, {this.props.student.birth_date}</td>
                <td>{this.props.student.groups}</td>
            </tr>
        );
    }
}

export default UserTableRow;