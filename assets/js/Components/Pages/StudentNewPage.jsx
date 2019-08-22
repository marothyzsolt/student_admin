import React, {Component} from 'react';
import Base from '../Forms/StudentBase'

class StudentNewPage extends Base {

    constructor(props) {

        super(props);

        super(props, {
            renderable: true,
            title: 'Create new student',
            saveLink: '/api/students/create',
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