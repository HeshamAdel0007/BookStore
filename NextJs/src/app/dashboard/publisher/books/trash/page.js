'use client'
import TrashedTable from '@/components/dashboard/publisher/BookTrashTable'
import { useState, useEffect } from 'react'
import axios from '@/lib/axios'

const BookTrash = () => {
  const [isBooks, setIsBooks] = useState([])
  const token = window.localStorage.getItem('token')
  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('publisher/book/trash', config).then((response) => {
      setIsBooks(response.data.data.data.toReversed())
    })
  }, [])
  return (
    <div className="w-full">
      <div className="grid grid-cols-2 gap-4">
        <h1 className="text-3xl font-bold">Book Trashed</h1>
      </div>
      <TrashedTable books={isBooks} />
    </div>
  )
}
export default BookTrash
