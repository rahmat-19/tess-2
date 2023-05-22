import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider } from "react-query";
import { Input, Button, Space, notification, Table, Popconfirm, message} from 'antd';
import { useState, useEffect } from 'react';
import axios from "axios";
import dayjs from 'dayjs'
import { getCookie } from "cookies-next";

const queryClient = new QueryClient();

function Index() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>
    );
}

export default Index;

if (document.getElementById("greeting-app")) {
    ReactDOM.render(<Index />, document.getElementById("greeting-app"));
}

export function InjectApp() {
    const [data, setData] = useState([])
    const [selectedRowKeys, setSelectedRowKeys] = useState([]);

    useEffect(() => {
        fatchData()
    }, [])

    const fatchData = async () => {
        const datas = await axios.get('/api/greeting', {
            headers: {
                Authorization : getCookie('token')
            }
        })
        setData(datas.data.data.map(item => ({ ...item, key: item.id })))
        setTableParams({
            ...tableParams,
            pagination: {
                ...tableParams.pagination,
                total: datas.data.data.length ,
              // 200 is mock data, you should read it from server
              // total: data.totalCount,
            },
        });
    }

    const onSelectChange = (newSelectedRowKeys) => {
        console.log('selectedRowKeys changed: ', newSelectedRowKeys);
        setSelectedRowKeys(newSelectedRowKeys);
    };

    const rowSelection = {
        selectedRowKeys,
        onChange: onSelectChange,
    };

    const [tableParams, setTableParams] = useState({
        pagination: {
            current: 1,
            pageSize: 5,
            position: ['bottomLeft'],
            showSizeChanger: true
        },
    });

    const handleTableChange = (pagination) => {
        setTableParams({
            pagination,
        });

    };

    const columns = [
        {
            title: 'Nama',
            dataIndex: 'name_guest',
        },
        {
            title: 'Greetings',
            dataIndex: 'greeting_word',
        },
        {
            title: 'Kehadiran',
            dataIndex: 'kehadiran',
            render: (kehadiran) => kehadiran == 1 ? 'Hadir' : 'Tidak Hadir'
        },
        {
            title: 'Action',
            key: 'action',
            render: (_, record) => (
                <Space>
                    <Popconfirm
                        title="Delete Greeting"
                        description="Are you sure to delete this Greeting?"
                        onConfirm={() => {
                            confirm(record.id)
                        }}
                        onCancel={cancel}
                        okText="Yes"
                        cancelText="No"
                    >
                        <Button type="primary" danger >Delete</Button>
                    </Popconfirm>
                </Space>
            )
        }
    ]


    return (
        <div className="container-fluid">
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                        <Table
                                rowSelection={rowSelection}
                                columns={columns}
                                dataSource={data}
                                pagination={tableParams.pagination}

                                onChange={handleTableChange}
                            />
                        </div>
                    </div>
                </div>
            </div>
            <ToastContainer />
        </div>
    );
}
