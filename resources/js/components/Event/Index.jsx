import React from "react";
import ReactDOM from "react-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Input, Select, Button, Modal, DatePicker, Space, notification } from 'antd';
import { SearchOutlined, PlusOutlined } from '@ant-design/icons';

import { QueryClient, QueryClientProvider } from "react-query";
import { useState } from 'react';
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
    const [api, contextHolder] = notification.useNotification();
    const [confirmLoading, setConfirmLoading] = useState(false);
    const [formData, setFormData] = useState({
        name: "",
        deskripsi: "",
        dateEvent: ''
    })

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
        } catch (error) {

            openNotification(false)
            // setOpen(false)
        }
    }


    return (
        <div className="container-fluid">
            {contextHolder}
            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                        <Modal
                            title='Create New Event'
                            open={open}
                            onCancel={handleCancel}
                            onOk={handleOk}
                            width={700}

                        >
                            <div className="container">
                                <div className="row">
                                    <div className="col">
                                        <label htmlFor="nameEvent" className="form-label">Nama Event</label>
                                        <Input id="nameEvent" onChange={e => setFormData({...formData, name: e.target.value})} value={formData.name} placeholder="Nama Event" />;
                                    </div>
                                    <div className="col">
                                        <label htmlFor="tanggal" className="form-label">Tanggal</label>
                                        <DatePicker id="tanggal"
                                            style={{
                                                width:'100%'
                                            }}
                                            onChange={(date, dateString) => setFormData({...formData, dateEvent: date})} value={formData.dateEvent}
                                        />
                                    </div>
                                    <div className="col">
                                        <label htmlFor="deskripsi" className="form-label">Deskripsi</label>
                                        <TextArea id="deskripsi" rows={4}
                                            onChange={e => setFormData({...formData, deskripsi: e.target.value})} value={formData.deskripsi}
                                        />
                                    </div>
                                </div>
                            </div>

                        </Modal>
                            <div className="d-flex justify-content-between">
                                <div></div>
                                <div><Button type="primary" icon={<PlusOutlined />} onClick={handleClick}>Add New Event</Button></div>
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
