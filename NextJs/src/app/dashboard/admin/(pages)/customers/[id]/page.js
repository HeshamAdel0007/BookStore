'use client'
import Button from '@/components/Button'
import { useState } from 'react'
import { Label } from '@/components/ui/label'
import { toast } from 'react-toastify'
import { useParams, useRouter } from 'next/navigation'
import axios from '@/lib/axios'
import Errors from '@/components/Errors'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

export default function page() {
  const router = useRouter()
  const params = useParams()
  const [errors, setErrors] = useState([])
  const token = window.localStorage.getItem('token')
  const [formData, setFormData] = useState({
    status: '',
  })

  // Handle input changes
  const handleChange = (e) => {
    const { name, value } = e.target

    setFormData((prevData) => {
      return {
        ...prevData,
        [name]: value,
      }
    })
  }

  const userUpdate = ({ ...props }) => {
    const updateToast = toast.loading('Update...')

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios
      .post(`/admin/edit/customer/${params.id}`, props, config)
      .then(() => {
        toast.update(updateToast, {
          render: 'Updated Successfully!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
        router.push('/dashboard/admin/customers')
      })
      .catch((error) => {
        setErrors(Object.values(error.response.data.errors).flat())
        toast.update(updateToast, {
          render: 'Error, please try again later ',
          type: 'error',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }

  // Login form submission
  const submitForm = async (e) => {
    e.preventDefault()
    userUpdate({
      ...formData,
    })
  }
  return (
    <div className="w-full h-full">
      <Card>
        <CardHeader>
          <CardTitle>Hello !</CardTitle>
          <CardDescription>
            You are will Edit this customer Status
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Errors
            className="mb-5 text-red text-sm font-semibold"
            errors={errors}
          />
          <form onSubmit={submitForm}>
            {/* change status */}
            <Label htmlFor="status">Status</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <select
                className="pl-2 w-full outline-none border-none bg-transparent"
                name="status"
                value={formData.status}
                onChange={handleChange}
              >
                <option className="pl-2 w-full outline-none border-none bg-transparent">
                  Select Status
                </option>
                <option
                  className="pl-2 w-full outline-none border-none bg-transparent"
                  value="1"
                >
                  Activated
                </option>
                <option
                  className="pl-2 w-full outline-none border-none bg-transparent"
                  value="0"
                >
                  Un-Activated
                </option>
              </select>
            </div>

            {/* Submit Button */}
            <Button
              ButtonName={'Update'}
              ButtonType="submit"
              ButtonClass={
                'block w-full text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2'
              }
            />
          </form>
        </CardContent>
      </Card>
    </div>
  )
}
