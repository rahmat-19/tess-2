import { Input, Modal, DatePicker } from 'antd';
import axios from 'axios';
import { getCookie } from 'cookies-next';
import dayjs from 'dayjs';
import { useEffect } from 'react';
const { TextArea } = Input;
export default function ModalUi({open, handleOk, handleCancel, formData, setFormData}) {

    useEffect(() => {
        if (open.id) {
            fatchData(open.id)
        }
    }, [open.id])
    const fatchData = async (id) => {
        try {

            const data = await axios.get(`/api/event_user/${id}/show`, {
                headers: {
                    Authorization : getCookie('token')
                }
            })
            setFormData(state => ({...state, name: data.data.data.nama, deskripsi: data.data.data.deskripsi, dateEvent: dayjs(data.data.data.tanggal, 'YYYY-MM-DD')}))
        } catch (error) {
            console.log(error);
        }

    }
    return (
        <Modal
                            title={open.id ? 'Edit Event' : 'Create New Event'}
                            open={open.isShow}
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
    )
}