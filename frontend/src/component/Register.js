import React, { useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

export default function Register() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');

    const handleSubmit = async (event) => {
        event.preventDefault();

        const formData = {
            name: name,
            email: email,
            password: password,
            password_confirmation: passwordConfirmation
        };
        // var form_data = new FormData();

        // for (let key in formData) {
        //     form_data.append(key, formData[key]);
        // }

        try {
            const response = await axios.post('http://127.0.0.1:8000/api/register', formData);
            console.log(response.data);
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <div className="card" style={{ display: 'flex', justifyContent: 'center', alignItems: 'left', height: '70vh'  }}>
<div>
            <form  onSubmit={handleSubmit}>
                
                <div className="mb-3 row">
                    <label htmlFor="email" className="col-sm-2 col-form-label">Email</label>
                    <div className="col-sm-10">
                        <input type="text" className="form-control" name="email" value={email} onChange={(e) => setEmail(e.target.value)} />
                    </div>
                </div>
                <div className="mb-3 row">
                    <label htmlFor="name" className="col-sm-2 col-form-label">Name</label>
                    <div className="col-sm-10">
                        <input type="text" className="form-control" name="name" value={name} onChange={(e) => setName(e.target.value)} />
                    </div>
                </div>
                <div className="mb-3 row">
                    <label htmlFor="password" className="col-sm-2 col-form-label">Password</label>
                    <div className="col-sm-10">
                        <input type="password" className="form-control" name="password" value={password} onChange={(e) => setPassword(e.target.value)} />
                    </div>
                </div>
                <div className="mb-3 row">
                    <label htmlFor="passwordConfirmation" className="col-sm-2 col-form-label">Confirm Password</label>
                    <div className="col-sm-10">
                        <input type="password" className="form-control" name="passwordConfirmation" value={passwordConfirmation} onChange={(e) => setPasswordConfirmation(e.target.value)} />
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div className="col-auto">
                    <button type="submit" className="btn btn-primary mb-3">Register</button>
                </div>
            </form>
        </div>
        </div>
    );
}
