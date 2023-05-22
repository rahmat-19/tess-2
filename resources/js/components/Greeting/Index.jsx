import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider } from "react-query";
import { Input, Button, Space, notification, Table, Popconfirm, message} from 'antd';
import { useState, useEffect } from 'react';
import axios from "axios";
import dayjs from 'dayjs'
import ModalUi from "./ModalUi";
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
    const [api, contextHolder] = notification.useNotification();

    const [open, setOpen] = useState({
        isShow: false,
        id: ''
    });

    useEffect(() => {
        fatchData()
        setInterval(() => {
            fatchData()
        }, 5000);
    }, [])

    const fatchData = async () => {
        const datas = await axios.get('/api/greeting', {
            headers: {
                Authorization : getCookie('token')
            }
        })
        console.log(datas);
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

    const cancel = (e) => {

    };
    const confirm = async (e) => {
        try {
            await axios.delete(`/api/greeting/${e}/delete`, {
                headers: {
                    Authorization : getCookie('token')
                }
            })

            api.success({
                message: `Berhasil Di Hapus`,
                description:
                    'Greeting Berhasil Di Hapus Dari Table',
                placement: 'bottomRight',
                duration: 1.5
            });
            fatchData()
        } catch (error) {

            api.error({
                message: `Gagal Di Hapus`,
                description:
                    'Greeting Gagal Di Hapus Dari Table',
                placement: 'bottomRight',
                duration: 1.5
            });
        }
    };

    const columns = [
        {
            title: 'Nama',
            dataIndex: 'name_guest',
        },
        {
            title: 'Greetings',
            dataIndex: 'greeting_word',
            render: (_, record) => (
                <Button type="primary" style={{width: '50%'}} onClick={() => {
                    setOpen(state => ({...state, isShow: true, id: record.id}))
                }}>{
                    record.greeting_word.length > 20 ?
                        `${record.greeting_word.substring(0, 20)}...` : `${record.greeting_word}`
                }</Button>
            )
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
            {contextHolder}
            <ModalUi open={open} setOpen={setOpen}/>
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
