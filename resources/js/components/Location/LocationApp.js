import React, { useState } from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider, useQuery } from "react-query";
import axios from "axios";

const queryClient = new QueryClient();
function LocationApp() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>
    );
}
export default LocationApp;

if (document.getElementById("location-app")) {
    ReactDOM.render(<LocationApp />, document.getElementById("location-app"));
}

export function InjectApp() {
    const [latLng, setLatLng] = useState(null);
    const dataLocation = useQuery("location", () =>
        axios.get("/dashboard/location/find/all")
    );
    const clickSetLatLng = (coords) => {
        setLatLng(coords);
    };

    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-header">HEADER LOCATION</div>
                        <div className="card-body">KONTEN LOCATION</div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
