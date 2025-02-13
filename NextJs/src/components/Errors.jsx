const Errors = ({
  errors = [],
  errorMessage = 'Whoops! Something went wrong.',
  ...props
}) => {
  return (
    <>
      {errors.length > 0 && (
        <div
          {...props}
          className={`p-4 border-l-4 border-red-500 bg-red-100 text-red-700 rounded-md`}
          aria-live="assertive"
        >
          {/* <div className="font-medium text-red-600"> */}
          <div className="font-medium">{errorMessage}</div>
          {/* </div> */}

          <ul className="mt-3 list-disc list-inside text-sm text-red-600">
            {errors.map((error) => (
              <li key={error}>{error}</li>
            ))}
          </ul>
        </div>
      )}
    </>
  )
}

export default Errors
