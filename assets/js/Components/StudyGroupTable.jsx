import React, {Component} from 'react';
import CheckBox from "./CheckBox";
import StudyGroupTableRow from "./StudyGroupTableRow";


class StudyGroupTable extends Component {

    constructor(props) {
        super(props);

        this.state = {
            groups: [],
            allChecked: false
        };

        this.selectAll = this.selectAll.bind(this);
        this.changedFilter = this.changedFilter.bind(this);
    }

    selectAll() {
        this.setState({allChecked: !this.state.allChecked});
    };

    componentWillMount() {
        var page = 1;

        fetch('/groups/list?page='+page)
            .then(response => response.json())
            .then(data => {
                this.setState({
                    groups: data.data
                });
            });
    }

    componentDidMount() {
        this.props.changedFilter(this.changedFilter);
    }

    changedFilter(data) {
        const queryString = new URLSearchParams(data).toString();
        fetch('/groups/list?'+queryString, {
            method: 'GET',
        }).then(response => response.json())
            .then(data => {
                this.setState({
                    groups: data.data
                });
            });
    }

    render() {
        return (
            <table className="table table-rowing">
                <thead>
                    <tr>
                        <th> <CheckBox onClickHandler={this.selectAll}/> </th>
                        <th>Name</th>
                        <th>Leader</th>
                        <th>Subject</th>
                        <th>Students</th>
                    </tr>
                </thead>
                <tbody>
                    {this.state.groups.map((group) => <StudyGroupTableRow checked={this.state.allChecked} group={group} key={group.id} />)}
                </tbody>
            </table>
        );
    }
}

export default StudyGroupTable;