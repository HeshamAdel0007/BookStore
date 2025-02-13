'use client'
import FormLayout from '@/components/auth/FormLayout'
import { MdOutlineAlternateEmail } from 'react-icons/md'
import Button from '@/components/Button'
import Form from 'next/form'
import axios from '@/lib/axios'
import { useEffect, useState, useRef } from 'react'
import Link from 'next/link'
import userAuth from '@/hooks/auth/checkauth'
import { toast } from 'react-toastify'

const EmailVerify = () => {
  const [isErrors, setErrors] = useState('')
  const [isSendLink, setSendLink] = useState('')
  const [token, setToken] = useState('')
  const [email, setEmail] = useState('')
  const [isVerified, setVerified] = useState(false)
  const notify = useRef(null)
  const { isAuthorized, isLoading } = userAuth()

  useEffect(() => {
    setEmail(window.localStorage.getItem('email'))
    setToken(window.localStorage.getItem('token'))
    setVerified(window.localStorage.getItem('email_verified_at'))
    if (isVerified != 'null' && isVerified != null) {
      setVerified(true)
    }
  }, [isVerified])

  // Loading state
  if (isVerified || isLoading) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <p>Loading, please wait...</p>
      </div>
    )
  }

  // Unauthorized state
  if (isVerified || isAuthorized) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <p>
          Sorry, you don't have permission to access this page.
          Redirecting...
          <Link href="/">Click here</Link>
        </p>
      </div>
    )
  }

  // send link verify to mail
  const sendEmailVerification = async (e) => {
    e.preventDefault()
    notify.sendLink = toast.loading('Loading.....')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios
      .get('/auth/email/verification', config)
      .then((response) => {
        setSendLink(response.data.message)
        toast.update(notify.sendLink, {
          render: 'Successfully send link verify to your E-Mail',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
      })
      .catch((error) => {
        if (error) {
          setErrors('please try again later')
        }
        toast.update(notify.sendLink, {
          render: 'Error, please try again later ',
          type: 'error',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }

  return (
    <FormLayout>
      <Form
        onSubmit={sendEmailVerification}
        className="bg-white rounded-md shadow-2xl p-5"
      >
        <h1 className="text-gray-800 font-bold text-2xl mb-1">
          Send Email Verification
        </h1>
        <span className="mb-5 text-red-500 text-sm font-semibold">
          {isErrors}
        </span>

        {isSendLink ? (
          <span className="mb-5 text-green-500 text-sm font-semibold">
            {isSendLink}
          </span>
        ) : (
          <span className="mb-5 text-black text-sm font-semibold">
            <br />
            Please click the button below to send link verification...
          </span>
        )}
        <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
          <MdOutlineAlternateEmail className="h-5 w-5 text-gray-400" />
          <input
            id="email"
            name="email"
            type="email"
            className="pl-2 w-full outline-none border-none text-black"
            placeholder={email}
            disabled
          />
        </div>
        <Button
          ButtonName={'Send Link'}
          ButtonType={'submit'}
          ButtonClass={
            'block w-full bg-black mt-5 py-2 rounded-2xl hover:bg-yellow hover:-translate-y-1 transition-all duration-500 text-yallow-bg hover:text-black font-semibold mb-2'
          }
        />
      </Form>
    </FormLayout>
  )
}
export default EmailVerify
