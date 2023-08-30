import apiUtils from "../utils/apiUtils"
import { useState, useEffect } from 'react';

const One = () => {
    const [dummy, setDummy] = useState();

    const URL = apiUtils.getUrl()

    useEffect(() => {
        const getData = async () => {
            const response = await apiUtils.getAxios().get(URL + '/test')
            setDummy(response.data)
            console.log(response.data);
        }
        getData();
    }, []);


    return (
        <div className="center">
            <h1>One</h1>
            <h3>{dummy}</h3>
        </div>
    )
}

export default One