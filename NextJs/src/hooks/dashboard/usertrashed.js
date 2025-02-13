'use client'
import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState, useRef } from 'react'
import { toast } from 'react-toastify'

const UserTrashed = ({ userTrash = '' }) => {
  const api = process.env.BACKEND_URL
  const toastGetTrashed = useRef(null)
  const token = localStorage.getItem('token')
  const [allUserTrashed, setAllUserTrashed] = useState()
  const [isLoading, setIsLoading] = useState(true) // Loading state
  const [isEmpty, setIsEmpty] = useState(false)

  useEffect(() => {
    // Check access and update states
    if (allUserTrashed !== undefined) {
      setIsLoading(false)
    }
  }, [allUserTrashed])

  const { data, error } = useSWR(`'${api}/admin/${userTrash}/trash'`, () =>
    axios
      .get(`/admin/${userTrash}/trash`, {
        headers: {
          Authorization: 'Bearer ' + token,
        },
      })
      .then((response) => {
        if (response.data.data.length == 0) {
          setIsEmpty(true)
        }
        setAllUserTrashed(Object.values(response.data.data.data).flat())
      })
      .catch((error) => {
        if (error.response.status == 403) {
          toastGetTrashed.login = toast.loading('Loading')
          const msg = error.response.data.message
          toast.update(toastGetTrashed.login, {
            render: msg,
            type: 'error',
            autoClose: 3000,
            isLoading: false,
          })
        }
      })
  )
  return {
    users: data || [], // Default to an empty array if data is undefined
    allUserTrashed,
    isLoading,
    isEmpty,
    error,
  }
}

export default UserTrashed
