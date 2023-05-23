import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Input, Button, Space, notification, Table, Popconfirm, message, Modal} from 'antd';
import { SearchOutlined, PlusOutlined, DeleteOutlined, ExclamationCircleOutlined } from '@ant-design/icons';
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
    const [open, setOpen] = useState({
        isShow: false,
        id: ''
    });
    const [data, setData] = useState([])
    const [api, contextHolder] = notification.useNotification();
    const [confirmLoading, setConfirmLoading] = useState(false);
    const [formData, setFormData] = useState({
        name: "",
        deskripsi: "",
        dateEvent: ''
    })
    const cancel = (e) => {

    };
    const confirm = async (e) => {
        try {
            await axios.delete(`/api/event_user/${e}/delete`, {
                headers: {
                    Authorization : getCookie('token')
                }
            })

            api.success({
                message: `Berhasil Di Hapus`,
                description:
                    'Event Berhasil Di Hapus Dari Table',
                placement: 'bottomRight',
                duration: 1.5
            });
            fatchData()
        } catch (error) {

            api.error({
                message: `Gagal Di Hapus`,
                description:
                    'Event Gagal Di Hapus Dari Table',
                placement: 'bottomRight',
                duration: 1.5
            });
        }
    };

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
        {
            title: 'Action',
            key: 'action',
            render: (_, record) =>(
                <Space size="middle">
                    <Button type="primary" style={{backgroundColor: '#ffc107', borderColor: '#ffc107', color: '#fff'}}
                        onClick={() => {
                            setOpen(state => ({...state, isShow: true, id: record.id}))
                        }}
                    >Edit</Button>
                    <Popconfirm
                        title="Delete Event"
                        description="Are you sure to delete this event?"
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
        setOpen(state => ({...state, isShow: true}))

    }
    const handleCancel = () => {
        setOpen(state => ({...state, isShow: false, id: ''}))
    };
    const openNotification = (status) => {
        if (status) {
            api.success({
            message: `Berhasil Di Tambahakan`,
            description:
                'Event Berhasil Di Tambahkan Ke Dalam Table',
            placement: 'bottomRight',
            duration: 1.5
            });

        } else {
            api.error({
                message: `Gagal Di Tambahakan`,
                description:
                    'Event Gagal Di Tambahkan Ke Dalam Table',
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
                if (open.id) {
                    axios.patch(`/api/event_user/${open.id}/edit`, {
                        nama: formData.name,
                        tanggal: dayjs(formData.dateEvent.$d).format('YYYY-MM-DD HH:mm:ss'),
                        deskripsi: formData.deskripsi
                    }, {
                        headers: {
                            Authorization : getCookie('token')
                        }
                    })
                    openNotification(true)
                } else {

                    axios.post('/api/event_user/create', {
                        nama: formData.name,
                        tanggal: dayjs(formData.dateEvent.$d).format('YYYY-MM-DD HH:mm:ss'),
                        deskripsi: formData.deskripsi
                    }, {
                        headers: {
                            Authorization : getCookie('token')
                        }
                    })
                    openNotification(true)
                }

                setOpen(state => ({...state, isShow: false, id: ''}))
                setFormData({
                        name: '',
                        dateEvent: '',
                        deskripsi: ''
                    })
                fatchData()
            } catch (error) {
                console.log(error);
                openNotification(false)
                // setOpen(false)
            }

        }
    }
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

    const [modal, contextHolderDeleteAll] = Modal.useModal();
    const handleDeleteAll = async () => {
        try {
            axios.post('/api/event_user/deleteMany', {
                ids: selectedRowKeys
            }, {
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
            setSelectedRowKeys([])
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

    }
    const confirmDeleteAll = () => {
        modal.confirm({
            title: 'Yakin Ingin Menghapus Seluruh Data Yang Di Pilih?',
            icon: <ExclamationCircleOutlined />,
            content: 'Data Yang Sudah Terhapus Tidak Akan Bisa Di Kembalikan',
            okText: 'Ya',
            cancelText: 'Tidak',
            onOk: handleDeleteAll
        });
    };


    return (
        <div className="container-fluid">
            {contextHolder}
            {contextHolderDeleteAll}
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
                            {
                                selectedRowKeys.length > 0 ? (
                                    <Button type="primary" danger onClick={confirmDeleteAll}>Delete All</Button>
                                ) : ''
                            }
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
