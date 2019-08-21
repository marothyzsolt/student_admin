import React, {Component} from 'react';

import SearchBox from './SearchBox'
import CheckBox from './CheckBox'
import UserTable from './UserTable'
import UserTableRow from "./UserTableRow";
import NavLink from "./NavLink";

class MainPage extends Component {

    constructor(props) {
        super(props);

        this.state = {
            groups: []
        };

        this.selectGroup = this.selectGroup.bind(this);
        this.sendSearchSubmit = this.sendSearchSubmit.bind(this);
        this.sendSearch = this.sendSearch.bind(this);
    }

    componentWillMount() {
        fetch('/groups/list/simple')
            .then(response => response.json())
            .then(data => {
                var curr = (data.data).map((group) => {return {...group, selected: false}});
                this.setState({
                    groups: curr,
                });
            });
    }

    selectGroup(group) {
        const newGroups = this.state.groups.map((cGroup) => {
            if(cGroup.id === group.id)
                return {...cGroup, selected: !cGroup.selected};
            return cGroup;
        });

        this.setState({
            groups: newGroups
        }, () => {
            //this.groupEvent();
            this.sendSearch(document.getElementById('searchForm'));
        });
    }

    selectedGroups() {
        var selectedGroups = [];
        this.state.groups.forEach((group) => {
            if(group.selected) {
                selectedGroups.push(group);
            }
        });
        return selectedGroups;
    }

    sendSearchSubmit(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        this.groupEvent(formData);
    }

    sendSearch() {
        const formData = new FormData(document.getElementById('searchForm'));
        this.groupEvent(formData);
    }

    render () {
        return (

            <section className="main">
                <div className="container-fluid row">
                    <div className="col-md-10 offset-1 base row">
                        <div className="col-md-3 side-left">
                            <form onSubmit={this.sendSearchSubmit} id="searchForm">
                                <div className="search">
                                    <div className="title">Search for name</div>
                                    <SearchBox name="name" />
                                </div>
                                <hr />
                                <div className="filter">
                                    <div className="title">Filters for study groups</div>
                                    {this.state.groups.map((group) => <CheckBox inputValue={group.id} inputName="group[]" name={group.name} key={group.id} onClickHandler={() => this.selectGroup(group)} />)}
                                </div>
                            </form>
                        </div>
                        <div className="col-md-9 side-right">
                            <div className="title">
                                <i className="fa fa-user-o" />
                                <span className="student-num">{this.props.stats.students_total} Students</span>
                                <NavLink to="/students/create">
                                    <button className="btn btn-custom icon-edit">New</button>
                                </NavLink>
                            </div>
                            <hr />
                            <div className="main-content">
                                <div className="table-responsive">
                                    <UserTable selectedGroups={this.selectedGroups()} changedFilter={e => this.groupEvent = e}/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default MainPage;