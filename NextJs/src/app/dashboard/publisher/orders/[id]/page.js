'use client'
import axios from '@/lib/axios'
import { useEffect, useState } from 'react'
import { Card, CardDescription, CardTitle } from '@/components/ui/card'
import { useParams } from 'next/navigation'

const Order = () => {
  const params = useParams()
  const [isOrderItems, setIsOrderItems] = useState([])
  useEffect(() => {
    const token = localStorage.getItem('token')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios
      .get(`/publisher/publisher/order/info/${params.id}`, config)
      .then((response) => {
        setIsOrderItems(response.data.data)
      })
  }, [])
  return (
    <div className="container mx-auto p-4">
      <div className="grid grid-cols-3 md:grid-cols-3 gap-6">
        {isOrderItems.map((item) => (
          <Card
            key={item.id}
            className="p-4 hover:shadow-lg transition-shadow"
          >
            <CardTitle className="text-xl font-semibold">
              Name: {item.product_name}
            </CardTitle>
            <CardDescription className="mt-4">
              <span className="text-gray-600 block mt-1">
                Quantity: {item.quantity}
              </span>
              <span className="text-gray-600 block mt-1">
                ProductPrice: {item.product_price}
              </span>
              <span className="text-gray-600 block mt-1">
                Discount: {item.discount}
              </span>
              <span className="text-yellow block mt-4">
                TotalPrice: {item.main_total_price}
              </span>
            </CardDescription>
          </Card>
        ))}
      </div>
    </div>
  )
}

export default Order
