import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Input, Select, Button, Divider } from 'antd';
import { SearchOutlined, PlusOutlined } from '@ant-design/icons';
import { QueryClient, QueryClientProvider } from "react-query";
import PrewedGalery from "./PrewedGallery";
import PageFront from "./PageFront";

const queryClient = new QueryClient();

function Index() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>
    );
}

export default Index;

if (document.getElementById("gallery-app")) {
    ReactDOM.render(<Index />, document.getElementById("gallery-app"));
}

export function InjectApp() {

    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            <h6>Add your prewed photo</h6>
                            <Divider />
                            <PrewedGalery />
                            <h6>Tambahkan foto halaman depan</h6>
                            <Divider />
                            <PageFront />

                        </div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
