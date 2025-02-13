import Link from 'next/link'
import { MdSpaceDashboard } from 'react-icons/md'

const ListIcon = ({
  href = '#',
  icon = <MdSpaceDashboard />,
  name = 'PageName',
}) => {
  return (
    <>
      <Link href={href} className="py-2">
        <span className="w-full h-6 flex text-[1.5em] items-center justify-center text-white hover:text-yellow duration-300 cursor-pointer relative group">
          {icon}
          <span className="font-medium absolute text-sm ml-14 uppercase bg-yellow text-black px-4 py-[1px] rounded-xl translate-x-8 group-hover:translate-x-12 transition-all z-20 duration-300 opacity-0 group-hover:opacity-100">
            {name}
          </span>
        </span>
      </Link>
    </>
  )
}
export default ListIcon
