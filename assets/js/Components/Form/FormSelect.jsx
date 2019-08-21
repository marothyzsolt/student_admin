import React, {Component} from 'react';

class FormSelect extends Component {
    render() {
        return (
            <div className="form-group row">
                <label className="control-label col-sm-2" htmlFor={this.props.inputName}>{this.props.name}:</label>
                <div className="col-sm-4">
                    <select name={this.props.inputName} onChange={this.props.onChangeEvent} className="form-control">
                        {this.props.children}
                    </select>
                    <span className="input-error">{this.props.error}</span>
                </div>
            </div>
        );
    }
}

export default FormSelect;