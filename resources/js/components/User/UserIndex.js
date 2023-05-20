import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider, useQuery } from "react-query";
import axios from "axios";
import { getCookie } from "cookies-next";

const queryClient = new QueryClient();

function UserIndex() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>
    );
}

export default UserIndex;

if (document.getElementById("user-index")) {
    ReactDOM.render(<UserIndex />, document.getElementById("user-index"));
}

export function InjectApp() {
    const [latLng, setLatLng] = useState(null);
    const data = async () => {
        await axios.get('/api/user', {
            headers: {
                Authorization : getCookie('token')
            }
        })
    }
    useEffect(() => {
        data()
    }, [])
    const clickSetLatLng = (coords) => {
        setLatLng(coords);
    };
    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-header">HEADER USER</div>
                        <div className="card-body">KONTEN USER</div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
