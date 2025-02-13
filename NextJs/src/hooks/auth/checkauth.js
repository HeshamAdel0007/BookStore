'use client'
import { useRouter } from 'next/navigation'
import { useEffect, useState } from 'react'

/**
 * check if user authentication or not
 */
const CheckAuth = () => {
  const router = useRouter()
  const [isLoading, setIsLoading] = useState(true) // Loading state
  const [isAuthorized, setIsAuthorized] = useState(false) // Authorization state

  useEffect(() => {
    const checkAccess = () => {
      const token = localStorage.getItem('token')
      const role = localStorage.getItem('role')
      if (!token) {
        // Redirect to login if not authenticated
        // router.push('/login')
        return false
      }

      if (
        ['admin', 'publisher', 'customer', 'super-admin'].includes(role)
      ) {
        router.push(`/dashboard/${role}`)
        return true // User is authorized as [admin,publisher or customer]
      }

      return false // User is not [ admin,publisher or customer]
    }

    // Check access and update states
    const isUserAuthorized = checkAccess()
    setIsAuthorized(isUserAuthorized)
    setIsLoading(false)
  }, [router])

  return { isAuthorized, isLoading }
}

export default CheckAuth
