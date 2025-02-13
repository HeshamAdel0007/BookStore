import Image from 'next/image'
import ListIcon from './sidebar/ListIcon'
import userImg from '@/../public/assets/images/user_icon.png'

const Sidebar = () => {
  return (
    <div className="flex flex-col gap-5 justify-items-center h-full w-20 bg-menu">
      <div className="flex justify-center rounded-full w-16	h-16 ml-2.5 overflow-hidden">
        <Image src={userImg.src} alt={'ImgAlt'} width={100} height={100} />
      </div>
      <ListIcon />
    </div>
  )
}

export default Sidebar
