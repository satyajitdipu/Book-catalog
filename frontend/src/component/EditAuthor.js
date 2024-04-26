import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link, useParams, useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';

export default function EditAuthor() {
  const { id } = useParams();
  const navigate = useNavigate();

  const [author, setAuthor] = useState({
    author_id: '',
    main_image: '',
    author_name: '',
    gender: '',
    genre: '',
    age: '',
    ratings: '',
    email:'',
    monthly_award: ''
  });

  useEffect(() => {
    axios
      .get(`http://0.0.0.0:8000/api/author/${id}`)
      .then(response => {
        const {
          author_id,
          main_image,
          author_name,
          gender,
          genre,
          age,
          ratings,
          email,
          monthly_award
        } = response.data;
        setAuthor({
          author_id,
          main_image,
          author_name,
          gender,
          genre,
          age,
          ratings,
          email,
          monthly_award
        });
        console.log(response);
      })
      .catch(error => {
        console.log(error);
      });
  }, [id]);

  const handleChange = event => {
    const { name, value } = event.target;
    setAuthor(prevState => ({
      ...prevState,
      [name]: value,
    }));
  };

  const handleImageChange = event => {
    const file = event.target.files[0];
    setAuthor(prevState => ({
      ...prevState,
      main_image: file,
    }));
  };

  const handleSubmit = async event => {
    event.preventDefault();

    const formData = new FormData();
    formData.append('author_id', author.author_id);
    formData.append('author_name', author.author_name);
    formData.append('age', author.age);
    formData.append('genre', author.genre);
    formData.append('gender', author.gender);
    formData.append('main_img', author.main_image);
    formData.append('ratings', author.ratings);
    formData.append('email', author.email);
    formData.append('monthly_award', author.monthly_award);

    // Create an instance of Axios
    const api = axios.create({
      baseURL: 'http://127.0.0.1:8000/api', // Your API base URL
    });

    // Add an interceptor to check token validity
    api.interceptors.response.use(
      response => response,
      error => {
        if (error.response.status === 401) {
          // Token not valid or expired
          // Redirect the user to the login page
          navigate('/login');
        }
        return Promise.reject(error);
      }
    );

    // Function to update author
    async function updateAuthor(id, formData) {
      try {
        const token = Cookies.get('token');
        const response = await api.post(`/author/update/${id}`, formData, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    }

    await updateAuthor(id, formData);
  };

  return (
    <div>
      {console.log(author)}
      <div className="mx-auto col-10 col-md-8 col-lg-6 bootstrap className card mt-3">
        <h3>Edit Author</h3>

        <form onSubmit={handleSubmit}>
          <label className="form-label col-sm-6">Author ID</label>
          <input
            type="text"
            className="form-control"
            name="author_id"
            value={author.author_id}
            onChange={handleChange}
          />

          <label className="form-label">Author Name</label>
          <input
            type="text"
            className="form-control"
            name="author_name"
            value={author.author_name}
            onChange={handleChange}
          />

          <label className="form-label">Age</label>
          <input
            type="text"
            className="form-control"
            name="age"
            value={author.age}
            onChange={handleChange}
          />

          <label className="form-label">Genre</label>
          <select
            className="form-select"
            name="genre"
            value={author.genre}
            onChange={handleChange}
          >
            <option value="">Select Genre</option>
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
          </select>

          <label className="form-label">Gender</label>
          <input
            type="text"
            className="form-control"
            name="gender"
            value={author.gender}
            onChange={handleChange}
          />

          <label className="form-label">Main Image</label>
          <input
            type="file"
            className="form-control"
            name="main_img"
            onChange={handleImageChange}
          />

          <label className="form-label">Ratings</label>
          <input
            type="text"
            className="form-control"
            name="ratings"
            value={author.ratings}
            onChange={handleChange}
          />
           <label className="form-label">Email</label>
          <input
            type="email"
            className="form-control"
            name="email"
            value={author.email}
            onChange={handleChange}
          />

          <label className="form-label">Monthly Award</label>
          <input
            type="text"
            className="form-control"
            name="monthly_award"
            value={author.monthly_award}
            onChange={handleChange}
          />

          <button className="mt-2 btn btn-success" type="submit">
            Save
          </button>
        </form>
      </div>
      <div className="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
        <button className="btn btn-secondary md-2" type="button">
          <Link style={{ color: 'white' }} to="/">
            List Of Book
          </Link>
        </button>
        <button className="btn btn-secondary md-2" type="button">
          <Link style={{ color: 'white' }} to="/listauthor">
            List Of Author
          </Link>
        </button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/author/create">Create Author</Link></button>
        <button className="btn btn-secondary md-2" type="button"><Link style={{ color: 'white' }} to="/book/create">Create Book</Link></button>
      </div>
    </div>
  );
}
