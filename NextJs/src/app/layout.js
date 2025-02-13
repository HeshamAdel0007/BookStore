'use client'
import Link from 'next/link'
import { CartProvider } from '@/lib/cart-context'
import 'react-toastify/dist/ReactToastify.css'
import '@/styles/css/globals.css'
import dynamic from 'next/dynamic'

const ToastContainer = dynamic(
  () => import('react-toastify').then((mod) => mod.ToastContainer),
  { ssr: false }
)
const Bounce = dynamic(
  () => import('react-toastify').then((mod) => mod.Bounce),
  { ssr: false }
)

export default function RootLayout({ children }) {
  const AppName = process.env.NEXT_PUBLIC_APP_NAME

  return (
    <html lang="en" className="dark">
      <body>
        <CartProvider>
          <main className="min-h-screen p-4">
            <nav className="mb-8 container mx-auto flex justify-between items-center">
              <h1 className="text-2xl font-bold">{AppName}</h1>
              <div className="flex gap-4">
                <Link href="/" className="hover:text-white">
                  Home
                </Link>
                <Link
                  href="/dashboard/customer/cart"
                  className="hover:text-white"
                >
                  Cart
                </Link>
                <Link href="/login" className="hover:text-white">
                  Login
                </Link>
                <Link href="/register" className="hover:text-white">
                  Register
                </Link>
              </div>
            </nav>
            {children}
          </main>
        </CartProvider>

        <ToastContainer
          position="top-left"
          autoClose={5000}
          hideProgressBar={false}
          newestOnTop={false}
          closeOnClick
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
          theme="light"
          transition={Bounce}
        />
      </body>
    </html>
  )
}
