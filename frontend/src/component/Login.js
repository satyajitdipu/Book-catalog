import React, { useState } from 'react';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';

export default function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = async (event) => {
    event.preventDefault();

    const formData = {
      email: email,
      password: password
    };

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/login', formData);
      console.log(response.data);
      Cookies.set('token', response.data.token);
      localStorage.setItem('token', response.data.token);
      navigate('/');
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div >
       <div className="card" style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '50vh'  }}>
      <form onSubmit={handleSubmit}>
        <div className="mb-3 row">
          <label htmlFor="email" className="col-sm-2 col-form-label">Email</label>
          <div className="col-sm-10">
            <input type="text" className="form-control" name="email" value={email} onChange={(e) => setEmail(e.target.value)} />
          </div>
        </div>
        <div className="mb-3 row">
          <label htmlFor="password" className="col-sm-2 col-form-label">Password</label>
          <div className="col-sm-10">
            <input type="password" className="form-control" name="password" value={password} onChange={(e) => setPassword(e.target.value)} />
          </div>
        </div>
        <div class="d-grid gap-2 d-md-block">
  <button class="btn btn-primary" type="submit">Login</button>
  <button className="btn btn-outline-success" type="button"><Link to="/register" >
            Register
          </Link></button>
</div>
      </form>
      </div>
    </div>
  );
}
