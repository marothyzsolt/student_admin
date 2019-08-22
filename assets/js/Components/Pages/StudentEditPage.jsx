import React, {Component} from 'react';
import Base from '../Forms/StudentBase'

class StudentEditPage extends Base {

    constructor(props) {
        super(props, {
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


    }
}

export default StudentEditPage;