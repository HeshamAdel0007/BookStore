'use client'
import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState, useRef } from 'react'
import { toast } from 'react-toastify'

const GetPublishers = () => {
  const api = process.env.BACKEND_URL
  const toastGetPublishers = useRef(null)
  const token = localStorage.getItem('token')
  const [allPublishers, setAllPublishers] = useState()
  const [isLoading, setIsLoading] = useState(true) // Loading state

  useEffect(() => {
    // Check access and update states
    if (allPublishers !== undefined) {
      setIsLoading(false)
    }
  }, [allPublishers])

  const { data, error } = useSWR(`'${api}/admin/all-publishers'`, () =>
    axios
      .get('/admin/all-publishers', {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      })
      .then((response) => {
        setAllPublishers(Object.values(response.data.data.data).flat())
      })
      .catch((error) => {
        if (error.response.status == 403) {
          toastGetPublishers.login = toast.loading('Loading')
          const msg = error.response.data.message
          toast.update(toastGetPublishers.login, {
            render: msg,
            type: 'error',
            autoClose: 3000,
            isLoading: false,
          })
        }
      })
  )
  return {
    publishers: data || [], // Default to an empty array if data is undefined
    allPublishers,
    isLoading,
    error,
  }
}

export default GetPublishers
