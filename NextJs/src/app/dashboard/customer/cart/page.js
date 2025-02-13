'use client'
import {
  Table,
  TableHeader,
  TableBody,
  TableHead,
  TableRow,
  TableCell,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { useCart } from '@/lib/cart-context'
import { useRouter } from 'next/navigation'
import { useState } from 'react'
import Buttons from '@/components/Button'
import axios from '@/lib/axios'

const CartPage = () => {
  const { items, updateQuantity, removeItem } = useCart()
  const router = useRouter()
  const [currency, setCurrency] = useState('USD')
  const [isLoading, setIsLoading] = useState(false)
  const [error, setError] = useState('')

  const convertToNumber = (value) => {
    if (typeof value === 'number') return value
    const num = parseFloat(value)
    return isNaN(num) ? 0 : num
  }

  const total = items.reduce((sum, item) => {
    const price = convertToNumber(item.price)
    const quantity = convertToNumber(item.quantity)
    const discountValue = convertToNumber(item.discount.discount_value)
    const discountType = item.discount.discount_type

    const subtotal = price * quantity

    const discount =
      discountType === 'percentage'
        ? subtotal * (discountValue / 100)
        : discountValue
    return sum + (subtotal - discount)
  }, 0)

  const createOrder = async () => {
    try {
      setIsLoading(true)
      setError('')

      const orderData = {
        quantity: items.reduce(
          (sum, item) => sum + convertToNumber(item.quantity),
          0
        ),
        total_price: total,
        currency: currency,
        items: items.map((item) => ({
          book_id: item.id,
          product_name: item.name,
          quantity: convertToNumber(item.quantity),
          product_price: convertToNumber(item.price),
        })),
      }

      const response = await axios.post('order', orderData, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      })

      if (response.status >= 200 && response.status < 300) {
        items.forEach((item) => removeItem(item.id))
        router.push('/checkout')
      } else {
        throw new Error(response.data.message || 'Failed to create order')
      }
    } catch (error) {
      const errorMessage =
        error.response?.data?.message ||
        error.message ||
        'Failed to create order'
      setError(errorMessage)
      console.error('Order creation error:', error)
    } finally {
      setIsLoading(false)
    }
  }

  const submitForm = async (e) => {
    e.preventDefault()
    await createOrder()
  }

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-3xl font-bold mb-8">Shopping Cart</h1>

      <form onSubmit={submitForm}>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Product</TableHead>
              <TableHead>Price</TableHead>
              <TableHead>Quantity</TableHead>
              <TableHead>Discount</TableHead>
              <TableHead>Total</TableHead>
              <TableHead>Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {items.map((item) => {
              const price = convertToNumber(item.price)
              const quantity = convertToNumber(item.quantity)
              const discountValue = convertToNumber(
                item.discount.discount_value
              )
              const discountType = item.discount.discount_type
              const itemPrice = price * quantity
              const discount =
                discountType === 'percentage'
                  ? itemPrice * (discountValue / 100)
                  : discountValue
              const itemTotal = itemPrice - discount
              return (
                <TableRow key={item.id}>
                  <TableCell>{item.name}</TableCell>
                  <TableCell>${price.toFixed(2)}</TableCell>
                  <TableCell>
                    <Input
                      type="number"
                      value={quantity}
                      onChange={(e) =>
                        updateQuantity(
                          item.id,
                          convertToNumber(e.target.value)
                        )
                      }
                      className="w-20"
                      min="1"
                    />
                  </TableCell>
                  <TableCell>
                    {item.discount.discount_value}
                    {item.discount.discount_type === 'percentage'
                      ? '%'
                      : ''}
                  </TableCell>
                  <TableCell>${itemTotal.toFixed(2)}</TableCell>
                  <TableCell>
                    <Button
                      variant="destructive"
                      onClick={() => removeItem(item.id)}
                      type="button"
                    >
                      Remove
                    </Button>
                  </TableCell>
                </TableRow>
              )
            })}
          </TableBody>
        </Table>

        <div className="mt-8 space-y-4">
          <div className="flex items-center gap-4">
            <label className="text-lg font-medium">Currency:</label>
            <select
              value={currency}
              onChange={(e) => setCurrency(e.target.value)}
              className="p-2 border rounded-md w-32"
              disabled={isLoading}
            >
              <option value="USD">USD</option>
              <option value="SAR">SAR</option>
            </select>
          </div>

          {error && (
            <div className="p-3 bg-red-100 text-red-700 rounded-md">
              {error}
            </div>
          )}

          {isLoading && (
            <div className="p-3 bg-blue-100 text-blue-700 rounded-md">
              Processing your order...
            </div>
          )}

          <div className="text-right">
            <h2 className="text-2xl font-bold">
              Total: {total.toFixed(2)} {currency}
            </h2>

            <Buttons
              ButtonName={isLoading ? 'Processing...' : 'Create Order'}
              ButtonType="submit"
              onClick={createOrder}
              ButtonClass={
                'block w-full text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2'
              }
            />
          </div>
        </div>
      </form>
    </div>
  )
}

export default CartPage
