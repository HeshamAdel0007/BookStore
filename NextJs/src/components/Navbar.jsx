import Left from './navbar/Left'
import Right from './navbar/Right'

const Navbar = () => {
  return (
    <div className="flex h-14 items-center justify-between px-6 py-3 bg-menu">
      <div className="flex justify-end ">
        <Left />
      </div>
      <div className="flex justify-start">
        <Right />
      </div>
    </div>
  )
}

export default Navbar
