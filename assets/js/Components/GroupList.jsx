import React, {Component} from "react";
import GroupListMore from "./GroupListMore"; GroupListMore;

class GroupList extends Component {

    render() {
        var groups = '';
        if(this.props.groups !== null) {
            [...this.props.groups].forEach((group, index) => {
                if(index === 0)
                    groups += group.name;
                else if(index < 2) {
                    groups += ', '+group.name;
                }
            });
        }

        return (
            <span>{groups} <GroupListMore groups={this.props.groups}/></span>
        );
    }
}

export default GroupList;