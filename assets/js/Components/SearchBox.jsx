import React, {Component} from 'react';

class SearchBox extends Component {
    render () {
        return (

            <div className="input-group">
                <div className="input-group-prepend">
                    <span className="input-group-text"><i className="fa fa-search" /></span>
                </div>
                <input type="text" className="form-control" name={this.props.name} />
            </div>
        );
    }
}

export default SearchBox;