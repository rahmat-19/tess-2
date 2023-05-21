import { Input, Modal, DatePicker } from 'antd';
const { TextArea } = Input;
export default function ModalUi({open, handleOk, handleCancel, formData, setFormData}) {
    return (
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
    )
}