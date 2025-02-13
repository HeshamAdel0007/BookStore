'use client'
import Button from '@/components/Button'
import { useEffect, useState } from 'react'
import { Input } from '@/components/ui/input'
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
  const [permissions, setPermissions] = useState([])
  const [errors, setErrors] = useState([])
  const token = window.localStorage.getItem('token')
  const [formData, setFormData] = useState({
    status: '',
    permissions: [],
  })

  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('/permissions', config).then((response) => {
      setPermissions(response.data.data)
    })
  }, [])

  // Handle input changes
  const handleChange = (e) => {
    const { name, value, checked } = e.target

    setFormData((prevData) => {
      if (name === 'permissions') {
        // Handle permissions changes
        const updatedPermissions = checked
          ? [...prevData.permissions, value]
          : prevData.permissions.filter(
              (permission) => permission !== value
            )

        return {
          ...prevData,
          permissions: updatedPermissions,
        }
      }

      // Handle other form data changes
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
      .post(`/admin/edit/${params.id}`, props, config)
      .then(() => {
        toast.update(updateToast, {
          render: 'Updated Successfully!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
        router.push('/dashboard/admin/admins')
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
            You are will Edit this admin Status & Permissions
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

            <div className="grid grid-cols-4 items-center gap-4 mb-8 py-2 px-3 rounded-2xl">
              <Label htmlFor="name" className="font-medium text-white">
                Permissions
              </Label>
              {permissions.map((permission) => (
                <div
                  className="inline-flex items-center space-x-2"
                  key={permission.id}
                >
                  <Input
                    type="checkbox"
                    name="permissions"
                    value={permission.name}
                    onChange={handleChange}
                    className="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-amber-600 checked:border-amber-600"
                  />
                  <div className="grid gap-1.5 leading-none">
                    <label
                      htmlFor={permission.name}
                      className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    >
                      {permission.name}
                    </label>
                  </div>
                </div>
              ))}
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
