'use client'
import FormLayout from '@/components/auth/FormLayout'
import Button from '@/components/Button'
import Form from 'next/form'
import { useEffect, useState, useRef } from 'react'
import { useParams } from 'next/navigation'
import axios from '@/lib/axios'
import Errors from '@/components/Errors'
import { useRouter } from 'next/navigation'
import { toast } from 'react-toastify'
import { FaLock } from 'react-icons/fa'
import { CiBarcode } from 'react-icons/ci'

const ResetPassword = () => {
  const router = useRouter()
  const params = useParams()
  const notify = useRef(null)
  const type = params.type // get user type [admin, publisher, customer]
  const [errors, setErrors] = useState([])
  const [isResetCode, setResetCode] = useState(null)
  const [formData, setFormData] = useState({
    code: '',
    password: '',
    password_confirmation: '',
  })

  // Handle input changes
  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    })
  }

  // reset password
  const resetPassword = async (e) => {
    e.preventDefault()
    notify.reset = toast.loading('Processing.....')
    axios
      .post(`/auth/reset-password/${type}`, {
        ...formData,
      })
      .then((response) => {
        toast.update(notify.reset, {
          render: 'Successfully reset your password',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
        setResetCode(response.data.message)
        router.push(`/login/${type}`)
      })
      .catch((error) => {
        setErrors(Object.values(error.response.data.errors).flat())
        toast.update(notify.reset, {
          render: 'Error, please try again later',
          type: 'error',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }
  useEffect(() => {
    if (errors != null) {
      setResetCode(null)
    }
  }, [errors])

  return (
    <FormLayout>
      <Form
        onSubmit={resetPassword}
        className="bg-white rounded-md shadow-2xl p-5"
      >
        <h1 className="text-gray-800 font-bold text-2xl">
          Reset Password
        </h1>
        <small className="text-gray-400 font-semibold text-xs mb-1">
          Please click the button below to reset password... <br />
        </small>
        <span className="mb-5 text-green-500 text-sm font-semibold">
          {isResetCode}
        </span>
        <Errors
          className="mb-5 text-red text-sm font-semibold"
          errors={errors}
        />
        {/* Code Input */}
        <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
          <CiBarcode className="h-5 w-5 text-gray-400" />
          <input
            id="code"
            name="code"
            type="text"
            value={formData.code}
            className="pl-2 w-full outline-none border-none text-black"
            onChange={handleChange}
            placeholder="code"
            autoFocus
          />
        </div>

        {/* Password Input */}
        <div className="flex items-center border-2 mb-12 py-2 px-3 rounded-2xl">
          <FaLock className="h-5 w-5 text-gray-400" />
          <input
            id="password"
            name="password"
            type="password"
            value={formData.password}
            className="pl-2 w-full outline-none border-none text-black"
            onChange={handleChange}
            placeholder="Password"
            autoComplete="off"
          />
        </div>

        {/* Password Confirmation Input */}
        <div className="flex items-center border-2 mb-12 py-2 px-3 rounded-2xl">
          <FaLock className="h-5 w-5 text-gray-400" />
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            value={formData.password_confirmation}
            className="pl-2 w-full outline-none border-none text-black"
            onChange={handleChange}
            placeholder="Password"
            autoComplete="off"
          />
        </div>

        <Button
          ButtonName={'ResetPassword'}
          ButtonType={'submit'}
          ButtonClass={
            'block w-full bg-black mt-5 py-2 rounded-2xl hover:bg-yellow hover:-translate-y-1 transition-all duration-500 text-yallow-bg hover:text-black font-semibold mb-2'
          }
        />
      </Form>
    </FormLayout>
  )
}

export default ResetPassword
