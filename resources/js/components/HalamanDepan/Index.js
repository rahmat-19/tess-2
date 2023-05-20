import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Input, Select } from 'antd';
import { QueryClient, QueryClientProvider } from "react-query";

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

if (document.getElementById("halaman-depan-app")) {
    ReactDOM.render(<Index />, document.getElementById("halaman-depan-app"));
}

export function InjectApp() {
    const onChange = (value) => {  console.log(`selected ${value}`);
    };
    const onSearch = (value) => {  console.log('search:', value);
    };
    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-3">
                                <label for="font" className="form-label">Pilih Jenis Font Yang Digunakan</label>
                                <Select
                                    id="font"
                                    style={{
                                        width:'100%'
                                    }}
                                    showSearch
                                    placeholder="Select a person"
                                    optionFilterProp="children"
                                    onChange={onChange}
                                    onSearch={onSearch}
                                    filterOption={(input, option) =>
                                    (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                                    }
                                    options={[
                                    {
                                        value: 'jack',
                                        label: 'Jack',
                                    },
                                    {
                                        value: 'lucy',
                                        label: 'Lucy',
                                    },
                                    {
                                        value: 'tom',
                                        label: 'Tom',
                                    },
                                    ]}
                                />
                            </div>
                            <div className="mb-3">
                                <label for="ucapan" className="form-label">Berikan Ucapan Pada Halaman Depan Anda</label>
                                <TextArea id="ucapan" rows={4} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
