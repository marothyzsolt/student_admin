import React, {Component} from 'react';
import FormInput from '../Form/FormInput';
import FormSelect from '../Form/FormSelect';
import CheckBox from "../CheckBox";
import { Redirect, NavLink } from 'react-router'

import eventsService from '../../services/events';
import {promised} from "q";

class StudentBase extends Component {

    constructor(props, state) {

        super(props);

        this.state = {
            ...state,
            redirect: false,
            message: '',
            groups: [],
            name: null,
            birth_place: null,
            birth_date: null,
            email: null,
            buttonStatus: false,
            errors: {
                name: '',
                birth_place: '',
                birth_date: '',
                email: ''
            }
        };

        this.handleSubmit = this.handleSubmit.bind(this);
        this.redirectStudent = this.redirectStudent.bind(this);
        this.handleCheckbox = this.handleCheckbox.bind(this);
    }

    handleChange = (event) => {
        event.preventDefault();
        const { name, value } = event.target;
        var errors = this.state.errors;
        var dateReg = /^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/;
        var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        var buttonStatus = true;
        switch (name) {
            case 'name':
                errors.name =
                    value.length < 5
                        ? 'Name must be 5 characters long!'
                        : '';
                break;
            case 'birth_date':
                errors.birth_date =
                    dateReg.test(value)
                        ? ''
                        : 'Date is not valid!';
                break;
            case 'birth_place':
                errors.birth_place =
                    value.length < 2
                        ? 'Birth place must be 2 characters long!'
                        : '';
                break;
            case 'email':
                errors.email =
                    emailReg.test(value)
                        ? ''
                        : 'E-mail is not valid!';
                break;
            default:
                break;
        }

        for(var cError in errors) {
            if(errors[cError].length > 0) buttonStatus = false;
        }

        this.setState({
            buttonStatus: buttonStatus
        });

        this.setState({errors, [name]: value});
    };

    handleSubmit = (event) => {
        event.preventDefault();
        const data = new FormData(event.target);
        fetch(this.state.saveLink, {
            method: 'POST',
            body: data,
        })
            .then(response => response.json())
            .then(data => {
                if(data.errors.length > 0)
                {
                    this.setState({
                       message: data.errors.join(', ')
                    });
                } else {
                    eventsService.triggerEvent('stat');
                    this.setState({message: '', redirect: true});
                }
            });

    };


    componentWillMount() {
        fetch('/groups/list/simple')
            .then(response => response.json())
            .then(data => {
                this.setState({
                    groups: data.data,
                });
            });
    }

    redirectStudent(input) {
        this.setState({redirect:"/students"})
    }

    handleCheckbox() {
        var buttonStatus = true;

        for(var cError in this.state.errors) {
            if(this.state.errors[cError].length > 0) buttonStatus = false;
        }
        new Promise(() => {
            this.setState({
                buttonStatus: buttonStatus
            });
        })
    }

    render() {
        if(!this.state.renderable)
        {
            return <div></div>
        }

        const {errors, redirect} = this.state;

        if (redirect) {
            return <Redirect to='/students'/>;
        }

        return (
            <section className="main">
                <div className="container-fluid row">
                    <div className="col-md-10 offset-1 base row">
                        <div className="col-md-11 side-right">
                            <div className="title">
                                <i className="fa fa-user-o" />
                                <span className="student-num">Create new user</span>
                            </div>
                            <hr />
                            <div className="main-content">
                                {this.state.message.length > 0 &&
                                    <div className="error-box alert alert-danger">{this.state.message}</div>
                                }

                                <form className="form-horizontal" onSubmit={this.handleSubmit}>
                                    <FormInput value={this.state.values.name} error={errors.name} onChangeEvent={this.handleChange} noValidate inputName="name" name="Student Name" />
                                    <FormInput value={this.state.values.birth_date} error={errors.birth_date} onChangeEvent={this.handleChange} noValidate inputName="birth_date" name="Date of Birth" placeholder="0000-00-00" />
                                    <FormInput value={this.state.values.town.name} error={errors.birth_place} onChangeEvent={this.handleChange} noValidate inputName="birth_place" name="Place of Birth" />
                                    <FormInput value={this.state.values.email} error={errors.email} onChangeEvent={this.handleChange} noValidate inputName="email" name="E-mail" />

                                    <FormSelect onChangeEvent={this.handleChange} noValidate inputName="sex" name="Sex" value={this.state.values.sex?0:1}>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                    </FormSelect>

                                    <div className="row">
                                        {this.state.groups.map((group) => <div key={group.id} className="col-md-3"><CheckBox checkboxHandler={this.handleCheckbox} checked={this.state.values.groups.some((e) => e.id===group.id)} inputName="group[]" inputValue={group.id} name={group.name} /></div>)}
                                    </div>

                                    <div className="form-group">
                                        <div className="col-sm-offset-2 col-sm-10">
                                            <button type="submit" className="btn btn-danger m-2" onClick={this.redirectStudent}>Cancel</button>
                                            <button disabled={!this.state.buttonStatus} type="submit" className="btn btn-info m-2">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

export default StudentBase;