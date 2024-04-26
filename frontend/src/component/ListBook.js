import React, { useEffect, useState } from "react";
import axios from "axios";
import 'bootstrap/dist/css/bootstrap.min.css';
import { Link } from "react-router-dom";
import Cookies from 'js-cookie';

export default function ListBook() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [postsPerPage] = useState(10); // Number of posts to display per page

  useEffect(() => {
    getPosts(currentPage);
  }, [currentPage]);

  const deletePost = (id) => {
    const token = localStorage.getItem('token');
  
    axios
      .delete(`http://0.0.0.0:8000/api/book/delete/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      .then(function(response) {
        console.log(response.data);
        getPosts(currentPage);
      })
      .catch(function(error) {
        console.log(error);
      });
  };
  

  function getPosts(page) {
    axios
      .get(`http://127.0.0.1:8000/api/allbook/${page}`)
      .then(function(response) {
        console.log(response.data);
        setPosts(response.data.Book);
        setTotalPages(response.data.TotalPages);
        setLoading(false);
      })
      .catch(function(error) {
        console.log(error);
        setLoading(false);
      });
  }

  // Pagination logic
  useEffect(() => {
    const paginationLinks = document.querySelectorAll('ul.pagination a');
    const paginationData = Array.from(paginationLinks).map((link) => link.textContent);
    console.log(paginationData);
  }, []);

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div>
      <div className="d-grid gap-2 d-md-flex m-5">
        {posts.map((post) => (
          <div className="card" key={post.book_id} style={{ width: '18rem' }}>
            <img src={post.image_url} className="card-img-top" alt="..." />
            <div className="card-body">
              <h5 className="card-title">{post.book_name}</h5>
              <p className="card-text">
                book_id: {post.book_id}
              </p>
            </div>
            <ul className="list-group list-group-flush">
              <li className="list-group-item">Author: {post.author_name}</li>
              <li className="list-group-item">Price: {post.price}</li>
              <li className="list-group-item">Author_id: {post.author_id}</li>
              <li className="list-group-item">Genre: {post.genre}</li>
              <li className="list-group-item">ISBN: {post.isbn}</li>
            </ul>
            <div className="card-body p-2">
              <button className="btn btn-info col-xs-2 margin-left">
                <Link style={{ textDecoration: 'none' }} to={`/book/edit/${post.book_id}`}>
                  Edit
                </Link>
              </button>
              <button onClick={() => deletePost(post.book_id)} className="btn btn-outline-danger" style={{ marginLeft: '1rem' }}>
                Delete
              </button>
            </div>
          </div>
        ))}
      </div>

      {/* Pagination */}
      <nav aria-label="Page navigation example">
        <ul className="pagination justify-content-center">
          <li className="page-item">
            <a
              className="page-link"
              href="#"
              onClick={() => setCurrentPage(currentPage - 1)}
              disabled={currentPage === 1}
            >
              Previous
            </a>
          </li>
          {Array.from({ length: totalPages }, (_, index) => index + 1).map((page) => (
            <li className={`page-item ${page === currentPage ? 'active' : ''}`} key={page}>
              <a
                className="page-link"
                href="#"
                onClick={() => setCurrentPage(page)}
              >
                {page}
              </a>
            </li>
          ))}
          <li className="page-item">
            <a
              className="page-link"
              href="#"
              onClick={() => setCurrentPage(currentPage + 1)}
              disabled={currentPage === totalPages}
            >
              Next
            </a>
          </li>
        </ul>
      </nav>

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
      <div className="d-flex justify-content-center mt-3">
        <p>
          Page {currentPage} 
        </p>
      </div>
    </div>
  );
}
