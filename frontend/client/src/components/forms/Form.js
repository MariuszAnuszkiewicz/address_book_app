import React, { useState } from 'react';
import { useForm } from 'react-hook-form'; // npm install react-hook-form
import ValidateConfig from './validators/ValidateConfig';
import Validate from './validators/Validate';
import SubmitButton from '../elements/SubmitButton';
import axios from 'axios';
const express = require("express");
const cors = require("cors");
const app = express();
//use cors as middleware
app.use(cors())

axios.defaults.baseURL = process.env.REACT_APP_API_URL;
axios.defaults.headers.post['Content-Type'] ='application/json;charset=utf-8';
axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

const client = axios.create({
    baseURL: process.env.REACT_APP_API_URL,
    headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Credentials': 'true',
        'Access-Control-Allow-Methods': 'GET, POST, OPTIONS',
        'Access-Control-Allow-Headers': 'Origin, Content-Type, Accept'
    }
});

const Form = () => {
    const { register, handleSubmit, formState: { errors }} = useForm();
    const [name, setName] = useState('');
    const [surname, setSurname] = useState('');
    const [phone, setPhone] = useState('');
    const [email, setEmail] = useState('');

    const submitTrigger = () => {

        addUser(name, surname, phone, email);
    };

    const addUser = (name, surname, phone, email) => {

        client
            .post('/api/user', {
                name: name,
                surname: surname,
                phone: phone,
                email: email
            })
            .then((response) => {
                setName(response.data);
                setSurname(response.data);
                setPhone(response.data);
                setEmail(response.data);
            });
        setName('');
        setSurname('');
        setPhone('');
        setEmail('');
    };

    const errorField = Object.keys(errors).shift();
    const validParams = ValidateConfig.apply();

    return (
        <div className="form">
            <form onSubmit={handleSubmit(submitTrigger)}>
                <div className="form-control">
                    <label>Name:</label>
                    <input
                        type="text"
                        placeholder="name"
                        {...register("name", {
                            required: validParams.requireTrue,
                            minLength: validParams.min,
                            maxLength: validParams.max
                        })}
                        onChange={(e) => setName(e.target.value)}
                    />
                    {errorField === 'name' ?
                        <Validate
                            errors={errors}
                            min={validParams.min}
                            max={validParams.max}
                        /> : ''
                    }
                </div>
                <div className="form-control">
                    <label>Surname:</label>
                    <input
                        type="text"
                        placeholder="surname"
                        {...register("surname", {
                            required: validParams.requireTrue,
                            minLength: validParams.min,
                            maxLength: validParams.max
                        })}
                        onChange={(e) => setSurname(e.target.value)}
                    />
                    {errorField === 'surname' ?
                        <Validate
                            errors={errors}
                            min={validParams.min}
                            max={validParams.max}
                        /> : ''
                    }
                </div>
                <div className="form-control">
                    <label>Phone:</label>
                    <input
                        type="text"
                        placeholder="phone"
                        {...register("phone", {
                            required: validParams.requireTrue,
                        })}
                        onChange={(e) => setPhone(e.target.value)}
                    />
                    {errorField === 'phone' ?
                        <Validate
                            errors={errors}
                        /> : ''
                    }
                </div>
                <div className="form-control">
                    <label>Email:</label>
                    <input
                        type="text"
                        placeholder="email"
                        {...register("email", {
                            required: validParams.requireTrue,

                        })}
                        onChange={(e) => setEmail(e.target.value)}
                    />
                    {errorField === 'email' ?
                        <Validate
                            errors={errors}
                        /> : ''
                    }
                </div>
                <div className="btn-wrapper">
                    <SubmitButton>
                        <span><strong>Submit</strong></span>
                    </SubmitButton>
                </div>
            </form>
        </div>
    )
};

export default Form;