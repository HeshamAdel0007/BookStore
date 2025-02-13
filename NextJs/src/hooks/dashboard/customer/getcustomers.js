'use client'
import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState, useRef } from 'react'
import { toast } from 'react-toastify'

const GetCustomers = () => {
  const api = process.env.BACKEND_URL
  const toastGetCustomers = useRef(null)
  const token = localStorage.getItem('token')
  const [allCustomers, setAllCustomers] = useState()
  const [isLoading, setIsLoading] = useState(true) // Loading state

  useEffect(() => {
    // Check access and update states
    if (allCustomers !== undefined) {
      setIsLoading(false)
    }
  }, [allCustomers])

  const { data, error } = useSWR(`'${api}/admin/all-customers'`, () =>
    axios
      .get('/admin/all-customers', {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      })
      .then((response) => {
        setAllCustomers(Object.values(response.data.data.data).flat())
      })
      .catch((error) => {
        if (error.response.status == 403) {
          toastGetCustomers.login = toast.loading('Loading')
          const msg = error.response.data.message
          toast.update(toastGetCustomers.login, {
            render: msg,
            type: 'error',
            autoClose: 3000,
            isLoading: false,
          })
        }
      })
  )
  return {
    customers: data || [], // Default to an empty array if data is undefined
    allCustomers,
    isLoading,
    error,
  }
}

export default GetCustomers
