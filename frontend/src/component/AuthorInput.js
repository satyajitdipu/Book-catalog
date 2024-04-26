import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link,useNavigate  } from 'react-router-dom';
import Cookies from 'js-cookie';

export default function AuthorInput() {
  const navigate = useNavigate();
  const [authorId, setAuthorId] = useState('');
  const [authorName, setAuthorName] = useState('');
  const [monthlyAward, setMonthlyAward] = useState('');
  const [genre, setGenre] = useState('');
  const [gender, setGender] = useState('');
  const [mainImg, setMainImg] = useState(null);
  const [ratings, setRatings] = useState('');
  const [age, setAge] = useState('');
  const [email, setEmail] = useState('');

  useEffect(() => {
    // Retrieve token from cookie
    const token = Cookies.get('token');
    console.log(token);
    // Set the authorization header for all axios requests
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
  }, []);

  const handleSubmit = async (event) => {
    event.preventDefault();
  
    const formData = new FormData();
    formData.append('author_id', authorId);
    formData.append('author_name', authorName);
    formData.append('monthly_award', monthlyAward);
    formData.append('genre', genre);
    formData.append('gender', gender);
    formData.append('main_image', mainImg);
    formData.append('ratings', ratings);
    formData.append('age', age);
    formData.append('email', email);
  
    try {
      const token = Cookies.get('token'); // Retrieve token from cookie
      const response = await axios.post('http://0.0.0.0:8000/api/author', formData, {
        headers: {
          Authorization: `Bearer ${token}` // Include token in the request headers
        }
      });
      console.log(response.data);
    } catch (error) {
      navigate('/login');
      console.error(error);

    }
  };
  

  return (
    <div>
      <div className="mx-auto col-10 col-md-8 col-lg-6 bootstrap className card mt-3">
        <h3>Create Author</h3>

        <form onSubmit={handleSubmit}>
          <label className="form-label col-sm-6">Author id</label>
          <input type="text" className="form-control" name="author_id" value={authorId} onChange={(e) => setAuthorId(e.target.value)} />

          <label className="form-label">Author Name</label>
          <input type="text" className="form-control" name="book_name" value={authorName} onChange={(e) => setAuthorName(e.target.value)} />

          <label className="form-label">Monthly Award</label>
          <input type="number" className="form-control" name="Monthly_award" value={monthlyAward} onChange={(e) => setMonthlyAward(e.target.value)} />

          <label className="form-label">Genre</label>
          <select className="form-select" name="genre" value={genre} onChange={(e) => setGenre(e.target.value)}>
            <option value="">Select Genre</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
          </select>

          <label className="form-label">Gender</label>
          <input type="text" className="form-control" name="gender" value={gender} onChange={(e) => setGender(e.target.value)} />

          <label className="form-label">Main Image</label>
          <input type="file" className="form-control" name="main_image" onChange={(e) => setMainImg(e.target.files[0])} />

          <label className="form-label">Ratings</label>
          <input type="text" className="form-control" name="ratings" value={ratings} onChange={(e) => setRatings(e.target.value)} />

          <label className="form-label">Age</label>
          <input type="number" className="form-control" name="age" value={age} onChange={(e) => setAge(e.target.value)} />
          <label className="form-label">email</label>
          <input type="text" className="form-control" name="email" value={email} onChange={(e) => setEmail(e.target.value)} />

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
