'use client'
import Sidebar from '@/components/dashboard/customer/Sidebar'
import userAuth from '@/hooks/auth/checkauth'
import Link from 'next/link'

const CustomerDashboardLayout = ({ children }) => {
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
  if (!isAuthorized) {
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
  return (
    <div className="flex h-screen bg-black">
      {/* Sidebar */}
      <Sidebar />
      <div className="flex-1 flex flex-col">
        {/* Main content area */}
        <main className="flex p-6 h-full">{children}</main>
      </div>
    </div>
  )
}

export default CustomerDashboardLayout
