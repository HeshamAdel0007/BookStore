'use client'
import useSWR from 'swr'
import { useRouter } from 'next/navigation'
import axios from '@/lib/axios'
import { useState, useEffect, useRef } from 'react'
import userStorage from '../userstorage'
import { toast } from 'react-toastify'

// user login hook
const Login = ({ userType, middleware }) => {
  const router = useRouter()
  const toastLogin = useRef(null)
  const [token, setToken] = useState()
  const [userID, setUserID] = useState()
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    // get token and user ID from localStorage on initial render
    setToken(localStorage.getItem('token'))
    setUserID(localStorage.getItem('id'))
    if (user || error) {
      setIsLoading(false)
    }
    if (middleware == 'guest' && user) router.push('/login')
    if (middleware == 'auth' && !user && error) router.push('/login')
  })

  const {
    data: user,
    error,
    mutate,
  } = useSWR(`'http://bookstore.test/api/v1/auth/info/${userType}'`, () =>
    axios
      .get(`auth/info/${userType}`, {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      })
      .then((response) => {
        router.push(`/dashboard/${userType}`)
        userStorage({ userData: response.data.data })
        toast.update(toastLogin.login, {
          render: 'Successfully logged in',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
      })
      .catch((error) => {
        if (error.response.status != 409) throw error
        router.push('/email/email-verify')
      })
  )

  // CSRF cookie setup
  const csrf = async () => {
    try {
      await axios.get('http://bookstore.test/sanctum/csrf-cookie')
    } catch (error) {
      throw new Error('Failed to get CSRF cookie')
    }
  }

  const userLogin = async ({ setErrors, ...props }) => {
    await csrf()
    setErrors([])
    toastLogin.login = toast.loading('Loading')
    axios
      .post(`auth/login/${userType}`, props)
      .then((response) => {
        // store token and user ID in localStorage
        localStorage.setItem('token', response.data.token)
        localStorage.setItem('id', response.data.data.id)
      })
      .catch((error) => {
        const errorMessages =
          error?.response?.status === 422
            ? Object.values(error.response.data.errors).flat()
            : Object.values(error?.response?.data || {}).flat()
        setErrors(errorMessages)
        toast.update(toastLogin.login, {
          render: 'Error, please try again later ',
          type: 'error',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }

  return {
    user,
    csrf,
    userLogin,
    isLoading,
  }
}
export default Login
