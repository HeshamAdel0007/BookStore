'use client'
import { createContext, useContext, useReducer, useCallback } from 'react'
import { toast } from 'react-toastify'

const CartContext = createContext()

// تعريف cartReducer
const cartReducer = (state, action) => {
  switch (action.type) {
    case 'ADD_TO_CART':
      const existingItem = state.items.find(
        (item) => item.id === action.payload.id
      )
      if (existingItem) {
        return {
          ...state,
          items: state.items.map((item) =>
            item.id === action.payload.id
              ? { ...item, quantity: item.quantity + 1 }
              : item
          ),
        }
      }
      return {
        ...state,
        items: [...state.items, { ...action.payload, quantity: 1 }],
      }

    case 'UPDATE_QUANTITY':
      return {
        ...state,
        items: state.items.map((item) =>
          item.id === action.payload.productId
            ? { ...item, quantity: action.payload.quantity }
            : item
        ),
      }

    case 'REMOVE_ITEM':
      return {
        ...state,
        items: state.items.filter((item) => item.id !== action.payload),
      }

    case 'CLEAR_CART':
      return { ...state, items: [] }

    default:
      return state
  }
}

export const CartProvider = ({ children }) => {
  const [state, dispatch] = useReducer(cartReducer, { items: [] })

  const addToCart = useCallback((product) => {
    const toastId = toast.loading('جاري الإضافة إلى السلة...')
    try {
      dispatch({ type: 'ADD_TO_CART', payload: product })
      toast.update(toastId, {
        render: 'Added successfully!',
        type: 'success',
        isLoading: false,
        autoClose: 3000,
      })
    } catch (error) {
      toast.update(toastId, {
        render: 'Failed to add!',
        type: 'error',
        isLoading: false,
        autoClose: 3000,
      })
    }
  }, [])

  const value = {
    items: state.items,
    addToCart,
    updateQuantity: (productId, quantity) =>
      dispatch({
        type: 'UPDATE_QUANTITY',
        payload: { productId, quantity },
      }),
    removeItem: (productId) =>
      dispatch({ type: 'REMOVE_ITEM', payload: productId }),
    clearCart: () => dispatch({ type: 'CLEAR_CART' }),
  }

  return (
    <CartContext.Provider value={value}>{children}</CartContext.Provider>
  )
}

export const useCart = () => {
  const context = useContext(CartContext)
  if (!context) {
    throw new Error('useCart must be used within a CartProvider')
  }
  return context
}
