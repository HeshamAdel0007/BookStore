'use client'
import Table from '@/components/dashboard/admin/Table'
import getAllAdmins from '@/hooks/dashboard/admin/getadmins'
import Link from 'next/link'
import { MdCreateNewFolder } from 'react-icons/md'

const Admins = () => {
  const { allAdmins, isLoading } = getAllAdmins()
  const edit = localStorage
    .getItem('permissions')
    .split(',')
    .includes('update-admin')
  const remove = localStorage
    .getItem('permissions')
    .split(',')
    .includes('delete-admin')

  if (isLoading) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <div className="flex flex-wrap w-full">
          <Table admins={allAdmins} />
          <p>Loading, please wait...</p>
        </div>
      </div>
    )
  }
  return (
    <div className="w-full">
      <div className="grid grid-cols-2 gap-4">
        <h1 className="text-3xl font-bold">Admins</h1>
        <Link href="create" className="py-2">
          <span className="w-full h-6 flex text-[1.5em] items-center justify-center text-white hover:text-yellow duration-300 cursor-pointer relative group">
            <MdCreateNewFolder />
            <span className="font-medium absolute text-sm ml-14 uppercase bg-yellow text-black px-4 py-[1px] rounded-xl translate-x-8 group-hover:translate-x-12 transition-all z-20 duration-300 opacity-0 group-hover:opacity-100">
              Create
            </span>
          </span>
        </Link>
      </div>
      <Table admins={allAdmins} edit={edit} remove={remove} />
    </div>
  )
}

export default Admins
