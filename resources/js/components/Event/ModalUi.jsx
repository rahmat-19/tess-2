import { Input, Select, Button, Modal } from 'antd';
export default function ModalUi({open, setOpen, confirmLoading, setConfirmLoading}) {
    return (
        <Modal
            title='Create New Event'
            open={open}
            onOk={setOpen(false)}
            onCancel={setOpen(false)}
        >
            <p>Ini Text</p>

        </Modal>
    )
}