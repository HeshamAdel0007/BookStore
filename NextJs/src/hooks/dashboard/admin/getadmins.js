'use client'
import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState, useRef } from 'react'
import { toast } from 'react-toastify'

const GetAdmins = () => {
  const api = process.env.BACKEND_URL
  const toastGetAdmins = useRef(null)
  const token = localStorage.getItem('token')
  const [allAdmins, setAllAdmins] = useState()
  const [isLoading, setIsLoading] = useState(true) // Loading state

  useEffect(() => {
    // Check access and update states
    if (allAdmins !== undefined) {
      setIsLoading(false)
    }
  }, [allAdmins])

  const { data, error } = useSWR(`'${api}/admin/all-admins'`, () =>
    axios
      .get('/admin/all-admins', {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      })
      .then((response) => {
        setAllAdmins(Object.values(response.data.data.data).flat())
      })
      .catch((error) => {
        if (error.response.status == 403) {
          toastGetAdmins.login = toast.loading('Loading')
          const msg = error.response.data.message
          toast.update(toastGetAdmins.login, {
            render: msg,
            type: 'error',
            autoClose: 3000,
            isLoading: false,
          })
        }
      })
  )
  return {
    admins: data || [], // Default to an empty array if data is undefined
    allAdmins,
    isLoading,
    error,
  }
}

export default GetAdmins
