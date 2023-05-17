import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider } from "react-query";

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
