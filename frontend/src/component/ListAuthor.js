import axios from "axios";
import { useEffect, useState } from "react";
import 'bootstrap/dist/css/bootstrap.min.css';
import { Link } from "react-router-dom";
import Cookies from 'js-cookie';

export default function ListBook() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getPosts();
  }, []);

  const deletePost = (id) => {
    const token = localStorage.getItem('token'); // Retrieve the token from localStorage
  
    axios
      .delete(`http://0.0.0.0:8000/api/author/delete/${id}`, {
        headers: {
          Authorization: `Bearer ${token}` // Include the token in the request headers
        }
      })
      .then(function(response) {
        console.log(response.data);
        getPosts();
      })
      .catch(function(error) {
        console.log(error);
      });
  };
  
    
  

  function getPosts() {
    axios
      .get('http://127.0.0.1:8000/api/allauthor')
      .then(function(response) {
        console.log(response.data);
        setPosts(response.data.Author); // Access the 'Book' array from the response
        setLoading(false);
      })
      .catch(function(error) {
        console.log(error);
        setLoading(false);
      });
  }
  

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      <div className="d-grid gap-2 d-md-flex m-5">
        {posts.map((post) => (
          <div className="card" key={post.author_id} style={{ width: '18rem' }}>
            <img src={post.image_url} className="card-img-top" alt="..." />
            <div className="card-body">
              <h5 className="card-title">{post.author_name}</h5>
              <p className="card-text">
                book_id: {post.author_id}
              </p>
            </div>
            <ul className="list-group list-group-flush">
              <li className="list-group-item">Author: {post.author_name}</li>
              <li className="list-group-item">Rating: {post.ratings}</li>
              <li className="list-group-item">monthly_award: {post.monthly_award}</li>
              <li className="list-group-item">Genre: {post.genre}</li>
              <li className="list-group-item">Gender: {post.gender}</li>
            </ul>
            <div className="card-body p-2">
              <button className="btn btn-info col-xs-2 margin-left">
                <Link style={{ textDecoration: 'none' }} to={`/book/edit/${post.author_id}`}>
                  Edit
                </Link>
              </button>
              <button onClick={() => deletePost(post.author_id)} className="btn btn-outline-danger" style={{ marginLeft: '1rem' }}>
                Delete
              </button>
            </div>
          </div>
        ))}
      </div>
      <div className="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
        <button className="btn btn-secondary md-2" type="button">
          <Link style={{ color: 'white' }} to="/listauthor">List Of Author</Link>
        </button>
        <button className="btn btn-secondary md-2" type="button">
          <Link style={{ color: 'white' }} to="/author/create">Create Author</Link>
        </button>
        <button className="btn btn-secondary md-2" type="button">
          <Link style={{ color: 'white' }} to="/book/create">Create Book</Link>
        </button>
      </div>
    </div>
  );
}
