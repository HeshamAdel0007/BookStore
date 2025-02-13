'use client'
import { useEffect, useState } from 'react'
import { useSearchParams, useRouter } from 'next/navigation'
import { Button } from '@/components/ui/button'
import { Rating } from '@/components/ui/rating/page'
import { useCart } from '@/lib/cart-context'
import axios from '@/lib/axios'
import {
  Card,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const Products = () => {
  const [isProducts, setIsProducts] = useState([])
  const [totalPages, setTotalPages] = useState(1)
  const { addToCart } = useCart()
  const router = useRouter()
  const searchParams = useSearchParams()
  const currentPage = Number(searchParams.get('page')) || 1
  const limit = 10

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `/books?page=${currentPage}&limit=${limit}`
        )

        const responseData = response.data.data
        setIsProducts(responseData.data)
        setTotalPages(responseData.last_page)

        // Update URL without page reload
        const params = new URLSearchParams(searchParams)
        params.set('page', currentPage)
        router.replace(`?${params.toString()}`, { scroll: false })
      } catch (error) {
        console.error('Error fetching products:', error)
      }
    }

    fetchData()
  }, [currentPage, searchParams, router])

  const handleAddToCart = (product, stock_quantity) => {
    if (stock_quantity != 0) {
      addToCart(product)
    }
  }

  const handlePageChange = (newPage) => {
    const validPage = Math.max(1, Math.min(newPage, totalPages))
    const params = new URLSearchParams(searchParams)
    params.set('page', validPage)
    router.push(`?${params.toString()}`, { scroll: false })
  }

  return (
    <>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {isProducts.map((product) => (
          <Card
            key={product.id}
            className="p-4 hover:shadow-lg transition-shadow"
          >
            <CardHeader>
              <img
                src={product.image}
                alt={product.name}
                className="w-full h-48 object-cover mb-4 rounded-lg"
              />
            </CardHeader>
            <CardTitle className="text-xl font-semibold">
              {product.name}
            </CardTitle>
            <CardDescription>
              {product.stock_quantity != 0 ? (
                <span className="text-gray-600 mt-4">in-Stock</span>
              ) : (
                <span className="text-gray-600 mt-4">Out-OfStock</span>
              )}
              <Rating rating={product.average_rating} className="mt-2" />
              <span className="text-gray-600 block mt-2">
                ${product.price}
              </span>
              <span className="text-gray-600 block mt-2">
                Discount: {product.discount.discount_value}
                {product.discount.discount_type == 'percentage' ? '%' : ''}
              </span>
              <span className="text-yellow block mt-2">
                Price:
                {product.discount.discount_type === 'percentage'
                  ? (
                      product.price -
                      product.price *
                        (product.discount.discount_value / 100)
                    ).toFixed(2)
                  : (
                      product.price - product.discount.discount_value
                    ).toFixed(2)}
              </span>
            </CardDescription>
            <CardFooter>
              <Button
                className="mt-4 w-full"
                onClick={() =>
                  handleAddToCart(product, product.stock_quantity)
                }
              >
                Add to Cart
              </Button>
            </CardFooter>
          </Card>
        ))}

        {isProducts.length === 0 && (
          <div className="text-center py-12 text-gray-500">
            No products found matching your criteria
          </div>
        )}
      </div>

      {/* Pagination Controls */}
      <div className="flex justify-center mt-8 space-x-2">
        <Button
          onClick={() => handlePageChange(currentPage - 1)}
          disabled={currentPage === 1}
        >
          Previous
        </Button>
        <span className="flex items-center px-4">
          Page {currentPage} of {totalPages}
        </span>
        <Button
          onClick={() => handlePageChange(currentPage + 1)}
          disabled={currentPage === totalPages}
        >
          Next
        </Button>
      </div>
    </>
  )
}

export default Products
