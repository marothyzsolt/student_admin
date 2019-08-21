import React, {Component} from 'react';

import SearchBox from '../SearchBox'
import CheckBox from '../CheckBox'
import StudyGroupTable from '../StudyGroupTable'

class StudyGroupsPage extends Component {

    constructor(props) {
        super(props);

        this.state = {
            subjects: []
        };

        this.selectSubject = this.selectSubject.bind(this);
        this.sendSearchSubmit = this.sendSearchSubmit.bind(this);
    }


    componentWillMount() {
        fetch('/subjects/list/simple')
            .then(response => response.json())
            .then(data => {
                var curr = (data.data).map((group) => {return {...group, selected: false}});
                this.setState({
                    subjects: curr,
                });
            });
    }

    selectSubject(subj) {
        const newSubjects = this.state.subjects.map((cSubject) => {
            if(cSubject.id === subj.id)
                return {...cSubject, selected: !cSubject.selected};
            return cSubject;
        });

        this.setState({
            groups: newSubjects
        }, () => {
            this.sendSearch(document.getElementById('searchForm'));
        });
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
                                    <div className="title">Search for groups</div>
                                    <SearchBox/>
                                </div>
                                <hr />
                                <div className="filter">
                                    <div className="title">Filters for subjects</div>
                                    {this.state.subjects.map((subject) => <CheckBox inputValue={subject.id} inputName="subject[]" name={subject.name} key={subject.id} onClickHandler={() => this.selectSubject(subject)} />)}
                                </div>
                            </form>
                        </div>
                        <div className="col-md-9 side-right">
                            <div className="title">
                                <i className="fa fa-user-o" />
                                <span className="student-num">{this.props.stats.groups_total} Groups</span>
                                <button className="btn btn-custom icon-edit">New</button>
                            </div>
                            <hr />
                            <div className="main-content">
                                <div className="table-responsive">
                                    <StudyGroupTable changedFilter={e => this.groupEvent = e}/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default StudyGroupsPage;