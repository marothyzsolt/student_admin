import React, {Component} from 'react';
import CheckBox from './CheckBox'
import {Link} from 'react-router-dom'

class StudyGroupTableRow extends Component {

    constructor(props) {
        super(props);
    }


    render() {
        return (
            <tr>
                <td>
                    <CheckBox checked={this.props.checked}/>
                </td>
                <td className="edit_link"><Link to="/groups/edit"> {this.props.group.name}</Link></td>
                <td>{this.props.group.leader ? this.props.group.leader.name : '-'}</td>
                <td>{this.props.group.subject ? this.props.group.subject.name : '-'}</td>
                <td><b>{this.props.group.students_total}</b> student{this.props.group.students_total>1?'s':''}</td>
            </tr>
        );
    }
}

export default StudyGroupTableRow;