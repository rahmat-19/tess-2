import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Input, Select, Button, Modal, DatePicker, Space, notification, Table, Pagination } from 'antd';
import { SearchOutlined, PlusOutlined } from '@ant-design/icons';

import { QueryClient, QueryClientProvider } from "react-query";
import { useState, useEffect } from 'react';
import axios from "axios";
import dayjs from 'dayjs'
import { getCookie } from "cookies-next";
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
    const [data, setData] = useState([])
    const [api, contextHolder] = notification.useNotification();
    const [confirmLoading, setConfirmLoading] = useState(false);
    const [formData, setFormData] = useState({
        name: "",
        deskripsi: "",
        dateEvent: ''
    })

    const columns = [
        {
            title: 'Nama Event',
            dataIndex: 'nama',
            // render: (text) => <a>{text}</a>,
        },
        {
            title: 'Tanggal Event',
            dataIndex: 'tanggal',
            render: (text) => dayjs(text).format('YYYY-MM-DD')
        },
        {
            title: 'Deskripsi',
            dataIndex: 'deskripsi',
        },
    ];

    useEffect(() => {
        fatchData()
    }, [])

    const fatchData = async () => {
        const datas = await axios.get('/api/event_user', {
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


    const handleClick = () => {
        setOpen(true)

    }
    const handleCancel = () => {
        setOpen(false);
    };
    const openNotification = (status) => {
        if (status) {
            api.success({
            message: `Berhasil Di Tambahakan`,
            description:
                'Event Berhasil Di Tambahkan Ke Dalam Database',
            placement: 'bottomRight',
            duration: 1.5
            });

        } else {
            api.error({
                message: `Gagal Di Tambahakan`,
                description:
                    'Event Gagal Di Tambahkan Ke Dalam Database',
                placement: 'bottomRight',
                duration: 1.5
                });
        }
    };

    const handleOk = () => {
        if (!formData.name &&
            !formData.dateEvent &&
            !formData.deskripsi
            ) {

                api.info({
                    message: 'Form Belum Di Isi',
                    description: 'Lengkapai Form Tersebut Sebelum Subbmit',
                    placement: 'bottomRight',
                    duration: 1.5
                })
        } else {
            try {
                axios.post('/api/event_user/create', {
                    user_id: 1,
                    nama: formData.name,
                    tanggal: dayjs(formData.dateEvent.$d).format('YYYY-MM-DD HH:mm:ss'),
                    deskripsi: formData.deskripsi
                }, {
                    headers: {
                        Authorization : getCookie('token')
                    }
                })

                openNotification(true)
                setOpen(false)
                setFormData({
                        name: '',
                        dateEvent: '',
                        deskripsi: ''
                    })
                fatchData()
            } catch (error) {

                openNotification(false)
                // setOpen(false)
            }

        }
    }
    const [selectionType, setSelectionType] = useState('checkbox');
    const [selectedRowKeys, setSelectedRowKeys] = useState([]);
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


    return (
        <div className="container-fluid">
            {contextHolder}
            <ModalUi open={open} handleOk={handleOk} handleCancel={handleCancel} formData={formData} setFormData={setFormData}/>
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">

                            <div className="d-flex justify-content-between">
                                <div></div>
                                <div><Button type="primary" icon={<PlusOutlined />} onClick={handleClick}>Add New Event</Button></div>
                            </div>
                            <br />
                            <br />

                            <div>
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
            </div>
            <ToastContainer />
        </div>
    );
}
