/**
 * Save User Info In Local Storage
 */
const UserStorage = ({ userData }) => {
  if (typeof window !== 'undefined') {
    try {
      for (const [key, value] of Object.entries(userData)) {
        window.localStorage.setItem(`${key}`, `${value}`)
      }
    } catch (error) {
      console.error('Error saving to localStorage:', error)
    }
  }
}

export default UserStorage
