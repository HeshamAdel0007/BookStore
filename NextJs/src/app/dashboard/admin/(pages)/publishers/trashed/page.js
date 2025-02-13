'use client'
import TrashedTable from '@/components/dashboard/TrashTable'
import getUserDelete from '@/hooks/dashboard/usertrashed'

const Trashed = () => {
  const { allUserTrashed, isLoading, isEmpty } = getUserDelete({
    userTrash: 'publishers',
  })
  const restore = localStorage
    .getItem('permissions')
    .split(',')
    .includes('update-publisher')
  const remove = localStorage
    .getItem('permissions')
    .split(',')
    .includes('delete-publisher')

  if (isEmpty) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <div className="flex flex-wrap w-full">
          <TrashedTable trashName={allUserTrashed} />
          <p>No trashed publishers found....</p>
        </div>
      </div>
    )
  }
  if (isLoading) {
    return (
      <div className="flex gap-2 mt-2 w-full h-screen justify-center items-center">
        <div className="flex flex-wrap w-full">
          <TrashedTable trashName={allUserTrashed} />
          <p>Loading, please wait...</p>
        </div>
      </div>
    )
  }
  return (
    <div className="w-full">
      <div className="grid grid-cols-2 gap-4">
        <h1 className="text-3xl font-bold">Trashed</h1>
      </div>
      <TrashedTable
        trashName={'publisher'}
        users={allUserTrashed}
        restore={restore}
        remove={remove}
      />
    </div>
  )
}

export default Trashed
