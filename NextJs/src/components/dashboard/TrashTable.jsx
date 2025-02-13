'use client'
import { MdDelete, MdRestore } from 'react-icons/md'
import axios from '@/lib/axios'
import { toast } from 'react-toastify'

const TrashTable = ({
  trashName = '',
  users = [],
  restore = false,
  remove = false,
}) => {
  const token = window.localStorage.getItem('token')
  const restoreUser = async (id) => {
    const restoreToast = toast.loading('Restore user...')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    await axios
      .get(`/admin/${trashName}/restore/${id}`, config)
      .then(() => {
        toast.update(restoreToast, {
          render: 'Restore Successfully!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }
  const deleteUser = async (id) => {
    const deleteToast = toast.loading('Delete user...')
    const config = {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
    await axios
      .delete(`/admin/${trashName}/destroy/${id}`, config)
      .then(() => {
        toast.update(deleteToast, {
          render: 'Delete Successfully!',
          type: 'success',
          autoClose: 3000,
          isLoading: false,
        })
      })
  }
  return (
    <section className="container mx-auto p-6 font-mono">
      <div className="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div className="w-full overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                <th className="px-4 py-3">#</th>
                <th className="px-4 py-3">Name</th>
                <th className="px-4 py-3">E-Mail</th>
                <th className="px-4 py-3">Restore</th>
                <th className="px-4 py-3">Delete</th>
              </tr>
            </thead>
            <tbody className="bg-white">
              {users.map((user, index) => (
                <tr className="text-gray-700" key={user.id}>
                  <td className="px-4 py-3 border">{index + 1}</td>
                  <td className="px-4 py-3 border">
                    <div className="flex items-center text-sm">
                      <div className="relative w-8 h-8 mr-3 rounded-full md:block">
                        <img
                          className="object-cover w-full h-full rounded-full"
                          src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                          alt=""
                          loading="lazy"
                        />
                        <div
                          className="absolute inset-0 rounded-full shadow-inner"
                          aria-hidden="true"
                        ></div>
                      </div>
                      <div>
                        <p className="font-semibold text-black">
                          {user.name}
                        </p>
                      </div>
                    </div>
                  </td>
                  <td className="px-4 py-3 text-ms font-semibold border">
                    {user.email}
                  </td>
                  <td className="px-4 py-3 text-sm border">
                    {restore == true ? (
                      <button
                        onClick={() => restoreUser(user.id)}
                        className="relative align-middle select-none font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-black hover:bg-blue-500 active:bg-blue-500 hover:text-white"
                        type="submit"
                      >
                        <span className="absolute text-[1.5em] top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                          <MdRestore />
                        </span>
                      </button>
                    ) : (
                      <button
                        className="relative align-middle select-none font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-black hover:bg-red-600 active:bg-red-600 hover:text-white"
                        type="button"
                        disabled
                      >
                        <span className="absolute text-[1.5em] top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                          <MdRestore />
                        </span>
                      </button>
                    )}
                  </td>
                  <td className="px-4 py-3 text-sm border">
                    {remove == true ? (
                      <button
                        onClick={() => deleteUser(user.id)}
                        className="relative align-middle select-none font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-black hover:bg-red-600 active:bg-red-600 hover:text-white"
                        type="submit"
                      >
                        <span className="absolute text-[1.5em] top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                          <MdDelete />
                        </span>
                      </button>
                    ) : (
                      <button
                        className="relative align-middle select-none font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-black hover:bg-red-600 active:bg-red-600 hover:text-white"
                        type="button"
                        disabled
                      >
                        <span className="absolute text-[1.5em] top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                          <MdDelete />
                        </span>
                      </button>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </section>
  )
}

export default TrashTable
