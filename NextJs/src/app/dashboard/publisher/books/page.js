'use client'
import Image from 'next/image'
import BookImg from '@/../public/assets/images/profile-avatar.jpg'
import { useEffect, useState } from 'react'
import axios from '@/lib/axios'
import Link from 'next/link'
import { toast } from 'react-toastify'
import {
  Card,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const Books = () => {
  const [isBooks, setIsBooks] = useState([])
  const token = window.localStorage.getItem('token')
  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('publisher/publisher/books', config).then((response) => {
      setIsBooks(response.data.data.books.toReversed())
    })
  }, [])

  const deleteBooks = async (id) => {
    const deleteToast = toast.loading('Delete Books...')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    await axios.delete(`/publisher/book/delete/${id}`, config).then(() => {
      toast.update(deleteToast, {
        render: 'Delete Successfully!',
        type: 'success',
        autoClose: 3000,
        isLoading: false,
      })
      window.location.reload('/dashboard/publisher/books')
    })
  }
  return (
    <div>
      <div className="grid grid-cols-4 gap-4">
        {isBooks.map((book) => (
          <div key={book.id}>
            <Card>
              <Image
                src={BookImg}
                width={250}
                height={200}
                alt={book.name}
              />
              <CardHeader>
                <CardTitle>{book.slug}</CardTitle>
              </CardHeader>
              <CardFooter>
                <Link
                  className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
                  href={`books/${book.id}/${book.slug}`}
                >
                  Edit
                </Link>
                <button
                  onClick={() => deleteBooks(book.id)}
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

export default Books
