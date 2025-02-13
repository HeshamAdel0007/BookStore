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
  const [isOrders, setIsOrders] = useState([])

  useEffect(() => {
    const token = window.localStorage.getItem('token')

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }

    axios.get('customer/orders', config).then((response) => {
      setIsOrders(response.data.data || [])
    })
  }, [])

  return (
    <div className="grid grid-cols-4 gap-4">
      {isOrders.map((order, index) => (
        <div key={order.id}>
          <Card>
            <CardHeader>
              <CardTitle>Order {index + 1}</CardTitle>
            </CardHeader>
            <CardContent>
              <span className="block">Quantity: {order.quantity}</span>
              <span className="block">
                Price: {order.total_price} {order.currency}
              </span>
              <span className="block">
                date: {order.created_at.split('T')[0]}
              </span>
            </CardContent>
            <CardFooter>
              <Link
                className="block w-full text-center text-black bg-yellow mt-2 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold"
                href={`customer/order/${order.id}`}
              >
                show
              </Link>
            </CardFooter>
          </Card>
        </div>
      ))}
    </div>
  )
}

export default DashboardCard
