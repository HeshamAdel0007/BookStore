import { clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'

export function cn(...inputs) {
  if (
    inputs.some(
      (input) => typeof input === 'object' && !Array.isArray(input)
    )
  ) {
    return twMerge(clsx(inputs))
  }
  return inputs.filter(Boolean).join(' ')
}
