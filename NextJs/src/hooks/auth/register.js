'use client'
import { useRouter } from 'next/navigation'
import axios from '@/lib/axios'
import { toast } from 'react-toastify'

// user register hook
const Register = ({ userType }) => {
  const router = useRouter()

  // CSRF cookie setup
  const csrf = async () => {
    try {
      await axios.get('http://bookstore.test/sanctum/csrf-cookie')
    } catch (error) {
      throw new Error('Failed to get CSRF cookie')
    }
  }

  const userRegister = async ({ setErrors, ...props }) => {
    await csrf()
    setErrors([])
    const loadingToast = toast.loading('Registering...')
    axios
      .post(`auth/register/${userType}`, props)
      .then(() => {
        toast.update(loadingToast, {
          render: 'Successfully registered!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
        router.push(`/login/${userType}`)
      })
      .catch((error) => {
        const errorMessages =
          error?.response?.status === 422
            ? Object.values(error.response.data.errors).flat()
            : Object.values(error?.response?.data || {}).flat()
        setErrors(errorMessages)
        toast.update(loadingToast, {
          render: 'Error, please try again later ',
          type: 'error',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }

  return {
    csrf,
    userRegister,
  }
}
export default Register
