'use client'
import Link from 'next/link'
import FormLayout from '@/components/auth/FormLayout'
import Errors from '@/components/Errors'
import Button from '@/components/Button'
import { useState } from 'react'
import { useParams } from 'next/navigation'
import authLogin from '@/hooks/auth/login'
import { MdOutlineAlternateEmail } from 'react-icons/md'
import { FaLock } from 'react-icons/fa'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const Login = () => {
  const params = useParams()
  const UserLoginType = params.type || 'user' // Fallback to 'user' if type is missing
  const [errors, setErrors] = useState([])
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  })

  // login hook
  const { userLogin, isLoading, user } = authLogin({
    userType: UserLoginType,
    middleware: 'gust',
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

    userLogin({
      userType: UserLoginType,
      ...formData,
      setErrors,
    })
  }

  // Show loading or user state while waiting
  if (isLoading || user) {
    return <div className="text-center">Loading...</div>
  }

  return (
    <FormLayout>
      <Card>
        <CardHeader>
          <CardTitle>Hello Again!</CardTitle>
          <CardDescription>
            You are logging in as a {UserLoginType.toUpperCase()}
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form onSubmit={submitForm}>
            {/* Display any errors */}
            <Errors
              className="mb-5 text-red text-sm font-semibold"
              errors={errors}
            />

            <input type="hidden" name="userType" value={UserLoginType} />

            {/* Email Input */}
            <Label htmlFor="email">E-Mail</Label>
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
                autoFocus
              />
            </div>

            {/* Password Input */}
            <Label htmlFor="password">Password</Label>
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

            {/* Submit Button */}
            <Button
              ButtonName={'Login'}
              ButtonType="submit"
              ButtonClass={
                'block w-full text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2'
              }
            />

            {/* Links for forgot password and registration */}
            <div className="flex justify-between mt-4">
              <Link
                href="/password/forgot"
                className="text-sm font-semibold ml- hover:text-white cursor-pointer hover:-translate-y-1 duration-500 transition-all"
              >
                Forgot Password?
              </Link>

              <Link
                href="/register"
                className="text-sm font-semibold ml-2 hover:text-white cursor-pointer hover:-translate-y-1 duration-500 transition-all"
              >
                Don't have an account yet?
              </Link>
            </div>
          </form>
        </CardContent>
      </Card>
    </FormLayout>
  )
}

export default Login
