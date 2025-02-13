'use client'
import axios from '@/lib/axios'
import { useEffect, useState } from 'react'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardDescription,
  CardTitle,
  CardFooter,
} from '@/components/ui/card'
import Link from 'next/link'

const Orders = () => {
  const [isOrders, setIsOrders] = useState([])
  useEffect(() => {
    const token = localStorage.getItem('token')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('/publisher/publisher/orders', config).then((response) => {
      setIsOrders(response.data.data.data)
    })
  }, [])
  return (
    <div className="container mx-auto p-4">
      <div className="grid grid-cols-3 md:grid-cols-3 gap-6">
        {isOrders.map((order) => (
          <Card
            key={order.id}
            className="p-4 hover:shadow-lg transition-shadow"
          >
            <CardTitle className="text-xl font-semibold">
              Customer: {order.customer.name}
            </CardTitle>
            <CardDescription className="mt-4">
              <span className="text-gray-600 mt-4">
                Quantity: {order.quantity}
              </span>
              <span className="text-yellow block mt-2">
                Price: {order.total_price} {order.currency}
              </span>
            </CardDescription>
            <CardFooter className="mt-4 w-full">
              <Link href={`orders/${order.id}`}>
                <Button>Details</Button>
              </Link>
            </CardFooter>
          </Card>
        ))}
      </div>
    </div>
  )
}

export default Orders
