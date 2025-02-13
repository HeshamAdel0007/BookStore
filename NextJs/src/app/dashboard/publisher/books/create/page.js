'use client'
import Button from '@/components/Button'
import { useEffect, useState } from 'react'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { toast } from 'react-toastify'
import axios from '@/lib/axios'
import Errors from '@/components/Errors'
import {
  MdDriveFileRenameOutline,
  MdOutlineProductionQuantityLimits,
} from 'react-icons/md'
import { FaDollarSign, FaAudioDescription } from 'react-icons/fa'
import { IoIosBarcode } from 'react-icons/io'
import { BsFillCalendar2DateFill } from 'react-icons/bs'
import { FaFileImage } from 'react-icons/fa6'
import { Textarea } from '@/components/ui/textarea'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const CreateBook = () => {
  const [categories, setCategories] = useState([])
  const [errors, setErrors] = useState([])
  const token = window.localStorage.getItem('token')
  const [formData, setFormData] = useState({
    name: '',
    price: '',
    category_id: '',
    published_date: '',
    isbn: '',
    stock_quantity: '',
    book_cover: '',
    description: '',
  })
  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('categories', config).then((response) => {
      setCategories(response.data.data)
    })
  }, [])

  const handleChange = (e) => {
    const { name, value, checked, files } = e.target

    setFormData((prevData) => {
      if (name === 'categories') {
        // Handle categories changes
        const updatedCategories = checked
          ? [...prevData.categories, value]
          : prevData.categories.filter((category) => category !== value)

        return {
          ...prevData,
          categories: updatedCategories,
        }
      }

      if (name === 'book_cover') {
        return {
          ...prevData,
          [name]: files[0],
        }
      }

      // Handle other form data changes
      return {
        ...prevData,
        [name]: value,
      }
    })
  }
  const createBook = ({ ...props }) => {
    const createToast = toast.loading('Create Book...')

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'multipart/form-data',
      },
    }
    axios
      .post(`/publisher/book/create`, props, config)
      .then(() => {
        toast.update(createToast, {
          render: 'Create Book Successfully!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
        router.push('/dashboard/publisher')
      })
      .catch((error) => {
        if (
          error.response &&
          error.response.data &&
          error.response.data.errors
        ) {
          setErrors(Object.values(error.response.data.errors).flat())
          toast.update(createToast, {
            render: 'Error, please try again later ',
            type: 'error',
            autoClose: 3000,
            isLoading: false,
          })
        }
      })
  }
  const submitForm = async (e) => {
    e.preventDefault()
    createBook({
      ...formData,
    })
  }
  return (
    <div className="w-full h-full">
      <Card>
        <CardHeader>
          <CardTitle>Hello !</CardTitle>
          <CardDescription>You are will Create New Book</CardDescription>
        </CardHeader>
        <CardContent>
          <Errors
            className="mb-5 text-red text-sm font-semibold"
            errors={errors}
          />
          <form
            onSubmit={submitForm}
            method="POST"
            encType="multipart/form-data"
          >
            {/* Name Input */}
            <Label htmlFor="name">Name</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <MdDriveFileRenameOutline className="h-5 w-5 text-gray-400" />
              <Input
                id="name"
                name="name"
                type="text"
                value={formData.name}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="BookName"
                autoFocus
              />
            </div>
            {/* Price Input */}
            <Label htmlFor="Price">Price</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <FaDollarSign className="h-5 w-5 text-gray-400" />
              <Input
                id="price"
                name="price"
                type="number"
                min="0.00"
                max="10000.00"
                step="0.01"
                value={formData.price}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Book Price"
                autoFocus
              />
            </div>
            {/* Quantity Input */}
            <Label htmlFor="Quantity">Quantity</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <MdOutlineProductionQuantityLimits className="h-5 w-5 text-gray-400" />
              <Input
                id="stock_quantity"
                name="stock_quantity"
                type="number"
                min="1"
                max="10000"
                step="any"
                value={formData.stock_quantity}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Stock Quantity"
                autoFocus
              />
            </div>
            {/* Isbn Input */}
            <Label htmlFor="Quantity">Isbn</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <IoIosBarcode className="h-5 w-5 text-gray-400" />
              <Input
                id="isbn"
                name="isbn"
                type="text"
                value={formData.isbn}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Book Isbn"
              />
            </div>
            {/* Published Date Input */}
            <Label htmlFor="Published Date">Published Date</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <BsFillCalendar2DateFill className="h-5 w-5 text-gray-400" />
              <Input
                id="published_date"
                name="published_date"
                type="text"
                value={formData.published_date}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="YY / MM / DD"
              />
            </div>
            {/* Category radioButton */}
            <div className="grid grid-cols-4 items-center gap-4 mb-8 py-2 px-3 rounded-2xl">
              <Label htmlFor="name" className="font-medium text-white">
                Categories
              </Label>
              {categories.map((category) => (
                <div
                  className="inline-flex items-center space-x-2"
                  key={category.id}
                >
                  <Input
                    type="radio"
                    name="category_id"
                    value={category.id}
                    onChange={handleChange}
                    className="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-amber-600 checked:border-amber-600"
                  />
                  <div className="grid gap-1.5 leading-none">
                    <label
                      htmlFor={category.name}
                      className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    >
                      {category.name}
                    </label>
                  </div>
                </div>
              ))}
            </div>
            {/* Photo Input */}
            <Label htmlFor="Photo">Photo</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <FaFileImage className="h-5 w-5 text-gray-400" />
              <Input
                id="book_cover"
                name="book_cover"
                type="file"
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
              />
            </div>

            {/* Description Input */}
            <Label htmlFor="Description">Description</Label>
            <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
              <FaAudioDescription className="h-5 w-5 text-gray-400" />
              <Textarea
                id="description"
                name="description"
                value={formData.description}
                className="pl-2 w-full outline-none border-none"
                onChange={handleChange}
                placeholder="Book Description"
              />
            </div>
            {/* Submit Button */}
            <Button
              ButtonName={'Add Book'}
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

export default CreateBook
