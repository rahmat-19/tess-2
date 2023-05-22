import { PlusOutlined } from '@ant-design/icons';
import { Modal, Upload } from 'antd';
import axios from 'axios';
import { getCookie } from 'cookies-next';
import { useEffect, useState } from 'react';
const getBase64 = (file) =>
    new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
});

export default function PrewedGalery() {
    const [previewOpen, setPreviewOpen] = useState(false);
    const [previewImage, setPreviewImage] = useState('');
    const [previewTitle, setPreviewTitle] = useState('');
    const [fileList, setFileList] = useState([])
    const handleCancel = () => setPreviewOpen(false);
    const handlePreview = async (file) => {
        if (!file.url && !file.preview) {
        file.preview = await getBase64(file.originFileObj);
        }
        setPreviewImage(file.url || file.preview);
        setPreviewOpen(true);
        setPreviewTitle(file.name || file.url.substring(file.url.lastIndexOf('/') + 1));
    };
    const handleChange = ({ fileList: newFileList }) => setFileList(newFileList);
    const handleRemove = async (file) => {
        // Remove the file from the fileList state
        const response = await axios.delete(`/api/prewedding_images/${file.id}/delete`, {
            headers: {
                Authorization : getCookie('token')
            }
        });

        console.log(response);

        const updatedFileList = fileList.filter((f) => f.id !== file.id);
        setFileList(updatedFileList);
      };

    useEffect(() => {
        fatchData()
    }, [])
    const fatchData = async () => {
        const response = await axios.get('/api/prewedding_images', {
            headers: {
                Authorization : getCookie('token')
            }
        });

        setFileList(response.data.data)
    }
    const handleUpload = async (options) => {
        const { onSuccess, onError, file } = options;


        try {
            const formData = new FormData();
            formData.append('image', file);



            // Send the image file to the server using Axios
            const response = await axios.post('/api/prewedding_images/create', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                Authorization : getCookie('token')
            }
            });

            // Handle the success case
            if (response.status === 201) {
            onSuccess(response.data, file);
            // message.success('Image uploaded successfully');
            console.log(response.data.data);
            setFileList(state => [...state, response.data.data])
            } else {
            onError();
            console.log('not ok');
            // message.error('Failed to upload image');
        }
    } catch (error) {
        onError();
        console.log(error);
            // message.error('Failed to upload image');
        }
    };
    const uploadButton = (
        <div>
        <PlusOutlined />
        <div
            style={{
            marginTop: 8,
            }}
        >
            Upload
        </div>
        </div>
    );

    return(
        <div>

            <Upload
                // customRequest={({ onSuccess }) =>
                // onSuccess("ok")}
                customRequest={handleUpload}
                listType="picture-card"
                fileList={fileList}
                onPreview={handlePreview}
                onRemove={handleRemove}
                // onChange={handleChange}
            >
                {fileList.length >= 8 ? null : uploadButton}
            </Upload>
            <Modal open={previewOpen} title={previewTitle} footer={null} onCancel={handleCancel}>
                <img
                alt="example"
                style={{
                    width: '100%',
                }}
                src={previewImage}
                />
            </Modal>
        </div>

    )

}
