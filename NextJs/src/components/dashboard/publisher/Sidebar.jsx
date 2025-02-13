import Image from 'next/image'
import ListIcon from '../../sidebar/ListIcon'
import userImg from '@/../public/assets/images/user_icon.png'
import { MdDashboard } from 'react-icons/md'
import { FaBook, FaFirstOrder } from 'react-icons/fa'
import { ImBooks } from 'react-icons/im'

const PublisherSidebar = () => {
  return (
    <div className="flex flex-col gap-5 justify-items-center h-full w-20 bg-menu">
      <div className="flex justify-center rounded-full w-16	h-16 ml-2.5 overflow-hidden">
        <Image src={userImg.src} alt={'ImgAlt'} width={100} height={100} />
      </div>
      <ListIcon
        href="/dashboard/publisher"
        name="dashboard"
        icon={<MdDashboard />}
      />
      <ListIcon
        href="/dashboard/publisher/books"
        name="my-books"
        icon={<ImBooks />}
      />
      <ListIcon
        href="/dashboard/publisher/books/create"
        name="create-book"
        icon={<FaBook />}
      />
      <ListIcon
        href="/dashboard/publisher/orders"
        name="orders"
        icon={<FaFirstOrder />}
      />
    </div>
  )
}

export default PublisherSidebar
