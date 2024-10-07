import { useState, useEffect } from 'react';
import axios from 'axios';

const useData = (url) => {
    const [state, setState] = useState();

    useEffect(() => {
        const dataFetch = async () => {
            await axios.get(url)
                .then(res => {
                    setState(res.data);
                }).catch(err => {
                    return Promise.reject(err.message);
                })
        }
        dataFetch();
    }, [url]);

    return { data: state };
};

export default useData;