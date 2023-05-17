import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider } from "react-query";

const queryClient = new QueryClient();

function SamplingApp() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>
    );
}

export default SamplingApp;

if (document.getElementById("sampling-app")) {
    ReactDOM.render(<SamplingApp />, document.getElementById("sampling-app"));
}

export function InjectApp() {
    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-header">HEADER SAMPLING</div>
                        <div className="card-body">KONTEN SAMPLING</div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
