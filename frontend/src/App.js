import { useState } from "react";
import {BrowserRouter,Route,Routes,Link} from "react-router-dom";
import "../node_modules/bootstrap/js/dist/button";
import $ from "jquery";
import "./App.css";
import Home from "./component/Home";
import ListBook from "./component/ListBook";
import EditBook from "./component/EditBook";
import ListAuthor from "./component/ListAuthor";
import AuthorInput from "./component/AuthorInput";
import EditAuthor from "./component/EditAuthor";
import Register from "./component/Register";
import Login from "./component/Login";
import axios from 'axios';
import Nav from "./component/Nav";


function App() {
	
	
	  return (
		<div className="App">
			<BrowserRouter>
			<Nav/>
			
<Routes>
<Route index element={<ListBook/>}/>
							<Route path="book/create" element={<Home/>}/>
							<Route path="book/edit/:id" element={<EditBook/>}/>
							<Route path="listauthor" element={<ListAuthor/>}/>
							<Route path="author/create" element={<AuthorInput/>}/>
							<Route path="listauthor/author/edit/:id" element={<EditAuthor/>}/>
							<Route path="register" element={<Register/>}/>
							<Route path="login" element={<Login/>}/>
							</Routes>
							
			</BrowserRouter>
		</div>
  );
}

export default App;
