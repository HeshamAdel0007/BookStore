'use client'
import axios from '@/lib/axios'
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardFooter,
} from '@/components/ui/card'
import { useEffect, useState } from 'react'
import Link from 'next/link'

const DashboardCard = () => {
  const [isPublisher, setIsPublisher] = useState([])
  const token = window.localStorage.getItem('token')

  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('/publisher/publisher', config).then((response) => {
      setIsPublisher(response.data.data)
    })
  }, [])

  return (
    <div className="grid grid-cols-4 gap-4">
      <div>
        <Card>
          <CardHeader>
            <CardTitle>Books</CardTitle>
          </CardHeader>
          <CardContent>BooksCount: {isPublisher.books_number}</CardContent>
        </Card>
      </div>
      <div>
        <Card>
          <CardHeader>
            <CardTitle>Orders</CardTitle>
          </CardHeader>
          <CardContent>OrdersCount: {isPublisher.orders}</CardContent>
          <CardFooter>
            <Link
              className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
              href={'publisher/orders'}
            >
              orders
            </Link>
          </CardFooter>
        </Card>
      </div>
      <div>
        <Card>
          <CardHeader>
            <CardTitle>Trash</CardTitle>
          </CardHeader>
          <CardContent>
            BookTrashed: {isPublisher.books_trashed}
          </CardContent>
          <CardFooter>
            <Link
              className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
              href={'publisher/books/trash'}
            >
              Trash
            </Link>
          </CardFooter>
        </Card>
      </div>
    </div>
  )
}
export default DashboardCard
