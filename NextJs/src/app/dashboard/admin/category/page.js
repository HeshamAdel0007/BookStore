'use client'
import { useEffect, useState } from 'react'
import axios from '@/lib/axios'
import Link from 'next/link'
import { toast } from 'react-toastify'
import {
  Card,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const Category = () => {
  const [allCategory, setAllCategories] = useState([])
  const token = window.localStorage.getItem('token')
  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('/categories', config).then((response) => {
      setAllCategories(response.data.data)
    })
  }, [])

  const deleteCategory = async (id) => {
    const deleteToast = toast.loading('Delete Category...')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    await axios.delete(`/category/delete/${id}`, config).then(() => {
      toast.update(deleteToast, {
        render: 'Delete Successfully!',
        type: 'success',
        autoClose: 3000,
        isLoading: false,
      })
      window.location.reload('/dashboard/admin/category')
    })
  }

  return (
    <div>
      <Card className="mb-8">
        <CardHeader>
          <CardTitle>Create Category</CardTitle>
        </CardHeader>
        <CardFooter>
          <Link
            className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
            href="category/create"
          >
            Create
          </Link>
        </CardFooter>
      </Card>
      <div className="grid grid-cols-4 gap-4">
        {allCategory.map((category) => (
          <div key={category.id}>
            <Card>
              <CardHeader>
                <CardTitle>{category.name}</CardTitle>
                <CardDescription>
                  Books: {category.books_count}
                </CardDescription>
              </CardHeader>
              <CardFooter>
                <Link
                  className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
                  href={`category/${category.id}`}
                >
                  Edit
                </Link>
                <button
                  onClick={() => deleteCategory(category.id)}
                  className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
                  type="submit"
                >
                  Delete
                </button>
              </CardFooter>
            </Card>
          </div>
        ))}
      </div>
    </div>
  )
}

export default Category
