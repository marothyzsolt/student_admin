import React, {Component} from 'react';
import CheckBox from "./CheckBox";
import UserTableRow from "./UserTableRow";

class UserTable extends Component {

    constructor(props) {
        super(props);

        this.state = {
            students: [],
            checkedList: [],
            allChecked: false
        };

        this.selectAll = this.selectAll.bind(this);
    }

    selectAll() {
        this.setState({allChecked: !this.state.allChecked});
    };

    componentDidMount() {
        var page = 1;

        fetch('/students/list?page='+page)
            .then(response => response.json())
            .then(data => {
                this.setState({
                    students: data.data
                });
            });
    }

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