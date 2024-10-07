import React from 'react';
import Table from '../tables/Table';
import Headers from '../tables/Headers';
import useData from "../fetch/useData";

const User = () => {
    const headers = Headers.apply();
    const urlAddress = process.env.REACT_APP_API_URL;

    const {data} = useData(urlAddress);

    if (!data) return 'data loading ...';

    return (
        <div className="content">
            <h1>User</h1>
            <Table headers={headers} data={data?.data} />
        </div>
    )
};

export default User