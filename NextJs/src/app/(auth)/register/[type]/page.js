'use client'
import Link from 'next/link'
import FormLayout from '@/components/auth/FormLayout'
import Errors from '@/components/Errors'
import Button from '@/components/Button'
import { useState } from 'react'
import { useParams, useRouter } from 'next/navigation'
import authRegister from '@/hooks/auth/register'
import { MdOutlineAlternateEmail } from 'react-icons/md'
import { FaLock, FaUser } from 'react-icons/fa'
import userAuth from '@/hooks/auth/checkauth'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const Register = () => {
  const params = useParams()
  const router = useRouter()
  const UserRegisterType = params.type || 'user' // Fallback to 'user' if type is missing
  const [errors, setErrors] = useState([])
  const { isAuthorized, isLoading } = userAuth()
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  // Register hook
  const { userRegister, userType } = authRegister({
    userType: UserRegisterType,
  })

  // Handle input changes
  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    })
  }

  // Login form submission
  const submitForm = async (e) => {
    e.preventDefault()
    userRegister({
      ...formData,
      setErrors,
    })
  }

  // Loading state
  if (isLoading) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <p>Loading, please wait...</p>
      </div>
    )
  }

  // Unauthorized state
  if (!isAuthorized) {
    setTimeout(() => {
      router.push('/login')
    }, 2000)
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

  return (
    <FormLayout>
      <Card>
        <CardHeader>
          <CardTitle>Hello !</CardTitle>
          <CardDescription>
            You are registered in as a {UserRegisterType.toUpperCase()}
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form onSubmit={submitForm}>
            {/* Display any errors */}
            <Errors
              className="mb-5 text-red text-sm font-semibold"
              errors={errors}
            />
            {/* TypeInput */}
            <input
              type="hidden"
              name="userType"
              value={UserRegisterType}
              className="hidden"
              readOnly={true}
            />

            {/* Name Input */}
            <Label htmlFor="name">Name</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <FaUser className="h-5 w-5 text-gray-400" />
              <Input
                id="name"
                name="name"
                type="text"
                value={formData.name}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Your Name"
                autoFocus
              />
            </div>

            {/* Email Input */}
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <MdOutlineAlternateEmail className="h-5 w-5 text-gray-400" />
              <Input
                id="email"
                name="email"
                type="email"
                value={formData.email}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Email Address"
              />
            </div>

            {/* Password Input */}
            <div className="flex items-center border-2 mb-12 py-2 px-3 rounded-2xl">
              <FaLock className="h-5 w-5 text-gray-400" />
              <Input
                id="password"
                name="password"
                type="password"
                value={formData.password}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Password"
                autoComplete="off"
              />
            </div>

            {/* Password Confirmation Input */}
            <div className="flex items-center border-2 mb-12 py-2 px-3 rounded-2xl">
              <FaLock className="h-5 w-5 text-gray-400" />
              <Input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                value={formData.password_confirmation}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Password"
                autoComplete="off"
              />
            </div>

            {/* Submit Button */}
            <Button
              ButtonName={'Register'}
              ButtonType="submit"
              ButtonClass={
                'block w-full text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2'
              }
            />

            {/* Links for forgot password and Login */}
            <div className="flex justify-between mt-4">
              <Link
                href="/password/forgot"
                className="text-sm font-semibold ml- hover:text-white cursor-pointer hover:-translate-y-1 duration-500 transition-all"
              >
                Forgot Password?
              </Link>

              <Link
                href="/login"
                className="text-sm font-semibold ml-2 hover:text-white cursor-pointer hover:-translate-y-1 duration-500 transition-all"
              >
                i have an account!
              </Link>
            </div>
          </form>
        </CardContent>
      </Card>
    </FormLayout>
  )
}

export default Register
