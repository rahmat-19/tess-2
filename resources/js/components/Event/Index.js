import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Input, Select, Button } from 'antd';
import { SearchOutlined, PlusOutlined } from '@ant-design/icons';
import { QueryClient, QueryClientProvider } from "react-query";
import { useState } from 'react';
import ModalUi from "./ModalUi";

const { TextArea } = Input;
const queryClient = new QueryClient();

function Index() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>
    );
}

export default Index;

if (document.getElementById("event-app")) {
    ReactDOM.render(<Index />, document.getElementById("event-app"));
}

export function InjectApp() {

    const [open, setOpen] = useState(false);
    const [confirmLoading, setConfirmLoading] = useState(false)



    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            {/* <ModalUi open={opne} setOpen={setOpen} confirmLoading={confirmLoading} setConfirmLoading={setConfirmLoading} /> */}
                            <div className="d-flex justify-content-between">
                                <div></div>
                                <div><Button type="primary" icon={<PlusOutlined />} onClick={setOpen(false)}>Add New Event</Button></div>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
