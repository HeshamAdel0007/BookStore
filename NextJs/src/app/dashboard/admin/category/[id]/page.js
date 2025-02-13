'use client'
import Button from '@/components/Button'
import { useEffect, useState } from 'react'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { toast } from 'react-toastify'
import { useRouter, useParams } from 'next/navigation'
import axios from '@/lib/axios'
import Errors from '@/components/Errors'
import { FaUser } from 'react-icons/fa'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const EditCategory = () => {
  const router = useRouter()
  const params = useParams()
  const [category, setCategory] = useState([])
  const [errors, setErrors] = useState([])
  const token = window.localStorage.getItem('token')
  const [formData, setFormData] = useState({
    name: '',
  })
  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get(`/show/category/${params.id}`, config).then((response) => {
      setCategory(response.data.data)
    })
  }, [])

  const handleChange = (e) => {
    const { name, value } = e.target
    setFormData((prevData) => {
      // Handle other form data changes
      return {
        ...prevData,
        [name]: value,
      }
    })
  }

  const createCategory = ({ ...props }) => {
    const createToast = toast.loading('Create New Category...')

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios
      .post(`/category/edit/${params.id}`, props, config)
      .then(() => {
        toast.update(createToast, {
          render: 'Update Successfully!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
        router.push('/dashboard/admin/category')
      })
      .catch((error) => {
        setErrors(Object.values(error.response.data.errors).flat())
        toast.update(createToast, {
          render: 'Error, please try again later ',
          type: 'error',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }

  const submitForm = async (e) => {
    e.preventDefault()
    createCategory({
      ...formData,
    })
  }

  return (
    <div className="w-full h-full">
      <Card>
        <CardHeader>
          <CardTitle>Hello !</CardTitle>
          <CardDescription>
            You are will Edit Category || {category.name}
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Errors
            className="mb-5 text-red text-sm font-semibold"
            errors={errors}
          />
          <form onSubmit={submitForm}>
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
                placeholder={category.name}
                autoFocus
              />
            </div>

            {/* Submit Button */}
            <Button
              ButtonName={'create'}
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

export default EditCategory
