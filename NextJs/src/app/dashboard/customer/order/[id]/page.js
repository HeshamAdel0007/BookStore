'use client'
import axios from '@/lib/axios'
import { useParams } from 'next/navigation'
import { useEffect, useState } from 'react'
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import Link from 'next/link'

const item = () => {
  const params = useParams()
  const [isItems, setIsItems] = useState([])
  const token = window.localStorage.getItem('token')

  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get(`customer/order/${params.id}`, config).then((response) => {
      setIsItems(response.data.data.items)
      console.log(response.data.data)
    })
  }, [])

  return (
    <div>
      <h3 className="block text-lg font-semibold mb-2">Order Summary</h3>
      <div className="grid grid-cols-3 gap-4">
        {isItems.map((item) => (
          <div key={item.id}>
            <Card>
              <CardHeader>
                <CardTitle>BookName: {item.product_name}</CardTitle>
              </CardHeader>
              <CardContent>
                <span className="block">Quantity: {item.quantity}</span>
                <span className="block">
                  ProductPrice: {item.product_price}
                </span>
                <span className="block">Discount: {item.discount}</span>
                <span className="block">
                  TotalPrice: {item.total_price}
                </span>
              </CardContent>
            </Card>
          </div>
        ))}
      </div>
      <Link
        className="block w-full text-center text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2"
        href={`/checkout/${params.id}`}
      >
        CheckOut
      </Link>
    </div>
  )
}

export default item
