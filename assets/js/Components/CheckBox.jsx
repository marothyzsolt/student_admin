import React, {Component} from 'react';

class CheckBox extends Component {

    constructor(props) {
        super(props);

        this.state = {
            checked: props.checked || false
        };

        this.checkboxHandler = this.checkboxHandler.bind(this);
    }

    checkboxHandler(e) {
        this.setState({
            checked: e.target.checked
        });
    }

    componentWillReceiveProps(props) {
        if(props.checked !== undefined) {
            this.setState({
                checked: props.checked
            })
        }
    }

    render() {
        return (
            <div className="checkbox" onChange={this.props.onClickHandler}>
                <label>
                    <input type="checkbox" checked={ this.state.checked } onChange={ this.checkboxHandler }  />
                    <span className="cr"><i className="cr-icon fa fa-check" /></span>
                    {this.props.name}
                </label>
            </div>
        );
    }
}

export default CheckBox;