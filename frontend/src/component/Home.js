import React, { useState } from 'react';
import axios from 'axios';
import { Link,useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';

export default function Home() {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    book_id: '',
    book_name: '',
    author: '',
    genre: '',
    price: '',
    main_img: null,
    isbn: '',
    author_id: ''
  });

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((prevState) => ({
      ...prevState,
      [name]: value
    }));
  };

  const handleImageChange = (event) => {
    const file = event.target.files[0];
    setFormData((prevState) => ({
      ...prevState,
      main_img: file
    }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    const token = Cookies.get('token');

    const formDataWithToken = new FormData();
    formDataWithToken.append('book_id', formData.book_id);
    formDataWithToken.append('book_name', formData.book_name);
    formDataWithToken.append('author', formData.author);
    formDataWithToken.append('genre', formData.genre);
    formDataWithToken.append('price', formData.price);
    formDataWithToken.append('main_img', formData.main_img);
    formDataWithToken.append('isbn', formData.isbn);
    formDataWithToken.append('author_id', formData.author_id);

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/book', formDataWithToken, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });

      console.log(response);

      setFormData({
        book_id: '',
        book_name: '',
        author: '',
        genre: '',
        price: '',
        main_img: null,
        isbn: '',
        author_id: ''
      });
    } catch (error) {
      console.error(error);
      navigate("/login");
    }
  };

  return (
    <div>
      <div className="mx-auto col-10 col-md-8 col-lg-6 bootstrap className card mt-3">
        <h3>Create Book</h3>

        <form onSubmit={handleSubmit}>
          <label className="form-label col-sm-6">Book id</label>
          <input type="text" className="form-control" name="book_id" value={formData.book_id} onChange={handleChange} />

          <label className="form-label">Book Name</label>
          <input type="text" className="form-control" name="book_name" value={formData.book_name} onChange={handleChange} />

          

          <label className="form-label">Genre</label>
          <select className="form-select" name="genre" value={formData.genre} onChange={handleChange}>
            <option value="">Select Genre</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
          </select>

          <label className="form-label">Price</label>
          <input type="text" className="form-control" name="price" value={formData.price} onChange={handleChange} />

          <label className="form-label">Main Image</label>
          <input type="file" className="form-control" name="main_img" onChange={handleImageChange} />

          <label className="form-label">ISBN no.</label>
          <input type="text" className="form-control" name="isbn" value={formData.isbn} onChange={handleChange} />

          <label className="form-label">Author Id</label>
          <input type="text" className="form-control" name="author_id" value={formData.author_id} onChange={handleChange} />

          <button className="mt-2 btn btn-success" type="submit">Save</button>
        </form>
      </div>

      <div className="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/">List Of Book</Link></button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/listauthor">List Of Author</Link></button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/book/create">Create Book</Link></button>
      </div>
    </div>
  );
}
