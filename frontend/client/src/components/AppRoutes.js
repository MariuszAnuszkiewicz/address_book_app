import React from 'react';
import { Route, Routes } from "react-router-dom";
import Navbar from '../components/Navbar';
import App from '../App';
import User from './pages/User';
import Create from "./pages/Create";
import '../styles/navbar.css';
import '../styles/forms.css';
var url = require('url');

const AppRoutes = () => (
    <App>
        <Navbar />
        <Routes>
            <Route path="/user" element={<User />} />
            <Route path="/user/create" element={<Create />} />
        </Routes>
    </App>
);

export default AppRoutes;