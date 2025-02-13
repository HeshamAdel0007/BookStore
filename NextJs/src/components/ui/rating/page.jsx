'use client'
import { cn } from '@/lib/utils'
import { Star } from 'lucide-react'

export const Rating = ({ rating, className }) => {
  const fullStars = Math.floor(rating)
  const hasHalfStar = rating % 1 >= 0.5

  return (
    <div className={cn('flex items-center gap-1', className)}>
      {[...Array(5)].map((_, index) => {
        let starFill = 'text-gray-300' // Default empty star

        if (index < fullStars) {
          starFill = 'text-yellow-400' // Full star
        } else if (index === fullStars && hasHalfStar) {
          starFill = 'text-yellow-400' // Half star
        }

        return (
          <Star
            key={index}
            className={`w-5 h-5 fill-current ${starFill}`}
            fill={
              index < fullStars || (index === fullStars && hasHalfStar)
                ? 'currentColor'
                : 'none'
            }
          />
        )
      })}
      <span className="text-sm text-gray-600 ml-2">
        ({Math.round(rating * 10) / 10})
      </span>
    </div>
  )
}
