import React, {Component} from 'react';
import FormInput from '../Form/FormInput';
import FormSelect from '../Form/FormSelect';
import CheckBox from "../CheckBox";
import { Redirect } from 'react-router'
import Base from '../Forms/StudentBase'

import eventsService from '../../services/events';

class StudentNewPage extends Base {

    constructor(props) {

        super(props);

        super(props, {
            renderable: true,
            title: 'Create new student',
            saveLink: '/api/students/create/' + props.match.params.userId,
            values: {
                name: '',
                email: '',
                town: {name: ''},
                birth_date: '',
                groups: [],
            }
        });

        this.handleSubmit = this.handleSubmit.bind(this);
    }
}

export default StudentNewPage;