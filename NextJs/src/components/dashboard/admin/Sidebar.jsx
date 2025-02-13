import Image from 'next/image'
import ListIcon from '../../sidebar/ListIcon'
import userImg from '@/../public/assets/images/user_icon.png'
import { MdDashboard } from 'react-icons/md'
import { FaHouseUser, FaUsers } from 'react-icons/fa6'
import { FaUser } from 'react-icons/fa'
import { BiSolidCategoryAlt } from 'react-icons/bi'

const AdminSidebar = () => {
  return (
    <div className="flex flex-col gap-5 justify-items-center h-full w-20 bg-menu">
      <div className="flex justify-center rounded-full w-16	h-16 ml-2.5 overflow-hidden">
        <Image src={userImg.src} alt={'ImgAlt'} width={100} height={100} />
      </div>
      <ListIcon
        href="/dashboard/admin"
        name="dashboard"
        icon={<MdDashboard />}
      />
      <ListIcon
        href="/dashboard/admin/admins"
        name="admins"
        icon={<FaHouseUser />}
      />
      <ListIcon
        href="/dashboard/admin/publishers"
        name="publishers"
        icon={<FaUser />}
      />
      <ListIcon
        href="/dashboard/admin/customers"
        name="customers"
        icon={<FaUsers />}
      />
      <ListIcon
        href="/dashboard/admin/category"
        name="category"
        icon={<BiSolidCategoryAlt />}
      />
    </div>
  )
}

export default AdminSidebar
