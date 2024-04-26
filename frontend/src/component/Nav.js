import { useState } from "react";
import { BrowserRouter, Route, Routes, Link } from "react-router-dom";
import $ from "jquery";
import axios from 'axios';

export default function Nav() {
  const handleLogout = () => {
    localStorage.removeItem('token');
    // Additional logout logic
    axios
      .post('http://127.0.0.1:8000/api/logout')
      .then(function(response) {
        console.log(response.data);
      })
      .catch(function(error) {
        console.log(error);
      });
  };

  const token = localStorage.getItem('token');

  const handleLogin = () => {
    // Redirect to login page
    // You can replace '/login' with the actual login page URL
    window.location.href = 'http://localhost:3000';
  };

  return (
    <nav className="navbar bg-body-tertiary">
      <div className="container-fluid">
        <a className="navbar-brand">Navbar</a>
        <form className="d-flex" role="search">
          {token ? (
            <button className="btn btn-outline-success" type="submit" onClick={handleLogout}>
              Logout
            </button>
          ) : (
            <Link to="/login" className="btn btn-outline-success">
              Login
            </Link>
          )}
        </form>
      </div>
    </nav>
  );
}
