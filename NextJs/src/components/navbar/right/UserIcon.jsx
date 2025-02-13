import Link from 'next/link'
import { useState } from 'react'
import { FaUserAlt } from 'react-icons/fa'

const UserIcon = () => {
  const [isDropdown, setDropdown] = useState(false)

  const handleChange = (e) => {
    e.preventDefault()
    setDropdown(!isDropdown)
  }
  return (
    <>
      <div
        onClick={handleChange}
        className="flex absolute hover:text-yellow duration-300 cursor-pointer"
      >
        <FaUserAlt />
        <div
          className={
            isDropdown
              ? 'z-50 ml-[-12rem] rounded mt-10 w-[10rem] overflow-hidden relative bg-menu translate-x-12 transition-all duration-300 opacity-100'
              : 'hidden transition-all duration-300 translate-x-12'
          }
        >
          <Link
            href="admin/profile"
            className="hover:bg-yellow border-b border-gray-600 py-2 hover:text-black font-medium w-full flex transition-all duration-300"
          >
            <span className="pl-2">profile</span>
          </Link>
          <Link
            href="/profile"
            className="hover:bg-yellow border-b border-gray-600 py-2 hover:text-black font-medium w-full flex transition-all duration-300"
          >
            <span className="pl-2">profile</span>
          </Link>
        </div>
      </div>
    </>
  )
}

export default UserIcon
