import { Input, Modal, Button } from 'antd';
import axios from 'axios';
import { getCookie } from 'cookies-next';
import dayjs from 'dayjs';
import { useEffect, useState } from 'react';
const { TextArea } = Input;
export default function ModalUi({open, setOpen}) {
    const [data, setData] = useState([])
    const handleCancel = () => {
        setOpen(state => ({...state, isShow: false, id: ''}))
        setData([])
    }

    useEffect(() => {
        if (open.id) {
            fatchData(open.id)
        }
    }, [open.id])
    const fatchData = async (id) => {
        try {

            const data = await axios.get(`/api/greeting/${id}/show`, {
                headers: {
                    Authorization : getCookie('token')
                }
            })

            setData(data.data.data)
        } catch (error) {
            console.log(error);
        }

    }
    return (
        <Modal
                            title={`Greeting From ${data.name_guest}`}
                            open={open.isShow}
                            onCancel={handleCancel}
                            cancelText="Close"
                            zIndex={1000}
                            footer={[
                                <Button type="primary" onClick={handleCancel}>Close</Button>
                            ]}
                            width={700}

                        >
                            <div className="container mt-3">
                                <p>{data.greeting_word}</p>
                            </div>

                        </Modal>
    )
}