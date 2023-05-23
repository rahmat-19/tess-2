import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider } from "react-query";
import axios from "axios";
import { setCookie } from 'cookies-next'
import { useHistory } from 'react-router-dom';
import { Input, Select } from 'antd';
import { ClockCircleOutlined } from '@ant-design/icons';

const queryClient = new QueryClient();
function Register() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>

    );
}
export default Register;

if (document.getElementById("resgister-app")) {
    ReactDOM.render(<Register />, document.getElementById("resgister-app"));
}

export function InjectApp() {
    // const history = useHistory();

    // const [latLng, setLatLng] = useState(null);
    // const dataLocation = useQuery("location", () =>
    //     axios.get("/dashboard/location/find/all")
    // );
    // const clickSetLatLng = (coords) => {
    //     setLatLng(coords);
    // };

    const [formData, setFormData] = useState({
        name: "",
        confirmPassword: '',
        provincyId: '',
        cityId: ''

    })

    useEffect(() => {
        fatchDataProvinsi()
    }, [])
    useEffect(() => {
        if (formData.provincyId) {
            const code = formData.provincyId.split('|')[0]
            fatchDataKota(code)
        }
    }, [formData.provincyId])
    const fatchDataProvinsi = async () => {
        try {
            const {data} = (await axios.get('/api/provinces')).data
            setProvinsis(
                data.map(provinsi => {
                    return{
                        value: `${provinsi.code}|${provinsi.id}`,
                        label: provinsi.name
                    }
                })
            )

        } catch (error) {

        }
    }

    const fatchDataKota = async (id) => {
        try {

            const {data} = (await axios.get(`/api/${id}/cities`)).data
            setCitys(
                data.map(city => {
                    return {
                        value: `${city.code}|${city.id}`,
                        label: city.name
                    }
                })
            )
        } catch (error) {

        }
    }


    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [errors, setErrors] = useState([])
    const [errorPw, setErrorPw] = useState(false)
    const [status, setStatus] = useState(null)
    const [message, setMessage] = useState('')
    const [provinsis, setProvinsis] = useState([])
    const [citys, setCitys] = useState([])


    const submitForm = async event => {
        event.preventDefault()
        setMessage('')
        setErrors([])
        setStatus(null)
        const formData = {
            name: FormData.name,
            email: email,
            password: password
        }
        console.log(email);
        console.log(password);
        try {
            await axios
                    .post('/api/register', {name: FormData.name, email: email, password: password})
                    .then(res => res.data)
                    .then(res => {
                        setCookie('token', `Bearer ${res.data.token}`)
                        axios.defaults.headers.common[
                            'Authorization'
                        ] = `Bearer ${res.data.token}`
                        window.location.href = '/halaman-depan';
                    })

        } catch (error) {
            setMessage(error.toString())
            if (error.response.status !== 422) throw error
            setErrors(Object.values(error.response.data.errors).flat())
        }
    }

    const onChangeProvinsi = (value) => {
        setFormData({...formData, provincyId: value})
    };
    const onSearchProvinsi = (value) => {
    };
    const onChangeCity = (value) => {
        setFormData({...formData, cityId: value})
    };
    const onSearchCity = (value) => {
    };

    useEffect(() => {
        if (password != formData.confirmPassword) {
            setErrorPw(true)
        } else {
            setErrorPw(false)
        }

    }, [password, formData.confirmPassword])

    return (
        <div className="font-sans text-gray-900 antialiased">
            <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form onSubmit={submitForm}>
                        <div>
                            <label className="block font-medium text-sm text-gray-700" htmlFor="name">
                                Nama
                            </label>

                            <input onChange={e => setFormData({...formData, name: e.target.value})} value={formData.name} className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="name" type="text" name="name" required="required" autoFocus="autofocus" />
                        </div>

                        <div className="mt-4">
                            <label className="block font-medium text-sm text-gray-700" htmlFor="email">
                                Email
                            </label>

                            <input onChange={e => setEmail(e.target.value)} value={email} className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="email" type="email" name="email" required="required" />
                        </div>
                        <div className="mt-4">
                            <label className="block font-medium text-sm text-gray-700" htmlFor="email">
                                Provinsi
                            </label>

                            <Select
                                    id="font"
                                    style={{
                                        width:'100%'
                                    }}
                                    showSearch
                                    placeholder="Pilih Provinsi"
                                    optionFilterProp="children"
                                    onChange={onChangeProvinsi}
                                    onSearch={onSearchProvinsi}
                                    filterOption={(input, option) =>
                                    (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                                    }
                                    options={provinsis}
                                />
                        </div>
                        <div className="mt-4">
                            <label className="block font-medium text-sm text-gray-700" htmlFor="email">
                                Kota
                            </label>

                            <Select
                                    id="font"
                                    style={{
                                        width:'100%'
                                    }}
                                    showSearch
                                    placeholder="Pilih Kota"
                                    optionFilterProp="children"
                                    onChange={onChangeCity}
                                    onSearch={onSearchCity}
                                    filterOption={(input, option) =>
                                    (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                                    }
                                    options={citys}
                                />
                        </div>



                        <div className="mt-4">
                            <label className="block font-medium text-sm text-gray-700" htmlFor="password">
                                Password
                            </label>

                            <input onChange={e => setPassword(e.target.value)} value={password} className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autoComplete="new-password" />
                        </div>

                        <div className="mt-4">
                            <label className="block font-medium text-sm text-gray-700" htmlFor="password_confirmation">
                                Konfirmasi Password
                            </label>


                            <Input status={errorPw ? 'error' : ''}  prefix={errorPw ? <ClockCircleOutlined /> : ''} id="password_confirmation" className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-1 w-full" type="password" name="password_confirmation" required="required" />
                            {
                                errorPw ? (
                                    <div className="invalid-feedback text-danger">
                                        Tidak Sama Dengan Password
                                    </div>

                                ) : ''
                            }

                        </div>


                        <div className="flex items-center justify-end mt-4">
                            <a className="underline text-sm text-gray-600 hover:text-gray-900" href="/login">
                                Already registered?
                            </a>

                            <button type="submit" className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
