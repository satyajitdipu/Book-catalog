import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link, useParams,useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';

export default function EditBook() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [book, setBook] = useState({
    book_id: '',
    book_name: '',
    genre: '',
    price: '',
    main_img: null,
    isbn: '',
    author_id: '',
  });

  useEffect(() => {
    axios
      .get(`http://0.0.0.0:8000/api/book/${id}`)
      .then(response => {
        const { book_id, book_name, genre, price, main_img, isbn, author_id } = response.data;
        setBook({
          book_id,
          book_name,
          genre,
          price,
          main_img,
          isbn,
          author_id,
        });
      })
      .catch(error => {
        console.log(error);
      });
  }, [id]);

  const handleChange = event => {
    const { name, value } = event.target;
    setBook(prevState => ({
      ...prevState,
      [name]: value,
    }));
  };

  const handleImageChange = event => {
    const file = event.target.files[0];
    setBook(prevState => ({
      ...prevState,
      main_img: file,
    }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
  
    const formData = new FormData();
    formData.append('book_id', book.book_id);
    formData.append('book_name', book.book_name);
    formData.append('genre', book.genre);
    formData.append('price', book.price);
    formData.append('main_img', book.main_img);
    formData.append('isbn', book.isbn);
    formData.append('author_id', book.author_id);
  
    try {
      const token = Cookies.get('token'); // Retrieve token from cookie
      const response = await axios.post(`http://127.0.0.1:8000/api/book/update/${id}`, formData, {
        headers: {
          Authorization: `Bearer ${token}` // Include token in the request headers
        }
      });
      console.log(response.data);
    } catch (error) {
      console.error(error);
      navigate("/login");
    }
  };
  
  
  return (
    <div>
      <div className="mx-auto col-10 col-md-8 col-lg-6 bootstrap className card mt-3 "style={{ width: '18rem' }}>
        <h3>Edit Book</h3>

        <form onSubmit={handleSubmit} >
          <label className="form-label col-sm-6">Book ID</label>
          <input type="text" className="form-control" name="book_id" value={book.book_id} onChange={handleChange} />

          <label className="form-label">Book Name</label>
          <input type="text" className="form-control" name="book_name" value={book.book_name} onChange={handleChange} />


          
          <label className="form-label">Genre</label>
<select className="form-select" name="genre" value={book.genre} onChange={handleChange}>
  <option value="">Select Genre</option>
  <option value="Action">Action</option>
  <option value="Adventure">Adventure</option>
  <option value="Comedy">Comedy</option>
  <option value="Drama">Drama</option>

</select>

          <label className="form-label">Price</label>
          <input type="text" className="form-control" name="price" value={book.price} onChange={handleChange} />

          <label className="form-label">Main Image</label>
          <input type="file" className="form-control" name="main_img" onChange={handleImageChange} />

          <label className="form-label">ISBN No.</label>
          <input type="text" className="form-control" name="isbn" value={book.isbn} onChange={handleChange} />

          <label className="form-label">Author ID</label>
          <input type="text" className="form-control" name="author_id" value={book.author_id} onChange={handleChange} />

          <button className="mt-2 btn btn-success" type="submit">Save</button>
        </form>
      </div>
       <div className="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/">List Of Book</Link></button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/listauthor">List Of Author</Link></button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/author/create">Create Author</Link></button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/book/create">Create Book</Link></button>
      </div>
    </div>
  );
}
