const Button = ({
  ButtonName = 'name',
  ButtonType = 'submit',
  ButtonClass = 'block w-full text-black bg-yellow mt-5 py-2 rounded-2xl hover:bg-black hover:-translate-y-1 transition-all duration-500  hover:text-yellow font-semibold mb-2',
  ButtonValue = '',
}) => {
  return (
    <>
      <button
        type={ButtonType}
        className={ButtonClass}
        value={ButtonValue}
      >
        {ButtonName}
      </button>
    </>
  )
}

export default Button
