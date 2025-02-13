'use client'
import { useEffect, useState } from 'react'
import { useForm } from 'react-hook-form'
import axios from '@/lib/axios'
import { Form } from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import Buttons from '@/components/Button'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { useCart } from '@/lib/cart-context'
import { PaymentMethodEnum } from '@/lib/enums'
import { useParams } from 'next/navigation'

const CheckoutPage = () => {
  const params = useParams()
  const { clearCart } = useCart()
  const [orderItems, setOrderItems] = useState([])
  const [error, setError] = useState('')
  const [taxRate] = useState(0.15)
  const [currency] = useState('USD')
  const [totalPrice, setTotalPrice] = useState(0)
  const [paymentStatus, setPaymentStatus] = useState('pending')
  const [isCouponDiscount, setCouponDiscount] = useState(0)
  const [isCouponDiscountType, setCouponDiscountType] =
    useState('percentage')
  const token = localStorage.getItem('token')
  const [coupon, setCoupon] = useState({
    coupon: '',
  })

  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get(`customer/order/${params.id}`, config).then((response) => {
      setOrderItems(response.data.data)
      setTotalPrice(parseFloat(response.data.data.total_price) || 0)
      console.log(response.data.data.total_price)
    })
    axios
      .get(`payment/info/${params.id}`, config)
      .then((response) => {
        setPaymentStatus('paid')
      })
      .catch((error) => {
        setPaymentStatus('pending')
      })
  }, [])

  const form = useForm({
    defaultValues: {
      name: '',
      email: '',
      address: '',
      city: '',
      cardNumber: '',
      paymentMethod: PaymentMethodEnum.CREDIT_CARD,
      expiryDate: '',
      cvc: '',
    },
  })

  const calculateTaxes = (subtotal) => (subtotal || 0) * taxRate

  const calculateDiscount = (subtotal) => {
    const discountValue = parseFloat(isCouponDiscount) || 0

    if (isCouponDiscountType === 'percentage') {
      return (subtotal || 0) * (discountValue / 100)
    } else {
      return discountValue
    }
  }

  const handleSubmit = async (data) => {
    setError('')

    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }

    try {
      const paymentData = {
        order_id: params.id,
        payment_method: data.paymentMethod,
        taxes_rate: taxRate,
        taxes_total: calculateTaxes(totalPrice),
        currency: currency,
        order_amount: totalPrice,
        coupon_code: coupon.coupon || 0,
        total_price: (
          (totalPrice || 0) +
          calculateTaxes(totalPrice) -
          calculateDiscount(totalPrice)
        ).toFixed(2),
        card_details: {
          number: data.cardNumber,
          expiry: data.expiryDate,
          cvc: data.cvc,
        },
      }

      await axios
        .post(`payment/${params.id}`, paymentData, config)
        .then((response) => {
          console.log(response)
        })

      clearCart()
    } catch (error) {
      const errorMessage = error.response?.data?.message || error.message
      setError(errorMessage)
      console.error('Checkout Error:', error)
    } finally {
    }
  }

  const handleChange = (e) => {
    setCoupon({
      ...coupon,
      [e.target.name]: e.target.value,
    })
  }

  const checkCoupon = async (e) => {
    e.preventDefault()
    setError('')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios
      .get(`coupon/${coupon.coupon}`, config)
      .then((response) => {
        setCouponDiscount(response.data.data.discount_value)
        setCouponDiscountType(response.data.data.discount_type)
        console.log(response)
      })
      .catch((error) => {
        const errorMessage = error.response?.data?.message || error.message
        setError(errorMessage)
      })
  }

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-3xl font-bold mb-8">Checkout</h1>
      <form onSubmit={checkCoupon}>
        <Input
          id="coupon"
          name="coupon"
          type="text"
          value={coupon.coupon}
          className="pl-2 w-full outline-none border-none"
          onChange={handleChange}
          placeholder="Enter coupon code (optional)"
          autoFocus
        />
        <Buttons
          ButtonName={'Check Coupon'}
          ButtonType="submit"
          ButtonClass={
            'block w-full text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2'
          }
        />
      </form>
      {/* Order Summary */}
      <div className="mt-6 p-4 bg-black rounded-lg">
        <h3 className="text-lg font-semibold mb-2">Order Summary</h3>
        <div className="space-y-2">
          <p>Subtotal: ${(totalPrice || 0).toFixed(2)}</p>

          <p>
            Taxes ({taxRate * 100}%): $
            {calculateTaxes(totalPrice).toFixed(2)}
          </p>

          <p>
            Discount
            {isCouponDiscountType === 'percentage'
              ? `(${isCouponDiscount}%)`
              : `($${(parseFloat(isCouponDiscount) || 0).toFixed(2)})`}
            : -${calculateDiscount(totalPrice).toFixed(2)}{' '}
          </p>
          <p>
            Total: $
            {(
              (totalPrice || 0) +
              calculateTaxes(totalPrice) -
              calculateDiscount(totalPrice)
            ).toFixed(2)}
          </p>
        </div>
      </div>

      {!orderItems || orderItems.length === 0 ? (
        <p className="text-center mt-4 text-gray-500">
          No items in your cart.
        </p>
      ) : (
        <Form {...form}>
          <form
            onSubmit={form.handleSubmit(handleSubmit)}
            className="space-y-6"
          >
            <div className="grid mt-4 md:grid-cols-2 gap-6">
              {/* Shipping Information */}
              <div>
                <h2 className="text-xl font-semibold mb-4">
                  Shipping Information
                </h2>

                <Input
                  label="Full Name"
                  required
                  placeholder="Enter your full name"
                  className="pl-2 mt-2 w-full outline-none border-none"
                  {...form.register('name', {
                    required: 'Name is required',
                  })}
                />

                <Input
                  label="Email"
                  type="email"
                  required
                  placeholder="Enter your email address"
                  className="pl-2 mt-2 w-full outline-none border-none"
                  {...form.register('email', {
                    required: 'Email is required',
                    pattern: {
                      value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                      message: 'Invalid email address',
                    },
                  })}
                />

                <Input
                  label="Address"
                  required
                  placeholder="Enter your shipping address"
                  className="pl-2 mt-2 w-full outline-none border-none"
                  {...form.register('address', {
                    required: 'Address is required',
                  })}
                />

                <Input
                  label="City"
                  required
                  placeholder="Enter your city"
                  className="pl-2 mt-2 w-full outline-none border-none"
                  {...form.register('city', {
                    required: 'City is required',
                  })}
                />
              </div>

              {/* Payment Details */}
              <div>
                <h2 className="text-xl font-semibold mb-4">
                  Payment Details
                </h2>
                <Select
                  onValueChange={(value) =>
                    form.setValue('paymentMethod', value)
                  }
                  defaultValue={PaymentMethodEnum.CREDIT_CARD}
                >
                  <SelectTrigger className="w-full mt-4 pl-2 outline-none border-none">
                    <SelectValue placeholder="Select payment method" />
                  </SelectTrigger>
                  <SelectContent>
                    {Object.values(PaymentMethodEnum).map((method) => (
                      <SelectItem key={method} value={method}>
                        {method.replace(/_/g, ' ')}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>

                {form.watch('paymentMethod') ===
                  PaymentMethodEnum.CREDIT_CARD && (
                  <>
                    <Input
                      label="Card Number"
                      required
                      placeholder="Enter card number"
                      className="pl-2 mt-2 w-full outline-none border-none"
                      {...form.register('cardNumber', {
                        required: 'Card number is required',
                        pattern: {
                          value: /^[0-9]{16}$/,
                          message: 'Invalid card number',
                        },
                      })}
                    />

                    <div className="grid grid-cols-2 gap-4 mt-4">
                      <Input
                        label="Expiry Date"
                        placeholder="MM/YY"
                        required
                        className="pl-2 mt-2 w-full outline-none border-none"
                        {...form.register('expiryDate', {
                          required: 'Expiry date is required',
                          pattern: {
                            value: /^(0[1-9]|1[0-2])\/?([0-9]{2})$/,
                            message: 'Invalid expiry date',
                          },
                        })}
                      />
                      <Input
                        label="CVC"
                        placeholder="123"
                        required
                        className="pl-2 mt-2 w-full outline-none border-none"
                        {...form.register('cvc', {
                          required: 'CVC is required',
                          pattern: {
                            value: /^[0-9]{3,4}$/,
                            message: 'Invalid CVC',
                          },
                        })}
                      />
                    </div>
                  </>
                )}
              </div>
            </div>

            {error && (
              <div className="text-red-500 text-sm mt-4">{error}</div>
            )}

            <Button
              type="submit"
              className="mt-8 w-full"
              disabled={paymentStatus === 'pending'}
            >
              {paymentStatus === 'pending'
                ? 'this order paid before this time'
                : 'Confirm Payment'}
            </Button>
          </form>
        </Form>
      )}
    </div>
  )
}

export default CheckoutPage
