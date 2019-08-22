import React, {Component} from 'react';
import Base from '../Forms/StudentBase'

class StudentEditPage extends Base {

    constructor(props) {
        super(props, {
            title: 'Edit student #' + props.match.params.userId,
            renderable: false,
            saveLink: '/api/students/edit/' + props.match.params.userId,
            values: {
                name: '',
                email: '',
                town: {name: ''},
                birth_date: '',
                groups: [],
            }
        });

        fetch('/students/'+this.props.match.params.userId)
            .then(response => response.json())
            .then(data => {
                this.setState({
                    values: data,
                    renderable: true
                });
            });

        this.deleteStudent = this.deleteStudent.bind(this);
    }

    deleteStudent() {
        fetch('/api/students/delete/'+this.props.match.params.userId, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                this.setState({
                    redirect: true,
                    renderable: true
                });
            });
    }
}

export default StudentEditPage;