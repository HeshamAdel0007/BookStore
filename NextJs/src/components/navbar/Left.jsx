import { useEffect, useState } from 'react'

const Left = () => {
  const [name, setName] = useState()
  useEffect(() => {
    setName(localStorage.getItem('name'))
  }, [])
  return (
    <>
      <div className="font-medium uppercase text-lg	">{name}</div>
    </>
  )
}

export default Left
