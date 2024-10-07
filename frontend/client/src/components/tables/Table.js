import React from 'react';
import '../../styles/table.css';
import { v4 as uuidv4 } from 'uuid';
//import axios from 'axios';

const Table = ({headers, data}) => {

    // const handleDelete= async(id)=>{
    //     const res = await axios.delete("http://app.local/api/user/"+id);
    // }
    return (
        <div className="table-wrapper">
            <table className="table">
                <thead>
                    <tr>
                        {headers.map((title) => (
                            <th key={`th-unique-${uuidv4()}`}>{title}</th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                {data.map((row) => (
                    <tr key={`tr-unique-${uuidv4()}`}>
                        <>
                            <td key={`td-unique-${uuidv4()}`}>{row?.name}</td>
                            <td key={`td-unique-${uuidv4()}`}>{row?.surname}</td>
                            <td key={`td-unique-${uuidv4()}`}>{row?.phone}</td>
                            <td key={`td-unique-${uuidv4()}`}>{row?.email}</td>
                            <td>
                                <button
                                    type="submit"
                                    className="delete-btn"
                                    >Delete
                                </button>
                            </td>
                        </>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    )
}

export default Table;