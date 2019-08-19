import React, {Component} from 'react';

import CheckBox from './CheckBox'
import GroupList from './GroupList'

var dateFormat = require('dateformat');

class UserTableRow extends Component {

    constructor(props) {
        super(props);
    }


    render() {
        var birth_date = dateFormat(new Date(this.props.student.birth_date.date), "yyyy.mm.dd");

        return (
            <tr>
                <td>
                    <CheckBox checked={this.props.checked}/>
                </td>
                <td>
                    <img src={this.props.student.img} alt="" className="rounded-pill" width="30px" />
                </td>
                <td>{this.props.student.name}</td>
                <td>{this.props.student.sex?'Male':'Female'}</td>
                <td>{this.props.student.town.name}, {birth_date}</td>
                <td><GroupList groups={this.props.student.groups} /></td>
            </tr>
        );
    }
}

export default UserTableRow;