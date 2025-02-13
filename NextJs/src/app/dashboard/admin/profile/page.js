'use client'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { FaUser } from 'react-icons/fa'
import { MdOutlineAlternateEmail } from 'react-icons/md'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { useEffect, useState } from 'react'
import axios from '@/lib/axios'

const Profile = () => {
  const [adminInfo, setAdminInfo] = useState([])
  const token = window.localStorage.getItem('token')

  useEffect(() => {
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    axios.get('/admin/profile', config).then((response) => {
      setAdminInfo(response.data.data)
    })
  }, [])

  return (
    <div className="w-full h-full">
      <Card>
        <CardHeader>
          <CardTitle>Hello !</CardTitle>
          <CardDescription>You are will create new admin</CardDescription>
        </CardHeader>
        <CardContent>
          {/* Name  */}
          <Label htmlFor="name">Name</Label>
          <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
            <FaUser className="h-5 w-5 text-gray-400" />
            <Input
              id="name"
              name="name"
              type="text"
              className="pl-2 w-full outline-none border-none"
              defaultValue={adminInfo.name}
              disabled
            />
          </div>
          {/* Email*/}
          <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
            <MdOutlineAlternateEmail className="h-5 w-5 text-gray-400" />
            <Input
              id="email"
              name="email"
              type="email"
              defaultValue={adminInfo.email}
              className="pl-2 w-full outline-none border-none"
              disabled
            />
          </div>
          {/* Phone  */}
          <Label htmlFor="name">Phone</Label>
          <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
            <FaUser className="h-5 w-5 text-gray-400" />
            <Input
              id="phone"
              name="phone"
              type="text"
              className="pl-2 w-full outline-none border-none"
              defaultValue={adminInfo.phone}
              disabled
            />
          </div>
          {/* Status  */}
          <Label htmlFor="name">Status</Label>
          <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
            <FaUser className="h-5 w-5 text-gray-400" />
            <Input
              id="status"
              name="status"
              type="text"
              className="pl-2 w-full outline-none border-none"
              defaultValue={adminInfo.status}
              disabled
            />
          </div>

          {/* Role  */}
          <Label htmlFor="name">Role</Label>
          <div className="flex items-center border-2 mb-8 py-2 px-3 rounded-2xl">
            <FaUser className="h-5 w-5 text-gray-400" />
            <Input
              id="role"
              name="role"
              type="text"
              className="pl-2 w-full outline-none border-none"
              defaultValue={adminInfo.role}
              disabled
            />
          </div>
          <div className="grid grid-cols-4 items-center gap-4 mb-8 py-2 px-3 rounded-2xl">
            <Label htmlFor="name" className="font-medium text-white">
              Permissions
            </Label>
            {adminInfo.permissions}
          </div>
        </CardContent>
      </Card>
    </div>
  )
}

export default Profile
