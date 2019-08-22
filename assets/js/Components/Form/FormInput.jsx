import React, {Component} from 'react';

class FormInput extends Component {
    render() {
        return (
            <div className="form-group row">
                <label className="control-label col-sm-2" htmlFor={this.props.inputName}>{this.props.name}:</label>
                <div className="col-sm-4">
                    <input defaultValue={this.props.value} onChange={this.props.onChangeEvent} type="text" className="form-control" name={this.props.inputName} placeholder={this.props.placeholder ? this.props.placeholder : this.props.name} />

                    <span className="input-error">{this.props.error}</span>
                </div>
            </div>
        );
    }
}

export default FormInput;