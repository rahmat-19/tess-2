import React, { useState } from "react";
import ReactDOM from "react-dom";
import "react-toastify/dist/ReactToastify.css";
import { QueryClient, QueryClientProvider } from "react-query";
import axios from "axios";
import { setCookie } from 'cookies-next'
import { useHistory } from 'react-router-dom';

const queryClient = new QueryClient();
function Login() {
    return (
        <QueryClientProvider client={queryClient}>
            <InjectApp />
        </QueryClientProvider>

    );
}
export default Login;

if (document.getElementById("login-app")) {
    ReactDOM.render(<Login />, document.getElementById("login-app"));
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

    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [errors, setErrors] = useState([])
    const [status, setStatus] = useState(null)
    const [message, setMessage] = useState('')

    const submitForm = async event => {
        event.preventDefault()
        setMessage('')
        setErrors([])
        setStatus(null)
        try {
            await axios
                    .post('/api/login', {email, password})
                    .then(res => res.data)
                    .then(res => {
                        console.log(res.data.token);
                        setCookie('token', `Bearer ${res.data.token}`)
                        axios.defaults.headers.common[
                            'Authorization'
                        ] = `Bearer ${res.data.token}`
                        window.location.href = '/halaman-depan';
                        // history.push('/user');
                    })
        } catch (error) {
            setMessage(error.toString())
            if (error.response.status !== 422) throw error
            setErrors(Object.values(error.response.data.errors).flat())
        }
    }

    return (
        <form onSubmit={submitForm}>

            <div>
                <label className="block font-medium text-sm text-gray-700" htmlFor="email">
                    Email
                </label>
                <input
                    className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                    id="email" type="email" name="email" required="required" value={email}
                    onChange={e => setEmail(e.target.value)} autoFocus="autofocus"
                    />
            </div>
            <div className="mt-4">
                <label className="block font-medium text-sm text-gray-700" htmlFor="password">
                    Password
                </label>

                <input
                    className="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                    id="password" type="password" name="password" required="required"
                    autoComplete="current-password" onChange={e => setPassword(e.target.value)} />
            </div>

            <div className="block mt-4">
                            {/* <label htmlFor="remember_me" className="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    className="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    name="remember" />
                                <span className="ml-2 text-sm text-gray-600">Remember me</span>
                            </label> */}
                        </div>

                        <div className="flex items-center justify-end mt-4">
                            <a className="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ asset('register') }}">
                                Register
                            </a>

                            <button type="submit"
                                className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                                Log in
                            </button>
                        </div>



        </form>
    );
}
