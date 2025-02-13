'use client'
import LoginSelection from '@/components/auth/LoginSelection'
import userAuth from '@/hooks/auth/checkauth'
import Link from 'next/link'

const LoginAs = () => {
  const { isAuthorized, isLoading } = userAuth()

  // Loading state
  if (isLoading) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <p>Loading, please wait...</p>
      </div>
    )
  }

  // Unauthorized state
  if (isAuthorized) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <p>
          Sorry, you don't have permission to access this page.
          Redirecting...
          <Link href="/">Click here</Link>
        </p>
      </div>
    )
  }

  // If user is not authenticated, show the login selection
  return (
    <div>
      <LoginSelection />
    </div>
  )
}

export default LoginAs
