import Notification from './right/Notification'
import UserIcon from './right/UserIcon'

const Right = () => {
  return (
    <>
      <div className="font-medium text-lg pr-1.5 pl-16">
        <Notification />
      </div>
      <div className="font-medium text-lg pr-3.5 pl-16">
        <UserIcon />
      </div>
    </>
  )
}

export default Right
