import React, {Component} from 'react';
import CheckBox from "./CheckBox";
import UserTableRow from "./UserTableRow";

class UserTable extends Component {

    constructor(props) {
        super(props);

        this.state = {
            students: [
                {
                    id: 1,
                    name: 'John Doe Smith',
                    sex: 'Male',
                    groups: 'Biologists, Typography',
                    birth_place: 'Budapest',
                    birth_date: '1999.05.21',
                    img: 'http://lorempixel.com/100/100/',
                }
            ],
            checkedList: [],
            allChecked: false
        };

        this.selectAll = this.selectAll.bind(this);
    }

    selectAll() {
        this.setState({allChecked: !this.state.allChecked});
    };


    render() {
        return (
            <table className="table table-rowing">
                <thead>
                    <tr>
                        <th> <CheckBox onClickHandler={this.selectAll}/> </th>
                        <th />
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Place and Date of Birth</th>
                        <th>Groups</th>
                    </tr>
                </thead>
                <tbody>
                    {this.state.students.map((student) => <UserTableRow checked={this.state.allChecked} student={student} key={student.id}/>)}
                </tbody>
            </table>
        );
    }
}

export default UserTable;